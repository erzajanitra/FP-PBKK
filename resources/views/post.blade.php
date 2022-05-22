{{-- @extends('layouts.navbar') --}}

@section('title', 'Post')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post by Admin</title>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    {{-- Font Style --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    {{-- CSS --}}
    <link rel="stylesheet" href="/css/style.css">
</head>
<div class="container" >
    <div class="row justify-content-center p-6">
        <div class="col-md-8 p-6">
            <h2 class="center">User Action Log</h2>
            <a href="{{ url('post/create') }}" >Create</a>
            <table style="width:100%">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>User ID</th>
                  <th>Action</th>
                </tr>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->name }}</td>
                    <td>{{ $post->user_id }}</td>
                    <td> <a href="{{ url('post/edit/'.$post->id) }}">Edit</a> <a href="{{ url('post/delete/'.$post->id) }}">Delete</a></td> 
                </tr>
                @endforeach
            </table>
            <br> <a href="{{ url('/') }}">Back</a>
        </div>
    </div>
</div>
{{-- @endsection --}}