<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">

    <ul class="navbar-nav navbar-right">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        <div class="d-none d-md-block text-center flex-grow-1">
            <h4 class="nav-link mb-0">Divisional Secretariat - {{ getSettingInfo('site_office_name') }}</h4>
        </div>
    </ul>

    <ul class="navbar-nav navbar-right ml-auto">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img src="{{ asset('admin/assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{ auth()->guard('admin')->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <a href="{{ route('admin.profile.index') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>

                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf

                    <a href="#"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </form>


            </div>
        </li>
    </ul>
</nav>
