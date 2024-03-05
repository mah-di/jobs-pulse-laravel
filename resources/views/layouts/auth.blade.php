<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Job board HTML-5 Template </title>
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

		<!-- CSS here -->
            <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

            <style>
                /* Custom CSS for the floating menu */
                .floating-menu {
                  position: fixed;
                  top: 0;
                  left: 50%;
                  width: 100vw;
                  transform: translateX(-50%);
                  background-color: #f8f9fa;
                  padding: 20px;
                  border-radius: 10px;
                }
              </style>

        <script>

            @auth
                localStorage.setItem('email', "{{ auth()->user()->email }}")
                localStorage.setItem('role', "{{ auth()->user()->role }}")
                localStorage.setItem('verified', "{{ auth()->user()->emailVerifiedAt }}")
            @else
                localStorage.clear()
            @endauth

        </script>
   </head>

   <body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
            </div>
        </div>
    </div>

    <div class="floating-menu">
        @include('components.main.navbar')
    </div>

    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="container">

            @yield('main')

        </div>
    </div>

  <!-- JS here -->

		<!-- All JS Custom Plugins Link Here here

		 Jquery, Popper, Bootstrap -->
		<script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


		<!-- Jquery Plugins, main Jquery -->
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>

		<!-- axios -->
        <script src="{{ asset('assets/js/axios.min.js') }}"></script>

		<!-- Custom JS -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        @stack('script')

    </body>
</html>
