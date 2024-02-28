@extends('layouts.auth')

@section('main')

    <div class="row">
        <div class="col text-center">
            <button type="button" class="genric-btn info circle e-large" data-bs-toggle="modal" data-bs-target="#companyModal">Company Login</button>
            <button type="button" class="genric-btn success circle e-large" data-bs-toggle="modal" data-bs-target="#candidateModal">Candidate Login</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal animated zoomIn" id="companyModal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">Company Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-10">
                        <input id="companyEmail" type="email" name="first_name" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required="" class="single-input">
                    </div>
                    <div class="mt-10">
                        <input id="companyPassword" type="password" name="first_name" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required="" class="single-input">
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('send.otp.view') }}" class="text-dark">Forgot your password?</a>
                    </div>
                    <button id="companyLogin" type="button" class="btn head-btn2 mt-2 w-100" onclick="loginCompany()">LogIn</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal animated zoomIn" id="candidateModal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="candidateModalLabel">Candidate Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-10">
                        <input id="candidateEmail" type="email" name="first_name" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required="" class="single-input">
                    </div>
                    <div class="mt-10">
                        <input id="candidatePassword" type="password" name="first_name" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required="" class="single-input">
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('send.otp.view') }}" class="text-dark">Forgot your password?</a>
                    </div>
                    <button id="candidateLogin" type="button" class="btn head-btn2 mt-2 w-100" onclick="loginCandidate()">LogIn</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>

        async function loginCompany() {
            let email = document.getElementById('companyEmail').value
            let password = document.getElementById('companyPassword').value

            if (email.length === 0) {
                return alert("Email is required!")
            }

            if (password.length === 0) {
                return alert("Password is required!")
            }

            showLoader()
            let res = await axios.post("{{ route('company.login') }}", {
                "email" : email,
                "password" : password
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert('success')

                localStorage.clear()

                localStorage.setItem('email', res.data['data']['user']['email'])
                localStorage.setItem('role', res.data['data']['user']['role'])
                localStorage.setItem('verified', res.data['data']['user']['emailVerifiedAt'])
                localStorage.setItem('companyStatus', res.data['data']['companyStatus'])

                window.location.href = "{{ route('company.dashboard.view') }}"
            } else {
                alert(res.data['message'])
            }
        }

        async function loginCandidate() {
            let email = document.getElementById('candidateEmail').value
            let password = document.getElementById('candidatePassword').value

            if (email.length === 0) {
                return alert("Email is required!")
            }

            if (password.length === 0) {
                return alert("Password is required!")
            }

            showLoader()
            let res = await axios.post("{{ route('candidate.login') }}", {
                "email" : email,
                "password" : password
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert('success')

                localStorage.clear()

                localStorage.setItem('email', res.data['data']['email'])
                localStorage.setItem('role', res.data['data']['role'])
                localStorage.setItem('verified', res.data['data']['emailVerifiedAt'])

                window.location.href = "{{ route('candidate.dashboard.view') }}"
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
