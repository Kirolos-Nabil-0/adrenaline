<?php

namespace App\Http\Resources;

use App\Models\Package;
use Illuminate\Http\Resources\Json\JsonResource;

class CenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->firstname,
            'email' => $this->email,
            'profile_photo_url' => $this->profile_photo_url,
            'package' => PackageResource::collection($this->whenLoaded('packages')),
            'current_package' => new PackageResource($this->currentPackage())
        ];
    }
}