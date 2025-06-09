<?php

use App\Controllers\AuthController;
use App\Controllers\ChatController;
use App\Controllers\NotificationController;
use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Models\User;
use Lib\Route;

Route::get('/', [PostController::class, 'index'])
    ->middleware([AuthMiddleware::class]);

//Auth
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register']);

//comments
Route::get('/post/:id/comments', [PostController::class, 'getComments'])
    ->middleware([AuthMiddleware::class]);
//Agregar comentario
Route::post('/post/:id/comments', [PostController::class, 'addComment'])
    ->middleware([AuthMiddleware::class]);
//Eliminar Comentario
Route::delete('/comment/:id/delete', [PostController::class, 'deleteComment'])
    ->middleware([AuthMiddleware::class]);
//Editar Comentario
Route::post('/comment/:id/update', [PostController::class, 'updateComment'])
    ->middleware([AuthMiddleware::class]);

//Likes
Route::post('/post/:id/like', [PostController::class, 'toggleLike'])
    ->middleware([AuthMiddleware::class]);

//Guardar post
Route::post('/post/store', [PostController::class, 'store'])
    ->middleware([AuthMiddleware::class]);
//Eliminar post
Route::delete('/post/:id/delete', [PostController::class, 'deletePost'])
    ->middleware([AuthMiddleware::class]);
//Editar caption o descripción de post
Route::post('/post/:id/update-caption', [PostController::class, 'updateCaption'])
    ->middleware([AuthMiddleware::class]);



//user profile routes
Route::get('/@:username', [UserController::class, 'show']);
Route::get('/profile/:id/edit', [UserController::class, 'edit'])
    ->middleware([AuthMiddleware::class]);
Route::post('/user/update-profile/:id', [UserController::class, 'update'])
    ->middleware([AuthMiddleware::class]);


//Follow and Unfollow
Route::post('/profile/:id/follow', [UserController::class, 'toggleFollow'])
    ->middleware([AuthMiddleware::class]);

//chat

// Obtener lista de chats
Route::get('/chats', [ChatController::class, 'getChats'])
    ->middleware([AuthMiddleware::class]);
// Obtener mensajes de un chat
Route::get('/chats/:chatWithId/messages', [ChatController::class, 'getMessages'])
    ->middleware([AuthMiddleware::class]);
// Enviar un mensaje
Route::post('/chats/:chatWithId/send', [ChatController::class, 'sendMessage'])
    ->middleware([AuthMiddleware::class]);
// Marcar mensajes como leídos
Route::post('/chats/:chatWithId/read', [ChatController::class, 'markMessagesAsRead'])
    ->middleware([AuthMiddleware::class]);

// Follow and Unfollow
Route::post('/user/:id/follow', [UserController::class, 'toggleFollow'])
    ->middleware([AuthMiddleware::class]);


//Notifications
Route::get('/notifications', [NotificationController::class, 'getNotifications'])
    ->middleware([AuthMiddleware::class]);
// Marcar notificación como leída
Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])
    ->middleware([AuthMiddleware::class]);

//ruta para blur de posts  
Route::post('/post/:id/toggle-blur', [PostController::class, 'toggleBlur'])
    ->middleware([AuthMiddleware::class]);

Route::get('/search/users', [UserController::class, 'searchUsers'])
    ->middleware([AuthMiddleware::class]);

//ruta para manejo de solicitudes de verificación 
Route::get('/check-availability', [UserController::class, 'checkAvailability']);

// Obtener todos los intereses
Route::get('/interests', [UserController::class, 'getInterests'])
    ->middleware([AuthMiddleware::class]);
// Obtener usuarios recomendados con intereses similares
Route::get('/user/recommendations', [UserController::class, 'getUsersWithSimilarInterests'])
    ->middleware([AuthMiddleware::class]);
// Guardar intereses del usuario
Route::post('/user/interests', [UserController::class, 'saveUserInterests'])
    ->middleware([AuthMiddleware::class]);
// Seguir/Dejar de seguir usuario
Route::post('/profile/:id/follow', [UserController::class, 'toggleFollow'])
    ->middleware([AuthMiddleware::class]);

// Mostrar seguidores y seguidos de un usuario
Route::get('/@:username/followers-list', [UserController::class, 'followersList'])
    ->middleware([AuthMiddleware::class]);

Lib\Route::dispatch();
