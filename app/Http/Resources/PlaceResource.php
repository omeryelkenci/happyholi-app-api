<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'surname' => $this->user->surname,
                'email' => $this->user->email,
                'img_url' => $this->user->img_url,
                'type' => $this->user->type,
                'created_at' => (string) $this->user->created_at,
                'updated_at' => (string) $this->user->updated_at,
            ],
        ];
    }
}
