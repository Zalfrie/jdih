<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\UncategorizedPost;
use DB;

class VisiMisiController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        $prakata = UncategorizedPost::where('post_type', 'prakata_visi_misi')->first();
        $visi = UncategorizedPost::where('post_type', 'visi')->first();
        $misi = UncategorizedPost::where('post_type', 'misi')->first();
        return view('administrasi.visimisi.index', ['prakata' => $prakata, 'visi' => $visi, 'misi' => $misi]);
    }
    
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $prakata = UncategorizedPost::where('post_type', 'prakata_visi_misi')->first();
            $visi = UncategorizedPost::where('post_type', 'visi')->first();
            $misi = UncategorizedPost::where('post_type', 'misi')->first();
            $prakata->content = $request->prakata;
            $visi->content = $request->visi;
            $misi->content = $request->misi;
            $prakata->save();
            $visi->save();
            $misi->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            throw $e;
            return redirect('/administrasi/visi-misi');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/visi-misi');
    }
}
