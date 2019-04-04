<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiteMenu extends Model
{
    protected $table = 'site_menus';
    protected $primaryKey = 'id';
    
    public function children()
    {
        return $this->hasMany(SiteMenu::class, 'parent_id');
    }
}