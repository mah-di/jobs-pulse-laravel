@extends('layouts.auth')

@section('main')

    <div class="row">
        <div class="col-md-6 offset-md-2 p-4" style="background-color: #f8f9fa;">
            <h4 class="text-center">Reset Password</h4>
            <div class="mt-10">
                <label for="password">Enter New Password</label>
                <input id="password" type="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required="" class="single-input bg-white">
            </div>
            <div class="mt-10">
                <label for="cpassword">Confirm Password</label>
                <input id="cpassword" type="password" placeholder="Confirm Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'" required="" class="single-input bg-white">
            </div>
            <button onclick="resetPassword()" class="btn head-btn2 mt-4 w-100">Reset Password</button>
        </div>
    </div>

@endsection

@push('script')

    <script>

        async function resetPassword() {
            let password = document.getElementById('password').value
            let cpassword = document.getElementById('cpassword').value

            if (password.length === 0) {
                return alert('Password is requierd!')
            }
            if (password !== cpassword) {
                return alert("Passwords don't match!")
            }

            showLoader()
            let res = await axios.post("{{ route('password.reset') }}", {
                password : password
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                window.location.href = "{{ route('login.view') }}"
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
