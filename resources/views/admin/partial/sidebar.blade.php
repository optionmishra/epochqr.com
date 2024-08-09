<aside class="main-sidebar sidebar-dark-primary bg-shadow">
    <!-- Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar fancyScroll bg-white">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- <li class="nav-header mt-2 mb-2">Menu</li> --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard.index') }}"
                        class="nav-link {{ Route::is('admin.dashboard.index') ? 'active' : '' }}">
                        <i class="las la-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="lar la-comment-dots"></i>
                        <span>Projects</span>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('admin.click.index') }}"
                        class="nav-link {{ Route::is('admin.click.index') ? 'active' : '' }}">
                        <i class="las la-chart-pie"></i>
                        <span>Reports</span>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="las la-cog"></i>
                        <span>Settings</span>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ Route::is('admin.users.index') ? 'active' : '' }}">
                        <i class="las la-user"></i>
                        <span>Users</span>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
