<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            "title" => $this->title,
            "slug" => $this->slug,
            "thumbnail" => $this->thumbnail,
            "content" => $this->content,
            "is_published" => $this->is_published,
            "excerpt" => $this->excerpt,
            "author" => new UserResource($this->whenLoaded('author'))
        ];
    }
}