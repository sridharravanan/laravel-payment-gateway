<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 22/8/20
 * Time: 10:05 PM
 */

namespace App\Http\Controllers;

use App\Helpers\Pagination;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostTutors;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        self::hasRole(Config::get('constants.role.slug_admin.slug'));
        return view('tutor.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  getTutor(Request $request)
    {
        self::hasRole(Config::get('constants.role.slug_admin.slug'));
        $query = User::query()->select('users.*')
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.slug',Config::get('constants.role.slug_tutor.slug'))
        ;
        return Pagination::preparePagination($query,$request,['users.name','users.phone_number','users.email']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        return  User::findOrFail($id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'razorpay_id'  => 'required|unique:users,razorpay_id,'.$id,
        ]);
        $message = DB::transaction(function() use ($request,$id) {
            $data = $request->all();
            $user = User::findOrFail($id);
            unset($data['password']);
            $user->update($data);

            return $user['name']." tutor has been updated";
        });
        return response()->json($message, 200);
    }

}
