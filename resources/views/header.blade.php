<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>T</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>TENNiSWHIZ</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">

                    <!-- Menu Toggle Button -->
                    @if(auth()->user())
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Welcome,
                        &nbsp;<b>{{ucwords(auth()->user()->name)}}</b>
                    </a>
                    @endif
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{url('/profile')}}">Profile</a>
                        </li>
                        {{-- <li>
                            <a href="{{url('change_password')}}">Change Password</a>
                </li> --}}
                @if(auth()->user()->getType() != 'admin')
                <li>
                    <a href="{{url('feedback')}}">Anonymous Feedback</a>
                </li>
                @endif
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();">
                        Sign out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
            </li>

            </ul>
        </div>
    </nav>
</header>
