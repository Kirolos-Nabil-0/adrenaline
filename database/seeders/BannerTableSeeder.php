<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $universities = [
            [
                'name' => 'Cairo University',
                'image' => 'a.png',
            ],
            [
                'name' => 'Minia University',
                'image' => 'b.png',
            ],
            [
                'name' => 'Menoufia University',
                'image' => 'c.png',
            ],
            [
                'name' => 'Beni Suef University',
                'image' => 'e.png',
            ],
        ];

        $colleges = [
            [
                'name' => 'Faculty of Pharmacy',
                'university_id' => 1,
            ],
            [
                'name' => 'Faculty of Computers',
                'university_id' => 2,
            ],
            [
                'name' => 'Faculty of Science',
                'university_id' => 3,
            ],
            [
                'name' => 'Faculty of Commerce',
                'university_id' => 4,
            ],
        ];

        $college_years = [
            [
                'college_id' => 1,
                'year_number' => 1,
            ],
            [
                'college_id' => 1,
                'year_number' => 2,
            ],
            [
                'college_id' => 1,
                'year_number' => 3,
            ],
            [
                'college_id' => 1,
                'year_number' => 4,
            ],
            [
                'college_id' => 2,
                'year_number' => 1,
            ],
            [
                'college_id' => 2,
                'year_number' => 2,
            ],
            [
                'college_id' => 3,
                'year_number' => 1,
            ],
            [
                'college_id' => 3,
                'year_number' => 2,
            ],
            [
                'college_id' => 4,
                'year_number' => 1,
            ],
        ];

        $semesters = [
            [
                'college_year_id' => 1,
                'semester_name' => 'First Semester',
            ],
            [
                'college_year_id' => 1,
                'semester_name' => 'Second Semester',
            ],
            [
                'college_year_id' => 2,
                'semester_name' => 'First Semester',
            ],
            [
                'college_year_id' => 2,
                'semester_name' => 'Second Semester',
            ],
            [
                'college_year_id' => 3,
                'semester_name' => 'First Semester',
            ],
            [
                'college_year_id' => 3,
                'semester_name' => 'Second Semester',
            ],
            [
                'college_year_id' => 4,
                'semester_name' => 'First Semester',
            ],
            [
                'college_year_id' => 4,
                'semester_name' => 'Second Semester',
            ],
            [
                'college_year_id' => 5,
                'semester_name' => 'First Semester',
            ],
            [
                'college_year_id' => 5,
                'semester_name' => 'Second Semester',
            ],
            [
                'college_year_id' => 6,
                'semester_name' => 'First Semester',
            ],
            [
                'college_year_id' => 6,
                'semester_name' => 'Second Semester',
            ],
            [
                'college_year_id' => 7,
                'semester_name' => 'First Semester',
            ],
            [
                'college_year_id' => 7,
                'semester_name' => 'Second Semester',
            ],
            [
                'college_year_id' => 8,
                'semester_name' => 'First Semester',
            ],
            [
                'college_year_id' => 8,
                'semester_name' => 'Second Semester',
            ],
            [
                'college_year_id' => 9,
                'semester_name' => 'First Semester',
            ],
            [
                'college_year_id' => 9,
                'semester_name' => 'Second Semester',
            ],
        ];



        DB::table('universities')->insert($universities);
        DB::table('colleges')->insert($colleges);
        DB::table('college_years')->insert($college_years);
        DB::table('semesters')->insert($semesters);
    }
}