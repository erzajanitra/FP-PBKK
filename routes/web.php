<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Queue\Listener;
use App\Http\Requests\Auth\LoginRequest;
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
    return view('welcome');
});
// View Article
Route::group(['prefix' => 'article'], function () {
    Route::get("/", [ArticleController::class, 'index']);
    Route::get("/{article:slug}", [ArticleController::class, 'detail']);
});
// View About Us
Route::get('/aboutus', function () {
    return view('aboutus');
});
// View Price List
Route::get('/pricelist', function () {
    return view('pricelist');
});
// View Reservation Ticket
//Asigment Formulir
// Route::get('/ticket', [TicketController::class, 'formulir']);
// // Route::post('/ticket', [TicketController::class, 'store']);
// Route::post('/hasil', [TicketController::class, 'hasil']);
Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
    Route::get('/', [TicketController::class, 'index'])->name('home');
    Route::get('/buat', [TicketController::class, 'create'])->name('tambah-data');
    Route::post('/buat-data', [TicketController::class, 'store'])->name('buat-data');
    Route::get('/hasil/{id}', [TicketController::class, 'show'])->name('show');
});
// View Dashboar Login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
// View Confirm-Password
Route::post('/confirm-password', function (Request $request) {
    if (!Hash::check($request->password, $request->user()->password)) {
        return back()->withErrors([
            'password' => ['The provided password does not match our records.']
        ]);
    }

    $request->session()->passwordConfirmed();

    return redirect()->intended('settings');
})->middleware(['auth', 'throttle:6,1'])->name('password.confirm');
// View Setting Password
Route::get('/settings', function () {
    return view('settings');
})->middleware(['password.confirm'])->name('settings');

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

Route::get('/private', [HomeController::class, 'private'])->name('private');
Route::get('/response', [HomeController::class, 'response'])->name('response');

Route::get('/post', [PostController::class, 'index']);
Route::get('/post/create', [PostController::class, 'create']);
Route::get('/post/edit/{id}', [PostController::class, 'edit']);
Route::get('/post/delete/{post}', [PostController::class, 'destroy'])->middleware('can:delete,post');
