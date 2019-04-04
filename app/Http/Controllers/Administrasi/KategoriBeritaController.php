<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\KategoriBerita;
use DB;

class KategoriBeritaController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('administrasi.referensi.kategoriberita.index', []);
    }
    
    public function dataTable(Request $request)
    {
        $data = DB::table(DB::raw("(SELECT kategori_id AS id, kategori, urutan, slug FROM berita_kategori_ref) A"))->select(['id', 'kategori', 'urutan', 'slug']);
        return \Datatables::of($data)
            ->addColumn('actions', function($item){
                return '<div class="btn-group">
                            <a href="/administrasi/referensi/kategoriberita/'.$item->id.'/edit" class="btn blue btn-xs">
                                <i class="fa fa-edit"></i>
                                Ubah
                            </a>
							<form action="/administrasi/referensi/kategoriberita/'.$item->id.'" method="POST" style="float: left;">
								'.csrf_field().'
								'.method_field('DELETE').'
								<button type="button" class="btn btn-danger btn-xs deleteData">
									<i class="fa fa-btn fa-trash"></i>Hapus
								</button>
							</form>
						</div>';
            })
            ->make(true);
    }
    
    public function tambah(Request $request)
    {
        return view('administrasi.referensi.kategoriberita.tambah', []);
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = new KategoriBerita;
            $data->kategori = $request->kategori;
            $data->urutan = $request->urutan;
            $data->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            return redirect('/administrasi/referensi/kategoriberita');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/referensi/kategoriberita');
    }
    
    public function edit(Request $request, $id)
    {
        $data = KategoriBerita::find($id);
        
        return view('administrasi.referensi.kategoriberita.edit', [
            'data' => $data,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = KategoriBerita::find($id);
            $data->kategori = $request->kategori;
            $data->urutan = $request->urutan;
            $data->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            return redirect('/administrasi/referensi/kategoriberita');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/referensi/kategoriberita');
    }
    
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = KategoriBerita::find($id);
            $data->delete();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Hapus data gagal");
            return redirect('/administrasi/referensi/kategoriberita');
        }
        
        DB::commit();
        \Flash::success("Hapus data berhasil");
        return redirect('/administrasi/referensi/kategoriberita');
    }
}
