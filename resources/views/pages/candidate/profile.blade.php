@extends('layouts.dashboard')

@section('content')

        <div class="container-fluid pt-4 px-4">
            <div class="bg-light g-4">
                <div class="m-3 pt-3">
                    <h3>Personal Information</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="d-none" id="profileID">
                                <img id="display" class="rounded-circle" height="200px" width="200px" src="{{ url(env('DEFAULT_PROFILE_IMG')) }}" alt="">
                                <input oninput="display.src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="image">
                                <input type="text" class="d-none" id="profileImg">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="firstName" placeholder="name@example.com">
                                <label for="floatingInput">First Name *</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="lastName" placeholder="name@example.com">
                                <label for="floatingInput">Last Name *</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="fatherName" placeholder="name@example.com">
                                <label for="floatingInput">Father Name *</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="motherName" placeholder="name@example.com">
                                <label for="floatingInput">Mother Name *</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="dob" placeholder="name@example.com">
                                <label for="floatingInput">Date of Birth *</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="address" placeholder="name@example.com">
                                <label for="floatingInput">Address *</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="contact-prefix">+880</span>
                                <input type="text" class="form-control" id="contact" aria-describedby="contact-prefix" placeholder="Contact *">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="econtact-prefix">+880</span>
                                <input type="text" class="form-control" id="emergencyContact" aria-describedby="econtact-prefix" placeholder="Emergency Contact">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="personalWebsite" placeholder="name@example.com">
                                <label for="floatingInput">Personal Website</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="whatsapp" placeholder="name@example.com">
                                <label for="floatingInput">Whatsapp</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="linkedin" placeholder="name@example.com">
                                <label for="floatingInput">LinkedIn</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="dribble" placeholder="name@example.com">
                                <label for="floatingInput">Dribble</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="behance" placeholder="name@example.com">
                                <label for="floatingInput">Behance</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="github" placeholder="name@example.com">
                                <label for="floatingInput">GitHub</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="slack" placeholder="name@example.com">
                                <label for="floatingInput">Slack</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="twitter" placeholder="name@example.com">
                                <label for="floatingInput">Twitter</label>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nid" placeholder="name@example.com">
                                <label for="floatingInput">NID *</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="passport" placeholder="name@example.com">
                                <label for="floatingInput">Passport</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select class="form-select mb-3" aria-label="Default select example" id="bloodGroup">
                                    <option selected="">Blood Group *</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                                <label for="floatingInput">Blood Group *</label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-3 pb-4">
                        <button class="btn btn-primary w-100" onclick="saveProfile()">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 px-4">
            <div class="bg-light g-4">
                <div class="m-3 pt-3">
                    <h3>Educational Information</h3>
                    <hr>
                    <div>
                        <h5>SSC</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="insNameSSC" placeholder="name@example.com">
                                    <label for="floatingInput">Institution Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select mb-3" aria-label="Default select example" id="groupSSC">
                                        <option selected="">Group *</option>
                                        <option value="Science">Science</option>
                                        <option value="Arts">Arts</option>
                                        <option value="Commerce">Commerce</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="gpaSSC" placeholder="name@example.com">
                                    <label for="floatingInput">GPA *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="passingYearSSC" placeholder="name@example.com">
                                    <label for="floatingInput">Passing Year *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="file" class="form-control" id="certSSC">
                                    <label for="certSSC">Certificate *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <a href="" id="certSSCLink" class="d-none">Certificate Link</a>
                                    <button onclick="saveEdu('SSC')" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h5>HSC</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="insNameHSC" placeholder="name@example.com">
                                    <label for="floatingInput">Institution Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select mb-3" aria-label="Default select example" id="groupHSC">
                                        <option selected="">Group *</option>
                                        <option value="Science">Science</option>
                                        <option value="Arts">Arts</option>
                                        <option value="Commerce">Commerce</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="gpaHSC" placeholder="name@example.com">
                                    <label for="floatingInput">GPA *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="passingYearHSC" placeholder="name@example.com">
                                    <label for="floatingInput">Passing Year *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="file" class="form-control" id="certHSC">
                                    <label for="floatingInput">Certificate *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <a href="" id="certHSCLink" class="d-none">Certificate Link</a>
                                    <button onclick="saveEdu('HSC')" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h5>Bachelor/Honors</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="insNameHNS" placeholder="name@example.com">
                                    <label for="floatingInput">Institution Name *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select mb-3" aria-label="Default select example" id="groupHNS">
                                        <option selected="">Department *</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="gpaHNS" placeholder="name@example.com">
                                    <label for="floatingInput">CGPA *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="passingYearHNS" placeholder="name@example.com">
                                    <label for="floatingInput">Passing Year *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="file" class="form-control" id="certHNS">
                                    <label for="floatingInput">Certificate *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <a href="" id="certHNSLink" class="d-none">Certificate Link</a>
                                    <button onclick="saveEdu('HNS')" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 px-4">
            <div class="bg-light g-4">
                <div class="m-3 pt-3 pb-3">
                    <h3>Training</h3>
                    <hr>
                    <div id="training-wrapper"></div>
                    <div class="d-flex justify-content-center">
                        <button id="addTraining" data-bs-toggle="modal" data-bs-target="#add-training-modal" class="btn btn-success">Add Training</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-4 px-4">
            <div class="bg-light g-4">
                <div class="m-3 pt-3 pb-3">
                    <h3>Job Experience</h3>
                    <hr>
                    <div>
                        <h5>Current Job</h5>
                        <div id="currentJob" class="row"></div>
                    </div>
                    <div id="job-experience-wrapper">
                        <h5>Previous Experiences</h5>
                        <div id="job-experiences"></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button id="addJobExperience" data-bs-toggle="modal" data-bs-target="#add-experience-modal" class="btn btn-success">Add Job Experience</button>
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

        <div class="modal animated zoomIn" id="add-experience-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Job Experience</h5>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="bg-light g-4">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="expCompany" placeholder="name@example.com">
                                                    <label for="floatingInput">Company *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="expDesignation" placeholder="name@example.com">
                                                    <label for="floatingInput">Designation *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" id="expJoiningDate" placeholder="name@example.com">
                                                    <label for="floatingInput">Joining Date *</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="date" class="form-control" id="expQuittingDate" placeholder="name@example.com">
                                                    <label for="floatingInput">Quitting Date<label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" placeholder="Details about the job" id="expJobDetails" style="height: 150px;"></textarea>
                                                <label for="floatingInput">Job Details *</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="expIsCurrentJob" value="true">
                                                <label class="form-check-label" for="expIsCurrentJob">Current Job</label>
                                            </div>
                                        </div>
                                        <div class="pt-3 pb-4 d-flex">
                                            <button class="btn btn-primary w-50" onclick="addExp()">Save</button>
                                            <button id="expClose" class="btn btn-danger w-50" data-bs-dismiss="modal" aria-label="Close">Close</button>
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
        getDepartments()
        getEducation()
        getTraining()
        getExperience()

        async function getProfile() {
            showLoader()
            let res = await axios.get("{{ route('candidate.profile.show') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                if (res.data['data'].length !== null) {
                    let data = res.data['data']

                    document.getElementById('profileID').value = data['id']
                    document.getElementById('display').src = `{{ url('') }}/${data['profileImg']}`
                    document.getElementById('profileImg').value = data['profileImg']
                    document.getElementById('firstName').value = data['firstName']
                    document.getElementById('lastName').value = data['lastName']
                    document.getElementById('fatherName').value = data['fatherName']
                    document.getElementById('motherName').value = data['motherName']
                    document.getElementById('address').value = data['address']
                    document.getElementById('dob').value = data['dob']
                    document.getElementById('contact').value = data['contact']
                    document.getElementById('emergencyContact').value = data['emergencyContact']
                    document.getElementById('personalWebsite').value = data['personalWebsite']
                    document.getElementById('whatsapp').value = data['whatsapp']
                    document.getElementById('linkedin').value = data['linkedin']
                    document.getElementById('dribble').value = data['dribble']
                    document.getElementById('behance').value = data['behance']
                    document.getElementById('github').value = data['github']
                    document.getElementById('slack').value = data['slack']
                    document.getElementById('twitter').value = data['twitter']
                    document.getElementById('nid').value = data['nid']
                    document.getElementById('passport').value = data['passport']
                    document.getElementById('bloodGroup').value = data['bloodGroup']
                }
            }
        }

        async function getDepartments() {
            showLoader()
            let res = await axios.get("{{ route('department.index') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                data.forEach(element => {
                    let option = `<option value="${element}">${element}</option>`

                    document.getElementById('groupHNS').innerHTML += option
                })
            }
        }

        async function getEducation() {
            showLoader()
            let res = await axios.get("{{ url('/api/candidate/education') . '/' . auth()->user()->candidateProfile()->pluck('id')->first() }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                if (res.data['data'].length > 0) {
                    res.data['data'].forEach(element => {
                        if (element['degreeType'] === 'SSC') {
                            document.getElementById('insNameSSC').value = element['institution']
                            document.getElementById('groupSSC').value = element['department']
                            document.getElementById('gpaSSC').value = element['cgpa']
                            document.getElementById('passingYearSSC').value = element['passingYear']
                            document.getElementById('certSSCLink').href = `{{ url('') }}/${element['certificate']}`
                            $('#certSSCLink').removeClass('d-none')
                        }
                        if (element['degreeType'] === 'HSC') {
                            document.getElementById('insNameHSC').value = element['institution']
                            document.getElementById('groupHSC').value = element['department']
                            document.getElementById('gpaHSC').value = element['cgpa']
                            document.getElementById('passingYearHSC').value = element['passingYear']
                            document.getElementById('certHSCLink').href = `{{ url('') }}/${element['certificate']}`
                            $('#certHSCLink').removeClass('d-none')
                        }
                        if (element['degreeType'] === 'Bachelor/Honors') {
                            document.getElementById('insNameHNS').value = element['institution']
                            document.getElementById('groupHNS').value = element['department']
                            document.getElementById('gpaHNS').value = element['cgpa']
                            document.getElementById('passingYearHNS').value = element['passingYear']
                            document.getElementById('certHNSLink').href = `{{ url('') }}/${element['certificate']}`
                            $('#certHNSLink').removeClass('d-none')
                        }
                    });
                }
            }
        }

        async function getTraining() {
            showLoader()
            let res = await axios.get("{{ url('/api/candidate/training') . '/' . auth()->user()->candidateProfile->id }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']
                document.getElementById('training-wrapper').innerHTML = ''

                data.forEach(element => {
                    let content = `
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <p>Institution Name : <b>${element['institution']}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <p>Title : <b>${element['title']}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <p>Completion Year : <b>${element['completionYear']}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3 d-flex align-items-center justify-content-between">` +
                                        (element['certificate'] ? `<a href="{{ url('') }}/${element['certificate']}">Certificate Link</a>` : '')
                                        + `<button class="btn btn-sm btn-danger del-training" data-id="${element['id']}">Delete</button>
                                    </div>
                                </div>
                            </div>
                    `

                    document.getElementById('training-wrapper').innerHTML += content
                });

                $('.del-training').click(async function () {
                    let id = $(this).data('id')

                    await delTraining(id)
                })

            } else {
                alert(res.data['message'])
            }
        }

        async function getExperience() {
            showLoader()
            let res = await axios.get("{{ url('/api/candidate/job-experience') . '/' . auth()->user()->candidateProfile->id }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']
                let count = 1

                document.getElementById('currentJob').innerHTML = '<p class="p-3 d-flex justify-content-center">Nothing to show</p>'
                document.getElementById('job-experiences').innerHTML = '<p class="p-3 d-flex justify-content-center">Nothing to show</p>'

                data.forEach(element => {
                    if (element['isCurrentJob']) {
                        let content = `
                            <input class="d-none" value="${element['isCurrentJob']}" id="isCurrent-${element['id']}">
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="company-${element['id']}" value="${element['company']}">
                                    <label for="floatingInput">Company *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="designation-${element['id']}" value="${element['designation']}">
                                    <label for="floatingInput">Designation *</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="joiningDate-${element['id']}" value="${element['joiningDate']}">
                                    <label for="floatingInput">Joining Date *</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="quittingDate-${element['id']}">
                                    <label for="floatingInput">Quitting Date</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Details about the job" id="details-${element['id']}" style="height: 150px;">${element['jobDetails']}</textarea>
                                    <label for="floatingInput">Job Details *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 d-flex align-items-end justify-content-end h-100">
                                    <button class="btn btn-primary update-exp" data-id="${element['id']}">Update</button>&nbsp;&nbsp;
                                    <button class="btn btn-danger delete-exp" data-id="${element['id']}">Delete</button>
                                </div>
                            </div>
                        `

                        document.getElementById('currentJob').innerHTML = content
                    } else {
                        let content = `
                            <h6>Job Experience ${count}</h6>
                            <div class="row">
                                <input class="d-none" value="${element['isCurrentJob']}" id="isCurrent-${element['id']}">
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="company-${element['id']}" value="${element['company']}">
                                        <label for="floatingInput">Company *</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="designation-${element['id']}" value="${element['designation']}">
                                        <label for="floatingInput">Designation *</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="joiningDate-${element['id']}" value="${element['joiningDate']}">
                                        <label for="floatingInput">Joining Date *</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="quittingDate-${element['id']}" value="${element['quittingDate']}">
                                        <label for="floatingInput">Quitting Date *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Details about the job" id="details-${element['id']}" style="height: 150px;">${element['jobDetails']}</textarea>
                                        <label for="floatingInput">Job Details *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex align-items-end justify-content-end h-100">
                                        <button class="btn btn-primary update-exp" data-id="${element['id']}">Update</button>&nbsp;&nbsp;
                                        <button class="btn btn-danger delete-exp" data-id="${element['id']}">Delete</button>
                                    </div>
                                </div>
                            </div>

                        `

                        count === 1 ? (document.getElementById('job-experiences').innerHTML = content) : (document.getElementById('job-experiences').innerHTML += content)
                        count++
                    }
                });

                $('.update-exp').click(async function () {
                    let id = $(this).data('id')

                    await updateExp(id)
                })

                $('.delete-exp').click(async function () {
                    let id = $(this).data('id')

                    await deleteExp(id)
                })

            } else {
                alert(res.data['message'])
            }
        }

        async function saveProfile() {
            let id = document.getElementById('profileID').value ?? null
            let image = document.getElementById('image').files[0] ?? null
            let profileImg = document.getElementById('profileImg').value
            let firstName = document.getElementById('firstName').value
            let lastName = document.getElementById('lastName').value
            let fatherName = document.getElementById('fatherName').value
            let motherName = document.getElementById('motherName').value
            let address = document.getElementById('address').value
            let dob = document.getElementById('dob').value
            let contact = document.getElementById('contact').value
            let emergencyContact = document.getElementById('emergencyContact').value
            let personalWebsite = document.getElementById('personalWebsite').value
            let whatsapp = document.getElementById('whatsapp').value
            let linkedin = document.getElementById('linkedin').value
            let dribble = document.getElementById('dribble').value
            let behance = document.getElementById('behance').value
            let github = document.getElementById('github').value
            let slack = document.getElementById('slack').value
            let twitter = document.getElementById('twitter').value
            let nid = document.getElementById('nid').value
            let passport = document.getElementById('passport').value
            let bloodGroup = document.getElementById('bloodGroup').value

            let data = new FormData()

            data.append('id', id)
            image !== null ? data.append('image', image) : null
            data.append('profileImg', profileImg)
            data.append('firstName', firstName)
            data.append('lastName', lastName)
            data.append('fatherName', fatherName)
            data.append('motherName', motherName)
            data.append('address', address)
            data.append('dob', dob)
            data.append('contact', contact)
            data.append('emergencyContact', emergencyContact)
            data.append('personalWebsite', personalWebsite)
            data.append('whatsapp', whatsapp)
            data.append('linkedin', linkedin)
            data.append('dribble', dribble)
            data.append('behance', behance)
            data.append('github', github)
            data.append('slack', slack)
            data.append('twitter', twitter)
            data.append('nid', nid)
            data.append('passport', passport)
            data.append('bloodGroup', bloodGroup)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post("{{ route('candidate.profile.save') }}", data, config)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }

        async function saveEdu(degreeType) {
            let institution = document.getElementById('insName'+degreeType).value
            let department = document.getElementById('group'+degreeType).value
            let cgpa = document.getElementById('gpa'+degreeType).value
            let passingYear = document.getElementById('passingYear'+degreeType).value
            let certificate = document.getElementById('cert'+degreeType).files[0] ?? null

            if (degreeType === 'HNS') {
                degreeType = 'Bachelor/Honors'
            }

            let data = new FormData()

            data.append('degreeType', degreeType)
            data.append('institution', institution)
            data.append('department', department)
            data.append('cgpa', cgpa)
            data.append('passingYear', passingYear)
            certificate !== null ? data.append('certificate', certificate) : null

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post("{{ route('education.save') }}", data, config)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                await getEducation()
            } else {
                alert(res.data['message'])
            }
        }

        async function delTraining(id) {
            showLoader()
            let res = await axios.delete("{{ url('/api/training') }}/"+id)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                await getTraining()
            }
        }

        async function addTraining() {
            let institution = document.getElementById('trainingIns').value
            let title = document.getElementById('trainingTitle').value
            let completionYear = document.getElementById('trainingCompletionYear').value
            let certificate = document.getElementById('trainingCertificate').files[0] ?? null

            let data = new FormData()

            data.append('institution', institution)
            data.append('title', title)
            data.append('completionYear', completionYear)
            certificate !== null ? data.append('certificate', certificate) : null

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post("{{ route('training.create') }}", data, config)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                document.getElementById('trainingClose').click()

                await getTraining()
            } else {
                alert(res.data['message'])
            }
        }

        async function addExp() {
            let company = document.getElementById('expCompany').value
            let designation = document.getElementById('expDesignation').value
            let joiningDate = document.getElementById('expJoiningDate').value
            let quittingDate = document.getElementById('expQuittingDate').value
            let jobDetails = document.getElementById('expJobDetails').value
            let isCurrentJob = document.getElementById('expIsCurrentJob').checked

            showLoader()
            let res = await axios.post("{{ route('job.experience.create') }}", {
                company : company,
                designation : designation,
                joiningDate : joiningDate,
                quittingDate : quittingDate,
                jobDetails : jobDetails,
                isCurrentJob : isCurrentJob
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                document.getElementById('expClose').click()

                await getExperience()
            } else {
                alert(res.data['message'])
            }
        }

        async function updateExp(id) {
            let isCurrentJob = document.getElementById('isCurrent-'+id).value
            let company = document.getElementById('company-'+id).value
            let designation = document.getElementById('designation-'+id).value
            let joiningDate = document.getElementById('joiningDate-'+id).value
            let quittingDate = document.getElementById('quittingDate-'+id).value
            let jobDetails = document.getElementById('details-'+id).value

            if (quittingDate) {
                isCurrentJob = '0'
            }

            showLoader()
            let res = await axios.post("{{ url('/api/job-experience') }}/"+id, {
                id : id,
                isCurrentJob : isCurrentJob,
                company : company,
                designation : designation,
                joiningDate : joiningDate,
                quittingDate : quittingDate,
                jobDetails : jobDetails
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                await getExperience()
            } else {
                alert(res.data['message'])
            }
        }

        async function deleteExp(id) {
            if (!confirm("Are you sure you want to delete this job experience?")) {
                return
            }
            showLoader()
            let res = await axios.delete("{{ url('/api/job-experience') }}/"+id)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                await getExperience()
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
