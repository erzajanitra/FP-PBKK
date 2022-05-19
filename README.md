## Anggota Kelompok:
| No | Nama  | NRP |
| ------------- |:-------------:| :-----:|
| 1 | Erza Janitradevi Nadine |   05111940000153 |
| 2 | Florentino Benedictus|   5025201222 |
| 3 | Fian Awamiry Maulana | 5025201235 |
# Required:
## Laravel route, controller and middleware  
**Laravel Route**  
* Terdapat pada path ```App\routes\web.php```
    * Pertama, laravel route untuk ```Menu Ticket Reservations```
    ```php  
    use App\Http\Controllers\TicketController;
    
    Route::get('/ticket', [TicketController::class, 'formulir']);
    Route::post('/hasil', [TicketController::class, 'hasil']);
    ```  
    * Selanjutnya, laravel route untuk ```Menu Dashboard``` setelah ```Login```  
    ```php
    Route::get('/dashboard', function () {
    return view('dashboard');
    })->middleware(['auth'])->name('dashboard');
    ```  
    * Laravel route untuk ```Confirm Password``` dan ```Setting Password```
    ```php
    Route::post('/confirm-password', function (Request $request) {
    if (!Hash::check($request->password, $request->user()->password)) {
        return back()->withErrors([
            'password' => ['The provided password does not match our records.']
        ]);
    }

    $request->session()->passwordConfirmed();

    return redirect()->intended('settings');
    })->middleware(['auth', 'throttle:6,1'])->name('password.confirm');
    ```
    ```php
    Route::get('/settings', function () {
        return view('settings');
    })->middleware(['password.confirm'])->name('settings');
    ```  
**Laravel Controller**  
**Laravel Middleware**  
## Laravel request, validation and response  
**Laravel request**  
**Laravel validation**  
**Laravel response**  
## Laravel model, eloquent and query builder  
**Laravel model**  
**Laravel eloquent**  
**Laravel query builder**  
## Laravel authentication and authorization  
**Laravel authentication**  
**Laravel authorization**  
## Laravel localization and file storage  
**Laravel localization**  
**Laravel file storage**  
## Laravel view and blade component  
**Laravel view**  
**Laravel Blade Component**  
## Laravel session and caching  
**Laravel Session**  
**Laravel Caching**  
## Laravel feature testing and unit testing  
**Laravel Feature Testing**  
**Laravel Unit Testing**  
# Optional:
## Laravel jobs and queue 
**Laravel Jobs**  
**Laravel Queue**  
## Laravel command and scheduling  
**Laravel Command**  
**Laravel Scheduling**  
## Laravel event and listener  
**Laravel Event**  
**Laravel Listener**  
## Laravel contracts and facade  
**Laravel Contracts**  
**Laravel Facadde**  
## Laravel broadcasting  
**Laravel Broadcasting**  
## Laravel composer package  
**Laravel Composer Package**  
# Rerensi 
* Install Alert - https://realrashid.github.io/sweet-alert/install
