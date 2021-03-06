## Anggota Kelompok:
| No | Nama  | NRP |
| ------------- |:-------------:| :-----:|
| 1 | Erza Janitradevi Nadine |   05111940000153 |
| 2 | Florentino Benedictus|   5025201222 |
| 3 | Fian Awamiry Maulana | 5025201035 |
## Link Presentasi : 
   [PPT Kelompok 1](https://docs.google.com/presentation/d/10AeQqswbJhFj1d6m3GbA7mq5ox0L_02L/edit?usp=sharing&ouid=106904049080820792855&rtpof=true&sd=true)
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
    use App\Models\Pricelist;
    use Illuminate\Http\Request;
    use RealRashid\SweetAlert\Facades\Alert;
    use Illuminate\Support\Facades\DB;
    use App\Models\Ticket;


    class TicketController extends Controller
    {
        //
        public function index()
        {
            // get all data from Ticket table
            $data = Pricelist::all();
            return view('ticket', [
                'data' => $data
            ]);
            // $ticket = Ticket::all();
            // return view('ticket');
        }
        public function create()
        {
            $data = Ticket::All();
            // $price = Pricelist::find($data->pricelists_id);
            return view('ticket', [
                'data' => $data,
                // 'price' => $price,
            ]);
        }
        // return view('ticket');


        public function store(Request $request)
        {
            Alert::success('Pesan Terkirim!', 'Terima kasih sudah melakukan Reservation Ticket Bromo Adventure 2022!');
            $validatedData = $request->validate([
                // 'namawisata' => 'required|min:8|max:50',
                // 'harga' => 'required|numeric',
                'nama' => 'required|min:8|max:50',
                'jeniskelamin' => 'required|max:1',
                'noktp' => 'required|numeric',
                'alamat' => 'required|min:8|max:100',
                'notelp' => 'required|numeric',
                'fotoktp' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]);

            if ($request->hasFile('fotoktp')) {
                $validatedData['fotoktp'] = $request->file('fotoktp')->store('public/images');


            }

            $price = Pricelist::where('name', '=', Str::lower($request->namawisata))->first();
            $ticket = new Ticket();
            $ticket->pricelist_id = $price->id;
            $ticket->nama = $request->nama;
            $ticket->jeniskelamin = $request->jeniskelamin;
            $ticket->alamat = $request->alamat;
            $ticket->noktp = $request->noktp;
            $ticket->notelp = $request->notelp;
            $ticket->fotoktp = $validatedData['fotoktp'];
            $ticket->save();
            
            if (Cache::has($price->id)) {
                Cache::increment($price->id);
            }
            else Cache::put($price->id, 1, now()->addHours(6));
            
            return redirect()->route('ticket.show')->with('tambah_data', 'Penambahan Pengguna berhasil');
        }

        public function show()
        {
        $data = Ticket::where('id', $id)->first();
        return view('hasil', [
            'data' => $data,
        ]);
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
## Laravel Request, Validation and Response  
**Laravel Request**  
* Laravel Request terletak pada path ```app\Http\Controllers\TicketController.php``` dan ```routes\web.php```
 * Pada path ```app\Http\Controllers\TicketController.php```
    ```php  
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    public function store(Request $request)
        {
            Alert::success('Pesan Terkirim!', 'Terima kasih sudah melakukan Reservation Ticket Bromo Adventure 2022!');
            $validatedData = $request->validate([
                // 'namawisata' => 'required|min:8|max:50',
                // 'harga' => 'required|numeric',
                'nama' => 'required|min:8|max:50',
                'jeniskelamin' => 'required|max:1',
                'noktp' => 'required|numeric',
                'alamat' => 'required|min:8|max:100',
                'notelp' => 'required|numeric',
                'fotoktp' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]);

            if ($request->hasFile('fotoktp')) {
                $validatedData['fotoktp'] = $request->file('fotoktp')->store('public/images');


            }
            $price = Pricelist::where('name', '=', Str::lower($request->namawisata))->first();
            $ticket = new Ticket();
            $ticket->pricelist_id = $price->id;
            $ticket->nama = $request->nama;
            $ticket->jeniskelamin = $request->jeniskelamin;
            $ticket->alamat = $request->alamat;
            $ticket->noktp = $request->noktp;
            $ticket->notelp = $request->notelp;
            $ticket->fotoktp = $validatedData['fotoktp'];
            $ticket->save();
            
            if (Cache::has($price->id)) {
                Cache::increment($price->id);
            }
            else Cache::put($price->id, 1, now()->addHours(6))

            return redirect()->route('ticket.show')->with('tambah_data', 'Penambahan Pengguna berhasil');
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
        <title>Bromo's | Ticket Reservation</title>

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        {{-- Font Style --}}
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        {{-- CSS --}}
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <div style="background-image: linear-gradient(to left,  #ff6666, #e18080, #cd4c4c); color: white;" class="col-md-12 pt-4 pb-1">
        <marquee behavior="" direction="left">
            <h6 style="color: white;" class="my-auto">
                 <b style="color: white"> Mohon untuk mengisi biodata Ticket Reservation Bromo Adventure 2022 dengan benar dan teliti! </b>
            </h6>
        </marquee>
    </div>
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
                                 <form action="{{ route('ticket.buat-data') }}" method="post" enctype="multipart/form-data" style="font-size: 1.2em">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="namawisata">Pilih Paket Wisata</label>
                                        <input class="form-control" type="text" name="namawisata" value="{{ old('namawisata') }}" list="nama-list">
                                        <datalist id="nama-list">
                                            @foreach ($data as $d)
                                                <option data-value="{{ $d->id }}">{{ $d->name}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="harga">Harga Ticket</label>
                                        <input class="form-control" type="text" name="harga" value="{{ old('harga') }}" list="nama-list-harga">
                                        <datalist id="nama-list-harga">
                                            @foreach ($data as $d)
                                                <option data-value="{{ $d->id }}">{{ $d->price}}</option>
                                            @endforeach
                                        </datalist>
                                    </div> --}}
                                    {{-- <div class="form-group">
                                        <label for="nama">Nama Lengkap</label>
                                        <input class="form-control" type="text" name="nama" value="{{ old('nama') }}" list="nama-list">
                                        <datalist id="nama-list">
                                            @foreach ($data as $d)
                                                <option data-value="{{ $d->id }}">{{ $d->nama }}</option>
                                            @endforeach
                                        </datalist>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap</label>
                                        <input class="form-control" type="text" name="nama" value="{{ old('nama') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="jeniskelamin">Jenis Kelamin (L/P)</label>
                                        <input class="form-control" type="text" name="jeniskelamin" value="{{ old('jeniskelamin') }}" list="jk-list">
                                        <datalist id="jk-list">
                                            @foreach ($data as $d)
                                                <option data-value="{{ $d->id }}">{{ $d->jeniskelamin }}</option>
                                            @endforeach
                                        </datalist>
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
                                        <label for="notelp">Nomor Telepon</label>
                                        <input class="form-control" type="text" name="notelp" value="{{ old('notelp') }}">
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
        <title>Bromo's | Ticket Reservation</title>

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        {{-- Font Style --}}
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        {{-- CSS --}}
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <div style="background-image: linear-gradient(to left, #ff6666, #e18080, #cd4c4c); color: white;" class="col-md-12 pt-1 pb-1">
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
                            <h3 class="text-center" style="font-weight: bold;">Ticket Trip to Bromo Adventure 2022</h3>
                            <table class="table table-bordered table-striped" style="font-size: 1.2em">
                                @foreach ( $data as $data )
                                <tr>
                                    <td style="width:150px">Paket Wisata</td>
                                    <td>{{ $data->name }}</td>
                                </tr>
                                {{-- <tr>
                                    <td style="width:200px">Harga Ticket</td>
                                    <td>{{ $data->harga}}</td>
                                </tr> --}}
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
                                <tr>
                                    <td style="width:150px">Nomor Telepon</td>
                                    <td>{{ $data->notelp }}</td>
                                </tr>
                                <tr>
                                    <td style="width:150px">Foto KTP</td>
                                    <td><img src="{{ asset('storage/'. $data->fotoktp) }}" alt="" width="200px"></td>
                                </tr>
                                @endforeach
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
            <label for="namawisata">Pilih Paket Wisata</label>
            <input class="form-control" type="text" name="namawisata" value="{{ old('namawisata') }}" list="nama-list">
            <datalist id="nama-list">
                @foreach ($data as $d)
                    <option data-value="{{ $d->id }}">{{ $d->name}}</option>
                @endforeach
            </datalist>
        </div>
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
* Laravel model terletak pada path ```app\Models\```  
    * Terdapat beberapa model yang sudah kami buat, yaitu bernama ```Article```, ```Post```,```Pricelist```, dan ```Ticket```.  
![models.png](https://drive.google.com/uc?export=view&id=1myTHxx0tQoC2AkYeesMnR6aygqbMknda)  

**Laravel Eloquent**  
* Terkait Laravel Eloquent, kami telah membuatnya dan terletak pada controller yaitu pada path ```App\Http\Controllers```.  
    * Eloquent pada ```Article Controller```.  
    ```php  
    <?php

    namespace App\Http\Controllers;
    use App\Models\Article;
    use Illuminate\Http\Request;

    class ArticleController extends Controller
    {
        public function index(){
            return view('article', [
                "title" => "Artikel Wisata Bromo",
                "articles" => Article::all()
            ]);
        }

        public function detail(Article $article){
            return view('article-detail', [
                "article" => $article
            ]);
        }
    }
    ```  
    * Eloquent pada ```Post Controller```.  
    ```php  
    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Post;
    use Illuminate\Support\Facades\Gate;

    class PostController extends Controller
    {
        //
        public function index()
        {
            $posts = Post::all();

            return view('post', ['posts' => $posts]); 
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $this->authorize('create', Post::class);

            return view('post-detail', ['msg' => 'User can create post']); 
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            //
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $user = Auth::user();
            $post = Post::find($id);

            // // menggunakan model user
            // if ($user && $user->can('update', $post)) {
            //     return view('post-detail', ['msg' => 'User can edit post']); 
            // }else{
            //     abort(403);
            // }

            // menggunakan response
            $response = Gate::inspect('update', $post);

            if ($response->allowed()) {
                return view('post-detail', ['msg' => 'User can edit post']); 
            } else {
                echo $response->message();
            }
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Post $post)
        {
            return view('post-detail', ['msg' => 'user can delete post']); 
        }

    }
    ```  
    * Eloquent pada ```Pricelist Controller```.  
    ```php  
    <?php

    namespace App\Http\Controllers;
    use App\Models\Pricelist;
    use Illuminate\Http\Request;

    class PricelistController extends Controller
    {
        public function index(){
            return view('pricelist', [
                "pricelists" => Pricelist::all()
            ]);
        }
    }
    ```  
    * Eloquent pada ```Ticket Controller```.  
    ```php  
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    public function store(Request $request)
        {
            Alert::success('Pesan Terkirim!', 'Terima kasih sudah melakukan Reservation Ticket Bromo Adventure 2022!');
            $validatedData = $request->validate([
                // 'namawisata' => 'required|min:8|max:50',
                // 'harga' => 'required|numeric',
                'nama' => 'required|min:8|max:50',
                'jeniskelamin' => 'required|max:1',
                'noktp' => 'required|numeric',
                'alamat' => 'required|min:8|max:100',
                'notelp' => 'required|numeric',
                'fotoktp' => 'required|mimes:png,jpg,jpeg|max:2048',
            ]);

            if ($request->hasFile('fotoktp')) {
                $validatedData['fotoktp'] = $request->file('fotoktp')->store('public/images');


            }
            $price = Pricelist::where('name', '=', Str::lower($request->namawisata))->first();
            $ticket = new Ticket();
            $ticket->pricelist_id = $price->id;
            $ticket->nama = $request->nama;
            $ticket->jeniskelamin = $request->jeniskelamin;
            $ticket->alamat = $request->alamat;
            $ticket->noktp = $request->noktp;
            $ticket->notelp = $request->notelp;
            $ticket->fotoktp = $validatedData['fotoktp'];
            $ticket->save();
            
            if (Cache::has($price->id)) {
                Cache::increment($price->id);
            }
            else Cache::put($price->id, 1, now()->addHours(6))

            return redirect()->route('ticket.show')->with('tambah_data', 'Penambahan Pengguna berhasil');
        }
    ```    
**Laravel Query Builder**  
* Pada Laravel Query Builder terdapat pada beberapa file ```PostController.php``` pada path ```app\Http\PostController.php```.  
    * Menggunakan method ```Post```
    ```php  
     public function index()
    {
        $posts = Post::all();

        return view('post', ['posts' => $posts]); 
    }
    ```  
    * Menggunakan method ```Gate```
    ```php  
    public function edit($id)
    {
        $user = Auth::user();
        $post = Post::find($id);

        // // menggunakan model user
        // if ($user && $user->can('update', $post)) {
        //     return view('post-detail', ['msg' => 'User can edit post']); 
        // }else{
        //     abort(403);
        // }

        // menggunakan response
        $response = Gate::inspect('update', $post);

        if ($response->allowed()) {
            return view('post-detail', ['msg' => 'User can edit post']); 
        } else {
            echo $response->message();
        }
    }
    ```  
* Pada Laravel Query Builder terdapat pada beberapa file ```HomeController.php``` pada path ```app\Http\HomeController.php```.  
    * Menggunakan method ```Gate```
    ```php  
    public function private()
    {
        // 1. allows
        if (Gate::allows('go-to-private')) {
            return view('private');
        }
        return 'You are not admin!';
    }
    ```  
    * Menggunakan method ```Gate```
    ```php  
    public function response()
    {
        $response = Gate::inspect('go-to-response');

        if ($response->allowed()) {
            return view('response', ['msg' => 'custom response']); 
        } else {
            echo $response->message();
        }
    }
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
**Laravel Localization**  
Laravel Localization digunakan untuk mengganti atau menggunakan 2 bahasa atau lebih sesuai dengan yang kita inginkan. Untuk menggunakan laravel localization, kita bisa menggunakan cara sebagai berikut:  
* Menambahkan Controller baru yang bernama ```LocalizationController``` pada path ```app\Http\Controllers\LocalizationController.php```, yang berisikan command sebagai berikut:  
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
    //
    public function index($locale)
    {
        App::setlocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
```  
* Menambahkan Middleware baru yang bernama ```Localization``` pada path ```app\Http\Middleware\Localization.php``` , yang berisikan command sebagai berikut:  
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setlocale(session()->get('locale'));
        }
        return $next($request);
    }
}
```  
* Menambahkan beberapa command sebagai berikut, pada file ```Kernel.php``` pada path ```app\Http\Kernel.php```.  
```php
'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\Localization::class,
        ],
```  
* Menambahkan folder dan file baru pada path ```resource\lang``` yaitu menambahkan folder ```en``` untuk bahasa Inggris dan ```id``` untuk bahasa Indonesia. Selain itu menambahkan file baru yang bernama ```form.php``` pada kedua folder tersebut dimana berisi halaman mana yang mau kita ubah.  
![lang.png](https://drive.google.com/uc?export=view&id=1PuFlLuBQOcbd8WELMSq7TfBzWU4KnWBR)  
* Kita panggil pada view yang telah kita sediakan, seperti contoh pada ```navbar-reservation.blade.php```.  
```php
 @php $locale = session()->get('locale'); @endphp
        <li class="nav-item dropdown" style="font-size: 15px em; color:white">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        @switch($locale)
                    @case('en')
                    <img src="/img/en.png" alt="" width=15% height="auto"> English
                    {{-- <img src="{{asset('/img/en.png')}}">  --}}
                    @break
                    @case('id')
                    <img src="/img/id.png" alt=""  width=15% height="auto"> Indonesia
                    @break
                    @default
                    <img src="/img/en.png" alt=""  width=105% height="auto"> English
                    {{-- <img src="{{asset('/img/en.png')}}"> English --}}
                @endswitch    
                <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/ticket/en"><img src="/img/en.png" alt=""  width=15% height="auto"> English</a>
                <a class="dropdown-item" href="/ticket/id"><img src="/img/id.png" alt=""  width=15% height="auto"> Indonesia</a>
            </div>
        </li>
```  
**Laravel File Storage**  
Laravel Localization and File Storage digunakan untuk menyimpan foto pada halaman Ticket Reservations. Pada halaman tersebut, user akan menginput beberapa data yang dibutuhkan untuk pembelian tiket dan mengupload foto KTP. Supaya foto KTP dapat tampil di halaman berikutnya, yaitu halaman bukti pembelian tiket, maka butuh dilakukan penyimpanan foto pada Storage.
* Untuk melakukan penyimpanan pada Storage, perlu menjalankan command berikut
    ```
    php artisan storage:link
    ```
    dan menambahkan ```FILESYSTEM_DRIVER=public``` pada file `.env`
* Penyimpanan foto pada storage </br>
  Penyimpanan foto terletak pada path ```app\Http\Controllers\TicketController.php```
    ```php  
   if ($request->hasFile('fotoktp')) {
            $validatedData['fotoktp'] = $request->file('fotoktp')->store('public/images');
        }
    ``` 
 * Menampilkan foto yang telah disimpan pada storage </br>
   Foto yang telah disimpan pada storage akan ditampilkan pada halaman bukti pembelian tiket, dimana halaman tersebut terletak pada ```resource\views\hasil.blade.php```. 
   ```php 
     <tr>
        <td style="width:150px">Foto KTP</td>
        <td><img src="{{ asset('storage/'. $data->fotoktp) }}" alt="" width="200px"></td>
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
Laravel Caching digunakan sebagai media menyimpan jumlah tiket yang terakhir dipesan untuk tiap paket pada tabel `pricelist` pada interval waktu tertentu.
* Pembuatan migration cache
Pertama-tama akan dibuat migration pada `/database/migrations/create_cache_table.php` dengan isi tabelnya sebagai berikut<br>
    ```php  
    Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });
    ```  
* Setup Cache Pada Controller
Pada `app/Http/Controllers/TicketController` perlu ditambahkan `use Illuminate\Support\Facades\Cache;` karena akan menggunakan namespace `Cache`. Selanjutnya, pada fungsi `store()` juga akan ditambahkan potongan code sebagai berikut:<br>
    ```php
     // Increment Counter Cache
        if (Cache::has($price->id)) {
			Cache::increment($price->id);
		}
        else Cache::put($price->id, 1, now()->addHours(6));
    ```
 Bagian tersebut berfungsi agar ketika seorang user memesan tiket, maka selain menyimpan data tiket pada database fungsi `store()` juga akan menyimpan counter jumlah tiket yang dipesan pada cache dengan key yaitu id dari masing-masing paket `pricelist` yang ada. Cache akan terhapus secara otomatis setelah 6 jam, karena bertujuan untuk memberi rekomendasi pada user lain mengenai paket manakah yang paling laku baru-baru ini.<br><br>
 
Selanjutnya, pada `app/Http/Controllers/PricelistController` juga akan ditambahkan `use Illuminate\Support\Facades\Cache;` karena nantinya fungsi `index()` pada `PricelistController` akan mengambil data dari cache. Berikut merupakan potongan codenya<br>

```php
      public function index(){

		$pricelists = Pricelist::all();

		foreach($pricelists as $pl){
			$value[] = Cache::get($pl->id, '0');
		}

		return view('pricelist', [
			"pemesan" => $value,
			"pricelists" => $pricelists
		]);
	}
```

Data counter pada cache akan tersimpan pada array `$value`. Jika cache tidak ditemukan menggunakan key id paket (belum ada yang membeli paket tersebut dalam waktu dekat) maka akan diset nilainya 0. Selanjutnya hasil `$value` juga akan dikirimkan ke view `pricelist.blade.php`.
* Menampilkan data cache pada `/resources/views/pricelist.blade.php`
Jumlah pemesanan tiket terakhir akan ditampilkan dibawah harga dari masing-masing tiket dengan menambahkan line jumlah pemesanan terbaru sehingga berikut merupakan perulangan untuk tiap data `pricelist` yang ada:
    ```blade.php
    @foreach($pricelists as $pricelist)
            <div class="col-md-12" style="text-align: center;margin-top: 5%;">
                <details>
                    <summary class="listharga" style="margin-bottom: 1%;">{{ $pricelist->name }}</summary>
                    <div class="content"><h2>{{ $pricelist->description }}</h2>
                    <p class="btn">Rp. {{ $pricelist->price }}</p>
                    <p>Jumlah Pemesan Terbaru: {{ $pemesan[$pricelist->id-1] }}</p>
                </details>
            </div>
    @endforeach
    ```

## Laravel Unit Testing and Feature Testing  
**Laravel Unit Testing**  
* Membuat testing dengan nama file ```.env.testing``` dan membuat unit testing dengan syntax dibawah ini:  
    ```php  
    php artisan make:test Post/PostControllerTest --unit
    ```  
![feature.png](https://drive.google.com/uc?export=view&id=1QlEWYxbs1adnpOLHj7OCx1nTgLvYWAQ9)  

**Laravel Feature Testing**  
* Laravel Feature Testing Terletak pada path: ```test\Feature\PostTest.php```.  
![unit.png](https://drive.google.com/uc?export=view&id=1KsPe57hYu6wdugqIZbo0-TqF39BbUnJr)  
* Mencoba untuk menjalankan file ```test```.  
    ```php
    php artisan test
    ```  
    
![unit2.png](https://drive.google.com/uc?export=view&id=1FSASIr-lA0jaNy2j9KjWUDs5hoN9qEVx)  
* Mencoba untuk menjalankan file ```test```.  
    ```php
    php artisan test --testsuite=Unit
    ```  
    
![unit2.png](https://drive.google.com/uc?export=view&id=1ZxATmdlmR_gn6gzRSSh47jwgxYlspqwo)  
* Mencoba menjalankan file ```test``` pada ```dusk```.  
    ```php  
    php artisan dusk
    ```  
    
![unit3.png](https://drive.google.com/uc?export=view&id=1guLoMmzkBZhcO8GyCd4drNtR-hw4A8J_)  
# Optional:
## Laravel Event and Listener
* Implementasi Event and Listener terletak pada path ```app\Providers\EventServiceProvider```. 
    ```php  
    protected $listen = [
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\LogRegisteredUser',
        ],
    
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
![login.png](https://drive.google.com/uc?export=view&id=1-G8TxQKReNJZhU2NZBXyZGpdyXtCwvZ8)

* Halaman Register
![register.png](https://drive.google.com/uc?export=view&id=15_iZCIfds2fAVGiAKNDf81khAjfhQnC8)

   
# Referensi 
* Install Alert: https://realrashid.github.io/sweet-alert/
* Referensi Laravel Unit Testing and Feature Testing: https://laravel.com/docs/8.x/http-tests#session-and-authentication
### Seeder Artikel
* https://www.yoshiwafa.com/gunung-bromo/
* https://petruswahyu.wordpress.com/2018/11/24/keindahan-gunung-bromo/
* https://travelingyuk.com/liburan-ke-gunung-bromo/300914
* https://travel.detik.com/travel-news/d-5514267/6-fakta-gunung-bromo-destinasi-wisata-hits-di-jawa-timur
* https://www.hipwee.com/narasi/sebuah-perjalanan-ke-gunung-bromo/
* https://www.indonesia.travel/id/id/destinasi/java/taman-nasional-bromo-tengger-semeru
* https://travel.tempo.co/read/1574947/taman-nasional-bromo-tengger-semeru-resmikan-pembukaan-orchidarium-ranu-darungan
* https://foresteract.com/taman-nasional-bromo-tengger-semeru/
* https://travel.detik.com/travel-news/d-5739038/mengenal-zonasi-taman-nasional-bromo-tengger-semeru
* https://rimbakita.com/taman-nasional-bromo-tengger-semeru/

