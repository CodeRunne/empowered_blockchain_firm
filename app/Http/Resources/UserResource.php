<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "fullname" => $this->fullname,
            "email" => $this->email,
            "role" => $this->roles()->pluck('name')[0] ?? '',
            "permissions" => PermissionResource::collection($this->whenLoaded('permissions')),
            "posts" => PostResource::collection($this->whenLoaded('posts')),
            "referrals" => ReferralResource::collection($this->whenLoaded('referrals')),
            "courses" => CourseResource::collection($this->whenLoaded('courses'))
        ];
    }
}