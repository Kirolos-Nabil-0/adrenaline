<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'firstname' => 'arab',
                'lastname' => 'medicine',
                'email' => 'admin@adrenaline-edu.com',
                'password' => Hash::make('admin@#com123'),
                'role' => 'admin'
            ],
            [
                'firstname' => 'emailtest',
                'lastname' => 'education',
                'email' => 'tth31770@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin'
            ],
            [
                'firstname' => 'center',
                'lastname' => 'one',
                'email' => 'center1@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'center'
            ],
            [
                'firstname' => 'instructor',
                'lastname' => 'education',
                'email' => 'taha@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'instructor'
            ]
        ]);
        DB::table('setting_webs')->insert([
            'about_us_ar' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ...',
            'about_us_en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ...',
            'terms_ar' => 'Terms in Arabic...',
            'terms_en' => 'Terms in English...',
            'privacy_ar' => 'Privacy Policy in Arabic...',
            'privacy_en' => 'Privacy Policy in English...',
            'return_policy_ar' => 'Return Policy in Arabic...',
            'return_policy_en' => 'Return Policy in English...',
            'store_policy_ar' => 'Store Policy in Arabic...',
            'store_policy_en' => 'Store Policy in English...',
            'seller_policy_ar' => 'Seller Policy in Arabic...',
            'seller_policy_en' => 'Seller Policy in English...',
            'color_primery' => '#ffffff',
            'color_second_primery' => '#000000',
            'licance_web' => 'License code here',
            'banner' => 'banner.jpg',
        ]);
    }
}