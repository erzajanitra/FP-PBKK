{{-- CSS --}}
<link rel="stylesheet" href="/css/navbar-reservation.css">
{{-- Font Poppins --}}
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<nav>
    {{-- <img src="img/logo1.png" alt="" width="180px" style="padding-left: 4%; border-radius: 15px 15px 15px 15px"> --}}
    <p class="judul">Bromo Adventure 2022</p>
    <ul>
        <li><a href="/article" class="nav-li">{{__('form.article')}}</a></li>
        <li><a href="/pricelist" class="nav-li">{{__('form.price_list')}}</a></li>
        <li><a href="/ticket" class="nav-li">{{__('form.ticket_reserv')}}</a></li>
        {{-- <li><a href="/logout" class="nav-li">Logout</a></li> --}}
        
        <x-slot name="content">
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{__('form.logout')}}
            </x-dropdown-link>
        
            @php $locale = session()->get('locale'); @endphp
            <li class="nav-item dropdown" style="font-size: 15px em; color:white">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
			@switch($locale)
                        @case('en')
                        <img src="/img/en.png" alt="" width=15% height="auto"> EN
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
                    <a class="dropdown-item" href="/ticket/en"><img src="/img/en.png" alt=""  width=15% height="auto"> EN</a>
                    <a class="dropdown-item" href="/ticket/id"><img src="/img/id.png" alt=""  width=15% height="auto"> ID</a>
                </div>
            </li>
         </ul>

</nav>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
