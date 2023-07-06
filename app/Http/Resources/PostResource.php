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
            "published_count" => $this->where('is_published', true)->count(),
            "not_published_count" => $this->where('is_published', false)->count(),
            "excerpt" => $this->excerpt,
            "author" => $this->author->fullname,
            "role" => $this->author->roles->pluck('name')->unique() ?? null,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}