<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\SendMessageInterface;
use App\Models\SendMessage;
use Illuminate\Http\Request;

class SendMessageController extends Controller
{
    private SendMessageInterface $sendMessage;

    public function __construct(SendMessageInterface $sendMessage)
    {
        $this->sendMessage = $sendMessage;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $data['user_id'] = auth()->user()->id;
        $data['email'] = $request->email;
        $data['message'] = $request->message;

        $this->sendMessage->store($data);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(SendMessage $sendMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SendMessage $sendMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SendMessage $sendMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SendMessage $sendMessage)
    {
        //
    }
}