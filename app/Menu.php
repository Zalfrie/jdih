<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['label'];
    
    protected $childMenu = array();

    /**
     * Get the user that owns the task.
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
    
    public function setChild(Menu $child){
        $this->childMenu[] = $child;
    }
}
