<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Tautan;
use DB;

class TautanController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('administrasi.tautan.index', []);
    }
    
    public function dataTable(Request $request)
    {
        $data = DB::table(DB::raw("(SELECT tautan_id AS id, tautan, keterangan, link, urutan FROM tautan) A"))->select(['id', 'tautan', 'keterangan', 'link', 'urutan']);
        return \Datatables::of($data)
            ->addColumn('actions', function($item){
                return '<div class="btn-group">
                            <a href="/administrasi/tautan/'.$item->id.'/edit" class="btn blue btn-xs">
                                <i class="fa fa-edit"></i>
                                Ubah
                            </a>
							<form action="/administrasi/tautan/'.$item->id.'" method="POST" style="float: left;">
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
        return view('administrasi.tautan.tambah', []);
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = new Tautan;
            $data->tautan = $request->tautan;
            $data->keterangan = $request->keterangan;
            $data->link = $request->link;
            $data->urutan = $request->urutan;
            $data->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            throw $e;
            return redirect('/administrasi/tautan/tambah')->withInput();
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/tautan');
    }
    
    public function edit(Request $request, $id)
    {
        $data = Tautan::find($id);
        
        return view('administrasi.tautan.edit', [
            'data' => $data,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Tautan::find($id);
            $data->tautan = $request->tautan;
            $data->keterangan = $request->keterangan;
            $data->link = $request->link;
            $data->urutan = $request->urutan;
            $data->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            return redirect('/administrasi/tautan');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/tautan');
    }
    
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Tautan::find($id);
            $data->delete();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Hapus data gagal");
            return redirect('/administrasi/tautan');
        }
        
        DB::commit();
        \Flash::success("Hapus data berhasil");
        return redirect('/administrasi/tautan');
    }
}
