@extends('layouts.main')

@section('title', 'About Us')

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
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    {{-- Font Poppins --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>
<body>
    <div class="container" style="font-family: Poppins;">
        <div class="Team">
            <div class="row" style="line-height: 1.2; text-align: center; padding-top:2%;">
                <div class="member col-md-12">
                    <div style="background-color:white; color:black;" class="col-md-12 pb-3">
                        <marquee behavior="" direction="left">
                            <h6 class="my-auto">
                                 <b> Terima kasih banyak Pak Agus Budi Raharjo atas ilmunya selama ini pada mata kuliah Pemrograman Berbasis Kerangka Kerja (B), semoga ilmu yang bapak berikan berkah bagi kami semua. </b>
                            </h6>
                        </marquee>
                    </div>
                    Apa itu Bromo Adventure 2022?
                </div>
                <div class="col-md-12" style="text-align: center; padding-top:2%" >
                    <p class="pesan">Bromo Adventure menyediakan akses bagi masyarakat untuk menemukan dan memesan berbagai layanan transportasi, akomodasi, aktivitas selama berwisata di Bromo. Sebagai penyedia layanan wisata nomor satu di Bromo, Bromo Adventure memiliki portofolio produk yang lengkap meliputi layanan transportasi serperti sewa mobil jeep dan antar jemput ke destinasi wisata. Bromo Adventure menawarkan bantuan untuk pembelian tiket masuk ke kawasan wisata Puncak Bromo, baik secara online dan offline.</p>
                </div>
                <div class="member col-md-12">
                    Dibalik layar website Bromo Adventure 2022
                </div>
                <div class="col-md-12" style="text-align: center" >
                    <img src="img/Erza.png" alt="" width="200px" style="margin-top: 3%;">
                    <p class="name">Erza Janitradevi Nadine</p>
                    <p class="nrp">05111940000153</p>
                    <p class="pesan"><b> Pesan & Kesan: </b> Terima kasih banyak Pak Agus Budi Raharjo atas ilmunya selama satu semester di kelas PBKK. Saya mendapatkan banyak pengetahuan tentang Laravel karena kelas Pak Agus Budi yang asik sehingga bisa saya pahami dengan baik. Terima kasih juga kepada Fitrah !!</p>
                    <a href="https://www.linkedin.com/in/erzajanitradevi/" target="_blank"><i class="linkedin fab fa-linkedin-in"></i></a>
                    <a href="https://github.com/erzajanitra" target="_blank"<i class="github fab fa-github"</i></a>
                    <a href="https://www.instagram.com/erzajanitradevi/" target="_blank" <i class="instagram fab fa-instagram"></i></a>
                </div>
                <div class="col-md-12" style="text-align: center" >
                    <img src="img/Fian.png" alt="" width="200px"style="margin-top: 3%;">
                    <p class="name">Fian Awamiry Maulana</p> 
                    <p class="nrp">5025201035</p>
                    <p class="pesan"><b> Pesan & Kesan: </b> Terima kasih banyak Pak Agus Budi Raharjo atas ilmunya selama satu semester dalam mata kuliah Pemrograman Berbasis Kerangka Kerja. Disini, saya mendapatkan banyak ilmu-ilmu baru yang saya pelajari pada saat mengikuti kelas, serta mendapatkan pengalaman baru yang belum pernah saya lakukan. Selain itu, terima kasih kepada Mas Fitrah atas ilmunya pada saat dikelas maupun diluar kelas tentang materi Laravel 8 dan 9.</p>
                    <a href="https://www.linkedin.com/in/fianawamirymaulana/" target="_blank"><i class="linkedin fab fa-linkedin-in"></i></a>
                    <a href="https://github.com/florentinobenedictus" target="_blank"<i class="github fab fa-github"</i></a>
                    <a href="https://www.instagram.com/afanfiann/" target="_blank" <i class="instagram fab fa-instagram"></i></a>
                </div>
                <div class="col-md-12" style="text-align: center" >
                    <img src="img/Florentino.png" alt="" width="200px" style="margin-top: 3%;">
                    <p class="name">Florentino Benedictus</p>
                    <p class="nrp"> 5025201222</p>
                    <p class="pesan"> <b> Pesan & Kesan: </b> Terima kasih banyak Pak Agus Budi Raharjo atas ilmunya selama satu semester ini pada mata kuliah PBKK B. Saya mendapat banyak ilmu mengenai Laravel karena materi diberikan menyeluruh baik secara teori maupun <i>hands-on</i>. Terima kasih juga Mas Fitrah yang sudah memberikan tutorial dan menambah <i>insight</i> baru mengenai implementasi Laravel.</p>
                    <a href="https://www.linkedin.com/in/florentino-benedictus-b35405220/" target="_blank"><i class="linkedin fab fa-linkedin-in"></i></a>
                    <a href="https://github.com/florentinobenedictus" target="_blank"<i class="github fab fa-github"</i></a>
                    <a href="https://www.instagram.com/flor_1006/" target="_blank" <i class="instagram fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>
