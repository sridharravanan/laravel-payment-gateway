<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 20/8/20
 * Time: 12:31 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    protected $table='roles';
    use SoftDeletes;
    protected $fillable = [
        'name','slug'
    ];

   

}
