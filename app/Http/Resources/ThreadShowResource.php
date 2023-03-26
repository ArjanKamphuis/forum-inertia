<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ThreadShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'path' => $this->path(),
            'owner' => ['name' => $this->owner->name],
            'replies_count' => $this->replies_count,
            'comment_noun' => Str::plural('comment', $this->replies_count)
        ];
    }
}
