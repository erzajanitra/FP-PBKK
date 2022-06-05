<nav class="navbar navbar-expand-lg navbar-dark bg-dark container">
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ml-auto">
                    @php $locale = session()->get('locale'); @endphp
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
			@switch($locale)
                                @case('en')
                                <img src="/img/en.png" alt=""> English
                                {{-- <img src="{{asset('/img/en.png')}}">  --}}
                                @break
                                @case('id')
                                <img src="/img/id.png" alt=""> Indonesia
                                @break
                                @default
                                <img src="/img/en.png" alt=""> English
                                {{-- <img src="{{asset('/img/en.png')}}"> English --}}
                            @endswitch    
                            <span class="caret"></span>
                        </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/form/en"><img src="/img/en.png"> English</a>
                        <a class="dropdown-item" href="/form/id"><img src="/img/id.png"> Indonesia</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>