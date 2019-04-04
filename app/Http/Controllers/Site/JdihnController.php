<?php
/**
 * Created by IntelliJ IDEA.
 * User: Widya Rarasati
 * Date: 18/05/2017
 * Time: 6:28
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Model\Peraturan;
use App\Model\Whitelist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JdihnController extends Controller
{

    public function __construct()
    {
    }

    public function getData(Request $request)
    {
        $ip = $request->getClientIp();
        $count = Whitelist::whereIn('ip', ['*', $ip, $this->getFormat($ip)])->where('is_active','t')->get()->count();
        DB::table('jdihn_service_log')->insert([
            ['ip' => $ip, 'allowed' => $count<1 ? 'f':'t']
        ]);
        if ($count < 1){
            return response(json_encode(['errorMessage' => 'You are not allowed.']), 403);
        }
        $results = Peraturan::where('is_publish', 1)
            ->where('bentuk_short', 'PERMENBUMN')->orderBy('tanggal', 'desc')->get();
        $data = new Collection();
        $date = date('Y-m-d');
        foreach ($results as $result){
            $id = $result->per_no;
            $lihatPeraturan = 'http://jdih.bumn.go.id/lihat/'.$id;
            $stringStatus = '';
            foreach ($result->status as $status){
                $nomor = $status->pivot->per_no_object;
                $stringStatus .= $status->status." : <a href='http://jdih.bumn.go.id/lihat/".$nomor."'>".$nomor."</a><br>";
            }
            $data->push([
                'idData' => $id,
                'idkategori' => $_GET['id'],
                'jenis' => $result->bentuk->bentuk,
                'noPeraturan' => $id,
                'judul' => $result->tentang,
//                'fileDownload' => $result->filedoc->filename,
                'fileDownload' => $id.'.pdf',
                'urlDownload' => 'http://jdih.bumn.go.id/unduh',
                'urlDetailPeraturan' => $lihatPeraturan,
                'status' => $stringStatus,
                'hasilUjiMateriMk' => '',
                'tanggal' => $result->tanggal,
                'tahun' => substr($result->tanggal, 0, 4),
                'abstrak' => $lihatPeraturan,
                'katalog' => $lihatPeraturan,
                'tanggalData' => $date,
                'display' => 1,
                'operasi' => 0
            ]);
        }
//        return json_encode($data, JSON_UNESCAPED_SLASHES);
        return response()->json($data);
    }
    private function getFormat($ip){
        $ipArray = explode('.', $ip);
        if (sizeof($ipArray)>2){
            return $ipArray[0].'.'.$ipArray[1].'.*';
        }
        return $ipArray;
    }
}