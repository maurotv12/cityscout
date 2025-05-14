<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Follower;

use App\Models\Comment;

class UserController extends Controller
{

    public function show($id)
    {

        $userModel = new User();
        $postModel = new Post();
        $followerModel = new Follower();

        $user = $userModel->find($id);
        $posts = $postModel->getPostsByUser($id);

        if (!$user) {
            http_response_code(404);
            return $this->view('errors.404', ['message' => 'Usuario no encontrado']);
        }

        // Contar publicaciones
        $postCount = $postModel->where('user_id', $id)->get();
        $postCount = count($postCount);

        // Contar seguidores
        $followersCount = $followerModel->where('user_followed_id', $id)->get();
        $followersCount = count($followersCount);

        // Contar seguidos
        $followingCount = $followerModel->where('user_follower_id', $id)->get();
        $followingCount = count($followingCount);

        // Verificar si el usuario actual sigue al perfil que está viendo
        $isFollowing = $followerModel->where('user_follower_id', $_SESSION['user']['id'])->where('user_followed_id', $id)->first();
        

        return $this->view('user.profile', [
            'posts' => $posts,
            'user' => $user,
            'postCount' => $postCount,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'isFollowing' => $isFollowing,

        ]);
    }



    public function update($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);
    
        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }
    
        $data = [];
    
        // Actualizar biografía
        if (isset($_POST['bio'])) {
            $data['bio'] = $_POST['bio'];
            $_SESSION['user']['bio'] = $data['bio'] ?? $user['bio']; // Actualizar la sesión con la nueva biografía
        }

        if (isset($_POST['username'])) {
            $data['username'] = $_POST['username'];
            $_SESSION['user']['username'] = $data['username'] ?? $user['username']; // Actualizar la sesión con el nuevo nombre de usuario
        }

        if (isset($_POST['fullname'])) {
            $data['fullname'] = $_POST['fullname'];
            $_SESSION['user']['fullname'] = $data['fullname'] ?? $user['fullname']; // Actualizar la sesión con el nuevo nombre completo
        }
    
        // Actualizar foto de perfil
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
    
            if (!in_array($extension, $allowedExtensions)) {
                return $this->json(['error' => 'Formato de archivo no permitido'], 400);
            }
    
            $fileName = $id . '.' . $extension;
            $filePath = __DIR__ . '/../../public/assets/images/profiles/' . $fileName;
    
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $filePath)) {
                $data['profile_photo_type'] = $extension;

                //eliminar foto de perfil anterior del local
                if (file_exists(__DIR__ . '/../../public/assets/images/profiles/' . $user['id'] . '.' . $user['profile_photo_type']) && $user['profile_photo_type'] !== $extension) {
                    unlink(__DIR__ . '/../../public/assets/images/profiles/' . $user['id'] . '.' . $user['profile_photo_type']);
                }

                $_SESSION['user']['profile_photo_type'] = $extension; // Actualizar la sesión con el nuevo tipo de foto de perfil
                
            } else {
                return $this->json(['error' => 'Error al guardar la foto de perfil'], 500);
            }
        }
    
        // Guardar cambios en la base de datos
        $updated = $userModel->update($id, $data);
    
        if ($updated) {
            return $this->json([
                'success' => true, 
                'message' => 'Perfil actualizado con éxito',
                'bio' => $data['bio'] ?? $user['bio'],
                'user_id' => $user['id'],
                'profile_photo_updated' => isset($data['profile_photo_type']),
                'profile_photo_type' => $data['profile_photo_type'] ?? $user['profile_photo_type'],
            ]);
            
        } else {
            return $this->json(['error' => 'No se pudo actualizar el perfil'], 500);
        }
    }


    public function updateBio($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Obtener la biografía enviada desde el formulario
        $bio = $_POST['bio'] ?? '';

        // Actualizar la biografía en la base de datos
        $updated = $userModel->update($id, ['bio' => $bio]);

        if ($updated) {
            // Devolver una respuesta JSON con éxito
            return $this->json(['success' => true, 'bio' => $bio]);
        } else {
            // Devolver un error si la actualización falla
            return $this->json(['error' => 'No se pudo actualizar la biografía'], 500);
        }
    }

    public function toggleFollow($id)
    {
        $followerModel = new Follower();
        $userId = $_SESSION['user']['id'];
    
        // Verificar si ya sigue al usuario
        $existingFollow = $followerModel->where('user_follower_id', $userId)->where('user_followed_id', $id)->first();

        if ($existingFollow) {
            // Dejar de seguir
            $followerModel->delete($existingFollow['id']);
            $followersCount = $followerModel->where('user_followed_id', $id)->get();
            $followersCount = count($followersCount);
            return $this->json(['success' => true, 'following' => false, 'followersCount' => $followersCount]);
        } else {
            // Seguir
            $followerModel->create([
                'user_follower_id' => $userId,
                'user_followed_id' => $id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $followersCount = $followerModel->where('user_followed_id', $id)->get();
            $followersCount = count($followersCount);

            $notificationController = new NotificationController();
            $notificationController->createNotification('follower', $userId, $id);

            return $this->json(['success' => true, 'following' => true, 'followersCount' => $followersCount]);
        }
    }

    public function searchUsers()
    {
    $query = $_GET['query'] ?? '';

    if (empty($query)) {
        return $this->json(['success' => false, 'message' => 'No se proporcionó un término de búsqueda.'], 400);
    }

    $userModel = new User();
    $users = $userModel->query(
        "SELECT id, username, fullname, profile_photo_type FROM users WHERE username LIKE ? OR fullname LIKE ? LIMIT 10",
        ['%' . $query . '%', '%' . $query . '%']
    )->get();

    return $this->json(['success' => true, 'users' => $users]);
    }

    public function checkAvailability()
{
    $field = $_GET['field'] ?? null;
    $value = $_GET['value'] ?? null;

     $allowedFields = ['username' => 'username', 'email' => 'email'];


    if (!$field || !$value || !in_array($field, ['username', 'email'])) {
        return $this->json(['success' => false, 'message' => 'Campo o valor inválido.'], 400);
    }

    $userModel = new User();
    $fieldName = $allowedFields[$field];


    // Consulta SQL directa para verificar si el campo ya existe
    $sql = "SELECT * FROM users WHERE {$field} = ?";
    $existingUser = $userModel->query($sql, [$value])->first();

    if ($existingUser) {
        return $this->json(['success' => false, 'message' => ucfirst($field) . ' ya está en uso.']);
    }

    return $this->json(['success' => true, 'message' => ucfirst($field) . ' disponible.']);
}


}

