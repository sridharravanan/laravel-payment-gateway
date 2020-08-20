<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $table='post';
    protected $fillable = [
        'name', 'user_id','sub_category_id','description','front_image_id','amount'
    ];
    public function postTutors(){
        return $this->hasMany(PostTutors::class,'post_id','id')->with(['tutor']);
    }
    public function frontImage()
    {
        return $this->belongsTo(Uploads::class,'front_image_id','id');
    }
}
