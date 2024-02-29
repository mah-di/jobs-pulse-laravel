@extends('layouts.dashboard')

@section('content')

        <div class="container-fluid pt-4 px-4">
            <div class="bg-light g-4">
                <div class="m-3 pt-3">
                    <h3>Personal Information</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input class="d-none" id="profileID">
                                <img id="display" class="rounded-circle mb-2" height="200px" width="200px" src="{{ url(env('DEFAULT_PROFILE_IMG')) }}" alt="">
                                <input oninput="display.src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="profileImg">
                            </div>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="firstName" placeholder="name@example.com">
                                <label for="floatingInput">First Name *</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="lastName" placeholder="name@example.com">
                                <label for="floatingInput">Last Name *</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded p-1" style="background-color: #eeeeee">
                                <small>Email *</small><br>
                                <span id="email"></span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-3 pb-4">
                        <button class="btn btn-primary w-100" onclick="saveProfile()">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal animated zoomIn" id="add-training-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Training</h5>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="bg-light g-4">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="trainingIns" placeholder="name@example.com">
                                                    <label for="floatingInput">Institution *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="trainingTitle" placeholder="name@example.com">
                                                    <label for="floatingInput">Title *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="trainingCompletionYear" placeholder="name@example.com">
                                                    <label for="floatingInput">Completion Year *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="file" class="form-control" id="trainingCertificate" placeholder="name@example.com">
                                                    <label for="floatingInput">Certificate<label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-3 pb-4 d-flex">
                                            <button class="btn btn-primary w-50" onclick="addTraining()">Save</button>
                                            <button id="trainingClose" class="btn btn-danger w-50" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

@endsection

@push('script')

    <script>

        getProfile()

        async function getProfile() {
            showLoader()
            let res = await axios.get("{{ route('profile.show') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                if (res.data['data'].length !== null) {
                    let data = res.data['data']

                    document.getElementById('profileID').value = data['profile']['id']
                    document.getElementById('display').src = `{{ url('') }}/${data['profile']['profileImg']}`
                    document.getElementById('firstName').value = data['profile']['firstName']
                    document.getElementById('lastName').value = data['profile']['lastName']
                    document.getElementById('email').innerText = data['email']
                }
            }
        }

        async function saveProfile() {
            let profileImg = document.getElementById('profileImg').files[0] ?? null
            let firstName = document.getElementById('firstName').value
            let lastName = document.getElementById('lastName').value

            let data = new FormData()

            profileImg !== null ? data.append('profileImg', profileImg) : null
            data.append('firstName', firstName)
            data.append('lastName', lastName)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post("{{ route('profile.update') }}", data, config)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
