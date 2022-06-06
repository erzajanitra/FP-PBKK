@extends('layouts.loginarticle')

@section('title', 'Article')

{{-- @section('container') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bromo's | Ticket Reservation</title>

    <!-- bootstrap -->
    
    {{-- Css --}}
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/article.css">
    {{-- Font Poppins --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>

<body style="font-family: Poppins; color:black; background-color: white; padding-top: 5%; ">
    <div class="container" >
    <div class="header">
        <h1 style="padding-top: 5%; font-family: Poppins;"><center><b> {{__('message.title_artikel')}}</b></center></h1>
        {{-- <h3 class="text-center" style="font-weight: bold; padding-top: 5%;"> {{__('message.title')}}</h3> --}}

        <hr style="height:5px;border-width:0;color:black;background-color:#1CE088">

        <div class="row mg-t-40" style="font-family: Poppins;">
            @foreach($articles as $article)
                <div class="col-lg-4">
                    <div class="features mg-t-30 text-center">
                        <h3>
                            <a href="/article/{{ $article->slug }}" class="articlename">
                                <div class="mb-0">{{ $article->title }}</div>
                            </a>
                        </h3>
                        <h5>By: <a href="#" class="by text-decoration-none" style="color:white; font-weight:bold;">{{ $article->user->name }}</a></h6>
                        <p class="mb-0">{{ $article->excerpt }}</p>
                        <a href="/article/{{ $article->slug }}" class="read text-decoration-none" style="color:black; font-weight:bold;">Read more...</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
{{-- @endsection --}}