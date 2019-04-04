<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\UncategorizedPost;
use DB;

class DisclaimerController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        $beranda = UncategorizedPost::where('post_type', 'disclaimer_beranda')->first();
        $contact = UncategorizedPost::where('post_type', 'disclaimer_contact_us')->first();
        return view('administrasi.disclaimer.index', ['beranda' => $beranda, 'contact' => $contact]);
    }
    
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $beranda = UncategorizedPost::where('post_type', 'disclaimer_beranda')->first();
            $contact = UncategorizedPost::where('post_type', 'disclaimer_contact_us')->first();
            $beranda->content = $request->beranda;
            $contact->content = $request->contact;
            $beranda->save();
            $contact->save();
        } catch(\Exception $e){
            DB::rollback();
            \Flash::error("Simpan data gagal");
            throw $e;
            return redirect('/administrasi/disclaimer');
        }
        
        DB::commit();
        \Flash::success("Simpan data berhasil");
        return redirect('/administrasi/disclaimer');
    }
}
