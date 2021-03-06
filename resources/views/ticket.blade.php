@extends('layouts.loginreservation')

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
<div style="background-image: linear-gradient(to right, #00ffed, #00b8ba); color: white;" class="col-md-12 pt-4 pb-1">
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
                            <h3 class="text-center" style="font-weight: bold; padding-top: 5%;"> {{__('form.title')}}</h3>
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
                                    <label for="namawisata">{{__('form.profile.paketwisata')}}</label>
                                    <input class="form-control" type="text" name="namawisata" value="{{ old('namawisata') }}" list="nama-list">
                                    <datalist id="nama-list">
                                        @foreach ($data as $d)
                                            <option data-value="{{ $d->id }}">{{ $d->name}}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group">
                                    <label for="nama">{{__('form.profile.name')}}</label>
                                    <input class="form-control" type="text" name="nama" value="{{ old('nama') }}">
                                </div>
                                <div class="form-group">
                                    <label for="jeniskelamin">{{__('form.profile.jeniskelamin')}}</label>
                                    <input class="form-control" type="text" name="jeniskelamin" value="{{ old('jeniskelamin') }}" list="jk-list">
                                    <datalist id="jk-list">
                                        @foreach ($data as $d)
                                            <option data-value="{{ $d->id }}">{{ $d->jeniskelamin }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">{{__('form.profile.address')}}</label>
                                    <input class="form-control" type="text" name="alamat" value="{{ old('alamat') }}">
                                </div>
                                <div class="form-group">
                                    <label for="noktp">{{__('form.profile.noktp')}}</label>
                                    <input class="form-control" type="text" name="noktp" value="{{ old('noktp') }}">
                                </div>
                                <div class="form-group">
                                    <label for="notelp">{{__('form.profile.notelp')}}</label>
                                    <input class="form-control" type="text" name="notelp" value="{{ old('notelp') }}">
                                </div>
                                <div class="form-group">
                                    <label for="foto">{{__('form.profile.fotoktp')}}</label>
                                    <input type="file" class="form-control-file" id="fotoktp" name="fotoktp" accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1" >{{__('form.thank')}}</label>
                                </div>
                                <div class="form-group" style="text-align: center;">
                                    <input class="btn btn-primary" type="submit" style="font-weight: bold" value="Send">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>