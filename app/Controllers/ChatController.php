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

        // Obtener los usuarios con los que el usuario ha chateado
        $sql = "
                SELECT 
                    u.id AS user_id, 
                    u.fullname, 
                    u.username, 
                    u.profile_photo_type,
                    COUNT(CASE WHEN m.is_read = 0 AND m.receiver_id = ? THEN 1 END) AS unread_count,
                    MAX(m.created_at) AS last_message_time
                FROM messages m
                INNER JOIN users u ON (u.id = m.sender_id OR u.id = m.receiver_id)
                WHERE (m.sender_id = ? OR m.receiver_id = ?)
                  AND u.id != ?
                GROUP BY u.id
                ORDER BY last_message_time DESC
            ";

        $chats = $messageModel->query($sql, [$userId, $userId, $userId, $userId])->get();

        // Formatear los datos
        foreach ($chats as &$chat) {
            $chat['profile_photo'] = file_exists(__DIR__ . "/../../public/assets/images/profiles/{$chat['user_id']}.{$chat['profile_photo_type']}")
                ? "/assets/images/profiles/{$chat['user_id']}.{$chat['profile_photo_type']}"
                : "/assets/images/user-default.png";
        }

        return $this->json(['success' => true, 'chats' => $chats]);
    }

    public function getMessages($chatWithId)
    {
        $messageModel = new Message();
        $userId = $_SESSION['user']['id'];

        // Obtener el historial de mensajes entre los dos usuarios
        $sql = "
                SELECT 
                    m.id, 
                    m.sender_id, 
                    m.receiver_id, 
                    m.message, 
                    m.is_read, 
                    m.created_at,
                    su.fullname AS sender_fullname,
                    su.profile_photo_type AS sender_profile_photo_type,
                    su.username AS sender_username
                FROM messages m
                INNER JOIN users su on (su.id = m.sender_id)
                WHERE (m.sender_id = ? OR m.receiver_id = ? )
                   AND (m.sender_id = ? OR m.receiver_id = ? )
                ORDER BY m.created_at ASC
            ";

        $messages = $messageModel->query($sql, [$userId, $userId, $chatWithId, $chatWithId])->get();

        foreach ($messages as &$message) {
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
        $sql = "
                UPDATE messages 
                SET is_read = 1 
                WHERE receiver_id = ? AND sender_id = ?
            ";

        $messageModel->query($sql, [$userId, $chatWithId]);

        return $this->json(['success' => true, 'message' => 'Mensajes marcados como leídos.']);
    }

 
   
}
