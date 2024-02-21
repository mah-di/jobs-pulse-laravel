@extends('layouts.auth')

@section('main')

    <div class="row">
        <div class="col-md-6 offset-md-2 p-4" style="background-color: #f8f9fa;">
            <h4 class="text-center">Verify OTP</h4>
            <div class="mt-10">
                <label for="otp">Enter OTP Code</label>
                <input id="otp" type="text" placeholder="OTP" onfocus="this.placeholder = ''" onblur="this.placeholder = 'OTP'" required="" class="single-input bg-white">
            </div>
            <button onclick="verifyOTP()" class="btn head-btn2 mt-4 w-100">Verify OTP</button>
        </div>
    </div>

@endsection

@push('script')

    <script>

        async function verifyOTP() {
            let otp = document.getElementById('otp').value
            let email = sessionStorage.getItem('email')

            if (otp.length !== 6) {
                return alert('OTP must be 6 digits long!')
            }

            showLoader()
            let res = await axios.post("{{ route('verify.password.reset.otp') }}", {
                email : email,
                otp : otp
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                sessionStorage.clear()

                window.location.href = "{{ route('password.reset.view') }}"
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
