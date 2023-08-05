<?php

namespace App\Http\Resources;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $sender = (string) \Auth::user()->id;
        $receiver = (string) $this->id;
        $groupId = $sender > $receiver ? $sender.$receiver : $receiver.$sender;
        $chat = Chat::where('groupId','=',$groupId)->get();
        return [
           "user" =>  [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'is_online' => $this->is_online ? true : false,
           ],
            'chat' => $chat
        ];
    }
}