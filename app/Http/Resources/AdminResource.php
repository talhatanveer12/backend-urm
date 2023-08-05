<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $role = Role::find($this->role_id);
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $role->role_name,
            "dob" => $this->dob,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}