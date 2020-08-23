<?php

namespace App;

use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number','razorpay_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @return array rule.
     * */
    public static function rule(){
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'phone_number' => ['required', 'numeric','digits:10', 'unique:users'],
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    /**
     * @param  $role
     * @return user count int.
     * */
    public static function getUserCountBasedOnRole( $role ){
        return User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.slug',$role)->count();
    }

}
