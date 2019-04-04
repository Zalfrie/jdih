<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PerPopulerCounter extends Model
{
    protected $table = 'per_populer_counter';
    protected $primaryKey = 'id';
    public $timestamps = false;
}