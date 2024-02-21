@extends('layouts.auth')

@section('main')

    <div class="row">
        <div class="col-md-6 offset-md-2 p-4" style="background-color: #f8f9fa;">
            <h4 class="text-center">Super User Login</h4>
            <div class="mt-10">
                <label for="email">Email</label>
                <input id="email" type="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required="" class="single-input bg-white">
                <label for="password">Password</label>
                <input id="password" type="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required="" class="single-input bg-white">
            </div>
            <button onclick="login()" class="btn head-btn2 mt-4 w-100">Verify OTP</button>
        </div>
    </div>

@endsection

@push('script')

    <script>

        async function login() {
            let email = document.getElementById('email').value
            let password = document.getElementById('password').value

            if (email.length === 0) {
                return alert('Email is required!')
            }
            if (password.length === 0) {
                return alert('Password is required!')
            }

            showLoader()
            let res = await axios.post("{{ route('superUser.login') }}", {
                email : email,
                password : password
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                localStorage.clear()

                localStorage.setItem('email', res.data['data']['email'])
                localStorage.setItem('role', res.data['data']['role'])
                localStorage.setItem('verified', res.data['data']['emailVerifiedAt'])

                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
