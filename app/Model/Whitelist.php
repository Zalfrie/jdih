<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Whitelist extends Model
{
    protected $table = 'whitelist';
    protected $primaryKey = 'id';
    public $timestamps = false;
}