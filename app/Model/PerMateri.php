<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PerMateri extends Model
{
    protected $table = 'per_materi_ref';
    protected $primaryKey = 'materi_id';
    public $timestamps = false;
}