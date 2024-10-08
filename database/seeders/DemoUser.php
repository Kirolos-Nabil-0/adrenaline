<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstname'=>'Demo',
            'lastname'=>'Account',
            'email'=>'demo@demo.com',
            'password'=>Hash::make('demo@123')
        ]);
    }
}
