<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Model\KontakKami;
use DB;

class KontakKamiController extends Controller
{
    
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        return view('administrasi.kontak.index', []);
    }
    
    public function dataTable(Request $request)
    {
        $data = DB::table(DB::raw("(SELECT kontak_kami_id AS id, nama, email, pesan, created_at as waktu FROM kontak_kami) A"))->select(['id', 'nama', 'email', 'pesan', 'waktu']);
        return \Datatables::of($data)
            ->addColumn('waktu2', function($item){
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->waktu)->formatLocalized('%d %B %Y').' '.\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->waktu)->format('H:i:s');
            })
            ->addColumn('pesan2', function($item){
                return '<div class="well no-margin">'.(nl2br($item->pesan)).'</div>';
            })
            ->make(true);
    }
    
    public function storeKontak(Request $request)
    {
        $secret = "6LeSyiITAAAAAKqNtxDVtqL_Jwc7zQdDyHqj1-Ju";
        $client = new \GuzzleHttp\Client([]);
        $getResponse = $client->request('POST', "https://www.google.com/recaptcha/api/siteverify", [
            'form_params' => [
                'secret' => $secret,
                'remoteip' => $_SERVER["REMOTE_ADDR"],
                'response' => $request->{'g-recaptcha-response'}
            ]
        ]);
        
        $body = $getResponse->getBody();
        $answers = json_decode($body, true);
        $pesan = '';
        if (trim($answers ['success']) == true) {
            DB::beginTransaction();
            try {
                $data = new KontakKami;
                $data->nama = $request->nama;
                $data->email = $request->email;
                $data->pesan = $request->message;
                $data->save();
            } catch(\Exception $e){
                DB::rollback();
                $pesan = 'Mohon maaf saat ini terdapat kesalahan sistem. Mohon untuk menghubungi kami melalui telepon atau email. Terima kasih';
                \Flash::success($pesan);
                return redirect('/kontak-kami')->withInput();
            }
            DB::commit();
            $pesan = 'Pesan Anda sudah kami terima. Terima kasih telah menghubungi kami.';
            \Flash::success($pesan);
            return redirect('/kontak-kami');
        }else{
            $pesan = 'Anda belum melakukan verifikasi "Saya Bukan Robot" secara benar.';
            \Flash::success($pesan);
            return redirect('/kontak-kami')->withInput();
        }
    }
}
