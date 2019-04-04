<?php 

namespace App;

use App\Menu;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['name'];
    
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'role_menu');
    }
    
    public function attachMenu($menu)
    {
        $this->menus()->attach($menu);
    }
}