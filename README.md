## Anggota Kelompok:
| No | Nama  | NRP |
| ------------- |:-------------:| :-----:|
| 1 | Erza Janitradevi Nadine |   05111940000153 |
| 2 | Florentino Benedictus|   5025201222 |
| 3 | Fian Awamiry Maulana | 5025201035 |
# Required:
## Laravel Route, Controller and Middleware  
**Laravel Route**  
* Laravel Route terletak pada path ```routes\web.php```
    ```php  
    <?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use App\Http\Controllers\TicketController;
    use App\Http\Controllers\ArticleController;
    use App\Http\Controllers\PricelistController;
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
    Route::get('/pricelist', [PricelistController::class, 'index']);
    // View Time Line
    Route::get('/timeline', function () {
        return view('timeline');
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
        // Problem
        Route::get('/hasil', [TicketController::class, 'show'])->name('show');
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
    ```
* Laravel Route Basic
    * Route untuk mengakses ```Menu About Us```
    ```php
    Route::get('/aboutus', function () {
    return view('aboutus');
    });
    ```  
    * Route untuk mengakses ```Time Line```
    ```php  
    Route::get('/timeline', function () {
    return view('timeline');
    });
    ```  
* Laravel Route Dengan Parameter
    * Route untuk mengakses halaman atau ```Menu Article```
    ```php  
    Route::group(['prefix' => 'article'], function () {
    Route::get("/", [ArticleController::class, 'index']);
    Route::get("/{article:slug}", [ArticleController::class, 'detail']);
    });
    ```  
    * Route untuk mengakses halaman atau ```Menu Ticket Reservations```
    ```php  
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
                'alamat' => 'required|min:8|max:100',
                'notelp' => 'required|numeric',
                'fotoktp' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]);
            $imageName = time() . '.' . $request->fotoktp->extension();
            $request->fotoktp->move(public_path('images'), $imageName);
            $request->fotoktp = $imageName;

            // echo $request->bukti;
            return view('hasil', ['data' => $request]);
            // $foto_link = $this->saveFoto($request, 1);
            // $request->fotoktp = $foto_link;
            // return view('hasil', ['data' => $request]);
        }
        // public function saveFoto(Request $request, $id)
        // {
        //     $foto = $request->ktm; // typedata : file
        //     $foto_name = ''; // typedata : string
        //     if ($foto !== NULL) {
        //         $foto_name = 'foto' . '-' . $id . "." . $foto->extension(); // typedata : string
        //         $foto_name = str_replace(' ', '-', strtolower($foto_name)); // typedata : string
        //         $foto->storeAs(null, $foto_name, ['disk' => 'public']); // memanggil function untuk menaruh file di storage
        //     }
        //     return asset('storage') . '/' . $foto_name; // me return path/to/file.ext
        // }
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
## Laravel Request, Validation and Response  
**Laravel Request**  
* Laravel Request terletak pada path ```app\Http\Controllers\TicketController.php``` dan ```routes\web.php```
 * Pada path ```app\Http\Controllers\TicketController.php```
    ```php  
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
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
    ```  
**Laravel Validation**  
* Laravel Validation terletak pada path ```resource\views\ticket.blade.php```, ```resource\views\hasil.blade.php``` dan ```routes\web.php```
    * Pada path ```resource\views\ticket.blade.php```
    ```php  
    @extends('layouts.loggedin')

    @section('title', 'Ticket Reservation')

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Reservation</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    {{-- Font Style --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    {{-- CSS --}}
    <link rel="stylesheet" href="/css/style.css">
    </head>
    <body style="font-family: Poppins; color:white; background-color: white; padding-top:50px; ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card mt-5">
                        <div class="card-body">
                            <p style="text-align: center"><img src="/img/bromo.jpg" alt="Logo Bromo" width="200px" style="border-radius: 30%; box-shadow: 10px 10px 10px rgb(92, 91, 91);"></p>
                            <h3 class="text-center" style="font-weight: bold; padding-top: 5%;">Ticket Reservation Bromo Adventure 2022</h3>
                            <br/>
                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            <br/>
                             <!-- form hasil -->
                            <form action="/hasil" method="post" enctype="multipart/form-data" style="font-size: 1.2em">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input class="form-control" type="text" name="nama" value="{{ old('nama') }}">
                                </div>
                                <div class="form-group">
                                    <label for="jeniskelamin">Jenis Kelamin (L/P)</label>
                                    <input class="form-control" type="text" name="jeniskelamin" value="{{ old('jeniskelamin') }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat Lengkap</label>
                                    <input class="form-control" type="text" name="alamat" value="{{ old('alamat') }}">
                                </div>
                                <div class="form-group">
                                    <label for="noktp">Nomor KTP</label>
                                    <input class="form-control" type="text" name="noktp" value="{{ old('noktp') }}">
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto KTP</label>
                                    <input type="file" class="form-control-file" id="fotoktp" name="fotoktp" accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1" >Tolong diteliti kembali, lalu dicentang!</label>
                                </div>
                                <div class="form-group" style="text-align: center;">
                                    <input class="btn btn-primary" type="submit" style="font-weight: bold" value="Kirim">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    ```  
    * Pada path ```resource\views\hasil.blade.php```
    ```php  
    @extends('layouts.loggedin')

    @section('title', 'Ticket Reservation')

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Reservation</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    {{-- Font Style --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    {{-- CSS --}}
    <link rel="stylesheet" href="/css/style.css">
    </head>
    <div style="background: #cd4c4c;color: white;" class="col-md-12 pt-2 pb-2">
    <marquee behavior="" direction="left">
        <h6 style="color: white;" class="my-auto">
             <b style="color: white"> Mohon untuk menyimpan bukti Reservation Ticket Bromo 2022 dengan cara mencapture (ScreenShot) ticket </b>
        </h6>
    </marquee>
    </div>
    <body style="font-family: Poppins; color:white; background-color: white; padding-top: 5%; ">
    <div class="container" >
        <div class="row justify-content-center">
                <div class="col-lg-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <p style="text-align: center"><img src="/img/bromo.jpg" alt="Logo Bromo" width="200px" style="border-radius: 30%; box-shadow: 10px 10px 10px rgb(92, 91, 91);"></p>
                        <h3 class="text-center" style="font-weight: bold;">Ticket Reservation Bromo Adventure 2022</h3>
                        <table class="table table-bordered table-striped" style="font-size: 1.2em">
                            <tr>
                                <td style="width:150px">Nama</td>
                                <td>{{ $data->nama }}</td>
                            </tr>
                            <tr>
                                <td style="width:200px">Jenis Kelamin (L/P)</td>
                                <td>{{ $data->jeniskelamin}}</td>
                            </tr>
                            <tr>
                                <td style="width:150px">Alamat Lengkap</td>
                                <td>{{ $data->alamat }}</td>
                            </tr>
                            <tr>
                                <td style="width:150px">Nomor KTP</td>
                                <td>{{ $data->noktp }}</td>
                            </tr>
                                <td style="width:150px">Foto KTP</td>
                                <td><img src="{{ $data->fotoktp }}" alt="" width="200px"></td>
                            </tr>
                        </table>
                        <p style="text-align: center"><a href="/ticket" class="btn btn-primary" style="text-align: center" >Kembali</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    @include('sweetalert::alert')
    </html> 
    ```  
    * Pada path ```routes\web.php```
    ```php  
    Route::get('/ticket', [TicketController::class, 'formulir']);
    Route::post('/hasil', [TicketController::class, 'hasil']);
    ```  
**Laravel Response**  
* Laravel Response terletak pada path ```resource\views\ticket.blade.php``` dan ```resource\views\hasil.blade.php```
    * Pada path ```resource\views\ticket.blade.php```
    ```php
    br/>
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <br/>
     <!-- form hasil -->
    <form action="/hasil" method="post" enctype="multipart/form-data" style="font-size: 1.2em">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input class="form-control" type="text" name="nama" value="{{ old('nama') }}">
        </div>
        <div class="form-group">
            <label for="jeniskelamin">Jenis Kelamin (L/P)</label>
            <input class="form-control" type="text" name="jeniskelamin" value="{{ old('jeniskelamin') }}">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat Lengkap</label>
            <input class="form-control" type="text" name="alamat" value="{{ old('alamat') }}">
        </div>
        <div class="form-group">
            <label for="noktp">Nomor KTP</label>
            <input class="form-control" type="text" name="noktp" value="{{ old('noktp') }}">
        </div>
        <div class="form-group">
            <label for="foto">Foto KTP</label>
            <input type="file" class="form-control-file" id="fotoktp" name="fotoktp" accept="image/png, image/jpg, image/jpeg">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1" >Tolong diteliti kembali, lalu dicentang!</label>
        </div>
        <div class="form-group" style="text-align: center;">
            <input class="btn btn-primary" type="submit" style="font-weight: bold" value="Kirim">
        </div>
    </form>
    ```
    * Pada path ```resource\views\hasil.blade.php```
    ```php  
    @include('sweetalert::alert')
    ```  
## Laravel Model, Eloquent and Query Builder  
**Laravel Model**  
    ```php  
    
    ```  
**Laravel Eloquent**  
    ```php  
    
    ```  
**Laravel Query Builder**  
    ```php  
    
    ```  
## Laravel Authentication and Authorization  
Laravel Authentication and Authorization digunakan untuk menangani user yang ingin login ke akun pada halaman login dan membuat akun baru pada halaman register. </br>
* Implementasi untuk Laravel Authentication terletak pada path ```app\Http\Controllers\Auth```, dimana pada folder Auth terdapat beberapa scripts yang digunakan untuk menangani autentikasi ketika user melakukan login. 
</br>Berikut adalah beberapa script tersebut :
[app\Http\Controllers\Auth](https://github.com/erzajanitra/FP-PBKK/tree/5dc9465e8a896ea3e293fef5d245ccee2ab86ac9/app/Http/Controllers/Auth)
</br><img width="300" alt="image" src="https://user-images.githubusercontent.com/75319371/169542573-3cdb4916-f9c3-451d-bb50-bb540bb21f7d.png">
* Pada ```app\Http\Controllers\AuthController.php``` terdapat fungsi ```authenticate```yang digunakan untuk autentikasi email dan password ketika user melakukan login dan menyimpan session user tersebut. Selain itu, pada fungsi ini juga menggunakan method redirect yang akan mengarahkan user ke halaman dashboard ketika berhasil melakukan login.
    ```php  
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
    ```  
* Pada ```app\Http\Controllers\AuthController.php``` terdapat fungsi ```check```yang digunakan untuk mengecek apakah user sudah melakukan login atau belum. Apabila user sudah login, maka ketika user mengklik button Login user akan diarahkan ke halaman Dashboard. Sedangkan, jika belum melakukan login maka user akan diarahkan ke halaman Login untuk melakukan login.
    ```php  
    public function check()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            return redirect('login');
        }
    }
    ```
* Pada ```app\Http\Controllers\AuthController.php``` terdapat fungsi ```logout```yang digunakan sebagai autentikasi ketika user melakukan logout. Terdapat dua hal yang dilakukan ketika user logout, yaitu invalidate session untuk menghapus session yang digunakan user ketika login dan regenerateToken session untuk generate session baru yang akan digunakan oleh user lain yang akan login. Setelah berhasil logout, user akan diarahkan kembali pada route "/"
    ```php  
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    ```
  
## Laravel Localization and File Storage  
Laravel Localization and File Storage digunakan untuk menyimpan foto pada halaman Ticket Reservations. Pada halaman tersebut, user akan menginput beberapa data yang dibutuhkan untuk pembelian tiket dan mengupload foto KTP. Supaya foto KTP dapat tampil di halaman berikutnya, yaitu halaman bukti pembelian tiket, maka butuh dilakukan penyimpanan foto pada Storage.
* Penyimpanan foto pada storage </br>
  Penyimpanan foto terletak pada path ```app\Http\Controllers\TicketController.php```
    ```php  
    if ($request->hasFile('fotoktp')) {
            $filenameWithExt = $request->file('fotoktp')->getClientOriginalName();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('fotoktp')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('fotoktp')->storeAs('public/images', $fileNameToStore);
        }
    ``` 
 * Menampilkan foto yang telah disimpan pada storage </br>
   Foto yang telah disimpan pada storage akan ditampilkan pada halaman bukti pembelian tiket, dimana halaman tersebut terletak pada ```resource\views\hasil.blade.php```. 
   ```php 
     <tr>
        <td style="width:150px">Foto KTP</td>
        <td><img src="{{ asset('storage/images/'. $data->fotoktp) }}" alt="" width="200px"></td>
     </tr>
   ``` 

## Laravel View and Blade Component  
**Laravel View**  
* Laravel View terletak pada path ```resource\views```
    * Didalam path diatas terdapat beberapa folder yang kami buat, yaitu ```layouts``` dan ada beberapa tambahan otomatis ketika menginstal allert yaitu ```vendor``` dan ketika membuat menu ```login```, yaitu folder ```auth``` dan ```components```.
![views.png](https://drive.google.com/uc?export=view&id=1zLlmvBCnFbHPL7J6__r-OekVdtJOj08J)
**Laravel Blade Component**  
* Laravel Blade terletak pada path ```resource\views```, dimana didalam ```view``` tersebut nama file harus diakhir dengan ```blade.php``` dapat menggunakan templating engine Laravel yaitu ```Blade```. 
    * Pada folder ```auth```
![auth.png](https://drive.google.com/uc?export=view&id=1HA_jbNRPg5sM_iYFp4pJt2Ais8OIW8VP)
    * Pada folder ```components```
![components.png](https://drive.google.com/uc?export=view&id=1ThwaUR1jYQTAunJA4kwm0GUjtHn9fV7p)
    * Pada folder ```layouts```
![layouts.png](https://drive.google.com/uc?export=view&id=1ajiXrPHzuKleMKQN8RqBuohLRUBM2U8D)
    * Pada folder ```vendor```
![vendor.png](https://drive.google.com/uc?export=view&id=1lnvu3VCldiVX4ndabCnho6WCVG-uUJ3r)
## Laravel Session and Caching  
**Laravel Session**  
Implementasi Laravel Session terdapat pada Controller, yaitu ConfirmablePasswordController.php pada folder Auth ``app\Http\Controllers\Auth\ConfirmablePasswordController.php`` dan AuthController.php pada path ```app\Http\Controllers\AuthController.php```
* Pada AuthController.php menggunakan method ``regenerate`` untuk menghapus session yang telah tersimpan dan menggantikannya dengan session yang baru pada fungsi ``authenticate``. 
    ```php  
    if (Auth::guard('web')->attempt($credentials, true)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }
    ```  
    Selain menggunakan session regenerate, dapat juga menggunakan method ``invalidate`` untuk menghapus semua data dalam sebuah session dengan single statement. 
   ```php  
    $request->session()->invalidate();
    ```  
    Method tersebut biasa digunakan untuk menghapus session ketika user melakukan logout, sehingga data yang terdapat pada session dari user tersebut terhapus dan tidak dapat diakses oleh user lain.
* Pada ConfirmablePasswordController.php menggunakan method ``put`` untuk menyimpan input data pada session yang terdapat pada fungsi ``store``. Pada fungsi ini, method ``put``digunakan untuk menyimpan password yang telah diinputkan oleh user sebagai confirmed password sehingga user dapat mengakses akun yang dimiliki. 
    ```php  
    public function store(Request $request)
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(RouteServiceProvider::HOME);
    }
    ```  
**Laravel Caching**  
    ```php  
    
    ```  

## Laravel Unit Testing and Feature Testing  
 
# Optional:
## Laravel Event and Listener
* Implementasi Event and Listener terletak pada path ```app\Providers\EventServiceProvider```. 
    ```php  
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\LogRegisteredUser',
        ],
    
        // 'Illuminate\Auth\Events\Attempting' => [
        //     'App\Listeners\LogAuthenticationAttempt',
        // ],
    
        'Illuminate\Auth\Events\Authenticated' => [
            'App\Listeners\LogAuthenticated',
        ],
    
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
    
        'Illuminate\Auth\Events\Failed' => [
            'App\Listeners\LogFailedLogin',
        ],
    
        'Illuminate\Auth\Events\Validated' => [
            'App\Listeners\LogValidated',
        ],
    
        'Illuminate\Auth\Events\Verified' => [
            'App\Listeners\LogVerified',
        ],
    
        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogSuccessfulLogout',
        ],
    
        'Illuminate\Auth\Events\CurrentDeviceLogout' => [
            'App\Listeners\LogCurrentDeviceLogout',
        ],
    
        'Illuminate\Auth\Events\OtherDeviceLogout' => [
            'App\Listeners\LogOtherDeviceLogout',
        ],
    
        'Illuminate\Auth\Events\Lockout' => [
            'App\Listeners\LogLockout',
        ],
    
        'Illuminate\Auth\Events\PasswordReset' => [
            'App\Listeners\LogPasswordReset',
        ],
    ];
    
    ```  
    Event dan Listener diatas digunakan untuk menangani user login dengan menyimpan log dari event yang sedang terjadi. Event tersebut terdiri dari melakukan register sebagai user, ketika user berhasil ataupun gagal melakukan login, validasi akun, verifikasi akun, logout dari akun, dan reset password. Semua Event tersebut dapat berfungsi jika dilengkapi dengan Listener yang sesuai. 
* Semua Listener tersebut terdapat pada path ```app\Listeners```
  
  <img width="200" alt="event listener" src="https://user-images.githubusercontent.com/75319371/170856227-49100dd6-f58b-4dd5-848d-1d15540ca33c.png">

## Laravel Composer Package  
Pada Laravel Composer Package, kami menggunakan **Laravel Breeze** untuk fitur autentikasi login, registrasi, reset password, verifikasi email, dan konfirmasi password. Composer digunakan untuk menginstall Laravel Breeze Package yang telah memiliki views, routes, controllers, dan hal yang dibutuhkan untuk beberapa fitur yang dimiliki. Berikut adalah tampilan halaman Login dan Register dari penggunaan Laravel Breeze
* Halaman Login
    <img width="909" alt="login" src="https://user-images.githubusercontent.com/75319371/170857549-71f37802-e28f-42bb-a22f-f59160c82ac0.png">

* Halaman Register

    <img width="839" alt="register" src="https://user-images.githubusercontent.com/75319371/170857553-dd1e16d0-b219-45a9-994a-4bff6090b4b6.png">

   
# Rerensi 
* Install Alert: https://realrashid.github.io/sweet-alert/
