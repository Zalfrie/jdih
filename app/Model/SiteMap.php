<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiteMap extends Model
{
    protected $table = 'site_map';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function children()
    {
        return $this->hasMany(SiteMap::class, 'parent_id');
    }
}