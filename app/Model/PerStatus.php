<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PerStatus extends Model
{
    protected $table = 'per_status_ref';
    protected $primaryKey = 'status_id';
    public $timestamps = false;
}