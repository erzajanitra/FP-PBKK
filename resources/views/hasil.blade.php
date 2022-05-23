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
                                <td><img src="{{ $data->fotoktp }}" alt="" width="200px"></td>
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