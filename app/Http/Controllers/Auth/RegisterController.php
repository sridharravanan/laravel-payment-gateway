<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, User::rule());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user =  User::create($data);
        $role = config('roles.models.role')::where('slug', '=', Config::get('constants.role.slug_student.slug'))->first();
        $user->attachRole($role);
        return $user;
    }
    public function tutorRegistration(){
        return view('auth.tutor_registration');
    }
    public function tutorSave(Request $request){
        $request->validate(User::rule());
        $message = DB::transaction(function() use ($request) {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $user =  User::create($data);
            $role = config('roles.models.role')::where('slug', '=', Config::get('constants.role.slug_tutor.slug'))->first();
            $user->attachRole($role);
            return $user['name']." tutor has been created";
        });
        return response()->json($message, 200);
    }
}
