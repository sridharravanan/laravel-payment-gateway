<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $table='post';
    protected $fillable = [
        'name', 'user_id','sub_category_id','description','front_image_id','amount','post_pdf_id'
    ];
    public function postTutors(){
        return $this->hasMany(PostTutors::class,'post_id','id')->with(['tutor']);
    }
    public function frontImage()
    {
        return $this->belongsTo(Uploads::class,'front_image_id','id');
    }
    public function postPdf()
    {
        return $this->belongsTo(Uploads::class,'post_pdf_id','id');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id','id')->with(['category']);
    }
}
