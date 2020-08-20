<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 20/8/20
 * Time: 11:27 PM
 */

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostTutors extends Model
{
    use SoftDeletes;
    protected $table='post_tutors';
    protected $fillable = [
        'post_id','tutor_id','amount'
    ];
    public function tutor(){
        return $this->belongsTo(User::class,'tutor_id','id');
    }
}
