<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Headline;
use DB;

class HeadlineController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('administrasi.headline.index', []);
    }
    
    public function publish(Request $request)
    {
        try{
            $headline = Headline::find($request->id);
            $headline->is_active = ($request->val == 'f') ? 't':'f';
            $headline->save();
            return response()->json(['isPublish' => $headline->is_active, 'type' => 'success', 'message' => 'Berhasil', 'title' => ($headline->is_active == 't') ? 'Publish':'Unpublish']);
        } catch(\Exception $e){
            throw $e;
            return response()->json(['isPublish' => $headline->is_active, 'type' => 'error', 'message' => 'Gagal', 'title' => ($request->val == 'f') ? 'Publish':'Unpublish']);
        }
    }
    
    public function dataTable(Request $request)
    {
        $headline = Headline::all();
        $collections = new Collection;
        foreach($headline as $val){
            $collections->push([
                'kosong' => '',
                'konten' => $val->content,
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
                            <a href="/administrasi/headline/'.$item['id'].'/edit" class="btn blue btn-xs">
                                <i class="fa fa-edit"></i>
                                Ubah
                            </a>
                            <form action="/administrasi/headline/'.$item['id'].'" method="POST" style="float: left;">
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
        return view('administrasi.headline.tambah');
    }
    
    public function simpan(Request $request)
    {
        \DB::beginTransaction();
        try {
            $headline = new Headline;
            $headline->is_active = ($request->status == 'draft')? 'f':'t';
            $headline->content = $request->konten;
            $headline->save();
        } catch(\Exception $e){
            \DB::rollback();
            \Flash::error("Simpan data gagal.");
            return redirect('/administrasi/headline/tambah')->withInput();
        }
        
        \DB::commit();
        \Flash::success("Simpan data berhasil.");
        return redirect('/administrasi/headline');
    }
    
    public function edit(Request $request, $id)
    {
        $data = Headline::find($id);
        return view('administrasi.headline.edit', ['data' => $data]);
    }
    
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $headline = Headline::find($id);
            $headline->is_active = ($request->status == 'draft')? 'f':'t';
            $headline->content = $request->konten;
            $headline->save();
        } catch(\Exception $e){
            \DB::rollback();
            \Flash::error("Simpan data gagal.");
            return redirect('/administrasi/headline/'.$id.'/edit')->withInput();
        }
        
        \DB::commit();
        \Flash::success("Simpan data berhasil.");
        return redirect('/administrasi/headline');
    }
    
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = Headline::find($id);
            $data->delete();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Hapus data gagal");
            return redirect('/administrasi/headline');
        }
        
        DB::commit();
        \Flash::success("Hapus data berhasil");
        return redirect('/administrasi/headline');
    }
}
