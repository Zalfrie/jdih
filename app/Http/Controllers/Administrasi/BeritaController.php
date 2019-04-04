<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\KategoriBerita;
use App\Model\Berita;
use DB;

class BeritaController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('administrasi.berita.index', []);
    }
    
    public function publish(Request $request)
    {
        try{
            $berita = Berita::find($request->id);
            $berita->is_publish = ($request->val == 'f') ? 't':'f';
            $berita->published_at = ($request->val == 'f') ? \Carbon\Carbon::now()->format('Y-m-d H:i:s'):null;
            $berita->save();
            return response()->json(['isPublish' => $berita->is_publish, 'type' => 'success', 'message' => 'Berhasil', 'title' => ($berita->is_publish == 't') ? 'Publish':'Unpublish', 'publish_at' => ($berita->is_publish == 't') ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $berita->published_at)->format('d-m-Y H:i:s'):'']);
        } catch(\Exception $e){
            throw $e;
            return response()->json(['isPublish' => $berita->is_publish, 'type' => 'error', 'message' => 'Gagal', 'title' => ($request->val == 'f') ? 'Publish':'Unpublish']);
        }
    }
    
    public function dataTable(Request $request)
    {
        $berita = Berita::with('kategori', 'author')->get();
        $collections = new Collection;
        foreach($berita as $val){
            $collections->push([
                'judul' => $val->title,
                'konten' => $val->content,
                'kontenPreview' => htmlspecialchars(substr($val->content, 0, 80)),
                'gbr' => $val->image,
                'author' => $val->author->name,
                'tgl_terbit' => $val->is_publish ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val->published_at)->format('d-m-Y H:i:s'):'',
                'status' => $val->is_publish,
                'id' => $val->berita_id
            ]);
        }
        return \Datatables::of($collections)
            ->addColumn('publish', function($item){
                $result = '<i class="publishCheck fa fa'.($item['status'] ? '-check':'').'-square font-'.($item['status'] ? 'green':'red').'"></i><br/>';
                $result .= '<a href="javascript:;" class="btn '.($item['status'] ? 'red':'green').' btn-xs publish" data-publish="'.($item['status'] ? 't':'f').'">
                                '.($item['status'] ? 'batalkan':'publish').'
                            </a>';
                return $result;
            })
            ->addColumn('actions', function($item){
                return '<div class="btn-group">
                            <a href="/administrasi/berita/'.$item['id'].'/edit" class="btn blue btn-xs">
                                <i class="fa fa-edit"></i>
                                Ubah
                            </a>
                            <form action="/administrasi/berita/'.$item['id'].'" method="POST" style="float: left;">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="button" class="btn btn-danger btn-xs deleteData">
                                    <i class="fa fa-btn fa-trash"></i>Hapus
                                </button>
                            </form>
                        </div>';
            })
            ->addColumn('expander', function(){
                return '<span class="row-details row-details-close"></span>';
            })
            ->make(true);
    }
    
    public function tambah(Request $request)
    {
        $kategori = KategoriBerita::all();
        return view('administrasi.berita.tambah', ['kategori' => $kategori]);
    }
    
    public function simpan(Request $request)
    {
        \DB::beginTransaction();
        try {
            $public_upload = \Config::get('constants.public_upload');
            $dir = $public_upload.'/'.date('Y').'/'.date('m');
            if ($request->file('image')->isValid()) {
                if (!file_exists ($dir)){
                    mkdir($dir, 0755, true);
                }
                $news = new Berita;
                $img = \Image::make($_FILES['image']['tmp_name']);
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(($dir."/".pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension()));
                //$request->file('image')->move($dir, $request->file('image')->getClientOriginalName());
                $news->image = ("/assets/upload/".date('Y').'/'.date('m').'/'.pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension());
                $news->is_publish = ($request->status == 'draft')? 'f':'t';
                $news->published_at = ($request->status != 'draft') ? \Carbon\Carbon::now()->format('Y-m-d H:i:s'):null;
                $news->author_id = $request->user()->id;
                $news->title = $request->judul;
                $news->content = $request->konten;
                $news->save();
            
                foreach($request->kategori as $kategori){
                    $news->kategori()->attach($kategori);
                }
            }
        } catch(\Exception $e){
            \DB::rollback();
            \Flash::error("Simpan data gagal.");
            return redirect('/administrasi/berita/tambah')->withInput();
        }
        
        \DB::commit();
        \Flash::success("Simpan data berhasil.");
        return redirect('/administrasi/berita');
    }
    
    public function edit(Request $request, $id)
    {
        $data = Berita::with('kategori')->find($id);
        $kategori = KategoriBerita::all();
        
        return view('administrasi.berita.edit', [
            'data' => $data,
            'kategori' => $kategori
        ]);
    }
    
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $news = Berita::find($id);
            
            $public_upload = \Config::get('constants.public_upload');
            $dir = $public_upload.'/'.date('Y').'/'.date('m');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if (!file_exists ($dir)){
                    mkdir($dir, 0755, true);
                }
                $img = \Image::make($_FILES['image']['tmp_name']);
                $img->resize(1280, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(($dir."/".pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension()));
                //$request->file('image')->move($dir, $request->file('image')->getClientOriginalName());
                $news->image = ("/assets/upload/".date('Y').'/'.date('m').'/'.pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME)."_".$img->width()."x".$img->height().".".$request->file('image')-> getClientOriginalExtension());
            }
            $news->is_publish = ($request->status == 'draft')? 'f':'t';
            $news->published_at = ($request->status != 'draft') ? \Carbon\Carbon::now()->format('Y-m-d H:i:s'):null;
            $news->author_id = $request->user()->id;
            $news->title = $request->judul;
            $news->content = $request->konten;
            $news->save();
            $news->kategori()->detach();
            foreach($request->kategori as $kategori){
                $news->kategori()->attach($kategori);
            }
            $news->save();
        } catch(\Exception $e){
            \DB::rollback();
            \Flash::error("Simpan data gagal.");
            return redirect('/administrasi/berita/{{$id}}/edit')->withInput();
        }
        
        \DB::commit();
        \Flash::success("Simpan data berhasil.");
        return redirect('/administrasi/berita');
    }
    
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Berita::find($id);
            $data->kategori()->detach();
            $data->delete();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Hapus data gagal");
            return redirect('/administrasi/berita');
        }
        
        DB::commit();
        \Flash::success("Hapus data berhasil");
        return redirect('/administrasi/berita');
    }
}
