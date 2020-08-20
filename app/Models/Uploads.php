<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Uploads extends Model
{
    use SoftDeletes;
    protected $table='uploads';
    protected $fillable = [
        'file_name',
        'file_size',
        'uploaded_path',
        'user_id',
    ];
}
