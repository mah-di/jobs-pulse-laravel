<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('home.view') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">JOBS PULSE</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <a href="{{ auth()->user()->role === 'Candidate' ? route('candidate.profile.view') : route('profile.view') }}">
                    <img class="rounded-circle profileImg" src="" alt="" style="width: 40px; height: 40px;">
                    <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                </a>
            </div>
            <div class="ms-3">
                <a href="{{ auth()->user()->role === 'Candidate' ? route('candidate.profile.view') : route('profile.view') }}"><h6 class="name mb-0"></h6></a>
                <span id="role"></span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            @if (auth()->user()->role === 'Candidate')
                <a href="{{ route('candidate.dashboard.view') }}" class="nav-item nav-link {{ request()->routeIs('candidate.dashboard.view') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="{{ route('candidate.applications.view') }}" class="nav-item nav-link {{ request()->routeIs('candidate.applications.view') ? 'active' : '' }}"><i class="fa fa-th me-2"></i>Job Applications</a>
                <a href="{{ route('candidate.savedJobs.view') }}" class="nav-item nav-link {{ request()->routeIs('candidate.savedJobs.view') ? 'active' : '' }}"><i class="fa fa-th me-2"></i>Saved Jobs</a>
            @endif

            @if (in_array(auth()->user()->role, ['Admin', 'Manager', 'Editor']))
                <a href="{{ route('company.dashboard.view') }}" class="nav-item nav-link {{ request()->routeIs('candidate.dashboard.view') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="{{ route('company.view') }}" class="nav-item nav-link {{ request()->routeIs('company.view') ? 'active' : '' }}"><i class="fa fa-building me-2"></i>Company</a>
                <a href="{{ route('company.employees.view') }}" class="nav-item nav-link {{ request()->routeIs('company.employees.view') ? 'active' : '' }}"><i class="fa fa-users me-2"></i>Employees</a>
                <a href="{{ route('company.blog.view') }}" id="company-has-blog" class="nav-item nav-link {{ request()->routeIs('company.blog.view') ? 'active' : '' }}"><i class="fa fa-briefcase me-2"></i>Blog</a>
                <a href="{{ route('company.jobs.view') }}" class="nav-item nav-link {{ request()->routeIs('company.jobs.view') ? 'active' : '' }}"><i class="fa fa-briefcase me-2"></i>Jobs</a>
            @endif

            @if (in_array(auth()->user()->role, ['Admin', 'Manager']))
                <a href="{{ route('company.applications.view') }}" class="nav-item nav-link {{ request()->routeIs('company.applications.view') ? 'active' : '' }}"><i class="fa fa-arrow-down me-2"></i>Applications</a>
            @endif

            @if (auth()->user()->role === 'Admin')
                <a href="{{ route('company.plugins.view') }}" class="nav-item nav-link {{ request()->routeIs('company.plugins.view') ? 'active' : '' }}"><i class="fa fa-th me-2"></i>Plugins</a>
            @endif

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="button.html" class="dropdown-item">Buttons</a>
                    <a href="typography.html" class="dropdown-item">Typography</a>
                    <a href="element.html" class="dropdown-item">Other Elements</a>
                </div>
            </div>
        </div>
    </nav>
</div>
