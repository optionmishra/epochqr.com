<nav class="topNav main-header-2 navbar navbar-expand navbar-white navbar-light bg-shadow">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="las la-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            @yield('pageTitle')
        </li>
    </ul>

    {{-- <ul class="navbar-nav">
      <li class="nav-item navRequest">
        <a class="nav-link ntop" data-toggle="dropdown" href="#">
          <i class="las la-user-plus mr-1 font-size-13"></i>Pending
          <sup class="supCount">2</sup>
        </a>
      </li>
    </ul> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        {{-- <li class="nav-item navIcon">
            <a class="nav-link ntop" href="#">
                <i class="las la-envelope mx-0"></i>
                <span class="count"></span>
            </a>
        </li> --}}

        <li class="nav-item dropdown navIcon">
            {{-- <a class="nav-link ntop" data-toggle="dropdown" href="#">
                <i class="las la-bell mx-0"></i>
                <span class="count"></span>
            </a> --}}
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                {{-- <a href="#" class="dropdown-item">
                    <i class="ti-user mr-2"></i> Profile
                </a>
                <a href="#" class="dropdown-item">
                    <i class="ti-settings menu-icon mr-2"></i> Settings
                </a> --}}
                <a href="#" class="dropdown-item"><i class="ti-power-off mr-2"></i>Logout</a>
            </div>
        </li>

    </ul>

    <ul class="usernav">

        <li class="nav-item">
            <a class="nav-link d-flex" data-toggle="dropdown" href="#">
                <img class="header-profile-user rounded" src="/tracklead/img/4.png" alt="Header Avatar">
                <div class="caption align-self-center">
                    <h6 class="line-height mb-0">{{ ucfirst(auth()->user()->name) }}</h6>
                    <p class="mb-0">Admin</p>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                {{-- <a href="#" class="dropdown-item">
                    <i class="ti-user mr-2"></i> Profile
                </a>
                <a href="#" class="dropdown-item">
                    <i class="ti-settings menu-icon mr-2"></i> Settings
                </a> --}}
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                    <i class="ti-power-off mr-2"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>

    </ul>
</nav>
