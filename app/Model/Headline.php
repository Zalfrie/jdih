<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    protected $table = 'headline';
    protected $primaryKey = 'id';
    public $timestamps = false;
}