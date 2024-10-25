<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $maximumStorage = null;
        if ($this->video_support) {
            if ($this->video_maximum >= 10000 || $this->courses_limit >= 10000 || $this->lessons_per_course_limit >= 10000) {
                $maximumStorage = 'Unlimited';
            } else {
                $maximumStorage = ($this->courses_limit * $this->lessons_per_course_limit * $this->video_maximum / 1000) . ' GB';
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration_type' => $this->duration_type,
            'duration' => $this->duration,
            'video_support' => (bool)$this->video_support,
            'video_maximum' => $this->video_support ? $this->video_maximum . ' MB' : null, // Return in MB if video_support is true
            'courses_limit' => $this->courses_limit,
            'lessons_per_course_limit' => $this->lessons_per_course_limit,
            'maximum_storage' => $maximumStorage, // Add calculated maximum storage
            'pivot' => [
                'start_date' => $this->pivot->start_date,
                'end_date' => $this->pivot->end_date,
                'status' => $this->pivot->status,
            ]
        ];
    }
}