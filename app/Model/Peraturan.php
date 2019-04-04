<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Negara;
use App\Model\Kota;
use App\Model\Instansi;
use App\Model\PerAbstrak;
use App\Model\PerFile;
use App\Model\PerSumber;
use App\Model\PerKatalog;
use App\Model\PerSubyek;
use App\Model\PerStatus;
use App\Model\PerBentuk;

class Peraturan extends Model
{
    protected $table = 'per_0_tm';
    protected $primaryKey = 'per_no';
    protected $fillable = ['per_no'];
    protected $dates = ['published_at', 'review_start', 'review_end'];
    
    public function tajukNegara()
    {
        return $this->hasOne(Negara::class, 'negara_id', 'tajuk_negara_id');
    }
    
    public function tajukInstansi()
    {
        return $this->hasOne(Instansi::class, 'instansi_id', 'tajuk_ins_id');
    }
    
    public function kota()
    {
        return $this->hasOne(Kota::class, 'kota_id', 'kota_id');
    }
    
    public function abstrak()
    {
        return $this->hasMany(PerAbstrak::class, 'per_no', 'per_no');
    }
    
    public function bentuk()
    {
        return $this->hasOne(PerBentuk::class, 'bentuk_short', 'bentuk_short');
    }
    
    public function filedoc()
    {
        return $this->hasOne(PerFile::class, 'file_id', 'file_id');
    }
    
    public function status()
    {
        return $this->belongsToMany(PerStatus::class, 'per_status_rel', 'per_no', 'status_id')->withPivot('per_no_object');
    }
    
    public function sumber()
    {
        return $this->belongsToMany(PerSumber::class, 'per_sumber_rel', 'per_no', 'sumber_short')->withPivot('year', 'jilid', 'hal');;
    }
    
    public function subyek()
    {
        return $this->belongsToMany(PerSubyek::class, 'per_subyek_rel', 'per_no', 'subyek_id');
    }
    
    public function materi()
    {
        return $this->belongsToMany(PerMateri::class, 'per_materi_rel', 'per_no', 'materi_id');
    }
    
    public function populerCounter()
    {
        return $this->hasMany(PerPopulerCounter::class, 'per_no', 'per_no');
    }

    public function review()
    {
        return $this->hasMany(PerReview::class, 'per_no', 'per_no');
    }
}