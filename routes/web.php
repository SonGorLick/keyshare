<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    //search
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/search/get', [SearchController::class, 'getSearch']);

    //games
    Route::get('games', [GameController::class, 'index'])->name('games');

    //keys
    Route::get('addkey', [KeyController::class, 'create'])->name('addkey');
    Route::post('addkey', [KeyController::class, 'store'])->name('storekey');
});


// OLD
Route::get('/notapproved', [HomeController::class, 'notApproved'])->name('notapproved');
Route::get('/demo', [HomeController::class, 'demo'])->name('demomode');

// Route::middleware(['steamlogin'])->group(function () {
//     Route::get('login/steam', 'Auth\LoginController@steamRedirect')->name('steamlogin');
//     Route::get('login/steam/callback', 'Auth\LoginController@steamCallback');
// });

Route::middleware(['auth:sanctum', 'verified', 'approved'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    //SEARCH
    Route::get('search', [SearchController::class, 'search'])->name('search');
    Route::get('search/get', [SearchController::class, 'getSearch']);
    Route::get('autocomplete/games/{search}', [SearchController::class, 'autocomplete'])->name('autocomplete');
    Route::get('autocomplete/dlc/{gamename}/{search}', [SearchController::class, 'autocompleteDlc'])->name('autocompleteDlc');

    //GAMES
    Route::get('games', [GameController::class, 'index'])->name('game.index');
    Route::get('games/get', [GameController::class, 'getGames']);
    Route::get('games/{id}', [GameController::class, 'show'])->name('game.show');

    //KEYS
    Route::get('keys/{key}', [KeyController::class, 'show'])->name('key.show');
    Route::get('claimedkeys', [KeyController::class, 'showClaimed'])->name('claimedkeys');
    Route::get('claimedkeys/get', [KeyController::class, 'getClaimed']);
    Route::get('sharedkeys', [KeyController::class, 'showShared'])->name('sharedkeys');
    Route::get('sharedkeys/get', [KeyController::class, 'getShared']);
    Route::get('addkey/', [KeyController::class, 'create'])->name('addkey');

    Route::post('addkey/store', [KeyController::class, 'store'])->name('key.store');
    Route::put('addkey/claim', [KeyController::class, 'claim'])->name('key.claim');

    //USERS
    // Route::get('/users', [UserController::class, 'index'])->name('users');
    // Route::get('/users/{id}', [UserController::class, 'show'])->name('showuser');
    // Route::get('/user/edit', [UserController::class, 'edit'])->name('edituser')->middleware('demomode');
    // Route::post('/user/update', [UserController::class, 'update'])->name('updateuser')->middleware('demomode');
    // Route::get('/changepassword', [UserController::class, 'passwordResetPage'])->name('changepassword')->middleware('demomode');
    // Route::post('/changepassword/save', [UserController::class, 'passwordResetSave'])->name('postpassword')->middleware('demomode');

    //PLATFORMS
    Route::get('/platform/{id}', [PlatformController::class, 'show'])->name('platform.show');
    Route::get('/platform/get/{id}', [PlatformController::class, 'getPlatform']);

    //DLC
    // Route::get('/games/dlc/get/{id}', [DlcController::class, 'index']);
    // Route::get('/games/dlc/{dlc}', [DlcController::class, 'show'])->name('dlc');


    //// TO BE MOVED TO ADMIN
    Route::get('/games/edit/{id}', [GameController::class, 'edit'])->name('game.edit');
    Route::put('/games/update', [GameController::class, 'update'])->name('game.update');
});

Route::middleware(['admin'])->group(function () {
    // Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('adminshowusers');
    // Route::get('/admin/user/{id}', [AdminController::class, 'usersEdit'])->name('adminuseredit')->middleware('demomode');
    // Route::post('/admin/user/update', [AdminController::class, 'usersUpdate'])->name('adminuserupdate')->middleware('demomode');

    // Route::get('/games/dlc/edit/{dlc}', [DlcController::class, 'edit'])->name('editdlc');
    // Route::post('/games/dlc/update', [DlcController::class, 'update'])->name('updatedlc');

    
    
});