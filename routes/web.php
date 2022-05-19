<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\TicketController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/article', function () {
    return view('article');
});

Route::get('/aboutus', function () {
    return view('aboutus');
});

Route::get('/pricelist', function () {
    return view('pricelist');
});

// Form Ticket

// Route::get('/ticket', function () {
//     return view('ticket');
// });

//Asigment Formulir
Route::get('/ticket', [TicketController::class, 'formulir']);
Route::post('/hasil', [TicketController::class, 'hasil']);

Route::post('/confirm-password', function (Request $request) {
    if (!Hash::check($request->password, $request->user()->password)) {
        return back()->withErrors([
            'password' => ['The provided password does not match our records.']
        ]);
    }

    $request->session()->passwordConfirmed();

    return redirect()->intended('settings');
})->middleware(['auth', 'throttle:6,1'])->name('password.confirm');

Route::get('/settings', function () {
    return view('settings');
})->middleware(['password.confirm'])->name('settings');
