<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'place_id' => (integer) $this->place_id,
            'title' => $this->title,
            'description' => $this->description,
            'img_url' => $this->img_url,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'user' => $this->user,
            'place' => $this->place
        ];
    }
}
