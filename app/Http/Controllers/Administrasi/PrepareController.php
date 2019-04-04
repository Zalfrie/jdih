<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\UncategorizedPost;
use DB;

class PrepareController extends Controller
{
    
    public function __construct()
    {
    }

    public function index(Request $request)
    {
    }
    public function update(Request $request)
    {
    }

    public function mukadimah(Request $request)
    {
        $mukadimah = UncategorizedPost::where('post_type', 'mukadimah_program_prepare')->first();
        $mukadimah1 = UncategorizedPost::where('post_type', 'mukadimah1')->first();
        $mukadimah2 = UncategorizedPost::where('post_type', 'mukadimah2')->first();
        $mukadimah3 = UncategorizedPost::where('post_type', 'mukadimah3')->first();
        $mukadimah4 = UncategorizedPost::where('post_type', 'mukadimah4')->first();
        $mukadimah5 = UncategorizedPost::where('post_type', 'mukadimah5')->first();
        return view('administrasi.prepare.index', ['mukadimah' => $mukadimah, 'mukadimah1' => $mukadimah1,
            'mukadimah2' => $mukadimah2, 'mukadimah3' => $mukadimah3,
            'mukadimah4' => $mukadimah4, 'mukadimah5' => $mukadimah5]);
    }
    
    public function updateMukadimah(Request $request)
    {
        DB::beginTransaction();
        try {
            $mukadimah = UncategorizedPost::where('post_type', 'mukadimah_program_prepare')->first();
            $mukadimah1 = UncategorizedPost::where('post_type', 'mukadimah1')->first();
            $mukadimah2 = UncategorizedPost::where('post_type', 'mukadimah2')->first();
            $mukadimah3 = UncategorizedPost::where('post_type', 'mukadimah3')->first();
            $mukadimah4 = UncategorizedPost::where('post_type', 'mukadimah4')->first();
            $mukadimah5 = UncategorizedPost::where('post_type', 'mukadimah5')->first();
            $mukadimah->content = $request->mukadimah;
            $mukadimah1->content = $request->mukadimah1;
            $mukadimah2->content = $request->mukadimah2;
            $mukadimah3->content = $request->mukadimah3;
            $mukadimah4->content = $request->mukadimah4;
            $mukadimah5->content = $request->mukadimah5;
            $mukadimah->save();
            $mukadimah1->save();
            $mukadimah2->save();
            $mukadimah3->save();
            $mukadimah4->save();
            $mukadimah5->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            throw $e;
            return redirect('/administrasi/mukadimah-prepare');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/mukadimah-prepare');
    }
}
