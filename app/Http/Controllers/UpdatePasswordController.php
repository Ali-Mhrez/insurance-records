<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UpdatePasswordController extends Controller
{
    public function __construct()
    {



    }


    public function index()
    {
        return view('auth.updatePassword');
    }

    public function update(UpdatePassword $request)
    {
        if (!(Hash::check($request->get('password'), Auth::user()->password))) {
            return redirect()->back()->with("error", "كلمة المرور الحالية لا تتطابق مع كلمة المرور التي قدمتها. حاول مرة اخرى.");
        }
        $user = Auth::user();
        $user->password = Hash::make($request->newPassword);
        $user->save();
        return redirect()->route('welcome')->with("success", "تم تغيير كلمة المرور بنجاح !");
    }
}
