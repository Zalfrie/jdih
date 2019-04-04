<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class KategoriBerita extends Model implements SluggableInterface
{
    use SluggableTrait;
    protected $table = 'berita_kategori_ref';
    protected $primaryKey = 'kategori_id';
    public $timestamps = false;
    protected $sluggable = [
        'build_from' => 'kategori',
        'save_to'    => 'slug',
        'on_update' => true
    ];
    
    public function berita()
    {
        return $this->belongsToMany(Berita::class, 'berita_kategori_rel', 'kategori_id', 'berita_id');
    }
}