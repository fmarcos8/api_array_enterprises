<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
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
            'nickname' => $this->nickname,
            'name' => $this->name,
            'email' => $this->email,
            'comments' => $this->comments,
            'created' => date('d/m/Y', strtotime($this->created_at->toDateString())),
            'updated' => date('d/m/Y', strtotime($this->updated_at->toDateString()))
        ];
    }
}
