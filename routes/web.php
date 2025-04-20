<?php

use App\Controllers\AuthController;
use App\Controllers\ChatController;
use Lib\Route;
use App\Controllers\PostConstroller;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Models\User;

// Route::get('/', function () {
//     AuthMiddleware::handle();
//     (new PostConstroller)->index();
// });
Route::get('/', [PostConstroller::class, 'index']);

//Auth
Route::get('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/logout', [AuthController::class, 'logout']);

//posts
Route::get('/post/create', function () {
    AuthMiddleware::handle();
    (new PostConstroller)->create();
});
// Route::get('/post/:id', function () {
//     AuthMiddleware::handle();
//     (new PostConstroller)->post();
// });

//user
Route::get('/profile/:id', [UserController::class, 'show']);
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