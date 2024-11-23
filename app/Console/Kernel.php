<?php

namespace App\Console;

use App\Models\TemporaryVideo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        $schedule->call(function () {
            $expiredVideos = TemporaryVideo::where('created_at', '<', now()->subDay())->get();
            foreach ($expiredVideos as $video) {
                $videoPath = public_path($video->video_path);
                if (file_exists($videoPath)) {
                    unlink($videoPath); // Delete the video file
                }
                $video->delete(); // Remove record from the database
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}