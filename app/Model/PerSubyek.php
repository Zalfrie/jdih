<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PerSubyek extends Model
{
    protected $table = 'per_subyek_ref';
    protected $primaryKey = 'subyek_id';
    public $timestamps = false;
}