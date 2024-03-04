@extends('layouts.auth')

@section('main')

    <div class="row">
        <div class="col-md-6 offset-md-2 p-4" style="background-color: #f8f9fa;">
            <h4 class="text-center">Verify Your Email</h4>
            <div class="mt-10">
                <label for="otp">Enter OTP Code</label>
                <input id="otp" type="text" placeholder="OTP" onfocus="this.placeholder = ''" onblur="this.placeholder = 'OTP'" required="" class="single-input bg-white">
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <button onclick="resendOTP()" class="btn head-btn1 w-100">Resend OTP</button>
                </div>
                <div class="col-md-6">
                    <button onclick="verify()" class="btn head-btn2 w-100">Verify Email</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>

        async function verify() {
            let otp = document.getElementById('otp').value

            if (otp.length !== 6) {
                return alert('OTP must be 6 digits long!')
            }

            showLoader()
            let res = await axios.post("{{ route('verify.email') }}", {
                otp : otp
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                localStorage.clear()

                localStorage.setItem('email', res.data['data']['user']['email'])
                localStorage.setItem('role', res.data['data']['user']['role'])
                localStorage.setItem('verified', res.data['data']['user']['emailVerifiedAt'])
                localStorage.setItem('companyStatus', res.data['data']['companyStatus'])

                window.location.href = "{{ route('login.view') }}"
            } else {
                alert(res.data['message'])
            }
        }

        async function resendOTP() {
            showLoader()
            let res = await axios.get("{{ route('resend.otp') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
