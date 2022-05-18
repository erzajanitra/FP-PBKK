{{-- CSS --}}
<link rel="stylesheet" href="/css/navbarlogin.css">
{{-- Font Poppins --}}
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<nav>
    <ul>
        <li><a href="/article" class="nav-li">Article</a></li>
        <li><a href="/pricelist" class="nav-li">Price List</a></li>
        <li><a href="/aboutus" class="nav-li">About Us</a></li>
        {{-- <li><a href="/" class="nav-li">Logout</a></li> --}}
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