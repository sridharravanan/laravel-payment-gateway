<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 23/8/20
 * Time: 12:32 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table='payments';
    protected $fillable = [
        'purchase_date', 'payment_id','post_id','user_id','amount'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id')->with(['tutor','postPdf','postTutors']);
    }
}
