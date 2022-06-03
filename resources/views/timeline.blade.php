@extends('layouts.main')

@section('title', 'Timeline')

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
    <link rel="stylesheet" href="/css/timeline.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    {{-- Font Poppins --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>

<body>
    <div class="container" style="font-family: Poppins;">
        <div class="timeline">
            {{-- <div class="container right">
                <div class="content">
                    <h2>28 Mei 2022</h2>
                    <p>Untuk penggunaan <b>required</b> sudah menggunakan Laravel route, controller and middleware, Laravel request, validation and response, Laravel model, eloquent and query builder, Laravel authentication and authorization, Laravel localization and file storage, Laravel view and blade component, Laravel session and caching, Laravel feature testing and unit testing. Selanjutnya untuk penggunaan <b>optional</b> sudah menggunakan Laravel event and listener dan Laravel composer package.</p>
                </div>
            </div> --}}
            <div class="container right">
                <div class="content">
                    <h2>19 Mei 2022 - 30 Juni 2022</h2>
                    <p>Add & update readme <b>Required</b> & <b>Optional</b>.</p>
                </div>
            </div>
            <div class="left">
                <div class="content">
                    <h2>02 Juni 2022</h2>
                    <p>Fixed Future Testing Dusk</b>.</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h2>03 Juni 2022</h2>
                    <p>Fixed database Ticket Reseveration</b>.</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h2>19 Mei 2022 - 30 Juni 2022</h2>
                    <p>Untuk penggunaan <b>required</b> sudah menggunakan Laravel route, controller and middleware, Laravel request, validation and response, Laravel model, eloquent and query builder, Laravel authentication and authorization, Laravel localization and file storage, Laravel view and blade component, Laravel session and caching, dan Laravel Unit Testing and Feature Testing. Selanjutnya untuk penggunaan <b>optional</b> sudah menggunakan Laravel event and listener dan Laravel composer package.
                    </p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h2>25 Mei 2022</h2>
                    <p>Add menu Time Line & Price List.</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h2>24 Mei 2022</h2>
                    <p>Untuk penggunaan <b>required</b> sudah menggunakan Laravel route, controller and middleware, Laravel request, validation and response, Laravel model, eloquent and query builder, Laravel authentication and authorization, Laravel localization and file storage, Laravel view and blade component, Laravel session and caching. Selanjutnya untuk penggunaan <b>optional</b> sudah menggunakan Laravel event and listener dan Laravel composer package.
                    </p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h2>24 Mei 2022</h2>
                    <p>Update about us, add article, add factory.</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h2>23 Mei 2022</h2>
                    <p>Update menu ticket reservations-dropdown.</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h2>20 Mei 2022</h2>
                    <p>Update view ticket, view hasil &  add runing text.</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h2>19 Mei 2022</h2>
                    <p>Add menu Ticket Reseveration & Install Alert.</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h2>18 Mei 2022</h2>
                    <p>Add menu Login, menu Dashboard, & menu Logout.</p>
                </div>
            </div>
            <div class="container left">
                <div class="content">
                    <h2>17 Mei 2022</h2>
                    <p>Add menu About Us.</p>
                </div>
            </div>
            <div class="container right">
                <div class="content">
                    <h2>14 Mei 2022</h2>
                    <p>Brainstorming ide: Website Bromo Adventure 2022.</p>
                </div>
            </div>
        </div>
    </div>
</body>
