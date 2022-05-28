@extends('layouts.main')

@section('title', 'Article')

@section('container')
    {{-- Css --}}
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/article.css">
    {{-- Font Poppins --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    
    <div class="header">
        <h1 style="padding-top: 5%; font-family: Poppins;"><center><b>{{ $title }}</b></center></h1>

        <hr style="height:5px;border-width:0;color:#1CE088;background-color:#1CE088">

        <div class="row mg-t-40" style="font-family: Poppins;">
            @foreach($articles as $article)
                <div class="col-lg-4">
                    <div class="features mg-t-30 text-center">
                        <h3>
                            <a href="/article/{{ $article->slug }}" class="articlename">
                                <div class="mb-0">{{ $article->title }}</div>
                            </a>
                        </h3>
                        <h5>By: <a href="#" class="text-decoration-none" style="color:#01F9C6">{{ $article->user->name }}</a></h6>
                        <p class="mb-0">{{ $article->excerpt }}</p>
                        <a href="/article/{{ $article->slug }}" class="text-decoration-none" style="color:#01F9C6">Read more...</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection