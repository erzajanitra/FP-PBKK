@extends('layouts.main')

@section('title', 'Article')

@section('container')
    {{-- Css --}}
    <link rel="stylesheet" href="/css/style.css">
    {{-- Font Poppins --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <div class="header">
        <h1 style="padding-top: 5%; font-family: Poppins;"><center><b>{{ $title }}</b></center></h1>

        <hr style="height:5px;border-width:0;color:#1CE088;background-color:#1CE088">

        @foreach($articles as $article)
            <article class="mb-5 border-bottom pb-3;">
                <h3>
                    <a href="/article/{{ $article->slug }}" class="text-decoration-none" style="color:#000000">
                    {{ $article->title }}
                    </a>
                </h3>
                <h5>By: <a href="#" class="text-decoration-none" style="color:#01F9C6">{{ $article->user->name }}</a></h6>
                <p>{{ $article->excerpt }}</p>
                <a href="/article/{{ $article->slug }}" class="text-decoration-none" style="color:#01F9C6">Read more...</a>
            </article>
        @endforeach
    </div>
@endsection