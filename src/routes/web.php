<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\StripeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', [RestaurantController::class, 'index']);
Route::post('/', [RestaurantController::class, 'search']);
Route::get('/detail/{id}', [RestaurantController::class, 'detail'])->name('detail');

Route::get('/register', [UserController::class, 'getRegister']);
Route::post('/register', [UserController::class, 'postRegister']);
Route::get('/login', [UserController::class, 'getLogin'])->name('login');
Route::post('/login', [UserController::class, 'postLogin']);

Route::middleware(['verified'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/reservation', [ReservationController::class, 'reservation']);
    Route::post('/cancel', [ReservationController::class, 'cancel']);
    Route::post('/edit-reservation', [ReservationController::class, 'edit']);
    Route::get('/done', [ReservationController::class, 'done']);
    Route::post('/add-favorite', [FavoriteController::class, 'addFavorite']);
    Route::post('/remove-favorite', [FavoriteController::class, 'removeFavorite']);
    Route::get('/mypage', [UserController::class, 'mypage']);
    Route::get('/review', [ReviewController::class, 'review']);
    Route::post('/add-review', [ReviewController::class, 'addReview']);
    Route::post('/charge', [StripeController::class, 'charge'])->name('stripe.charge');
});

Route::get('/admin/login', [AdministratorController::class, 'getLogin']);
Route::post('/admin/login', [AdministratorController::class, 'postLogin']);

Route::middleware(['auth.admin'])->group(function () {
    Route::post('/admin/logout', [AdministratorController::class, 'logout']);
    Route::get('/admin', [AdministratorController::class, 'index']);
});

Route::post('/owner/register', [OwnerController::class, 'postRegister']);
Route::get('/owner/login', [OwnerController::class, 'getLogin']);
Route::post('/owner/login', [OwnerController::class, 'postLogin']);

Route::middleware(['auth.owner'])->group(function () {
    Route::post('/owner/logout', [OwnerController::class, 'logout']);
    Route::get('/owner', [OwnerController::class, 'index']);
    Route::post('/add', [RestaurantController::class, 'add']);
    Route::post('/update', [RestaurantController::class, 'update']);
    Route::get('/message', [OwnerController::class, 'message']);
    Route::post('/send-message', [OwnerController::class, 'sendMessage']);
    Route::get('/confirm-visit/{id}', [ReservationController::class, 'confirmVisit']);
});
