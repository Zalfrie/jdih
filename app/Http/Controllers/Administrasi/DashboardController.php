<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use DB;
use App\Model\Peraturan;
use App\Model\PerBentuk;

class DashboardController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(\Illuminate\Cookie\CookieJar $cookieJar, Request $request)
    {
        if (\Auth::user()->hasRole(['Prepare_Bumn'])){
            return redirect('/administrasi/review');
        }
        $peraturan = Peraturan::selectRaw('COUNT(per_no) as jml, EXTRACT(YEAR FROM tanggal)::INT as tahun, bentuk_short')
            ->where('is_publish', 1)
            ->groupBy('bentuk_short')
            ->groupBy('tahun')
            ->get();
        $bentuk = PerBentuk::orderBy('urutan')->get();
        $rekap = [];
        $endYear = date('Y');
        $startYear = $endYear - 4;
        $array[1] = 0;
        $year = [];
        for ($i = $startYear; $i <= $endYear; $i++){
            $array[$i] = 0;
            $year[] = $i;
        }
        foreach($bentuk as $val){
            $array['bentuk'] = $val->bentuk;
            $rekap[$val->bentuk_short] = $array;
        }
        foreach ($peraturan as $val){
            if ($val->tahun < $startYear){
                $rekap[$val->bentuk_short][1] = $val->jml;
            }else{
                $rekap[$val->bentuk_short][$val->tahun] = $val->jml;
            }
        }
        
        $populer = Peraturan::where('is_publish', 1)->whereNotNull('file_id')->orderBy('reading_counter', 'desc')->orderBy('published_at', 'desc')->take(5)->get();
        return view('administrasi.dashboard.index', ['populer' => $populer, 'rekap' => $rekap, 'thisYear' => date("Y")]);
    }
    
    public function getPeraturanChart(Request $request)
    {
        if ($request->jns == 'minggu' || $request->jns == 'bulan'){
            if ($request->jns == 'minggu'){
                $startDate = \Carbon\Carbon::now()->subDays(6);
            }else{
                $startDate = \Carbon\Carbon::now()->firstOfMonth();
            }
            $peraturan = Peraturan::selectRaw('COUNT(per_no) as jml, published_at::DATE as tgl')
                ->where('published_at', '>=', $startDate->format('Y-m-d'))
                ->groupBy('tgl')
                ->orderBy('tgl')
                ->get();
            $peraturan = $peraturan->pluck('jml', 'tgl')->toArray();
            $result = [];
            $i = $startDate;
            $endDate = \Carbon\Carbon::now()->addDay();
            while($i->diffInDays($endDate) > 0){
                $array['tgl'] = $i->format('Y-m-d');
                $array['jml'] = !empty($peraturan[$i->format('Y-m-d')]) ? $peraturan[$i->format('Y-m-d')]:0;
                $result[] = $array;
                $i = $i->addDay();
            }
        }else{
            $startDate = \Carbon\Carbon::now()->firstOfYear();
            $peraturan = Peraturan::selectRaw('COUNT(per_no) as jml, EXTRACT(MONTH FROM published_at)::INT as tgl')
                ->where('published_at', '>', $startDate->format('Y-m-d'))
                ->groupBy('tgl')
                ->orderBy('tgl')
                ->get();
            $peraturan = $peraturan->pluck('jml', 'tgl')->toArray();
            $result = [];
            $endDate = \Carbon\Carbon::now()->format('m');
            for ($i = 1; $i <= $endDate; $i++){
                $array['tgl'] = \Carbon\Carbon::createFromFormat('m', $i)->formatLocalized('%b');
                $array['jml'] = !empty($peraturan[$i]) ? $peraturan[$i]:0;
                $result[] = $array;
            }
        }
        
        return response()->json($result);
    }
    
    public function getVisitor(Request $request)
    {
        $client = new \Google_Client();
        $client->setAuthConfigFile(\Config::get('constants.dir').'./JDIH-3d37ba5c9948.json');
        $client->addScope(\Google_Service_Analytics::ANALYTICS_READONLY);
        $analytics = new \Google_Service_AnalyticsReporting($client);
        $response = $this->getReport($analytics, $request->all());
        $result = $this->printResults($response, $request->all());
        
        return response()->json($result);
    }
    
    function getReport(&$analytics, $param) {
        $VIEW_ID = "133123975";
        $dateRange = new \Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($param['start']);
        $dateRange->setEndDate($param['end']);
        
        $sessions = new \Google_Service_AnalyticsReporting_Metric();
        $sessions->setExpression("ga:sessions");
        $sessions->setAlias("sessions");
        
        $dimensions = new \Google_Service_AnalyticsReporting_Dimension();
        $dimensions->setName($param['dimensi']);
        
        $request = new \Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($VIEW_ID);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($sessions));
        $request->setDimensions(array($dimensions));
        
        $body = new \Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        return $analytics->reports->batchGet( $body );
    }
    
    function printResults(&$reports, $param) {
        $data = [];
        for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();
            
            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                $row = $rows[ $rowIndex ];
                $dimensions = $row->getDimensions();
                $metrics = $row->getMetrics();
                for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                    if ($param['dimensi'] == 'ga:month'){
                        $data[$rowIndex]['dimension'] = \Carbon\Carbon::createFromFormat('m', $dimensions[$i])->formatLocalized('%b');
                    }else{
                        $data[$rowIndex]['dimension'] = \Carbon\Carbon::createFromFormat('Ymd', $dimensions[$i])->format('Y-m-d');
                    }
                }
                
                for ($j = 0; $j < count( $metrics ); $j++) {
                    $values = $metrics[$j];
                    for ( $valueIndex = 0; $valueIndex < count( $values->getValues() ); $valueIndex++ ) {
                        $value = $values->getValues()[ $valueIndex ];
                        $entry = $metricHeaders[$valueIndex];
                        $data[$rowIndex][$entry->getName()] = $value;
                    }
                }
            }
        }
        return $data;
    }
}
