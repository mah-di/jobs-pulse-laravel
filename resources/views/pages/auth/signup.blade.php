@extends('layouts.auth')

@section('main')

    <div class="row">
        <div class="col text-center">
            <button class="genric-btn info circle e-large" data-bs-toggle="modal" data-bs-target="#companyModal">Company Registration</button>
            <button class="genric-btn success circle e-large" data-bs-toggle="modal" data-bs-target="#candidateModal">Candidate Registration</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal animated zoomIn" id="companyModal" tabindex="-1" aria-labelledby="companyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">Company Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Company Info</h4>
                            <div class="mt-10">
                                <label for="comName">Company Name *</label>
                                <input id="comName" type="text" name="first_name" placeholder="Company Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Company Name'" required="" value="abc" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="comLogo">Company Logo *</label>
                                <input id="comLogo" type="file" name="first_name" placeholder="Company Logo" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Company Logo'" required="" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="comDescription">Company Description *</label>
                                <textarea id="comDescription" type="text" name="first_name" placeholder="Company Description" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Company Description'" required="" value="abc" class="single-input" rows="10"></textarea>
                            </div>
                            <div class="mt-10">
                                <label for="comAddress">Company Address *</label>
                                <textarea id="comAddress" type="text" name="first_name" placeholder="Company Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Company Address'" required="" value="abc" class="single-input" rows="3"></textarea>
                            </div>
                            <div class="mt-10">
                                <label for="comContact">Company Contact *</label>
                                <input id="comContact" type="text" name="first_name" placeholder="Company Contact" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Company Contact'" required="" value="abc" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="comEmail">Company Email *</label>
                                <input id="comEmail" type="email" name="first_name" placeholder="Company Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Company Email'" required="" value="abc" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="comWebsite">Company Website</label>
                                <input id="comWebsite" type="text" name="first_name" placeholder="Company Website" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Company Website'" required="" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="comEstablishDate">Establish Date *</label>
                                <input id="comEstablishDate" type="date" name="first_name" placeholder="Establish Date" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Establish Date'" required="" class="single-input">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>Admin Info</h4>
                            <div class="mt-10">
                                <label for="userProfileImg">Profile Image</label>
                                <input id="userProfileImg" type="file" name="first_name" placeholder="Profile Image" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Profile Image'" required="" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="userFirstName">First Name *</label>
                                <input id="userFirstName" type="text" name="first_name" placeholder="First Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" required="" value="abc" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="userLastName">Last Name *</label>
                                <input id="userLastName" type="text" name="first_name" placeholder="Last Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'" required="" value="abc" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="userEmail">Email *</label>
                                <input id="userEmail" type="text" name="first_name" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required="" value="abc" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="userPassword">Password *</label>
                                <input id="userPassword" type="password" name="first_name" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required="" value="abc" class="single-input">
                            </div>
                            <div class="mt-10">
                                <label for="cUserPassword">Confirm Password *</label>
                                <input id="cUserPassword" type="password" name="first_name" placeholder="Confirm Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'" required="" value="abc" class="single-input">
                            </div>
                        </div>
                    </div>
                    <button id="companyRegister" type="button" class="btn head-btn2 mt-4 w-100" onclick="registerCompany()">SignUp</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal animated zoomIn" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="candidateModalLabel">Candidate Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-10">
                        <input id="email" type="email" name="first_name" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required="" class="single-input">
                    </div>
                    <div class="mt-10">
                        <input id="password" type="password" name="first_name" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required="" class="single-input">
                    </div>
                    <div class="mt-10">
                        <input id="cpassword" type="password" name="first_name" placeholder="Confirm Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'" required="" class="single-input">
                    </div>
                    <button id="companyLogin" type="button" class="btn head-btn2 mt-4 w-100" onclick="registerCandidate()">SignUp</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>

        async function registerCompany() {
            let comName = document.getElementById('comName').value
            let comLogo = document.getElementById('comLogo').files[0]
            let comDescription = document.getElementById('comDescription').value
            let comAddress = document.getElementById('comAddress').value
            let comContact = document.getElementById('comContact').value
            let comEmail = document.getElementById('comEmail').value
            let comWebsite = document.getElementById('comWebsite').value
            let comEstablishDate = document.getElementById('comEstablishDate').value

            let userProfileImg = document.getElementById('userProfileImg').files[0] ?? null
            let userFirstName = document.getElementById('userFirstName').value
            let userLastName = document.getElementById('userLastName').value
            let userEmail = document.getElementById('userEmail').value
            let userPassword = document.getElementById('userPassword').value
            let cpassword = document.getElementById('cUserPassword').value

            if (comName.length === 0) {
                return alert("Company Name is required!")
            }
            if (comLogo === null) {
                return alert("Company Logo is required!")
            }
            if (comDescription.length === 0) {
                return alert("Company Description is required!")
            }
            if (comAddress.length === 0) {
                return alert("Company Address is required!")
            }
            if (comEmail.length === 0) {
                return alert("Company Email is required!")
            }
            if (comEstablishDate.length === 0) {
                return alert("Company Establish Date is required!")
            }

            if (userFirstName.length === 0) {
                return alert("First Name is required!")
            }
            if (userLastName.length === 0) {
                return alert("Last Name is required!")
            }
            if (userEmail.length === 0) {
                return alert("Email is required!")
            }
            if (userPassword.length === 0) {
                return alert("Password is required!")
            }
            if (userPassword !== cpassword) {
                return alert("Passwords don't match!")
            }

            let data = new FormData();

            data.append('comName', comName)
            data.append('comLogo', comLogo)
            data.append('comDescription', comDescription)
            data.append('comAddress', comAddress)
            data.append('comContact', comContact)
            data.append('comEmail', comEmail)
            data.append('comWebsite', comWebsite)
            data.append('comEstablishDate', comEstablishDate)
            userProfileImg !== null ? data.append('userProfileImg', userProfileImg) : null
            data.append('userFirstName', userFirstName)
            data.append('userLastName', userLastName)
            data.append('userEmail', userEmail)
            data.append('userPassword', userPassword)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post("{{ route('company.register') }}", data, config)
            hideLoader()

            if (res.data['status'] === 'success') {
                localStorage.clear()

                localStorage.setItem('email', res.data['data']['user']['email'])
                localStorage.setItem('role', res.data['data']['user']['role'])
                localStorage.setItem('verified', res.data['data']['user']['emailVerifiedAt'])
                localStorage.setItem('companyStatus', res.data['data']['company']['status'])

                alert('success')
            } else {
                alert(res.data['message'])
            }
        }

        async function registerCandidate() {
            let email = document.getElementById('email').value
            let password = document.getElementById('password').value
            let cpassword = document.getElementById('cpassword').value

            if (email.length === 0) {
                return alert("Email is required!")
            }
            if (password.length === 0) {
                return alert("Password is required!")
            }
            if (password !== cpassword) {
                return alert("Passwords don't match!")
            }

            showLoader()
            let res = await axios.post("{{ route('candidate.register') }}", {
                email : email,
                password : password
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert("success")

                localStorage.clear()

                localStorage.setItem('email', res.data['data']['email'])
                localStorage.setItem('role', res.data['data']['role'])
                localStorage.setItem('verified', res.data['data']['emailVerifiedAt'])
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
