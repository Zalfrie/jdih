<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Peraturan;

class PerAbstrak extends Model
{
    protected $table = 'per_abstrak';
    protected $primaryKey = 'abstrak_id';
    public $timestamps = false;
    
    public function peraturan()
    {
        return $this->belongsTo(Peraturan::class, 'per_no', 'per_no');
    }
}