<?php
namespace App\Helpers;

use App\Models\User;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PackageHelper{
    public static function attachUserToPackage($userId, $packageId){
        $user = User::find($userId);
        $package = Package::find($packageId);

        if (!$user || !$package) {
            return "User or package not found.";
        }

        $startDate = Carbon::now();
        $duration = $package->duration; // Assume this is an integer
        $durationType = $package->duration_type; // "year", "month", "week", or "day"

        // Calculate the end date based on duration and duration_type
        switch ($durationType) {
            case 'year':
                $endDate = $startDate->copy()->addYears($duration);
                break;
            case 'month':
                $endDate = $startDate->copy()->addMonths($duration);
                break;
            case 'week':
                $endDate = $startDate->copy()->addWeeks($duration);
                break;
            case 'day':
                $endDate = $startDate->copy()->addDays($duration);
                break;
            default:
                throw new \Exception("Invalid duration type");
        }

        // Attach the user to the package with the calculated dates
        $user->packages()->attach($packageId, [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return "User attached to package successfully!";
    }

    public static function updateAndAttachPackage($center, $packageId){
        DB::transaction(function () use ($center, $packageId) {
            $currentPackage = $center->currentPackage();
            if ($currentPackage) {
                $currentPackage->pivot->status = false; // Update the status
                $currentPackage->pivot->save();
            }

            if($center->instructors){
                foreach ($center->instructors as $instructor) {
                    $instructorCurrentPackage = $instructor->currentPackage();
                    
                    if ($instructorCurrentPackage) {
                        $instructorCurrentPackage->pivot->status = false; // Update the status
                        $instructorCurrentPackage->pivot->save();
                    }
    
                    self::attachUserToPackage($instructor->id, $packageId);
                }
            }

            self::attachUserToPackage($center->id, $packageId);
        });
    }

    public static function deactivatePackage($center){
        DB::transaction(function () use ($center) {
            $currentPackage = $center->currentPackage();
            if ($currentPackage) {
                $currentPackage->pivot->status = false; // Update the status
                $currentPackage->pivot->save();
            }
            
            if($center->instructors){
                foreach ($center->instructors as $instructor) {
                    $instructorCurrentPackage = $instructor->currentPackage();
                    
                    if ($instructorCurrentPackage) {
                        $instructorCurrentPackage->pivot->status = false; // Update the status
                        $instructorCurrentPackage->pivot->save();
                    }
                }
            }
        });
    }

    public static function activatePackage($center){
        DB::transaction(function () use ($center) {
            $currentDeactivePackage = $center->currentDeactivePackage();
            if ($currentDeactivePackage) {
                $currentDeactivePackage->pivot->status = true; // Update the status
                $currentDeactivePackage->pivot->save();
            }

            if($center->instructors){
                foreach ($center->instructors as $instructor) {
                    $instructorcurrentDeactivePackage = $instructor->currentDeactivePackage();
                    
                    if ($instructorcurrentDeactivePackage) {
                        $instructorcurrentDeactivePackage->pivot->status = true; // Update the status
                        $instructorcurrentDeactivePackage->pivot->save();
                    }
                }
            }
        });
    }
}