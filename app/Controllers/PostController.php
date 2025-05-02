<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Controllers\NotificationController;

class PostController extends Controller
{


    public function index()
    {
        $postModel = new Post;
        $posts = $postModel->getFollowedUsersPosts($_SESSION['user']['id']);

        return $this->view('post.feed', ['posts' => $posts]);
    }

    public function create()
    {
        $model = new User;
        $model = new Post;

        $users = $model->all();

        return $this->view('post.create');
    }

    public function post($id){
        return "aqui se mostrará el feed";
    }

    public function getComments($postId)
    {
        $commentModel = new Comment();
        $comments = $commentModel->getComments($postId);
        $postModel = new Post();
        $post = $postModel->find($postId);

        $comments = array_map(function($comment) use ($post) {
            $userModel = new User();
            $user = $userModel->find($comment['user_id']);

            return [
                'id' => $comment['id'],
                'can_delete' => $comment['user_id'] === $_SESSION['user']['id'] || $post['user_id'] === $_SESSION['user']['id'],
                'comment' => htmlspecialchars($comment['comment'], ENT_QUOTES, 'UTF-8'),
                'created_at' => $comment['created_at'],
                'user' => $user
            ];
        }, $comments);

        if (!$comments) {
            return ['success' => false, 'message' => 'No se encontraron comentarios.'];
        } 

        return ['success' => true, 'message' => 'funciono', 'comments' => $comments];
    }

    public function toggleLike($postId){
        $likeModel = new Like();
        $postModel = new Post();
        $post = $postModel->find($postId);
        $userId = $_SESSION['user']['id'];


        // Verificar si el usuario ya dio like
        $existingLike = $likeModel->where('post_id', $postId)->where('user_id', $userId)->first();

        if ($existingLike) {
            // Quitar like
            $likeModel->delete($existingLike['id']);
            return $this->json(['success' => true, 'liked' => false]);
        } else {
            // Dar like
            $likeModel->create(['post_id' => $postId, 'user_id' => $userId, 'created_at' => date('Y-m-d H:i:s')]);
            $notificationController = new NotificationController();
            $notificationController->createNotification('like', $userId, $post['user_id'], $postId);
            return $this->json(['success' => true, 'liked' => true]);
        }
    }



    public function store()
    {
        
        $userId = $_SESSION['user']['id'];
        $caption = $_POST['caption'] ?? '';
        $uploadedFiles = $_FILES['files'] ?? null;

        // return $this->json(['success' => false, 'message' => $caption], 400);

        if (!$uploadedFiles || empty($uploadedFiles['name'][0])) {
            return $this->json(['success' => false, 'message' => 'No se seleccionaron archivos.'], 400);
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'mp4'];
        $uploadDir = __DIR__ . '/../../public/assets/images/posts/';
        $fileData = [];

        foreach ($uploadedFiles['name'] as $index => $name) {
            $tmpName = $uploadedFiles['tmp_name'][$index];
            $error = $uploadedFiles['error'][$index];
            $size = $uploadedFiles['size'][$index];

            if ($error === UPLOAD_ERR_OK) {
                $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

                if (!in_array($extension, $allowedExtensions)) {
                    return ['success' => false, 'message' => 'Formato de archivo no permitido.'];
                }

                $timestamp = time() . '_' . uniqid();
                $fileName = $timestamp;
                $filePath = $uploadDir . $fileName . '.' . $extension;

                if (move_uploaded_file($tmpName, $filePath)) {
                    $fileData[] = [
                        'user_id' => $userId,
                        'file_name' => $fileName,
                        'type' => $extension,
                        'caption' => $caption,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                } else {
                    return ['success' => false, 'message' => 'Error al guardar el archivo.'];
                }
            } else {
                return ['success' => false, 'message' => 'Error al subir el archivo.'];
            }
        }

        // Guardar en la base de datos
        $postModel = new Post();
        foreach ($fileData as $data) {
            $postModel->create($data);
        }
      
        return ['success' => true, 'message' => 'Publicación creada con éxito.'];
    }
    
    public function updateCaption($id)
    {
        $postModel = new Post();
        $caption = json_decode(file_get_contents('php://input'), true)['caption'] ?? '';
    
        if (empty($caption)) {
            return $this->json(['success' => false, 'message' => 'La descripción no puede estar vacía.'], 400);
        }
    
        $updated = $postModel->update($id, ['caption' => $caption]);
    
        if ($updated) {
            return $this->json(['success' => true, 'message' => 'Descripción actualizada correctamente.']);
        } else {
            return $this->json(['success' => false, 'message' => 'Error al actualizar la descripción.'], 500);
        }
    }

    public function addComment($postId)
    {
        $commentModel = new Comment();
        $userId = $_SESSION['user']['id'];
        $data = json_decode(file_get_contents('php://input'), true);
     
        $commentText = $data['comment'] ?? '';
        
        

        if (empty($commentText)) {
            return $this->json(['success' => false, 'message' => 'El comentario no puede estar vacío.'], 400);
        }
    
        $comment = $commentModel->create([
            'post_id' => $postId,
            'user_id' => $userId,
            'comment' => htmlspecialchars($commentText, ENT_QUOTES, 'UTF-8'),
            'can_delete' => true,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    
        // Obtener información del usuario para devolverla en la respuesta
        $userModel = new User();
        $user = $userModel->find($userId);
    
        $hasMoreComments = count($commentModel->where('post_id', $postId)->get()) > 1; // Verificar si hay más comentarios para el post actual

        return $this->json([
            'success' => true,
            'comment' => [
                'id' => $comment['id'],
                'comment' => $comment['comment'],
                'created_at' => $comment['created_at'],
                'user' => [
                    'id' => $user['id'],
                    'fullname' => $user['fullname'],
                    'profile_photo' => file_exists(__DIR__ . '/../../public/assets/images/profiles/' . $user['id'] . '.' . $user['profile_photo_type'])
                    ? '/assets/images/profiles/' . $user['id'] . '.' . $user['profile_photo_type']
                    : '/assets/images/user-default.png',
                ],
            ],
            'has_more_comments' => $hasMoreComments,
        ]);
    }

    public function deleteComment($id)
{
    $commentModel = new Comment();
    $userId = $_SESSION['user']['id'];

    // Verificar si el comentario pertenece al usuario o al post del usuario
    $comment = $commentModel->find($id);

    if (!$comment) {
        return $this->json(['success' => false, 'message' => 'Comentario no encontrado.'], 404);
    }

    if ($comment['user_id'] !== $userId) {
        return $this->json(['success' => false, 'message' => 'No tienes permiso para eliminar este comentario.'], 403);
    }

    $deleted = $commentModel->delete($id);

    if ($deleted) {
        return $this->json(['success' => true, 'message' => 'Comentario eliminado correctamente.']);
    } else {
        return $this->json(['success' => false, 'message' => 'Error al eliminar el comentario.'], 500);
    }
}

}
