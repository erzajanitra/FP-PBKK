{{-- CSS --}}
<link rel="stylesheet" href="/css/navbar.css">
{{-- Font Poppins --}}
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<nav>
    {{-- <img src="img/logo1.png" alt="" width="200px" style="padding-left: 4%"> --}}
    <p class="judul">Bromo Adventure 2022</p>
    <ul>
        <li><a href="/article" class="nav-li">Article</a></li>
        <li><a href="/login" class="nav-li">Login</a></li>
        <li><a href="/aboutus" class="nav-li">About Us</a></li>
        <li><a href="/timeline" class="nav-li">Timeline</a></li>
        @php $locale = session()->get('locale'); @endphp
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                @switch($locale)
                    @case('en')
                    <img src="/img/en.png" alt="" width=25% height="auto"> EN
                    {{-- <img src="{{asset('/img/en.png')}}">  --}}
                    @break
                    @case('id')
                    <img src="/img/id.png" alt=""  width=15% height="auto"> ID
                    @break
                    @default
                    <img src="/img/en.png" alt=""  width=15% height="auto"> EN
                    {{-- <img src="{{asset('/img/en.png')}}"> EN --}}
                @endswitch    
                <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/article/en"><img src="/img/en.png" alt=""  width=15% height="auto"> EN</a>
                <a class="dropdown-item" href="/article/id"><img src="/img/id.png" alt=""  width=15% height="auto"> ID</a>
            </div>
        </li>
    </ul>
</nav>