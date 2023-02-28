<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $thread = parent::toArray($request);
        $thread['path'] = $this->resource->path();
        $thread['replies'] = ReplyResource::collection($this->resource->replies);
        return $thread;
    }
}
