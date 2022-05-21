{{-- CSS --}}
<link rel="stylesheet" href="/css/navbarlogin.css">
{{-- Font Poppins --}}
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<nav>
    {{-- <img src="img/logo1.png" alt="" width="180px" style="padding-left: 4%; border-radius: 15px 15px 15px 15px"> --}}
    <p class="judul">Bromo Adventure 2022</p>
    <ul>
        <li><a href="/article" class="nav-li">Article</a></li>
        <li><a href="/pricelist" class="nav-li">Price List</a></li>
        <li><a href="/ticket" class="nav-li">Ticket reservations</a></li>
        {{-- <li><a href="/logout" class="nav-li">Logout</a></li> --}}
        <x-slot name="content">
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
            </x-dropdown-link>
    </ul>
</nav>