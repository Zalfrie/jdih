<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Employee extends Model
{
    protected $fillable = ['employee_number', 'name', 'email'];

    public function hasUsers()
    {
        return $this->hasMany(User::class, 'employee_id');
    }
}
