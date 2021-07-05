


<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">
                            @if(Auth::check())
                                 {{ Auth::user()->username }}
                                @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                @if(Auth::check())
                                    <a href="{{ url('admin/changePass') }}" class="btn btn-default btn-flat">Đổi mật khẩu</a>
                                @endif
                            </div>
                            <div class="pull-right">
                                @if(Auth::check())
                                    <a href="{{ url('admin/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                @endif
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
