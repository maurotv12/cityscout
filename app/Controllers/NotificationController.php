<?php

namespace App\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Post;

class NotificationController extends Controller
{


    public function getNotifications()
    {
        $userId = $_SESSION['user']['id'];
        $notificationModel = new Notification();
        $userModel = new User();
        $postModel = new Post();
        

        // Obtener notificaciones del usuario autenticado usando where
        $notifications = $notificationModel
            ->where('user_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();

        $notifications = array_map(function($notification) use ($userModel, $postModel) {
            $sender = $userModel->find($notification['sender_id']);
            $notification['sender'] = [
                'id' => $sender['id'],
                'fullname' => $sender['fullname'],
                'username' => $sender['username'],
                'profile_photo_type' => $sender['profile_photo_type'],
            ];

            $notification['post'] = $postModel->getPost($notification['reference_id']);
            return $notification;
        }, $notifications);


        return $this->json(['success' => true, 'notifications' => $notifications]);
    }

    public function markAsRead()
    {
        $userId = $_SESSION['user']['id'];
        $notificationModel = new Notification();

        $notifications = $notificationModel->where('user_id', $userId)->get();

        if (!$notifications) {
            return $this->json(['success' => false, 'message' => 'No hay notificaciones para marcar como leídas.']);
        }

        foreach ($notifications as $notification) {
            if ($notification['is_read'] == 0) {
                $notificationModel->update($notification['id'], ['is_read' => 1]);
            }
        }

        return $this->json(['success' => true, 'message' => 'Notificaciones marcadas como leídas.']);
    }

    public function createNotification($type, $senderId, $receiverId, $referenceId = null)
    {
        $notificationModel = new Notification();
        $content = null;
        switch ($type) {
            case 'like':
                $content = 'Le dio like a tu publicación.';
                break;
            case 'comment':
                $content = 'Comentó tu publicación.';
                break;
            case 'follower':
                $content = 'Te ha seguido.';
                break;
            case 'message':
                $content = 'Te ha enviado un mensaje.';
                break;
        }

        $notification = $notificationModel->create([
            'user_id' => $receiverId,
            'sender_id' => $senderId,
            'type' => $type,
            'reference_id' => $referenceId,
            'content' => $content,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $notification;
    }
}
