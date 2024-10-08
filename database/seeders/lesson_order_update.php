<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;
class lesson_order_update extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $lessons = Lesson::get();
        foreach($lessons as $lesson){
            $lesson->update([
                'order' => $lesson->id,
            ]);
        }
    }
}
