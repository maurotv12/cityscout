<?php

namespace App\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{


    public function getNotifications()
    {
        $userId = $_SESSION['user']['id'];
        $notificationModel = new Notification();

        // Obtener notificaciones del usuario autenticado
        $notifications = $notificationModel->where('user_id', $userId);

        return $this->json(['success' => true, 'notifications' => $notifications]);
    }
    
    public function markAsRead()
    {
        $notificationId = json_decode(file_get_contents('php://input'), true)['notification_id'] ?? null;

        if (!$notificationId) {
            return $this->json(['success' => false, 'message' => 'ID de notificación no proporcionado'], 400);
        }

        $notificationModel = new Notification();
        $updated = $notificationModel->update($notificationId, ['is_read' => 1]);

        if ($updated) {
            return $this->json(['success' => true, 'message' => 'Notificación marcada como leída']);
        } else {
            return $this->json(['success' => false, 'message' => 'Error al marcar la notificación como leída'], 500);
        }
    }

    public function createNotification($type, $senderId, $receiverId, $referenceId, $content)
    {
        $notificationModel = new Notification();

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
