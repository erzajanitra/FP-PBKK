@extends('layouts.main')

@section('title', 'Article')

@section('container')
    {{-- Css --}}
    <link rel="stylesheet" href="/css/style.css">
    {{-- Font Poppins --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <div class="header">
        <h1 style="padding-top: 5%; font-family: Poppins;">{{ $article->title }}</h1>

        <hr style="height:5px;border-width:0;color:#1CE088;background-color:#1CE088">
        
        <h5>By: <a href="#" class="text-decoration-none" style="color:#01F9C6">{{ $article->user->name }}</a></h6>

        <article class="mb-5">
            <p>{!! $article->body !!}</p>
        </article>

        <h5><a href="/article" style="color:#01F9C6">Back to Articles</a></h6>
        
    </div>
@endsection