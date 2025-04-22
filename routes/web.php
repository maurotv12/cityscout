<?php

use App\Controllers\AuthController;
use App\Controllers\ChatController;
use Lib\Route;
use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Models\User;

Route::get('/', [PostController::class, 'index'])
    ->middleware([AuthMiddleware::class]);

//Auth
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'register']);

//posts
Route::get('/post/create', function () {
    AuthMiddleware::handle();
    (new PostController)->create();
});
// Route::get('/post/:id', function () {
//     AuthMiddleware::handle();
//     (new PostConstroller)->post();
// });

//user
Route::get('/profile/:id', [UserController::class, 'show'])
    ->middleware(middlewareList: [AuthMiddleware::class]);

Route::get('/profile/:id/edit', [UserController::class, 'edit']);

//chat
Route::get('/chats', [ChatController::class, 'index']);
Route::get('/conversation/:id', [ChatController::class, 'conversation']);

Lib\Route::dispatch();


// <?php

// use Lib\Route;
// use App\Controllers\HomeController;

// Route::get('/', function (){
//     echo 'hola desde la pagina principal';
// });

// Route::get('/feed', function () {
//     echo 'hola desde el feed';
// });

// Route::get('/perfil', function () {
//     echo 'hola desde perfil';
// });

// Route::get('/courses/:slug', function ($slug) {
//     echo 'Hola es: ' . $slug;
    
// });

// Route::dispatch();