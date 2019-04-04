<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\UncategorizedPost;
use DB;

class BerandaController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        $title = UncategorizedPost::where('post_type', 'title_beranda')->first();
        $paragraf = UncategorizedPost::where('post_type', 'paragraf_beranda')->first();
        return view('administrasi.beranda.index', ['title_beranda' => $title, 'paragraf_beranda' => $paragraf]);
    }
    
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $title = UncategorizedPost::where('post_type', 'title_beranda')->first();
            $paragraf = UncategorizedPost::where('post_type', 'paragraf_beranda')->first();
            $title->content = $request->title;
            $paragraf->content = $request->paragraf;
            $title->save();
            $paragraf->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            throw $e;
            return redirect('/administrasi/beranda');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/beranda');
    }
}
