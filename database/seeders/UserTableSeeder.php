<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin')
        ]);
        $permissions=Permission::get();
        
        $user->attachRole('administrator');
        $user->attachPermissions($permissions);
    }
}
