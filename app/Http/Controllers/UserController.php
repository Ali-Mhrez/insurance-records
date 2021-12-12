<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewUser;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    { //  $this->middleware('role:administrator');
        //  $this->middleware('permission:users-read')->only(['index','show']);
        //  $this->middleware('permission:users-create')->only(['create', 'registerForm']);
        //  $this->middleware('permission:users-delete')->only('delete');
    }

    public function index()
    {
        $users =  User::whereRoleIs('user')->paginate(5);
        return view('users.list', ['users' => $users]);
    }

    public function registerForm()
    {
        return view('users.newUser');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function create(NewUser $request)
    {
        $user = new User;
        $user->name = $request['name'];
        $user->username = $this->generateUsername();
        $password = Str::random(6);
        $user->password = Hash::make($password);
        $validator = Validator::make($user->toArray(), [
            'username' => ['unique:users,username'],
        ]);
        if ($validator->fails()) {
            return $this->create($request);
        }
        $user->save();
        $user->attachRole('user');
        $user->syncPermissions($request->permissions);
        if (preg_grep("/^initial+/", $request->permissions) != null)
           // array_add( $request->permissions,'initial_records-read');
            $user->syncPermissionsWithoutDetaching(['initial_records-read']);
        if(preg_grep("/^final+/", $request->permissions) != null)
            $user->syncPermissionsWithoutDetaching(['final_records-read']);
        session()->flash('success', 'تم تسجيل المستخدم بنجاح');
        return Redirect::route('new-user-show', [$user])->with(['password' => $password]);
    }

    static public function generateUsername()
    {
        $username = 'ID';
        $userRows  = User::whereRaw("username REGEXP '^{$username}(-[0-9]*)?$'")->get();
        $random = rand(1000, 9800);
        $countUser = count($userRows) + $random;

        return  "{$username}.{$countUser}";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function show($id)
    {
        $user = User::find($id);
        $name = $user->name;
        $username = $user->username;
        $password = session()->get('password');
        $toastr = session()->get('toastr');
        return view('auth.successRegister', ['name' => $name, 'username' =>  $username, 'password' => $password, 'toastr' => $toastr]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   $user=User::find($id);
        return view('users.edit',['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(NewUser $request,$id)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->save();
        $user->syncPermissions($request->permissions);
        if (preg_grep("/^initial+/", $request->permissions) != null)
            $user->syncPermissionsWithoutDetaching(['initial_records-read']);
        if(preg_grep("/^final+/", $request->permissions) != null)
            $user->syncPermissionsWithoutDetaching(['final_records-read']);
        session()->flash('success', 'تم تعديل البيانات بنجاح');
       // dd($user->all());
        return redirect()->action([UserController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        session()->flash('warning', 'تم حذف المستخدم بنجاح');
        return redirect()->action([UserController::class, 'index']);
    }

        public function resetPassword ($id){
        $user = User::find($id);
        $password = Str::random(6);
        $user->password = Hash::make($password);
        $user->save();
        session()->flash('success', 'تم إعادة تعيين كلمة المرور بنجاح');
        return Redirect::route('user.resetShow', [$user])->with(['password' => $password]);

    }

    protected function resetShow($id)
    {
        $user = User::find($id);
        $name = $user->name;
        $username = $user->username;
        $password = session()->get('password');
        $toastr = session()->get('toastr');
        return view('users.reset', ['name' => $name, 'username' =>  $username, 'password' => $password, 'toastr' => $toastr]);
    }
}
