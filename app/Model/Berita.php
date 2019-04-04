<?php 

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\User;

class Berita extends Model implements SluggableInterface
{
    use SluggableTrait;
    protected $table = 'berita';
    protected $primaryKey = 'berita_id';
    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
        'on_update' => true
    ];
    
    public function kategori()
    {
        return $this->belongsToMany(KategoriBerita::class, 'berita_kategori_rel', 'berita_id', 'kategori_id');
    }
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}