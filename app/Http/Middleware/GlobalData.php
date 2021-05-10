<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GlobalData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $check = User::where('username', '=', 'admin')->first();
        if (!$check) {
            $check = new User();
            $check->name = "Admin";
            $check->username = "admin";
            $check->password = Hash::make("admin");
            $check->save();
        }
        return $next($request);
    }
}
