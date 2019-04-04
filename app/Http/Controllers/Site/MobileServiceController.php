<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;
use App\Model\MobileFaq;
use DB;

class MobileServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getdatabyparam(Request $request)
    {
        try{
            $search = $request->input('search') == ''? date('Y') : $request->input('search');

            $data = DB::table('per_0_tm')
                    ->select([
                        'per_0_tm.per_no',
                        'per_0_tm.per_no',
                        'per_0_tm.tajuk_negara_id',
                        'negara.nama_negara',
                        'per_0_tm.tajuk_ins_id',
                        'instansi.nama_instansi',
                        'per_0_tm.bentuk_short',
                        'per_0_tm.tanggal',
                        'per_0_tm.tentang',
                        'per_0_tm.kota_id',
                        'kota.nama_kota',
                        'per_0_tm.lokasi',
                        'per_0_tm.file_id',
                        'per_file.direktori',
                        'per_file.file_type',
                        'per_file.filename',
                        'per_file.tanggal_upload',
                        'per_0_tm.is_publish',
                        'per_0_tm.is_publish2'
                    ])
                    ->leftJoin('negara','negara.negara_id','=','per_0_tm.tajuk_negara_id')
                    ->leftJoin('instansi','instansi.instansi_id','=','per_0_tm.tajuk_ins_id')
                    ->leftJoin('kota','kota.kota_id','=','per_0_tm.kota_id')
                    ->leftJoin('per_file','per_file.file_id','=','per_0_tm.file_id')
                    ->where('per_0_tm.is_publish','=',true)
                    ->where(function($query) use($search) {
                        $query->where('per_0_tm.per_no','ilike','%'.$search.'%')
                        ->orWhere('per_0_tm.bentuk_short','ilike','%'.$search.'%')
                        ->orWhere('per_0_tm.tentang','ilike','%'.$search.'%')
                        ->orWhere('per_0_tm.lokasi','ilike','%'.$search.'%')
                        ->orWhere('negara.nama_negara','ilike','%'.$search.'%')
                        ->orWhere('instansi.nama_instansi','ilike','%'.$search.'%')
                        ->orWhere('kota.nama_kota','ilike','%'.$search.'%')
                        ->orWhere('per_0_tm.lokasi','ilike','%?%',[$search])
                        ->orWhereRaw('extract(year from per_0_tm.tanggal) = ?',[(int)$search]);
                    })
                    ->orderBy('per_0_tm.tanggal','desc')
                    ->get();

            $items = new Collection();
            foreach ($data as $key => $value) {
                     $items->push([
                        'id' => Crypt::encrypt($value->per_no),
                        'per_no' => $value->per_no,
                        'tentang' => $value->tentang,
                        'tanggal' => $value->tanggal,
                     ]);
            }
            return response()->json(compact('items'));
        }catch(\Exception $e){
            return response()->json([]);
        }
    }

    public function getlastperaturan()
    {
        try{
            $items = DB::table('per_0_tm')
                    ->select([
                        'per_0_tm.per_no',
                        'per_0_tm.tajuk_negara_id',
                        'negara.nama_negara',
                        'per_0_tm.tajuk_ins_id',
                        'per_0_tm.bentuk_short',
                        'per_0_tm.tanggal',
                        'per_0_tm.tentang',
                        'per_0_tm.kota_id',
                        'kota.nama_kota',
                        'per_0_tm.lokasi',
                        'per_0_tm.file_id',
                        'per_file.direktori',
                        'per_file.file_type',
                        'per_file.filename',
                        'per_file.tanggal_upload',
                        'per_0_tm.is_publish'
                    ])
                    ->leftJoin('negara','negara.negara_id','=','per_0_tm.tajuk_negara_id')
                    ->leftJoin('instansi','instansi.instansi_id','=','per_0_tm.tajuk_ins_id')
                    ->leftJoin('kota','kota.kota_id','=','per_0_tm.kota_id')
                    ->leftJoin('per_file','per_file.file_id','=','per_0_tm.file_id')
                    ->where('per_0_tm.is_publish','=',1)
                    ->whereIn('per_0_tm.bentuk_short', ['PERMENBUMN', 'SEMENBUMN'])
                    ->orderBy('per_0_tm.tanggal','desc')
                    ->limit(10)
                    ->get();

            return response()->json(compact('items'));
        }catch(\Exception $e){
            return response()->json([]);
        }
    }

    /*public function getmobilefaq()
    {
        try{
            $items = MobileFaq::select(['question','answer','status'])->where('status','=',true)->orderBy('created_at','asc')->get();
            return response()->json(compact('items'));
        }catch(\Exception $e){
            return response()->json([]);   
        }
    }*/

    public function getperaturanbyparam(Request $request)
    {
        try{
           $per_no = Crypt::decrypt($request->input('id'));
            
           $items = DB::table('per_0_tm')
                   ->select([
                    'per_0_tm.per_no',
                    'per_0_tm.bentuk_short',
                    'per_0_tm.tanggal',
                    'per_0_tm.tentang',
                    'per_0_tm.kota_id',
                    'kota.nama_kota',
                    'per_0_tm.lokasi',
                    'per_0_tm.file_id',
                    'per_file.direktori',
                    'per_file.file_type',
                    'per_file.filename',
                    'per_file.tanggal_upload'
                   ])
                   ->leftJoin('kota','kota.kota_id','=','per_0_tm.kota_id')
                   ->leftJoin('per_file','per_file.file_id','=','per_0_tm.file_id')
                   ->where('per_0_tm.is_publish','=',1)
                   ->where('per_0_tm.per_no','=',$per_no)
                   ->first();

           return response()->json([
            'rest' => true,
            'items' => $items
           ]);   
        }catch(\Exception $e){
           return response()->json([
            'rest' => false,
            'items' => []
           ]);     
        }
    }
}
