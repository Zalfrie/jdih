<?php

namespace App\Http\Controllers\Administrasi;

use App\MiddlewareClient;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Peraturan;
use App\Model\UncategorizedPost;
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
use App\Model\PerReview;
use DB;

class ReviewController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        $bentuk = PerBentuk::orderBy('urutan', 'asc')->get();
        $status = PerStatus::orderBy('urutan', 'asc')->get();
        $subyek = PerSubyek::orderBy('subyek')->get();
//        $mukadimah = UncategorizedPost::where('post_type', 'mukadimah_program_prepare')->first();
        return view('administrasi.review.index', ['bentuk' => $bentuk, 'status' => $status, 'subyek' => $subyek]);
    }

    public function hide($id){
        DB::beginTransaction();
        try{
            $peraturan = Peraturan::where('per_no', $id)->first();
            $peraturan->is_reviewed = false;
            $peraturan->save();
        }catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            throw $e;
            return redirect('/administrasi/review');
        }
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/review');
    }

    public function remove($id){
        DB::beginTransaction();
        try{
            $peraturan = Peraturan::where('per_no', $id)->first();
            $peraturan->is_reviewed = false;
            $peraturan->save();
            PerReview::where('per_no', $id)->delete();
        }catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            throw $e;
            return redirect('/administrasi/review');
        }
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/review');
    }

    public function getDataReview(Request $request){
        $reviewList = DB::table('per_review')
            ->select(DB::raw('count(*) as jumlah, CASE WHEN users.name IS NOT NULL THEN users.name ELSE per_review.review_user END AS nama, review_user'))
            ->leftjoin('users', 'per_review.review_user', '=', 'users.username')
            ->where('per_no', $request->perno)
            ->groupBy('review_user', 'nama')
            ->orderBy('nama')
            ->get();
//        $reviewList = PerReview::where('per_no', $request->perno)->get();
        $collections = new Collection;
        foreach ($reviewList as $review){
            $collections->push([
                'pengirim' => $review->nama,
                'username' => $review->review_user,
                'jumlah' => $review->jumlah,
            ]);
        }
        return \Datatables::of($collections)
            ->addColumn('actions', function ($item){
                return '<div class="btn-group">
                            <button id="lihatReviewButton" type="button" class="btn green btn-xs lihat" value="'.$item['username'].'" onclick="lihat(\''.$item['username'].'\')" >
                                <i class="fa fa-book"></i>View</button>
                    </div>';
            })
            /*->filter(function ($instance) use ($request) {
                if ($request->has('userReview')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return ($row['review_user'] == $request->userReview) ? true : false;
                    });
                }
            })*/->make(true);
    }

    public function getDataReviewUser(Request $request){
        $reviewList = PerReview::where('per_no', $request->perno)->where('review_user', $request->userReview)->get();
        $collections = new Collection;
        foreach ($reviewList as $review){
            $collections->push([
                'review_user' => $review->review_user,
                'instansi' => $review->instansi,
                'konten' => substr($review->review, 0, 75),
                'review_at' => \Carbon\Carbon::parse($review->review_at)->format('d-m-Y H:m:s'),
                'review_id' => $review->review_id,
                'isfileExist' => !is_null($review->filedoc),
            ]);
        }
        return \Datatables::of($collections)
            ->addColumn('actions', function ($item){
                if ($item['isfileExist']){
                    return '<div class="btn-group">
                            <a href="/administrasi/review/detail/'.$item['review_id'].'" class="btn green btn-xs margin-bottom-5">
                                <i class="fa fa-search"></i>Detail
                            </a>
                            <a href="/administrasi/review/download/'.$item['review_id'].'" class="btn blue btn-xs margin-bottom-5">
                                <i class="fa fa-download"></i>File Pendukung
                            </a>
                        </div>';
                }else
                {
                    return '<div class="btn-group">
                            <a href="/administrasi/review/detail/'.$item['review_id'].'" class="btn green btn-xs margin-bottom-5">
                                <i class="fa fa-search"></i>Detail
                            </a>
                        </div>';
                }
            })
            /*->filter(function ($instance) use ($request) {
                if ($request->has('userReview')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return ($row['review_user'] == $request->userReview) ? true : false;
                    });
                }
            })*/->make(true);
    }

    public function getDataTable(Request $request)
    {
        $peraturan = Peraturan:://with('sumber', 'status', 'abstrak', 'subyek', 'materi', 'tajukNegara', 'tajukInstansi', 'kota', 'review')
            where('is_reviewed', 't')
            ->where('is_publish', 1)
            ->orderBy('review_end', 'desc')->get();
        $collections = new Collection;
        foreach($peraturan as $val){
            \Carbon\Carbon::setLocale('id');
            $tanggalCarbon = \Carbon\Carbon::createFromFormat('Y-m-d', $val->tanggal);
            $reviewStartCarbon = \Carbon\Carbon::parse($val->review_start);
            $reviewEndCarbon = \Carbon\Carbon::parse($val->review_end);
            $status = (\Carbon\Carbon::parse($val->review_start)->format('Y-m-d') <= date('Y-m-d')
                && \Carbon\Carbon::parse( $val->review_end)->format('Y-m-d') >= date('Y-m-d'))
            ? 'Open' : 'Closed';
            $collections->push([
                'perno' => $val->per_no,
                'tanggal' => ['short' => $tanggalCarbon->format('d-m-Y'), 'human' => $tanggalCarbon->formatLocalized('%d %B %Y'), 'humanShort' => $tanggalCarbon->formatLocalized('%d %b %Y'), 'tahun' => $tanggalCarbon->format('Y')],
                'tentang' => $val->tentang,
                'publish' => ['state' => $val->is_publish, 'by' => $val->publish_user, 'tgl' => $val->published_at, 'note' => $val->unpublish_note],
                'waktu_review' => $reviewStartCarbon->formatLocalized('%d %b %Y').' -<br>'.$reviewEndCarbon->formatLocalized('%d %b %Y'),
                'status' => $status,
                'sum' => $val->review->count(),
                'sum_distinct' => $val->review()->distinct('review_user')->count('review_user'),
                'file' => $val->file_id,

                /*'created' => ['tgl' => $val->created_at, 'by' => $val->author_user],
                'file' => $val->file_id,
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
                'review' =>  (count($review) > 0)?("<ul><li>".implode('</li><li>', $review)."</li></ul>"):'',
                'updated' => ['tgl' => $val->updated_at, 'by' => $val->last_update_user],
                'bentuk' => ['short' => $val->bentuk->bentuk_short, 'long' => $val->bentuk->bentuk, 'seragam' => $val->bentuk->seragam],*/

            ]);
        }
        return \Datatables::of($collections)
            ->addColumn('actions', function($item){

                if (\Auth::user()->hasRole(['Admin_Konten', 'sys_admin'])){
                return '<div class="btn-group">
                                <a href="/administrasi/peraturan/'.$item['perno'].'/review" class="btn blue btn-xs margin-bottom-5">
                                    <i class="icon-settings"></i>
                                    Ubah
                                </a>
                                <a href="/administrasi/review/'.$item['perno'].'/stop" class="btn red btn-xs margin-bottom-5 stopReview">
                                    <i class="fa fa-ban"></i>
                                    Stop
                                </a>
                                <a href="/administrasi/review/'.$item['perno'].'/review-submit" class="btn green btn-xs margin-bottom-5">
                                    <i class="fa fa-book"></i>
                                    Review
                                </a>
                            </div>';
                }else{
                    return '<div class="btn-group">
                                <a href="/administrasi/review/'.$item['perno'].'/review-submit" class="btn green btn-xs margin-bottom-5">
                                    <i class="fa fa-book"></i>
                                    Review
                                </a>
                            </div>';
                }
            })
            ->addColumn('berkas', function($item){
                $pdf = (empty($item['file'])) ? '':'
                            <br/><a href="javascript:;" class="btn blue btn-xs pdf">
                                <i class="fa fa-file-pdf-o"></i>
                                pdf
                            </a>';
                return $pdf;
            })
            ->filter(function ($instance) use ($request) {
                /*if ($request->has('bentuk')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return ($row['bentuk']['short'] == $request->bentuk) ? true : false;
                    });
                }*/
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
                /*if ($request->has('status')) {
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
                }*/
                if (!empty($request->search['value'])){
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
//                        return str_contains(strtolower($row['bentuk']['short']), strtolower($request->search['value']))
                            return  str_contains(strtolower($row['perno']), strtolower($request->search['value']))
                            ||  str_contains(strtolower($row['tanggal']['short']), strtolower($request->search['value']))
                            ||  str_contains(strtolower($row['tentang']), strtolower($request->search['value']))
//                            ||  str_contains(strtolower($row['sumberTabel']), strtolower($request->search['value']))
//                            ||  str_contains(strtolower($row['statusList']), strtolower($request->search['value']))
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
    
    public function review(Request $request, $id)
    {
        $data = Peraturan::with('sumber', 'status', 'abstrak', 'materi', 'subyek', 'tajukNegara', 'tajukInstansi', 'kota', 'bentuk', 'review')->find($id);
        if ($data->review_start != null) $data->review_start_format = $data->review_start->format('Y-m-d');
        if ($data->review_end != null) $data->review_end_format = $data->review_end->format('Y-m-d');
        return view('administrasi.review.review', [
            'data' => $data,
        ]);
    }

    public function download($id)
    {
        $review = PerReview::where('review_id', $id)->first();
        $path = \Config::get('constants.dir').$review->filedoc->direktori.$review->filedoc->filename;
        return \Response::download($path, $review->filedoc->filename, [
            'Content-Type' => 'application/octet-stream'
        ]);
    }

    public function editWaktu(Request $request, $id)
    {
        $this->validate($request, [
            'review_end' => 'required|date|after:review_start',
            'review_start' => 'required',
            ]);
        DB::beginTransaction();
        try {
            $peraturan = Peraturan::find($id);
            $peraturan->review_start = $request->review_start;
            $peraturan->review_end = $request->review_end;
            $peraturan->catatan_prepare = $request->catatan;
            $peraturan->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            throw $e;
            return redirect('/administrasi/review');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/review');
    }


    public function stop(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $peraturan = Peraturan::find($id);
            $peraturan->review_end = date('Y-m-d', strtotime('-1 day'));
            $peraturan->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            return redirect('/administrasi/review');
        }
        
        DB::commit();
        \Flash::success("Data berhasil disimpan");
        return redirect('/administrasi/review');
    }

    public function tambah(Request $request)
    {
        $peraturan = Peraturan::where('is_publish', 1)
            ->where('is_reviewed', false)
            ->where('per_no', 'like', 'PER%')
            ->orWhere('per_no', 'like', 'KEP%')
            ->get();
        return view('administrasi.review.tambah', [
            'peraturan' => $peraturan,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'review_end' => 'required|date|after:yesterday',
        ]);
        try{
            $peraturan = Peraturan::find($request->perno);
            if ($peraturan->review_start == null) $peraturan->review_start = \Carbon::now();
            $peraturan->review_end = $request->review_end;
            $peraturan->catatan_prepare = $request->catatan;
            $peraturan->is_reviewed = true;
            $peraturan->save();
            \Flash::success("Tambah Review Peraturan berhasil");
            return redirect('/administrasi/review');
        } catch(\Exception $e){
            \Flash::error("Tambah Review Peraturan gagal");
            return redirect('/administrasi/review');
        }
    }

    public function reviewSubmit(Request $request, $id)
    {
        $isReviewer = false;
        $user_review = PerReview::where('per_no', $id)->where('review_user', \Auth::user()->username)->first();
        if (!is_null($user_review)){
            $isReviewer = true;
        }
        $peraturan = Peraturan::where('per_no', $id)->first();
        $peraturan->isActive = (\Carbon\Carbon::parse($peraturan->review_start)->format('Y-m-d') <= date('Y-m-d')
            && \Carbon\Carbon::parse( $peraturan->review_end)->format('Y-m-d') >= date('Y-m-d'))
            ? true : false;
        return view('administrasi.review.submit', [
            'peraturan' => $peraturan,
            'isReviewer' => $isReviewer,
        ]);
    }

    public function detail($review_id)
    {
        $review = PerReview::where('review_id', $review_id)->first();
        $peraturan = Peraturan::where('per_no', $review->per_no)->first();
        $peraturan->isActive = false;
        return view('administrasi.review.detail',[
            'peraturan' => $peraturan,
            'review' => $review,
        ]);
    }

    public function reviewSimpan(Request $request, $id){
        $this->validate($request, [
            'konten' => 'required',
        ]);
        \DB::beginTransaction();
        try {
            $peraturan = Peraturan::find($id);
//            $user_review = PerReview::with('filedoc')->where('per_no', $id)->where('review_user', $request->user()->username)->first();
            $user_review = PerReview::create([
                'review_user' => $request->user()->username,
                'review' => $request->konten,
            ]);
//            $review->review_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $public_upload = \Config::get('constants.public_upload');
            $dirThumb = $public_upload.'review';
            $dirFile = \Config::get('constants.fileReviewDir');
            if ($request->file('file') && $request->file('file')->isValid()){
                if (!file_exists ($dirFile)){
                    mkdir($dirFile, 0755, true);
                }
                if (!file_exists ($dirThumb)){
                    mkdir($dirThumb, 0755, true);
                }
//                $fileUpload = str_replace('/', '-', $peraturan->per_no).'-'.$user_review->review_user.'.'.$request->file('file')->getClientOriginalExtension();
                $fileUpload = $user_review->review_id.'.'.$request->file('file')->getClientOriginalExtension();
                if (!$user_review->filedoc){
                    $file = new PerFile;
                }else{
                    $file = $user_review->filedoc;
                }
                $request->file('file')->move($dirFile, $fileUpload);
                $file->filename = $fileUpload;
                $file->direktori = \Config::get('constants.fileReviewDirDB');;
                $file->file_type = $request->file('file')->getClientOriginalExtension();
                $file->save();
                $user_review->file_id = $file->file_id;/*
                $pdfWithPath = $dirFile.'/'.$fileUpload;
                $fileThumb = str_replace('/', '-', $peraturan->per_no).'-'.$user_review->review_user.'.jpg';
                $thumbWithPath = $dirThumb.'/'.$fileThumb;*/
            }
            $user_review->peraturan()->associate($peraturan);
            $user_review->instansi = MiddlewareClient::getAsalInstansi($request->user()->username);
            $user_review->save();
        } catch(\Exception $e){
            \DB::rollback();
            \Flash::error("Simpan data gagal.");
            return redirect('/administrasi/review');///{{$id}}/review-submit')->withInput();
        }
        \DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/review');
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
}
