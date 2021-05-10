<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewUser;
use App\Providers\RouteServiceProvider;
use App\Models\User;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


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


    public function registerForm()
    {
        return view('users.newUser');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[\u0621-\u064Aa-zA-Z\d\-_\s]/', 'max:30'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(NewUser $request)
    {
        //   $val = $this->validator($request);
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
        //dd($request->all());
        $user->attachRole('user');
        $user->SyncPermissions($request->permissions);
        session()->flash('success','تم تسجيل المستخدم بنجاح');
        return Redirect::route('new-user-show', [$user])->with(['password' => $password]);
    }

    protected function show($id)
    {
        $user = User::find($id);
        $name = $user->name;
        $username = $user->username;
        $password = session()->get('password');
        $toastr = session()->get('toastr');
        // dd($password);
        return view('auth.successRegister', ['name' => $name, 'username' =>  $username, 'password' => $password, 'toastr' => $toastr]);
    }


    static public function generateUsername()
    {
        $username = 'ID';
        $userRows  = User::whereRaw("username REGEXP '^{$username}(-[0-9]*)?$'")->get();
        $random = rand(1000, 9800);
        $countUser = count($userRows) + $random;

        return  "{$username}.{$countUser}";
    }
}
