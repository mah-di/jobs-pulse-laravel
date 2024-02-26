<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('home.view') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">JOBS PULSE</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <a href="{{ route('candidate.profile.view') }}">
                    <img class="rounded-circle profileImg" src="" alt="" style="width: 40px; height: 40px;">
                    <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                </a>
            </div>
            <div class="ms-3">
                <a href="{{ route('candidate.profile.view') }}"><h6 class="name mb-0"></h6></a>
                <span id="role"></span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            @if (auth()->user()->role === 'Candidate')
                <a href="{{ route('candidate.dashboard.view') }}" class="nav-item nav-link {{ request()->routeIs('candidate.dashboard.view') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="{{ route('candidate.applications.view') }}" class="nav-item nav-link {{ request()->routeIs('candidate.applications.view') ? 'active' : '' }}"><i class="fa fa-th me-2"></i>Job Applications</a>
                <a href="{{ route('candidate.savedJobs.view') }}" class="nav-item nav-link {{ request()->routeIs('candidate.savedJobs.view') ? 'active' : '' }}"><i class="fa fa-th me-2"></i>Saved Jobs</a>
            @endif

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="button.html" class="dropdown-item">Buttons</a>
                    <a href="typography.html" class="dropdown-item">Typography</a>
                    <a href="element.html" class="dropdown-item">Other Elements</a>
                </div>
            </div>
            <a href="form.html" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
            <a href="table.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
            <a href="chart.html" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="signin.html" class="dropdown-item">Sign In</a>
                    <a href="signup.html" class="dropdown-item">Sign Up</a>
                    <a href="404.html" class="dropdown-item">404 Error</a>
                    <a href="blank.html" class="dropdown-item">Blank Page</a>
                </div>
            </div>
        </div>
    </nav>
</div>
