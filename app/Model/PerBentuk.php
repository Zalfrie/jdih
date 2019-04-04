<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PerBentuk extends Model
{
    protected $table = 'per_bentuk_ref';
    protected $primaryKey = 'bentuk_short';
    public $timestamps = false;
    public $incrementing = false;
}