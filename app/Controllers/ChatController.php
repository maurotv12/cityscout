<?php

namespace App\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Comment; 
use App\Controllers\NotificationController;

class ChatController extends Controller
{
    public function index()
    {
        $model = new Message;
        $messages = $model->all();
        return $this->view('chat.chatList', compact('messages'));
    }

    public function conversation($id)
    {
        return $this->view('chat.conversation');
    }

    public function getChats()
    {
        $messageModel = new Message();
        $userModel = new User();
        $userId = $_SESSION['user']['id'];

        // Obtener todos los mensajes donde el usuario es sender o receiver
        $messages = $messageModel
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();

        // Agrupar por el otro usuario y obtener datos
        $userChats = [];
        foreach ($messages as $msg) {
            $otherUserId = ($msg['sender_id'] == $userId) ? $msg['receiver_id'] : $msg['sender_id'];
            if (!isset($userChats[$otherUserId])) {
                $userChats[$otherUserId] = [
                    'user_id' => $otherUserId,
                    'last_message_time' => $msg['created_at'],
                    'unread_count' => 0,
                ];
            }
            // Contar no leídos
            if ($msg['is_read'] == 0 && $msg['receiver_id'] == $userId) {
                $userChats[$otherUserId]['unread_count']++;
            }
            // Actualizar última fecha
            if (strtotime($msg['created_at']) > strtotime($userChats[$otherUserId]['last_message_time'])) {
                $userChats[$otherUserId]['last_message_time'] = $msg['created_at'];
            }
        }

        // Obtener datos del usuario
        $chats = [];
        foreach ($userChats as $chat) {
            $user = $userModel->find($chat['user_id']);
            $chat['fullname'] = $user['fullname'] ?? '';
            $chat['username'] = $user['username'] ?? '';
            $chat['profile_photo_type'] = $user['profile_photo_type'] ?? '';
            $chat['profile_photo'] = file_exists(__DIR__ . "/../../public/assets/images/profiles/{$chat['user_id']}.{$chat['profile_photo_type']}")
                ? "/assets/images/profiles/{$chat['user_id']}.{$chat['profile_photo_type']}"
                : "/assets/images/user-default.png";
            $chats[] = $chat;
        }

        // Ordenar por last_message_time DESC
        usort($chats, function($a, $b) {
            return strtotime($b['last_message_time']) - strtotime($a['last_message_time']);
        });

        return $this->json(['success' => true, 'chats' => $chats]);
    }

    public function getMessages($chatWithId)
    {
        $messageModel = new Message();
        $userModel = new User();
        $userId = $_SESSION['user']['id'];

        // Obtener el historial de mensajes entre los dos usuarios
        $messages = $messageModel
            ->where('sender_id', $userId)
            ->where('receiver_id', $chatWithId)
            ->orWhere('sender_id', $chatWithId)
            ->where('receiver_id', $userId)
            ->orderBy('created_at', 'ASC')
            ->get();

        foreach ($messages as &$message) {
            $sender = $userModel->find($message['sender_id']);
            $message['sender_fullname'] = $sender['fullname'] ?? '';
            $message['sender_profile_photo_type'] = $sender['profile_photo_type'] ?? '';
            $message['sender_username'] = $sender['username'] ?? '';
            $message['sender_profile_photo'] = file_exists(__DIR__ . "/../../public/assets/images/profiles/{$message['sender_id']}.{$message['sender_profile_photo_type']}")
                ? "/assets/images/profiles/{$message['sender_id']}.{$message['sender_profile_photo_type']}"
                : "/assets/images/user-default.png";
        }

        return $this->json(['success' => true, 'messages' => $messages]);
    }

    public function sendMessage($receiverId)
    {
        $senderId = $_SESSION['user']['id'];
        $messageModel = new Message();
        $message = json_decode(file_get_contents('php://input'), true)['message'] ?? '';

        // Validar el mensaje
        if (empty(trim($message))) {
            return $this->json(['success' => false, 'message' => 'El mensaje no puede estar vacío.'], 400);
        }

        // Guardar el mensaje en la base de datos
        $newMessage = $messageModel->create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        $notificationController = new NotificationController();
        $notificationController->createNotification('message', $senderId, $receiverId);

        return $this->json(['success' => true, 'message' => $newMessage]);
    }

    public function markMessagesAsRead($chatWithId)
    {
        $messageModel = new Message();
        $userId = $_SESSION['user']['id'];

        // Marcar como leídos los mensajes recibidos del otro usuario
        $messageModel
            ->where('receiver_id', $userId)
            ->where('sender_id', $chatWithId)
            ->update(null, ['is_read' => 1]);

        return $this->json(['success' => true, 'message' => 'Mensajes marcados como leídos.']);
    }
}
