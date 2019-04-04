<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use App\Model\Whitelist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use DB;

class WhitelistController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('administrasi.whitelist.index', []);
    }
    
    public function publish(Request $request)
    {
        try{
            $whitelist = Whitelist::find($request->id);
            $whitelist->is_active = ($request->val == 'f') ? 't':'f';
            $whitelist->save();
            return response()->json(['isPublish' => $whitelist->is_active, 'type' => 'success', 'message' => 'Berhasil', 'title' => ($whitelist->is_active == 't') ? 'Publish':'Unpublish']);
        } catch(\Exception $e){
            throw $e;
            return response()->json(['isPublish' => $whitelist->is_active, 'type' => 'error', 'message' => 'Gagal', 'title' => ($request->val == 'f') ? 'Publish':'Unpublish']);
        }
    }
    
    public function dataTable(Request $request)
    {
        $whitelist = Whitelist::all();
        $collections = new Collection;
        foreach($whitelist as $val){
            $collections->push([
                'ip' => $val->ip,
                'domain' => $val->domain,
                'keterangan' => $val->keterangan,
                'status' => $val->is_active,
                'id' => $val->id
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
                            <a href="/administrasi/whitelist/'.$item['id'].'/edit" class="btn blue btn-xs">
                                <i class="fa fa-edit"></i>
                                Ubah
                            </a>
                            <form action="/administrasi/whitelist/'.$item['id'].'" method="POST" style="float: left;">
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
        return view('administrasi.whitelist.tambah');
    }
    
    public function simpan(Request $request)
    {
        \DB::beginTransaction();
        try {
            $whitelist = new Whitelist;
            $whitelist->is_active = ($request->status == 'draft')? 'f':'t';
            $whitelist->ip = $request->ip;
            $whitelist->domain = $request->domain;
            $whitelist->keterangan = $request->keterangan;
            $whitelist->save();
        } catch(\Exception $e){
            \DB::rollback();
            \Flash::error("Simpan data gagal.");
            return redirect('/administrasi/whitelist/tambah')->withInput();
        }
        
        \DB::commit();
        \Flash::success("Simpan data berhasil.");
        return redirect('/administrasi/whitelist');
    }
    
    public function edit(Request $request, $id)
    {
        $data = Whitelist::find($id);
        return view('administrasi.whitelist.edit', ['data' => $data]);
    }
    
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $whitelist = Whitelist::find($id);
            $whitelist->is_active = ($request->status == 'draft')? 'f':'t';
            $whitelist->ip = $request->ip;
            $whitelist->domain = $request->domain;
            $whitelist->keterangan = $request->keterangan;
            $whitelist->save();
        } catch(\Exception $e){
            \DB::rollback();
            \Flash::error("Simpan data gagal.");
            return redirect('/administrasi/whitelist/'.$id.'/edit')->withInput();
        }
        
        \DB::commit();
        \Flash::success("Simpan data berhasil.");
        return redirect('/administrasi/whitelist');
    }
    
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Whitelist::find($id);
            $data->delete();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Hapus data gagal");
            return redirect('/administrasi/whitelist');
        }
        
        DB::commit();
        \Flash::success("Hapus data berhasil");
        return redirect('/administrasi/whitelist');
    }
}
