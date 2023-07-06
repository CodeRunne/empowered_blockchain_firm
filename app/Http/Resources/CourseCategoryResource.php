<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'url' => route('course_categories.show', $this->slug),
            'course_count' => $this->courses()->count(),
            'courses' => CourseResource::collection($this->whenLoaded('courses'))
        ];
    }
}
