<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'email' => $this->email,
            'first_name' => $this->profile->first_name,
            'last_name' => $this->profile->last_name,
            'birthday' => $this->profile->birthday,
            'gender' => $this->profile->gender
        ];
    }
}
