<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kota';
    protected $primaryKey = 'kota_id';
    public $timestamps = false;
}