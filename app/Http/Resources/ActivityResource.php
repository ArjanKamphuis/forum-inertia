<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'subject' => match ($this->type) {
                'created_thread' => ThreadProfileResource::make($this->subject),
                'created_reply' => ReplyProfileResource::make($this->subject),
                'created_favorite' => FavoriteProfileResource::make($this->subject)
            }
        ];
    }
}
