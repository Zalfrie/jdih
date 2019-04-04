<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Peraturan;
use App\Model\PerBentuk;
use App\Model\PerStatus;
use App\Model\PerMateri;
use App\Model\UncategorizedPost;
use App\Model\Berita;
use App\Model\KategoriBerita;
use App\Model\Tautan;
use App\Model\SiteMap;
use App\Model\Headline;
use App\Plugin\ReCaptcha;
use DB;
use Illuminate\Contracts\Auth\Guard;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('public.menu', ['except' => ['bacaPDF', 'unduhPDF']]);
    }

    public function denied(){
        return response('Unauthorized.', 401);
    }

    public function index(Request $request)
    {
        $judul_banner = UncategorizedPost::where('post_type', 'title_beranda')->first();
        $paragraf_banner = UncategorizedPost::where('post_type', 'paragraf_beranda')->first();
        $active_headline = Headline::where('is_active', true)->get();
        if (!empty($active_headline) && sizeof($active_headline)>0){
            $judul_banner->content = $this->obtainHeadline($active_headline);
        }
        
        $jenis = PerBentuk::orderBy('urutan', 'asc')->get();
        $materi = PerMateri::all();
        $newest = Peraturan::where('is_publish', 1)->whereNotNull('file_id')->whereIn('bentuk_short', ['PERMENBUMN', 'SEMENBUMN'])->orderBy('tanggal', 'desc')->take(8)->get();
        $populer = Peraturan::where('is_publish', 1)->whereNotNull('file_id')->orderBy('monthly_counter', 'desc')->orderBy('published_at', 'desc')->take(5)->get();
        $berita = Berita::with('kategori')->where('is_publish', 't')->orderBy('published_at', 'desc')->take(10)->get();
        $tautan = Tautan::orderBy('urutan')->get();
        $disclaimer = UncategorizedPost::where('post_type', 'disclaimer_beranda')->first();

        //$visitor = \Tracker::currentSession();
        //dd(count($visitor));
        //$sessions = \Tracker::sessions();
        //dd(count($sessions));
        //$users = \Tracker::onlineUsers();
        //dd(count($users));

        $endYear = date('Y');
        $startYear = $endYear - 4;
        $array[1] = 0;
        $year = [];
        for ($i = $startYear; $i <= $endYear; $i++){
            $array[$i] = 0;
            $year[] = $i;
        }
        return view('site1.home.index', ['disclaimer' => $disclaimer, 'title_beranda' => $judul_banner, 'paragraf_beranda' => $paragraf_banner, 'newest' => $newest, 'populer' => $populer, 'jenis' => $jenis, 'materi' => $materi, 'berita' => $berita, 'tautan' => $tautan, 'thisYear' => date("Y")]);
    }
    
    public function cse(Request $request)
    {
        return view('site1.home.cse', ['title' => 'Pencarian Khusus']);
    }
    
    public function lihatPeraturan(Request $request, $id)
    {
        $peraturan = Peraturan::with('sumber', 'status', 'abstrak', 'materi', 'subyek', 'tajukNegara', 'tajukInstansi', 'kota', 'bentuk','review')->where('per_no', $id)->where('is_publish', 1)->whereNotNull('file_id')->first();
        if (empty($peraturan)){
            return view('site1.home.notfounddata', ['perno' => $id]);
        }
        $title = $peraturan->bentuk->bentuk.' '.$peraturan->per_no.' tanggal '.\Carbon\Carbon::createFromFormat('Y-m-d', $peraturan->tanggal)->formatLocalized('%d %B %Y');
        return view('site1.home.lihat', ['title' => $title, 'peraturan' => $peraturan]);
    }
    
    public function bacaPDF(Request $request, $id)
    {
        $peraturan = Peraturan::with('filedoc')->where('is_publish', 1)->where('per_no', $id)->whereNotNull('file_id')->first();
        $filename = $peraturan->filedoc->filename;
        $path = \Config::get('constants.dir').$peraturan->filedoc->direktori.$filename;
        
        return \Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
    
    public function unduhPDF(Request $request, $id)
    {
        $peraturan = Peraturan::with('filedoc')->where('per_no', $id)->where('is_publish', 1)->whereNotNull('file_id')->first();
        $filename = $peraturan->filedoc->filename;
        $path = \Config::get('constants.dir').$peraturan->filedoc->direktori.$filename;
        
        if (file_exists($path)){
            $peraturan->reading_counter++;
            $peraturan->monthly_counter++;
            $peraturan->save();
        }
        
        return \Response::download($path, $filename, [
            'Content-Type' => 'application/pdf'
        ]);
    }
    
    public function pencarian(Request $request)
    {
        $urutan = 'desc';
        if (!empty($request->sorting)){
            $urutan = $request->sorting;
        }
        $jenis = PerBentuk::orderBy('urutan', 'asc')->get();
        $peraturan = Peraturan::with('sumber', 'status', 'abstrak')->where('is_publish', 1)->whereNotNull('file_id')
            ->orderBy('tanggal', $urutan)->orderBy('per_no', $urutan);
        $materi = PerMateri::all();
        if (!empty($request->byBentuk)){
            $peraturan = $peraturan->whereRaw("LOWER(bentuk_short) = ?", [strtolower($request->byBentuk)]);
        }
        if (!empty($request->byNomor)){
            $peraturan = $peraturan->whereRaw('per_no ILIKE ?', [('%'.$request->byNomor.'%')]);
        }
        if (!empty($request->byTahun)){
            $peraturan = $peraturan->whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [$request->byTahun]);
        }
        if (!empty($request->byTentang)){
            $peraturan = $peraturan->whereRaw('tentang ILIKE ?', [('%'.$request->byTentang.'%')]);
        }
        if (!empty($request->byMateri)){
            $peraturan = $peraturan->whereRaw('per_no IN (SELECT per_no FROM per_materi_rel WHERE materi_id = ?)', [$request->byMateri]);
        }
        $peraturan = $peraturan->orderBy('published_at', 'desc')->paginate(10);
        $request->flash();
        return view('site1.home.pencarian', ['title' => 'Pencarian Peraturan', 'sorting' => $urutan,
            'peraturan' => $peraturan->appends(\Input::except('page')), 'jenis' => $jenis, 'materi' => $materi]);
    }
    
    public function perBentuk (Request $request, $bentuk)
    {
        $urutan = 'desc';
        if (!empty($request->sorting)){
            $urutan = $request->sorting;
        }
        $peraturan = Peraturan::with('sumber', 'status', 'abstrak')->where('is_publish', 1)->whereNotNull('file_id')
            ->orderBy('tanggal', $urutan)->orderBy('per_no', $urutan);
        $perBentukList = false;
        if ($bentuk == 'etc'){
            $perBentukList = PerBentuk::where('is_etc', 't')->orderBy('urutan')->get();
            $peraturan = $peraturan->whereRaw("LOWER(bentuk_short) IN (SELECT LOWER(bentuk_short) FROM per_bentuk_ref WHERE is_etc IS TRUE)", []);
        }else{
            $perBentukList = PerBentuk::whereRaw("LOWER(bentuk_short) = ?", [strtolower($bentuk)])->get();
            $peraturan = $peraturan->whereRaw("LOWER(bentuk_short) = ?", [strtolower($bentuk)]);
        }
        if (!empty($request->byBentuk)){
            $peraturan = $peraturan->whereRaw("LOWER(bentuk_short) = ?", [strtolower($request->byBentuk)]);
        }
        if (!empty($request->byNomor)){
            $peraturan = $peraturan->whereRaw('per_no ILIKE ?', [('%'.$request->byNomor.'%')]);
        }
        if (!empty($request->byTahun)){
            $peraturan = $peraturan->whereRaw('EXTRACT(YEAR FROM tanggal) = ?', [$request->byTahun]);
        }
        if (!empty($request->byTentang)){
            $peraturan = $peraturan->whereRaw('tentang ILIKE ?', [('%'.$request->byTentang.'%')]);
        }
        if (!empty($request->byStatus)){
            $peraturan = $peraturan->whereRaw('per_no IN (SELECT A.per_no FROM per_status_rel A, per_status_ref B WHERE A.status_id = B.status_id AND LOWER(B.status) = ?)', [$request->byStatus]);
        }
        $peraturan = $peraturan->orderBy('published_at', 'desc')->paginate(10);
        $statusObject = $peraturan->filter(function($item){
            return count($item->status) > 0;
        })->pluck('status');
        $resultStatusObject = [];
        foreach($statusObject as $val){
            $resultStatusObject = array_merge($resultStatusObject, $val->pluck('pivot')->pluck('per_no_object')->toArray());
        }
        $perBentuk = PerBentuk::whereRaw("LOWER(bentuk_short) = ?", [strtolower($bentuk)])->first();
        $status = PerStatus::orderBy('urutan', 'asc')->get();
        $title = !empty($perBentuk) ? $perBentuk->bentuk:'Peraturan Lainnya';
        $request->flash();
        return View('site1.home.bentuk', ['title' => $title, 'sorting' => $urutan,
            'bentuk' => $bentuk, 'peraturan' => $peraturan->appends(\Input::except('page')), 'perBentuk' => $perBentuk, 'perBentukList' => $perBentukList, 'status' => $status]);
    }
    
    public function kontak(Request $request)
    {
        $disclaimer = UncategorizedPost::where('post_type', 'disclaimer_berita')->first();
        return view('site1.home.kontak', ['title' => 'Hubungi Kami', 'disclaimer' => $disclaimer]);
    }
    
    public function visimisi(Request $request)
    {
        $prakata = UncategorizedPost::where('post_type', 'prakata_visi_misi')->first();
        $visi = UncategorizedPost::where('post_type', 'visi')->first();
        $misi = UncategorizedPost::where('post_type', 'misi')->first();
        return view('site1.home.visimisi', ['title' => 'Visi dan Misi', 'prakata' => $prakata, 'visi' => $visi, 'misi' => $misi]);
    }
    
    public function bacaBerita(Request $request, $id = null)
    {
        if (is_null($id)){
            $berita = Berita::orderBy('published_at', 'desc')->where('is_publish', true)->paginate(5);
            return view('site1.berita.kategori', ['title' => 'Berita', 'berita' => $berita]);
        }elseif (KategoriBerita::where('slug', $id)->exists()){
            $berita = Berita::with(array('kategori' => function($query) use ($id)
                {
                     $query->where('berita_kategori_ref.slug', $id);
                }))->whereHas('kategori', function($query) use ($id)
                {
                     $query->where('berita_kategori_ref.slug', $id);
                })->orderBy('published_at', 'desc')->paginate(5);
            return view('site1.berita.kategori', ['title' => KategoriBerita::where('slug', $id)->first()->kategori, 'berita' => $berita, 'kategori' => KategoriBerita::where('slug', $id)->first()]);
        }else{
            $berita = Berita::with('kategori')->where('slug', $id)->first();
            return view('site1.berita.baca', ['title' => $berita->title, 'berita' => $berita]);
        }
    }
    public function prepareBumn(Request $request)
    {
        $peraturan = Peraturan::where('is_publish', 1)->where('is_reviewed', true)->orderBy('review_end', 'desc')->paginate(5);
        $mukadimah = UncategorizedPost::where('post_type', 'mukadimah_program_prepare')->first();
        $mukadimah1 = UncategorizedPost::where('post_type', 'mukadimah1')->first();
        $mukadimah2 = UncategorizedPost::where('post_type', 'mukadimah2')->first();
        $mukadimah3 = UncategorizedPost::where('post_type', 'mukadimah3')->first();
        $mukadimah4 = UncategorizedPost::where('post_type', 'mukadimah4')->first();
        $mukadimah5 = UncategorizedPost::where('post_type', 'mukadimah5')->first();
        return view('site1.home.prepare', ['title' => 'PREPARE BUMN',
            'peraturan'=>$peraturan->appends(\Input::except('page')),
            'mukadimah'=>$mukadimah,
            'mukadimah1'=>$mukadimah1->content,
            'mukadimah2'=>$mukadimah2->content,
            'mukadimah3'=>$mukadimah3->content,
            'mukadimah4'=>$mukadimah4->content,
            'mukadimah5'=>$mukadimah5->content,
        ]);
    }
    
    public function sitemap(Request $request)
    {
        $menu = SiteMap::with('children.children.children.children.children')->where('parent_id', 0)->orderBy('order', 'asc')->get();
        
        $sitemap = $this->buildMenu($menu->toArray());
        return view('site1.home.sitemap', ['title' => 'Peta Situs', 'sitemap' => $sitemap]);
    }
    
    private function buildMenu($menu, $is_submenu = false){ 
        $result = null;
        foreach ($menu as $item) {
            $children = null;
            if (count($item['children']) > 0){
                $children = $this->buildMenu($item['children'], true);
            }
            $result .= "<li>";
			$result .= (!empty($item['link']))?"<a href='{$item['link']}'>":'';
            $result .= "{$item['label']}";
            $result .= (!empty($item['link']))?"</a>":'';
            $result .= "\n$children</li>";
        }
         
        if ($is_submenu){
            return $result ?  "\n<ul>\n$result</ul>\n" : null;
        }else{
            return $result ?  "\n$result\n" : null;
        }
    }

    private function obtainHeadline($active_headline)
    {
        $jdihIcon = '  <img src="/assets/global/img/rsz_logo-jdihn.png"/>  ';
        $headlineStr = $jdihIcon;
        foreach ($active_headline as $headline){
            $headlineStr .= $headline->content . $jdihIcon;
        }
        return $headlineStr;
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
