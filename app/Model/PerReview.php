<?php 

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\Peraturan;
use App\Model\PerFile;

class PerReview extends Model
{
    protected $table = 'per_review';
    protected $primaryKey = 'review_id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['review_user', 'review'];

    public function peraturan()
    {
        return $this->belongsTo(Peraturan::class, 'per_no', 'per_no');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'review_user', 'username');
    }

    public function filedoc()
    {
        return $this->hasOne(PerFile::class, 'file_id', 'file_id');
    }
}