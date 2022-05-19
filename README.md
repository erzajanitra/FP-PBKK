## Anggota Kelompok:
| No | Nama  | NRP |
| ------------- |:-------------:| :-----:|
| 1 | Erza Janitradevi Nadine |   05111940000153 |
| 2 | Florentino Benedictus|   5025201222 |
| 3 | Fian Awamiry Maulana | 5025201235 |
# Required:
## Laravel route, controller and middleware  
**Laravel Route**  
* Laravel Route terletak pada path ```routes\web.php```
* Laravel Route Basic
    * Route untuk mengakses ```Menu Article```
    ```php  
    Route::get('/article', function () {
    return view('article');
    });
    ```  
    * Route untuk mengakses ```Menu About Us```
    ```php
    Route::get('/aboutus', function () {
    return view('aboutus');
    });
    ```  
    * Route untuk mengakses ```Menu Price List```
    ```php  
    Route::get('/pricelist', function () {
    return view('pricelist');
    });
    ```  
* Laravel Route Dengan Parameter
    * Route untuk mengakses halaman atau ```Menu Ticket Reservations```
    ```php  
    use App\Http\Controllers\TicketController;
    
    Route::get('/ticket', [TicketController::class, 'formulir']);
    Route::post('/hasil', [TicketController::class, 'hasil']);
    ```  
**Laravel Controller**  
* Laravel Controller terletak pada path ```app\Http\Controllers```
    * Terdapat Controller yang bernama ```AuthController.php``` yang berfungsi untuk menyambungkan ```Authentikasi```, ```Login```, ```Dashboard Login```, ```Log Out```     kedalam ```routes\web.php```.
    ```php  
    <?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Auth\LoginRequest;
    use App\Providers\RouteServiceProvider;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;

    class AuthController extends Controller
    {

    public function show()
    {
        return view('auth.manual-login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // MANUAL LOGIN
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials, true)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // RETRIEVING USER 
    public function retrieve(Request $request)
    {
        // $user = Auth::user()->name;
        // $id = Auth::id();

        // ALTERNATIVE
        $user = $request->user()->name;
        $id = $request->user()->id;

        return view('dashboard', compact(['user', 'id']));
    }

    // CHECK AUTHENTICATION
    public function check()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            return redirect('login');
        }
    }

    public function update(Request $request)
    {
        $request->user();
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    }
    ```  
    * Terdapat Controller yang bernama ```TicketController.php``` yang berfungsi untuk menyambungkan ke dalam ```View Ticket```, ```View Hasil```, ngevalidasi dari ```View Hasil``` dan menghubungkan kedalam ```routes\web.php``` biar bisa diakses.
    ```php  
    <?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use RealRashid\SweetAlert\Facades\Alert;


    class TicketController extends Controller
    {
    //
    public function formulir()
    {
        return view('ticket');
    }

    public function hasil(Request $request)
    {
        Alert::success('Pesan Terkirim!', 'Terima kasih sudah melakukan Reservation Ticket Bromo Adventure 2022!');
        $this->validate($request, [
            'nama' => 'required|min:8|max:50',
            'jeniskelamin' => 'required|max:1',
            'noktp' => 'required|numeric',
            'alamat' => 'required|min:8|max:50',
            'fotoktp' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);
        $foto_link = $this->saveFoto($request, 1);
        $request->fotoktp = $foto_link;
        return view('hasil', ['data' => $request]);
    }
    public function saveFoto(Request $request, $id)
    {
        $foto = $request->ktm; // typedata : file
        $foto_name = ''; // typedata : string
        if ($foto !== NULL) {
            $foto_name = 'foto' . '-' . $id . "." . $foto->extension(); // typedata : string
            $foto_name = str_replace(' ', '-', strtolower($foto_name)); // typedata : string
            $foto->storeAs(null, $foto_name, ['disk' => 'public']); // memanggil function untuk menaruh file di storage
        }
        return asset('storage') . '/' . $foto_name; // me return path/to/file.ext
    }
    }
    ```
**Laravel Middleware**  
* Laravel Middleware terletak pada path ```routes\web.php```
    * Laravel untuk mengakses ```Menu Dashboard``` setelah ```Login```  
    ```php
    Route::get('/dashboard', function () {
    return view('dashboard');
    })->middleware(['auth'])->name('dashboard');
    ```  
    * Laravel route untuk mengakses ```Confirm Password```
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
    * Laravel route untuk mengakses ```Setting Password```
    ```php
    Route::get('/settings', function () {
        return view('settings');
    })->middleware(['password.confirm'])->name('settings');
    ```  
## Laravel request, validation and response  
**Laravel request**  
    ```php  
    
    ```  
**Laravel validation**  
    ```php  
    
    ```  
**Laravel response**  
    ```php  
    
    ```  
## Laravel model, eloquent and query builder  
**Laravel model**  
    ```php  
    
    ```  
**Laravel eloquent**  
    ```php  
    
    ```  
**Laravel query builder**  
    ```php  
    
    ```  
## Laravel authentication and authorization  
**Laravel authentication**  
    ```php  
    
    ```  
**Laravel authorization**  
    ```php  
    
    ```  
## Laravel localization and file storage  
**Laravel localization**  
    ```php  
    
    ```  
**Laravel file storage**  
    ```php  
    
    ```  
## Laravel view and blade component  
**Laravel view**  
    ```php  
    
    ```  
**Laravel Blade Component**  
    ```php  
    
    ```  
## Laravel session and caching  
**Laravel Session**  
    ```php  
    
    ```  
**Laravel Caching**  
    ```php  
    
    ```  
## Laravel feature testing and unit testing  
**Laravel Feature Testing** 
    ```php  
    
    ```  
**Laravel Unit Testing**  
    ```php  
    
    ```  
# Optional:
## Laravel jobs and queue 
**Laravel Jobs**  
    ```php  
    
    ```  
**Laravel Queue**  
    ```php  
    
    ```  
## Laravel command and scheduling  
**Laravel Command**  
    ```php  
    
    ```  
**Laravel Scheduling**  
    ```php  
    
    ```  
## Laravel event and listener  
**Laravel Event**  
    ```php  
    
    ```  
**Laravel Listener**  
    ```php  
    
    ```  
## Laravel contracts and facade  
**Laravel Contracts**  
    ```php  
    
    ```  
**Laravel Facadde**  
    ```php  
    
    ```  
## Laravel broadcasting  
**Laravel Broadcasting**  
    ```php  
    
    ```  
## Laravel composer package  
**Laravel Composer Package**  
    ```php  
    
    ```  
# Rerensi 
* Install Alert - https://realrashid.github.io/sweet-alert/install
