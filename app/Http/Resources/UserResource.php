<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->getStatusValue(),
            'phone' => $this->phone,
            'role_id' => $this->role_id,
            'school_id' => $this->school_id,
            'guno_id' => $this->guno_id,
            'rano_id' => $this->rano_id,
            'parent_id' => $this->parent_id,
            'last_sign_in_at' => $this->last_sign_in_at,
        ];
    }
}
