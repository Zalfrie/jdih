<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $table = 'instansi';
    protected $primaryKey = 'instansi_id';
    public $timestamps = false;
}