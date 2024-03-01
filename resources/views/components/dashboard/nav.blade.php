<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>

    @if (auth()->user()->role === 'Candidate')
    <a class="ms-4" href="{{ route('jobs.view') }}">Find Jobs</a>
    @endif

    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2 profileImg" src="" alt="" style="width: 40px; height: 40px;">
                <span class="name d-none d-lg-inline-flex"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="{{ auth()->user()->role === 'Candidate' ? route('candidate.profile.view') : (auth()->user()->isSuperUser ? route('admin.profile.view') : route('profile.view')) }}" class="dropdown-item">My Profile</a>
                <a href="{{ route('logout') }}" class="dropdown-item">Log Out</a>
            </div>
        </div>
    </div>
</nav>
