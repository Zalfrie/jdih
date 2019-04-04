<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Instansi;
use DB;

class ReferensiInstansiController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('administrasi.referensi.instansi.index', []);
    }
    
    public function dataTable(Request $request)
    {
        $data = DB::table(DB::raw("(SELECT instansi_id AS id, nama_instansi AS nama FROM instansi) A"))->select(['id', 'nama']);
        return \Datatables::of($data)
            ->addColumn('actions', function($item){
                return '<div class="btn-group">
                            <a href="/administrasi/referensi/instansi/'.$item->id.'/edit" class="btn blue btn-xs">
                                <i class="fa fa-edit"></i>
                                Ubah
                            </a>
							<form action="/administrasi/referensi/instansi/'.$item->id.'" method="POST" style="float: left;">
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
        return view('administrasi.referensi.instansi.tambah', []);
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = new Instansi;
            $data->nama_instansi = $request->instansi;
            $data->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            return redirect('/administrasi/referensi/instansi');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/referensi/instansi');
    }
    
    public function edit(Request $request, $id)
    {
        $data = Instansi::find($id);
        
        return view('administrasi.referensi.instansi.edit', [
            'data' => $data,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Instansi::find($id);
            $data->nama_instansi = $request->instansi;
            $data->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            return redirect('/administrasi/referensi/instansi');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/referensi/instansi');
    }
    
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Instansi::find($id);
            $data->delete();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Hapus data gagal");
            return redirect('/administrasi/referensi/instansi');
        }
        
        DB::commit();
        \Flash::success("Hapus data berhasil");
        return redirect('/administrasi/referensi/instansi');
    }
}
