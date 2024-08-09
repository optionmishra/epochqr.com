<div class="logo-header">
    <nav class="navbar navbar-expand-lg navbar-dark p-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">EQR</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link mx-2  {{ request()->is('/') ? 'active' : '' }}" aria-current="page"
                                href="/">Home</a>
                        </li>

                        @if (request()->is('register'))
                            <li class="nav-item">
                                <a class="nav-link mx-2  {{ request()->is('login') ? 'active' : '' }}" aria-current="page"
                                    href="{{ route('login') }}">Sign in</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link mx-2  {{ request()->is('register') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('register') }}">Sign up</a>
                            </li>
                        @endif
                    @endguest
                    @auth
                        <div class="contactUs ml-5 text-center">
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="las la-user-circle"></i>
                                    <span class="">{{ Auth::user()->name }}</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="las la-sign-out-alt"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

</div>
