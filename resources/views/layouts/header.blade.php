

<nav id="header" class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">AXIE</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @guest
                @else
                    <li class="nav-item"><a class="{{ (request()->is('/')) ? 'active' : '' }}" href="{{ url("/") }}">Trang chủ</a></li>
                    <li class="nav-item"><a class="{{ (request()->is('earnedPerDay')) ? 'active' : '' }}" href="{{ url("earnedPerDay") }}">Thống kê SLP hằng ngày</a></li>
                    <li class="nav-item"><a class="{{ (request()->is('staff')) ? 'active' : '' }}" href="{{ url("staff") }}">Quản lý người chơi</a></li>
                    <li class="nav-item"><a  class="{{ (request()->is('account')) ? 'active' : '' }}" href="{{ url("account") }}">Quản lý tài khoản</a></li>
                    <li class="nav-item"><a class="{{ (request()->is('buy_package/add')) ? 'active' : '' }}" href="{{ url("buy_package/add") }}">Mua gói sử dụng</a></li>
                    <li class="nav-item"><a  class="{{ (request()->is('buy_package')) ? 'active' : '' }}" href="{{ url("buy_package") }}">QL gói </a></li>

                @endguest
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else


                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>  <a class="dropdown-item" href="{{ url('userInfo')  }}">
                                    User Info
                                </a></li>
                            <li>
                                <a class="dropdown-item" href="{{ url('logout1')  }}">
                                    Logout
                                </a>
                            </li>
                        </ul>

                    </li>
                @endguest
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<slider id="slider">
    <img style="height: 100%; width: 100%;" class="backgound" src="{{ asset('public/css/images/headers.png') }}">
</slider>