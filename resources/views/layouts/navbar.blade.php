<nav class="navbar navbar-expand-lg bg-white rounded shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-blog"></i>
            Laravel Blog
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/') }}">
                        <i class="fas fa-home"></i>
                        @if(session()->get('lang') === 'fr')
                            Accueil
                        @else
                            Home
                        @endif
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="fas fa-users"></i>
                        @if(session()->get('lang') === 'fr')
                            Compte
                        @else
                            Account
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        @guest
                            <li><a class="dropdown-item" href="{{ route('login') }}"><i class="fas fa-sign-in"></i>
                                    @if(session()->get('lang') === 'fr')
                                        Connexion
                                    @else
                                        Login
                                    @endif
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.login') }}"><i
                                        class="fas fa-sign-in"></i>
                                    @if(session()->get('lang') === 'fr')
                                        Admin
                                    @else
                                        Admin
                                    @endif
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}"><i class="fas fa-user-plus"></i>
                                    @if(session()->get('lang') === 'fr')
                                        Inscription
                                    @else
                                        Register
                                    @endif
                                </a></li>
                        @endguest
                        @auth
                            <li><a class="dropdown-item" href="{{ route('admin.login') }}"><i
                                        class="fas fa-sign-in"></i>
                                    @if(session()->get('lang') === 'fr')
                                        Admin
                                    @else
                                        Admin
                                    @endif
                                </a></li>
                            <li><a class="dropdown-item" href="#"
                                   onclick="document.getElementById('formLogout').submit();"><i
                                        class="fas fa-sign-out"></i>
                                    @if(session()->get('lang') === 'fr')
                                        Déconnexion
                                    @else
                                        Logout
                                    @endif
                                </a></li>
                            <form id="formLogout" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        @endauth
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="fas fa-language"></i> Languages
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('change.lang', 'en') }}">En</a></li>
                        <li><a class="dropdown-item" href="{{ route('change.lang', 'fr') }}">Fr</a></li>
                    </ul>
                </li>
                @auth()
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user"></i>
                            {{ auth()->user()->name }}
                        </a>
                    </li>
                @endauth
                <li class="nav-item">
                    @auth
                        <a class="nav-link" href="{{ route('favorites.index') }}">
                            <i class="fas fa-heart"></i>
                            Favoris
                            <span class="badge bg-danger">{{ auth()->user()->favorites->count() }}</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-heart"></i>
                            Favoris
                            <span class="badge bg-danger">0</span>
                        </a>
                    @endauth
                </li>


            </ul>
        </div>
        <search-component></search-component>
    </div>
</nav>
<search-canvas :placeholder=" @if(session()->get('lang') === 'fr')  'Recherche' @else 'Search' @endif"></search-canvas>
