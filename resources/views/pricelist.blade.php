@extends('layouts.main')

@section('title', 'Price List')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{-- Css --}}
    <link rel="stylesheet" href="/css/pricelist.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    {{-- Font Poppins --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<body>
    <div class="container" style="font-family: Poppins;">
		<div class="row" style="line-height: 1.2; style="text-align: center;">
            <div class="pricetitle col-md-12">
                Price List
            </div>
            @foreach($pricelists as $pricelist)
            <div class="col-md-12" style="text-align: center;margin-top: 5%;">
                <details>
                    <summary class="listharga" style="margin-bottom: 1%;">{{ $pricelist->name }}</summary>
                    <div class="content"><h2>{{ $pricelist->description }}</h2>
                    <p class="price">Rp. {{ $pricelist->price }}</p>
                </details>
            </div>
            @endforeach
        </div>
    </div>
</body>
