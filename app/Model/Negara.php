<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Negara extends Model
{
    protected $table = 'negara';
    protected $primaryKey = 'negara_id';
    public $timestamps = false;
}