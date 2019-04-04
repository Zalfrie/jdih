<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PerSumber extends Model
{
    protected $table = 'per_sumber_ref';
    protected $primaryKey = 'sumber_short';
    public $timestamps = false;
    public $incrementing = false;
}