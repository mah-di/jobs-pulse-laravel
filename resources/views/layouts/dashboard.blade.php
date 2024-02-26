<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('assets/dashboard/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dashboard/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('assets/dashboard/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('assets/dashboard/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        @include('components.dashboard.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('components.dashboard.nav')
            <!-- Navbar End -->


            <!-- Blank Start -->
            @yield('content')
            <!-- Blank End -->


            <!-- Footer Start -->
            @include('components.dashboard.footer')
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/dashboard/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- axios -->
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/dashboard/js/main.js') }}"></script>

    <script>

        getCandidateProfile()

        async function getCandidateProfile() {
            showLoader()
            let res = await axios.get("{{ route('candidate.profile.show') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                let names = document.querySelectorAll('.name')
                let profileImgs = document.querySelectorAll('.profileImg')

                names.forEach(name => name.innerText = `${data['firstName']} ${data['lastName']}`)
                profileImgs.forEach(profileImg => profileImg.src = "{{ url('') }}" + '/' + data['profileImg'])

                document.querySelector('#role').innerText = localStorage.getItem('role')
            } else {
                alert(res.data['message'])
            }
        }

    </script>

    @stack('script')

</body>

</html>
