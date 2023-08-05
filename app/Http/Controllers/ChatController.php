<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Http\Resources\ChatResource;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Http\Resources\ChatUserResource;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chatResource = ChatResource::collection(User::where('id' ,'!=', \Auth::user()->id)->get());
        $data = ['status' => 1, 'data' => $chatResource];
        if ($data['status']) {
            return response()->json(['status' => true, 'data' => $data['data'], 'message' => 'Get All Chat User Successfully!'], 200);
        } else {
            return response()->error([], $data['data'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat1,$id)
    {
        try {
            $chat = User::find($id);
            $classResource = new ChatUserResource($chat);
            $data = ['status' => 1, 'data' => $classResource];
        } catch (Throwable $e) {
            $data = ['status' => 0, 'data' => $e->getMessage()];
        }
        if ($data['status']) {
            return response()->json(['status' => true, 'data' => $data['data'], 'message' => 'Found Class Successfully!'], 200);
        } else {
            return response()->error([], $data['data'], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}