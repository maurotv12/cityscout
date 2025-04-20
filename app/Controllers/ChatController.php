<?php

namespace App\Controllers;

use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {

        $model = new Message;

        $messages = $model->all();

        return $this->view('chat.chatList', compact ('messages'));
    }

    public function conversation($id)
    {
        return $this->view('chat.conversation');
    }
}