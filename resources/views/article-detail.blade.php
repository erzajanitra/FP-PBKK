@extends('layouts.main')

@section('title', 'Article')

@section('container')
    {{-- Css --}}
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/article.css">
    {{-- Font Poppins --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <div class="header">
        <h1 style="padding-top: 5%; font-family: Poppins;text-align: center;">{{ $article->title }}</h1>

        <hr style="height:5px;border-width:0;color:#1CE088;background-color:#1CE088">
        
        <h5 style="text-align: center;">By: <a href="#" class="text-decoration-none" style="color:#01F9C6">{{ $article->user->name }}</a></h5>

        <article class="mb-5">
            <p align="justify">{!! $article->body !!}</p>
        </article>

        <h5 style="text-align: center;"><a href="/article" class="btn">Back to Articles</a></h5>
        
    </div>
@endsection
