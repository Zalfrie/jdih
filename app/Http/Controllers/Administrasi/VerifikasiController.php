<?php

namespace App\Http\Controllers\Administrasi;

use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Peraturan;
use App\Model\PerBentuk;
use App\Model\PerStatus;
use App\Model\PerSubyek;
use DB;

class VerifikasiController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        $bentuk = PerBentuk::orderBy('urutan', 'asc')->get();
        $status = PerStatus::orderBy('urutan', 'asc')->get();
        $subyek = PerSubyek::orderBy('subyek')->get();
        return view('administrasi.verifikasi.index', ['bentuk' => $bentuk, 'status' => $status, 'subyek' => $subyek]);
    }
    
    public function getDataTable(Request $request)
    {
        $peraturan = Peraturan::with('sumber', 'status', 'abstrak', 'subyek', 'materi', 'tajukNegara', 'tajukInstansi', 'kota')->whereNotNull('file_id')
            ->orderBy('updated_at', 'desc')->get();
        $collections = new Collection;
        foreach($peraturan as $val){
            $status = [];
            foreach($val->status as $stat){
                $status[] = $stat->status." : ".$stat->pivot->per_no_object;
            }
            \Carbon\Carbon::setLocale('id');
            $tanggalCarbon = \Carbon\Carbon::createFromFormat('Y-m-d', $val->tanggal);
            $collections->push([
                'bentuk' => ['short' => $val->bentuk->bentuk_short, 'long' => $val->bentuk->bentuk, 'seragam' => $val->bentuk->seragam],
                'perno' => $val->per_no,
                'tanggal' => ['short' => $tanggalCarbon->format('d-m-Y'), 'human' => $tanggalCarbon->formatLocalized('%d %B %Y'), 'humanShort' => $tanggalCarbon->formatLocalized('%d %b %Y'), 'tahun' => $tanggalCarbon->format('Y')],
                'tentang' => $val->tentang,
                'created' => ['tgl' => $val->created_at, 'by' => $val->author_user],
                'sumberTabel' => implode(', ', $val->sumber->pluck('sumber_short')->all()),
                'statusList' => (count($status) > 0)?("<ul><li>".implode('</li><li>', $status)."</li></ul>"):'',
                'subyek' => $val->subyek->pluck('subyek')->all(),
                'statusKatalog' => $val->status,
                'subyekKatalog' => $val->subyek,
                'tajukEntri' => $val->tajukNegara->nama_negara.'. '.$val->tajukInstansi->nama_instansi.'.',
                'bentukSeragam' => $val->bentuk->seragam,
                'kota' => $val->kota->nama_kota,
                'sumber' => $val->sumber->toArray(),
                'lokasi' => $val->lokasi,
                'abstrak' => $val->abstrak->where('is_note', false)->pluck('abstrak')->all(),
                'abstrakNote' => $val->abstrak->where('is_note', true)->pluck('abstrak')->first(),
                'file' => $val->file_id,
                'publish' => ['state' => $val->is_publish, 'by' => $val->publish_user, 'tgl' => $val->published_at, 'note' => $val->unpublish_note],
                'updated' => ['tgl' => $val->updated_at, 'by' => $val->last_update_user],
            ]);
        }
        return \Datatables::of($collections)
            ->addColumn('publishCol', function($item){
                $result = '<span class="label label-sm label-'.($item['publish']['state'] == 1 ? 'success':'danger').'"> '.($item['publish']['state'] == 1 ? 'YA':($item['publish']['state'] == 2 ? 'DITOLAK':'BELUM')).' </span>';
                if ($item['publish']['state'] == 2){
                    $result .= '<br/><p class="margin-top-10">'.(nl2br($item['publish']['note']))."</p>";
                }if (!empty($item['publish']['by'])){
                    $result .= '<p class="margin-top-10">Oleh :<br/>'.($item['publish']['by'])."</p>";
                }
                return $result;
            })
            ->addColumn('tglUpload', function($item){
                $result = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['created']['tgl'])->formatLocalized('%d %b %Y').'<br/>'.$item['created']['by'];
                $result .= '<br/><br/>Last update:<br/>'.\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item['updated']['tgl'])->formatLocalized('%d %b %Y').'<br/>'.$item['updated']['by'];
                return $result;
            })
            
            ->addColumn('actions', function($item){
                if ($item['publish']['state'] == 1){
                    return '<div class="btn-group">
                                <a href="/administrasi/peraturan/'.$item['perno'].'/verifikasi" class="btn blue btn-xs margin-bottom-5">
                                    <i class="fa fa-times"></i>
                                    Batalkan
                                </a>
    						</div>';
                }else{
                    return '<div class="btn-group">
                                <a href="/administrasi/peraturan/'.$item['perno'].'/verifikasi" class="btn blue btn-xs margin-bottom-5">
                                    <i class="fa fa-bookmark-o"></i>
                                    Verifikasi
                                </a>
    						</div>';
                }
            })
            ->filter(function ($instance) use ($request) {
                if ($request->has('bentuk')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return ($row['bentuk']['short'] == $request->bentuk) ? true : false;
                    });
                }
                if ($request->has('perno')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return str_contains(strtolower($row['perno']), strtolower($request->perno)) ? true : false;
                    });
                }
                if ($request->has('tentang')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return str_contains(strtolower($row['tentang']), strtolower($request->tentang)) ? true : false;
                    });
                }
                if ($request->has('status')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return $row['statusKatalog']->contains('status_id', $request->status);
                    });
                }
                if ($request->has('tahun')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return str_contains($row['tanggal']['tahun'], $request->tahun) ? true : false;
                    });
                }
                if ($request->has('publish')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return ($request->publish == 't' && $row['publish']['state'] == 1) || ($request->publish == 'f' && $row['publish']['state'] != 1) ? true : false;
                    });
                }
                if ($request->has('subyek')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return $row['subyekKatalog']->contains('subyek_id', $request->subyek);
                    });
                }
                if (!empty($request->search['value'])){
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return str_contains(strtolower($row['bentuk']['short']), strtolower($request->search['value']))
                            ||  str_contains(strtolower($row['perno']), strtolower($request->search['value']))
                            ||  str_contains(strtolower($row['tanggal']['short']), strtolower($request->search['value']))
                            ||  str_contains(strtolower($row['tentang']), strtolower($request->search['value']))
                            ||  str_contains(strtolower($row['sumberTabel']), strtolower($request->search['value']))
                            ||  str_contains(strtolower($row['statusList']), strtolower($request->search['value']))
                            ||  str_contains(strtolower(nl2br($row['publish']['note'])), strtolower($request->search['value']))
                            ||  (str_contains('ya', strtolower($request->search['value'])) && $row['publish']['state'] == 1
                                || str_contains('ditolak', strtolower($request->search['value'])) && $row['publish']['state'] == 2
                                || str_contains('belum', strtolower($request->search['value'])) && $row['publish']['state'] == 0)
                        ? true : false;
                    });
                }
            })
            ->make(true);
    }
    
    public function verifikasi(Request $request, $id)
    {
        $data = Peraturan::with('sumber', 'status', 'abstrak', 'materi', 'subyek', 'tajukNegara', 'tajukInstansi', 'kota', 'bentuk')->find($id);
        
        return view('administrasi.verifikasi.verifikasi', [
            'data' => $data,
        ]);
    }
    
    public function verify(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            //$peraturan = Peraturan::find($id);
            $peraturan = Peraturan::with('sumber', 'status', 'abstrak', 'materi', 'subyek', 'tajukNegara', 'tajukInstansi', 'kota', 'bentuk')->find($id);
            $peraturan->is_publish = $request->value;
            $peraturan->unpublish_note = ($request->value == 2) ? $request->note:null;
            $peraturan->published_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $peraturan->publish_user = $request->user()->username;
            $peraturan->timestamps = false;
            $peraturan->emailpublish = $request->emailpublish;
            if($request->emailpublish == 't'){
                /*Mail::send('administrasi.verifikasi.send', ['data' => $peraturan], function ($message)
                {

                    $message->from('jdih.kbumn@gmail.com', 'Notifikasi JDIH');
                    $message->subject('Publikasi Peraturan JDIH');
                    $message->to('zalfrie@gmail.com');

                });*/
            }
            
            $peraturan->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            throw $e;
            return redirect('/administrasi/verifikasi');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/verifikasi');
    }
}
