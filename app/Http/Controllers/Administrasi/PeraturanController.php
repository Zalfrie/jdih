<?php
namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Peraturan;
use App\Model\Negara;
use App\Model\Instansi;
use App\Model\Kota;
use App\Model\PerBentuk;
use App\Model\PerSumber;
use App\Model\PerStatus;
use App\Model\PerSubyek;
use App\Model\PerAbstrak;
use App\Model\PerFile;
use App\Model\PerMateri;
use DB;
use App\Plugin\PDFWatermark;
use App\Plugin\PDFWatermarker;

class PeraturanController extends Controller
{
    
    public function __construct()
    {
        ini_set( 'max_execution_time', 1200);
    }
    
    public function index(Request $request)
    {
        $bentuk = PerBentuk::orderBy('urutan', 'asc')->get();
        $status = PerStatus::orderBy('urutan', 'asc')->get();
        $subyek = PerSubyek::orderBy('subyek')->get();
        return view('administrasi.peraturan.index', ['bentuk' => $bentuk, 'status' => $status, 'subyek' => $subyek]);
    }
    
    public function autocomplete(Request $request, $q)
    {
        $peraturan = Peraturan::whereRaw('LOWER(per_no) LIKE \'%'.strtolower(trim($q)).'%\'')->select(['per_no AS key', 'per_no AS value'])->get();
        return response()->json($peraturan->toArray());
    }
    
    public function newSubyek(Request $request)
    {
        $subyek = new PerSubyek;
        $subyek->subyek = $request->newSubyek;
        $subyek->save();
        return response()->json(['key' => $subyek->subyek_id, 'text' => $subyek->subyek, 'appendTarget' => '.subyek']);
    }
    
    public function newMateri(Request $request)
    {
        $materi = new PerMateri;
        $materi->materi = $request->newMateri;
        $materi->save();
        return response()->json(['key' => $materi->materi_id, 'text' => $materi->materi, 'appendTarget' => '.materi']);
    }
    
    public function publish(Request $request)
    {
        try{
            $peraturan = Peraturan::find($request->perno);
            $peraturan->is_publish = ($request->val == 'f') ? 't':'f';
            $peraturan->published_at = ($request->val == 'f') ? \Carbon\Carbon::now()->format('Y-m-d H:i:s'):null;
            $peraturan->save();
            return response()->json(['isPublish' => $peraturan->is_publish, 'type' => 'success', 'message' => 'Berhasil', 'title' => ($peraturan->is_publish == 't') ? 'Publish':'Unpublish']);
        } catch(\Exception $e){
            return response()->json(['isPublish' => $peraturan->is_publish, 'type' => 'error', 'message' => 'Gagal', 'title' => ($request->val == 'f') ? 'Publish':'Unpublish']);
        }
    }
    
    public function getDataTable(Request $request)
    {
        
        $peraturan = Peraturan::with('sumber', 'status', 'abstrak', 'subyek', 'materi', 'tajukNegara', 'tajukInstansi', 'kota', 'bentuk')
            ->orderBy('tanggal', 'desc')->get();
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
                'tanggal' => ['short' => $tanggalCarbon->format('Y-m-d'), 'human' => $tanggalCarbon->formatLocalized('%d %B %Y'), 'humanShort' => $tanggalCarbon->formatLocalized('%d %b %Y'), 'tahun' => $tanggalCarbon->format('Y')],
                'tentang' => $val->tentang,
                'created' => ['tgl' => $val->created_at, 'by' => $val->author_user, 'tanggal' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->created_at)->formatLocalized('%d %B %Y')],
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
                'abstrakNote' => $val->abstrak->where('is_note', true)->pluck('abstrak')->all(),
                'file' => $val->file_id,
                'publish' => ['state' => $val->is_publish, 'by' => $val->publish_user, 'tgl' => $val->published_at, 'note' => nl2br($val->unpublish_note), 'tanggal' => (!empty($val->published_at))?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->published_at)->formatLocalized('%d %B %Y'):''],
                'updated' => ['tgl' => $val->updated_at, 'by' => $val->last_update_user, 'tanggal' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->updated_at)->formatLocalized('%d %B %Y')],
            ]);
        }
        return \Datatables::of($collections)
            ->addColumn('publishCol', function($item){
                $result = '<span class="label label-sm label-'.($item['publish']['state'] == 1 ? 'success':'danger').'"> '.($item['publish']['state'] == 1 ? 'YA':($item['publish']['state'] == 2 ? 'DITOLAK':'BELUM')).' </span>';
                if ($item['publish']['state'] == 2){
                    $result .= '<br/><p class="margin-top-10">'.($item['publish']['note'])."</p>";
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
            ->addColumn('pernoOut', function($item){
                $pdf = (empty($item['file'])) ? '':'
                            <br/><a href="javascript:;" class="btn blue btn-xs pdf">
                                <i class="fa fa-file-pdf-o"></i>
                                pdf
                            </a>';

                $cekabstrak = ($item['bentuk']['short'] == 'PERMENBUMN') ? '
                            <a href="javascript:;" class="btn blue btn-xs abstrak margin-bottom-5">
                                Abstrak
                            </a>' : '';
                
                return $item['perno']."<br/>".$cekabstrak.'
                            <a href="javascript:;" class="btn blue btn-xs katalog margin-bottom-5">
                                Katalog
                            </a>'.$pdf;
            })
            ->addColumn('actions', function($item){
                $button = '<div class="btn-group">
                            <a href="/administrasi/peraturan/'.$item['perno'].'/edit" class="btn blue btn-xs margin-bottom-5">
                                <i class="fa fa-edit"></i>
                                Ubah
                            </a>
                            <a href="/administrasi/peraturan/'.$item['perno'].'/upload" class="btn blue btn-xs margin-bottom-5">
                                <i class="fa fa-upload"></i>
                                Upload PDF
                            </a>
                            <a href="javascript:;" class="btn blue btn-xs log margin-bottom-5">
                                Log
                            </a>';
                if ($item['publish']['state'] != 1){
                    $button .= '
							<form action="/administrasi/peraturan/'.$item['perno'].'" method="POST">
								'.csrf_field().'
								'.method_field('DELETE').'
								<button type="button" class="btn btn-danger btn-xs deletePeraturan">
									<i class="fa fa-btn fa-trash"></i>Delete
								</button>
							</form>';
                }
                $button .= '</div>';
                return $button;
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
    
    public function tambah(Request $request)
    {
        $negara = Negara::all();
        $instansi = Instansi::all();
        $bentuk = PerBentuk::orderBy('urutan', 'asc')->get();
        $kota = Kota::all();
        $sumber = PerSumber::all();
        $status = PerStatus::orderBy('urutan', 'asc')->get();
        $peraturan = Peraturan::all();
        $subyek = PerSubyek::orderBy('subyek')->get();
        $materi = PerMateri::orderBy('materi')->get();
        
        return view('administrasi.peraturan.tambah', [
            'negara' => $negara,
            'instansi' => $instansi,
            'bentuk' => $bentuk,
            'kota' => $kota,
            'sumber' => $sumber,
            'status' => $status,
            'peraturan' => $peraturan,
            'subyek' => $subyek,
            'materi' => $materi,
        ]);
    }
    
    public function simpanPeraturan(Request $request)
    {
        DB::beginTransaction();
        try {
            $peraturan = new Peraturan;
            $peraturan->per_no = $request->perno;
            $peraturan->tajuk_negara_id = $request->negara;
            $peraturan->tajuk_ins_id = $request->instansi;
            $peraturan->bentuk_short = $request->bentuk;
            $peraturan->tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
            $peraturan->tentang = $request->tentang;
            $peraturan->kota_id = $request->kota;
            $peraturan->lokasi = $request->lokasi;
            $peraturan->author_user = $request->user()->username;
            $peraturan->last_update_user = $request->user()->username;
            $peraturan->save();
            
            for($i = 0; $i < count($request->sumberShort); $i++){
                if (!empty($request->sumberShort[$i]) && !empty($request->sumberYear[$i]) && !empty($request->sumberHalaman[$i])){
                    $peraturan->sumber()->attach($request->sumberShort[$i], ['year' => empty($request->sumberYear[$i])?null:$request->sumberYear[$i], 
                    'jilid' => empty($request->sumberJilid[$i])?null:$request->sumberJilid[$i], 
                    'hal' => empty($request->sumberHalaman[$i])?null:$request->sumberHalaman[$i]]);
                }
            }
            
            for($i = 0; $i < count($request->materi); $i++){
                $peraturan->materi()->attach($request->materi[$i]);
            }
            
            for($i = 0; $i < count($request->subyek); $i++){
                $peraturan->subyek()->attach($request->subyek[$i]);
            }
            
            for($i = 0; $i < count($request->status); $i++){
                if (!empty($request->status[$i]) && !empty($request->statusPerno[$i])){
                    $peraturan->status()->attach($request->status[$i], ['per_no_object' => empty($request->statusPerno[$i])?null:$request->statusPerno[$i]]);
                }
            }
            
            for($i = 0; $i < count($request->abstrak); $i++){
                if (!empty($request->abstrak[$i])){
                    $abstrak = new PerAbstrak;
                    $abstrak->abstrak = $request->abstrak[$i];
                    $abstrak->is_note = 'f';
                    $abstrak->peraturan()->associate($peraturan);
                    $abstrak->save();
                }
            }
            
            for($i = 0; $i < count($request->abstrakNote); $i++){
                if (!empty($request->abstrakNote[$i])){
                    $abstrak = new PerAbstrak;
                    $abstrak->abstrak = $request->abstrakNote[$i];
                    $abstrak->is_note = 't';
                    $abstrak->peraturan()->associate($peraturan);
                    $abstrak->save();
                }
            }
            $peraturan->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error($e->getMessage());
            return redirect()->back()->withInput()->with('failed', 1);
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect(('/administrasi/peraturan/'.$peraturan->per_no.'/upload'));
    }
    
    public function edit(Request $request, $id)
    {
        $negara = Negara::all();
        $instansi = Instansi::all();
        $bentuk = PerBentuk::orderBy('urutan', 'asc')->get();
        $kota = Kota::all();
        $sumber = PerSumber::all();
        $status = PerStatus::orderBy('urutan', 'asc')->get();
        $peraturan = Peraturan::all();
        $subyek = PerSubyek::orderBy('subyek')->get();
        $data = Peraturan::with('sumber', 'status', 'abstrak', 'materi', 'subyek', 'filedoc')->where('per_no', $id)->first();
        $materi = PerMateri::orderBy('materi')->get();
        
        return view('administrasi.peraturan.edit', [
            'negara' => $negara,
            'instansi' => $instansi,
            'bentuk' => $bentuk,
            'kota' => $kota,
            'sumber' => $sumber,
            'status' => $status,
            'peraturan' => $peraturan,
            'subyek' => $subyek,
            'data' => $data,
            'materi' => $materi,
        ]);
    }
    
    public function unduhPDF(Request $request, $id)
    {
        $peraturan = Peraturan::with('filedoc')->where('per_no', $id)->whereNotNull('file_id')->first();
        $filename = $peraturan->filedoc->filename;
        $path = \Config::get('constants.dir').$peraturan->filedoc->direktori.$filename;
        
        return \Response::download($path, $filename, [
            'Content-Type' => 'application/pdf'
        ]);
    }
    
    public function updatePeraturan(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $peraturan = Peraturan::find($id);
            $peraturan->per_no = $request->perno;
            $peraturan->tajuk_negara_id = $request->negara;
            $peraturan->tajuk_ins_id = $request->instansi;
            $peraturan->bentuk_short = $request->bentuk;
            $peraturan->tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
            $peraturan->tentang = $request->tentang;
            $peraturan->kota_id = $request->kota;
            $peraturan->lokasi = $request->lokasi;
            $peraturan->is_publish = 0;
            $peraturan->last_update_user = $request->user()->username;
            $peraturan->save();
            
            $peraturan->sumber()->detach();
            for($i = 0; $i < count($request->sumberShort); $i++){
                if (!empty($request->sumberShort[$i]) && !empty($request->sumberYear[$i]) && !empty($request->sumberHalaman[$i])){
                    $peraturan->sumber()->attach($request->sumberShort[$i], ['year' => empty($request->sumberYear[$i])?null:$request->sumberYear[$i], 
                    'jilid' => empty($request->sumberJilid[$i])?null:$request->sumberJilid[$i], 
                    'hal' => empty($request->sumberHalaman[$i])?null:$request->sumberHalaman[$i]]);
                }
            }
            
            $peraturan->subyek()->detach();
            for($i = 0; $i < count($request->subyek); $i++){
                $peraturan->subyek()->attach($request->subyek[$i]);
            }
            
            $peraturan->materi()->detach();
            for($i = 0; $i < count($request->materi); $i++){
                $peraturan->materi()->attach($request->materi[$i]);
            }
            
            $peraturan->status()->detach();
            for($i = 0; $i < count($request->status); $i++){
                if (!empty($request->status[$i]) && !empty($request->statusPerno[$i])){
                    $peraturan->status()->attach($request->status[$i], ['per_no_object' => empty($request->statusPerno[$i])?null:$request->statusPerno[$i]]);
                }
            }
            
            $peraturan->abstrak()->delete();
            for($i = 0; $i < count($request->abstrak); $i++){
                if (!empty($request->abstrak[$i])){
                    $abstrak = new PerAbstrak;
                    $abstrak->abstrak = $request->abstrak[$i];
                    $abstrak->is_note = 'f';
                    $abstrak->peraturan()->associate($peraturan);
                    $abstrak->save();
                }
            }
            
            for($i = 0; $i < count($request->abstrakNote); $i++){
                if (!empty($request->abstrakNote[$i])){
                    $abstrak = new PerAbstrak;
                    $abstrak->abstrak = $request->abstrakNote[$i];
                    $abstrak->is_note = 't';
                    $abstrak->peraturan()->associate($peraturan);
                    $abstrak->save();
                }
            }
            $peraturan->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error($e->getMessage());
            return redirect()->back()->withInput()->with('failed', 1);
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/peraturan');
    }
    
    public function destroyPeraturan(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $peraturan = Peraturan::find($id);
            
            $fileThumb = str_replace('/', '-', $peraturan->per_no).'.jpg';
            $peraturan->sumber()->detach();
            $peraturan->subyek()->detach();
            $peraturan->status()->detach();
            
            $peraturan->abstrak()->delete();
            $file = $peraturan->filedoc;
            $peraturan->filedoc()->delete();
            $peraturan->delete();
            if (!empty($file)){
                $dirThumb = \Config::get('constants.public_upload').'peraturan';
                $thumbWithPath = $dirThumb.'/'.$fileThumb;
                $pdfPath = \Config::get('constants.dir').$file->direktori.$file->filename;
                if (file_exists($pdfPath)) unlink($pdfPath);
                if (file_exists($thumbWithPath)) unlink($thumbWithPath);
            }
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Hapus data gagal");
            return redirect('/administrasi/peraturan');
        }
        
        DB::commit();
        \Flash::success("Hapus data berhasil");
        return redirect('/administrasi/peraturan');
    }
    
    public function getPDF(Request $request, $id)
    {
        $file = PerFile::find($id);
        $filename = $file->filename;
        $path = \Config::get('constants.dir').$file->direktori.$filename;
        
        return \Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
    
    public function uploadForm(Request $request, $id)
    {
        $data = Peraturan::with('filedoc')->where('per_no', $id)->first();
        
        return view('administrasi.peraturan.uploadPDFForm', [
            'data' => $data,
        ]);
    }
    
    public function uploadPDF(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $peraturan = Peraturan::with('filedoc')->where('per_no', $id)->first();
            $peraturan->is_publish = 0;
            $peraturan->last_update_user = $request->user()->username;
                
            $public_upload = \Config::get('constants.public_upload');
            
            $dirThumb = $public_upload.'peraturan';
            $dirFile = \Config::get('constants.pdfPeraturanDir');
            if ($request->file('pdf') && $request->file('pdf')->isValid()) {
                if (!file_exists ($dirFile)){
                    mkdir($dirFile, 0755, true);
                }
                if (!file_exists ($dirThumb)){
                    mkdir($dirThumb, 0755, true);
                }
                $filePDF = str_replace('/', '-', $peraturan->per_no).'.pdf';
                if (!$peraturan->filedoc){
                    $file = new PerFile;
                }else{
                    $file = $peraturan->filedoc;
                }
                $request->file('pdf')->move($dirFile, $filePDF);
                $file->filename = $filePDF;
                $file->direktori = \Config::get('constants.pdfPeraturanDirDB');;
                $file->file_type = 'pdf';
                $file->save();
                $peraturan->file_id = $file->file_id;
                $peraturan->save();
                $pdfWithPath = $dirFile.'/'.$filePDF;
                $fileThumb = str_replace('/', '-', $peraturan->per_no).'.jpg';
                $thumbWithPath = $dirThumb.'/'.$fileThumb;             
                
                /*$fileImage = \Config::get('constants.public_upload').'watermark.png';
                $watermark = new PDFWatermark($fileImage); 
        		$watermarker = new PDFWatermarker($pdfWithPath, $pdfWithPath, $watermark); 
        		$watermarker->setWatermarkPosition('center');
        		$watermarker->watermarkPdf('F');
                
                $img = new \Imagick();                
                $img->setResolution(200,200);
                $img->readImage("{$pdfWithPath}[0]");                
                $img->scaleImage(150,0);
                $img->setImageBackgroundColor('#ffffff');
                $img = $img->mergeImageLayers(\Imagick::LAYERMETHOD_FLATTEN);
                
                $img->setImageFormat("jpeg");
                $img->setImageCompressionQuality(95);
                $img->writeImages($thumbWithPath, false);*/
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['result' => $e->getMessage()]);
        }
        
        DB::commit();
        return response()->json(['result' => 'yes', 'id' => $peraturan->file_id]);
    }
    
    public function importForm(Request $request)
    {
        return view('administrasi.peraturan.importForm', []);
    }
    
    public function import(Request $request)
    {
        $peraturanColl = Peraturan::all()->pluck('per_no')->transform(function ($item, $key) {
            return strtolower($item);
        })->all();
        $negaraRef = Negara::all()->pluck('nama_negara')->transform(function ($item, $key) {
            return strtolower($item);
        })->all();
        $instansiRef = Instansi::all()->pluck('nama_instansi')->transform(function ($item, $key) {
            return strtolower($item);
        })->all();
        $kotaRef = Kota::all()->pluck('nama_kota')->transform(function ($item, $key) {
            return strtolower($item);
        })->all();
        $statusRef = PerStatus::all()->pluck('status')->transform(function ($item, $key) {
            return strtolower($item);
        })->all();
        $sumberRef = PerSumber::all()->pluck('sumber_short')->transform(function ($item, $key) {
            return strtolower($item);
        })->all();
        $bentukRef = PerBentuk::orderBy('urutan')->get()->pluck('bentuk_short')->transform(function ($item, $key) {
            return strtolower($item);
        })->all();
        $hasil = [];
        if ($request->file('xl') && $request->file('xl')->isValid()) {
            \Excel::load($request->file('xl'), function($reader) use($peraturanColl, $negaraRef, $instansiRef, $kotaRef, $sumberRef, $statusRef, $bentukRef, &$hasil) {
                $results = $reader->get();
                $i = 1;
                foreach($results as $row){
                    $column = [];
                    $column['no'] = $i;
                    $column['error'] = [];
                    if (empty($row[0])) continue;
                    $tajuk = explode('. ', $row[1]);
                    $column['negara'] = trim($tajuk[0]);
                    if (empty($column['negara'])){
                        $column['error'][] = 'Negara tidak boleh kosong';
                    }elseif (!in_array(strtolower($column['negara']), $negaraRef)){
                        $column['error'][] = 'Negara '.$column['negara'].' belum tersedia di referensi';
                    }
                    
                    $column['instansi'] = trim($tajuk[1]);
                    if (empty($column['instansi'])){
                        $column['error'][] = 'Instansi tidak boleh kosong';
                    }elseif (!in_array(strtolower($column['instansi']), $instansiRef)){
                        $column['error'][] = 'Instansi '.$column['instansi'].' belum tersedia di referensi';
                    }
                    
                    $column['judul_seragam'] = trim($row[2]);
                    $column['bentuk'] = trim($row[3]);
                    if (empty($column['bentuk'])){
                        $column['error'][] = 'Bentuk Peraturan tidak boleh kosong';
                    }elseif (!in_array(strtolower($column['bentuk']), $bentukRef)){
                        $column['error'][] = 'Bentuk Peraturan '.$column['bentuk'].' belum tersedia di referensi';
                    }
                    
                    $column['nomor_peraturan'] = trim($row[4]);
                    if (empty($column['nomor_peraturan'])){
                        $column['error'][] = 'Nomor Peraturan tidak boleh kosong';
                    }elseif (in_array(strtolower($column['nomor_peraturan']), $peraturanColl)){
                        $column['error'][] = 'Nomor Peraturan '.$column['nomor_peraturan'].' sudah ada di database';
                    }
                    
                    $column['tanggal_penetapan'] = $row[5]->format('d-m-Y');
                    $column['tentang'] = trim($row[6]);
                    $column['tempat_penetapan'] = trim($row[7]);
                    if (empty($column['tempat_penetapan'])){
                        $column['error'][] = 'Kota Penetapan tidak boleh kosong';
                    }elseif (!in_array(strtolower($column['tempat_penetapan']), $kotaRef)){
                        $column['error'][] = 'Kota Penetapan '.$column['tempat_penetapan'].' belum tersedia di referensi';
                    }
                    
                    $sumber = explode('<br />', nl2br($row[8]));
                    $column['sumber'] = new Collection;
                    foreach($sumber as $valSumber){
                        if (empty($valSumber)) continue;
                        $arr3 = [];
                        $arr1 = explode(':', $valSumber);
                        $arr3['hal'] = (int)str_replace(array(' ', 'hlm'), '', $arr1[1]);
                        if (empty($arr3['hal'])){
                            $column['error'][] = 'Halaman Sumber Teks tidak boleh kosong';
                        }
                        $arr2 = explode('(', $arr1[0]);
                        $arr3['jilid'] = (!empty($arr2[1]))?(int)str_replace(array(' ', ')'), '', $arr2[1]):'';
                        $arr2[0] = trim($arr2[0]);
                        $arr3['jnsSumber'] = trim(substr($arr2[0], 0, strrpos($arr2[0], ' ')));
                        if (!in_array(strtolower($arr3['jnsSumber']), $sumberRef)){
                            $column['error'][] = 'Sumber Teks '.$arr3['jnsSumber'].' belum tersedia di referensi';
                        }
                        $arr3['thnSumber'] = (int)substr($arr2[0], strrpos($arr2[0], ' '), strlen($arr2[0]));
                        if (empty($arr3['thnSumber'])){
                            $column['error'][] = 'Tahun Sumber Teks tidak boleh kosong';
                        }
                        $column['sumber']->push($arr3);
                    }
                    $status = explode('<br />', nl2br($row[9]));
                    $column['status'] = new Collection;
                    foreach($status as $valStatus){
                        if (empty($valStatus)) continue;
                        $arrResult = [];
                        foreach ($statusRef as $ref){
                            if (strpos(strtolower($valStatus), $ref) !== false){
                                $arrResult['status'] = $ref;
                                $valStatus = substr((trim($valStatus)), strpos((trim($valStatus)), ' '));
                                break;
                            }
                        }
                        foreach ($bentukRef as $ref){
                            if (strpos(strtolower($valStatus), $ref) !== false){
                                $valStatus = substr((trim($valStatus)), strpos((trim($valStatus)), ' '));
                                break;
                            }
                        }
                        if (strpos(strtolower($valStatus), 'nomor') !== false){
                            $valStatus = substr((trim($valStatus)), strpos((trim($valStatus)), ' '));
                        }
                        $arrResult['objek_peraturan'] = trim($valStatus);
                        if (!empty($arrResult['objek_peraturan']) && !empty($arrResult['status'])){
                            $arrResult['statusResult'] = $arrResult['status'].' '.$arrResult['objek_peraturan'];
                        }else{
                            $column['error'][] = 'Data Status Peraturan belum benar.';
                        }
                        $column['status']->push($arrResult);
                    }
                    $subyek = explode('<br />', nl2br($row[10]));
                    $column['subyek'] = new Collection;
                    foreach($subyek as $valSubyek){
                        $valSubyek = trim($valSubyek);
                        if (empty($valSubyek)) continue;
                        $column['subyek']->push($valSubyek);
                    }
                    $column['penyimpanan'] = trim($row[11]);
                    
                    $column['abstrak'] = [];
                    $column['abstrak'][] = ['val' => trim($row[12]), 'show' => trim(nl2br($row[12]))];
                    if (empty(trim($row[12]))){
                        $column['error'][] = 'Abstrak 1 tidak boleh kosong';
                    }
                    
                    $column['abstrak'][] = ['val' => trim($row[13]), 'show' => trim(nl2br($row[13]))];
                    if (empty(trim($row[13]))){
                        $column['error'][] = 'Abstrak 2 tidak boleh kosong';
                    }
                    
                    $column['abstrak'][] = ['val' => trim($row[14]), 'show' => trim(nl2br($row[14]))];
                    if (empty(trim($row[14]))){
                        $column['error'][] = 'Abstrak 3 tidak boleh kosong';
                    }
                    
                    $column['abstrakNote'][] = ['val' => trim($row[15]), 'show' => trim(nl2br($row[15]))];
                    $col = 16;
                    while(!empty($row[$col]) && !empty(trim(str_replace('<br />', '', nl2br($row[$col]))))){
                        $column['abstrakNote'][] = ['val' => trim($row[$col]), 'show' => trim(nl2br($row[$col]))];
                        $col++;
                    }
                    $column['detail'] = '<a href="javascript:;" class="btn blue btn-xs dataDetail margin-bottom-5">
                                Detail
                            </a>';
                    $column['action'] = (count($column['error']) > 0)?'<a href="javascript:;" class="btn btn-danger btn-xs dataError margin-bottom-5">
                                Error
                            </a>':'<a href="javascript:;" class="btn btn-success btn-xs submitButton margin-bottom-5">
                                Submit
                            </a>'
                            ;
                    $hasil[] = $column;
                    $i++;
                }
            });
        }
        return view('administrasi.peraturan.import', ['hasil' => json_encode($hasil)]);
    }
    
    public function saveDataImport(Request $request)
    {
        DB::beginTransaction();
        try {
            $negaraRef = Negara::all()->pluck('nama_negara', 'negara_id')->transform(function ($item, $key) {
                return strtolower($item);
            })->flip()->all();
            $instansiRef = Instansi::all()->pluck('nama_instansi', 'instansi_id')->transform(function ($item, $key) {
                return strtolower($item);
            })->flip()->all();
            $kotaRef = Kota::all()->pluck('nama_kota', 'kota_id')->transform(function ($item, $key) {
                return strtolower($item);
            })->flip()->all();
            $statusRef = PerStatus::all()->pluck('status', 'status_id')->transform(function ($item, $key) {
                return strtolower($item);
            })->flip()->all();
            $sumberRef = PerSumber::all()->pluck('sumber_short', 'sumber_short')->transform(function ($item, $key) {
                return strtolower($item);
            })->flip()->all();
            $subyekRef = PerSubyek::all()->pluck('subyek', 'subyek_id')->transform(function ($item, $key) {
                return strtolower($item);
            })->flip()->all();
            $bentukRef = PerBentuk::orderBy('urutan')->get()->pluck('bentuk_short', 'bentuk_short')->transform(function ($item, $key) {
                return strtolower($item);
            })->flip()->all();
            
            $peraturan = new Peraturan;
            $peraturan->per_no = $request->nomor_peraturan;
            $peraturan->tajuk_negara_id = $negaraRef[strtolower($request->negara)];
            $peraturan->tajuk_ins_id = $instansiRef[strtolower($request->instansi)];
            $peraturan->bentuk_short = $bentukRef[strtolower($request->bentuk)];
            $peraturan->tanggal = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_penetapan)->format('Y-m-d');
            $peraturan->tentang = $request->tentang;
            $peraturan->kota_id = $kotaRef[strtolower($request->tempat_penetapan)];
            $peraturan->lokasi = $request->penyimpanan;
            $peraturan->author_user = $request->user()->username;
            $peraturan->save();
            
            if (count($request->sumber)>0){
                foreach($request->sumber as $sumber){
                    if (!empty($sumberRef[strtolower($sumber['jnsSumber'])]) && !empty($sumber['thnSumber']) && !empty($sumber['hal'])){
                        $peraturan->sumber()->attach($sumberRef[strtolower($sumber['jnsSumber'])], ['year' => empty($sumber['thnSumber'])?null:$sumber['thnSumber'], 
                        'jilid' => empty($sumber['jilid'])?null:$sumber['jilid'], 
                        'hal' => empty($sumber['hal'])?null:$sumber['hal']]);
                    }
                }
            }
            
            if (count($request->subyek)>0){
                foreach($request->subyek as $subyek){
                    if (array_key_exists((strtolower($subyek)), $subyekRef)){
                        $peraturan->subyek()->attach($subyekRef[strtolower($subyek)]);
                    }else{
                        $newSubyek = new PerSubyek;
                        $newSubyek->subyek = $subyek;
                        $newSubyek->save();
                        $peraturan->subyek()->attach($newSubyek->subyek_id);
                    }
                }
            }
            
            if (count($request->status)>0){
                foreach($request->status as $status){
                    if (!empty($statusRef[strtolower($status['status'])]) && !empty($status['objek_peraturan'])){
                        $peraturan->status()->attach($statusRef[strtolower($status['status'])], ['per_no_object' => empty($status['objek_peraturan'])?null:$status['objek_peraturan']]);
                    }
                }
            }
            
            for($i = 0; $i < count($request->abstrak); $i++){
                if (!empty($request->abstrak[$i])){
                    $abstrak = new PerAbstrak;
                    $abstrak->abstrak = $request->abstrak[$i]['val'];
                    $abstrak->is_note = 'f';
                    $abstrak->peraturan()->associate($peraturan);
                    $abstrak->save();
                }
            }
            
            for($i = 0; $i < count($request->abstrakNote); $i++){
                if (!empty($request->abstrakNote[$i])){
                    $abstrak = new PerAbstrak;
                    $abstrak->abstrak = $request->abstrakNote[$i]['val'];
                    $abstrak->is_note = 't';
                    $abstrak->peraturan()->associate($peraturan);
                    $abstrak->save();
                }
            }
            

        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['result' => 'gagal', 'type' => 'error', 'message' => 'Gagal']);
        }
        
        DB::commit();
        return response()->json(['result' => 'berhasil', 'type' => 'success', 'message' => 'Berhasil']);
    }
}
