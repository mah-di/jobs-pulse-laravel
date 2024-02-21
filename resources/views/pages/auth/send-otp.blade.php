@extends('layouts.auth')

@section('main')

    <div class="row">
        <div class="col-md-6 offset-md-2 p-4" style="background-color: #f8f9fa;">
            <h4 class="text-center">Request OTP</h4>
            <div class="mt-10">
                <label for="email">Enter Your Email</label>
                <input id="email" type="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required="" class="single-input bg-white">
            </div>
            <button onclick="sendOTP()" class="btn head-btn2 mt-4 w-100">Send OTP</button>
        </div>
    </div>

@endsection

@push('script')

    <script>

        async function sendOTP() {
            let email = document.getElementById('email').value

            if (email.length === 0) {
                return alert('Email is required!')
            }

            showLoader()
            let res = await axios.post("{{ route('send.password.reset.otp') }}", {
                email : email
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                sessionStorage.setItem('email', email)

                alert(res.data['message'])

                window.location.href = "{{ route('verify.otp.view') }}"
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
