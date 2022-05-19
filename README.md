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
**Laravel validation**  
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
**Laravel response**  
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
