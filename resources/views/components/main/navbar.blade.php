<header>
    <!-- Header Start -->
   <div class="header-area header-transparrent">
       <div class="headder-top header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-2">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="{{ route('home.view') }}"><h2>JOBS PULSE</h2></a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <div class="menu-wrapper">
                            <!-- Main-menu -->
                            <div class="main-menu">
                                <nav class="d-none d-lg-block">
                                    <ul id="navigation">
                                        <li><a href="{{ route('home.view') }}">Home</a></li>
                                        @auth
                                            @if (auth()->user()->role === 'Candidate')
                                            <li><a href="{{ route('candidate.dashboard.view') }}">Dashboard</a></li>
                                            @elseif (auth()->user()->isSuperUser)
                                            <li><a href="{{ route('admin.dashboard.view') }}">Dashboard</a></li>
                                            @else
                                            <li><a href="{{ route('company.dashboard.view') }}">Dashboard</a></li>
                                            @endif
                                        @endauth
                                        <li><a href="{{ route('jobs.view') }}">Job Listing</a></li>
                                        <li><a href="{{ route('blogs.view') }}">Blogs</a></li>
                                        <li><a href="{{ route('about.view') }}">About</a></li>
                                        <li><a href="{{ route('contact.view') }}">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Header-btn -->
                            <div class="header-btn d-none f-right d-lg-block">

                                @if (!request()->routeIs('verify.view') and !request()->routeIs('verify.otp.view') and !request()->routeIs('password.reset.view'))
                                    @auth
                                        <a href="{{ route('logout') }}" class="btn head-btn1">LogOut</a>
                                    @else
                                        <a href="{{ route('signup.view') }}" class="btn head-btn1">Register</a>
                                        <a href="{{ route('login.view') }}" class="btn head-btn2">Login</a>
                                    @endauth
                                @endif

                            </div>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
       </div>
   </div>
    <!-- Header End -->
</header>
