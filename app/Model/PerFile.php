<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PerFile extends Model
{
    protected $table = 'per_file';
    protected $primaryKey = 'file_id';
    public $timestamps = false;
}