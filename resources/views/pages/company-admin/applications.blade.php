@extends('layouts.dashboard')

@section('content')

    <div class="pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h5 class="mb-4">Job Applications</h5>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-available-tab" data-bs-toggle="tab" data-bs-target="#nav-available" type="button" role="tab" aria-controls="nav-available" aria-selected="true">Available</button>
                    <button class="nav-link" id="nav-unavailable-tab" data-bs-toggle="tab" data-bs-target="#nav-unavailable" type="button" role="tab" aria-controls="nav-unavailable" aria-selected="false">Unavailable</button>
                </div>
            </nav>
            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-available" role="tabpanel" aria-labelledby="nav-available-tab">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Salary</th>
                            <th>Deadline</th>
                            <th>Applications</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="available-wrapper"></tbody>
                    </table>
                    <div id="available-load-btn"></div>
                </div>
                <div class="tab-pane fade" id="nav-unavailable" role="tabpanel" aria-labelledby="nav-unavailable-tab">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Salary</th>
                            <th>Deadline</th>
                            <th>Applications</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="unavailable-wrapper"></tbody>
                    </table>
                    <div id="unavailable-load-btn"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal animated zoomIn" id="applications-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Job Applications</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">
                                    <h2 id="title"></h2>
                                    <small><b id="deadline"></b></small>
                                    <div id="skills"></div>
                                    <p id="salary"></p>
                                    <div>
                                        <table class="table">
                                            <thead>
                                                <th>#</th>
                                                <th>Applicant</th>
                                                <th>View Details</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody id="applicationList"></tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex-justify-content-end">
                                        <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="modal animated zoomIn" id="detail-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Applicant Detail</h3>
                        <h5>Application #<span id="applicationId"></span></h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">

                                    <div class="container-fluid pt-4 px-4">
                                        <div class="bg-light g-4">
                                            <div class="m-3 pt-3">
                                                <h3>Personal Information</h3>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <img id="profileImg" class="rounded-circle" height="200px" width="200px" src="{{ url(env('DEFAULT_PROFILE_IMG')) }}" alt="">
                                                    </div>
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-6">
                                                        <p>Name : <b id="name"></b></p>
                                                        <p>Father's Name : <b id="fatherName"></b></p>
                                                        <p>Mother's Name : <b id="motherName"></b></p>
                                                        <p>Date of Birth : <b id="dob"></b></p>
                                                        <p>email : <b id="email"></b></p>
                                                        <p>Contact : <b id="contact"></b></p>
                                                        <p id="ecWrapper" class="d-none">Emergency Contact : <b id="econtact"></b></p>
                                                        <p>NID : <b id="nid"></b></p>
                                                        <p id="psWrapper" class="d-none">Passport : <b id="passport"></b></p>
                                                        <p>Blood Group : <b id="bloodGroup"></b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>Address : <b id="address"></b></p>
                                                        <p id="webWrapper" class="d-none">Personal Website : <b id="website"></b></p>
                                                        <p id="waWrapper" class="d-none">Whatsapp : <b id="whatsapp"></b></p>
                                                        <p id="lkWrapper" class="d-none">LinkedIn : <b id="linkedin"></b></p>
                                                        <p id="drWrapper" class="d-none">Dribble : <b id="dribble"></b></p>
                                                        <p id="beWrapper" class="d-none">Behance : <b id="behance"></b></p>
                                                        <p id="ghWrapper" class="d-none">GitHub : <b id="github"></b></p>
                                                        <p id="slWrapper" class="d-none">Slack : <b id="slack"></b></p>
                                                        <p id="twWrapper" class="d-none">Twitter : <b id="twitter"></b></p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h3>Educational Information</h3>
                                                <table class="table">
                                                    <thead>
                                                        <th>Degree</th>
                                                        <th>Institution</th>
                                                        <th>Group/Department</th>
                                                        <th>GPA/CGPA</th>
                                                        <th>Passing Year</th>
                                                        <th>Certificate</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="SSC"></tr>
                                                        <tr id="HSC"></tr>
                                                        <tr id="Bachelor/Honors"></tr>
                                                    </tbody>
                                                </table>
                                                <hr>
                                                <h3>Professional Training</h3>
                                                <div id="training-wrapper"></div>
                                                <hr>
                                                <h3>Job Experience</h3>
                                                <div id="job-experience-wrapper"></div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button id="detailClose" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
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

        get()

        function createBadgeHTML(item) {
            return `<span class="badge bg-success ms-2">${item}</span>`;
        }

        async function get() {
            await getAvailableJobs("{{ route('company.jobs') }}?status=available")
            await getUnavailableJobs("{{ route('company.jobs') }}?status=unavailable")

            $('.job').click(async function () {
                let id = $(this).data('id')
                let title = $(this).data('title')
                let skills = $(this).data('skills')
                let salary = $(this).data('salary')
                let deadline = $(this).data('deadline')

                const trimmedString = skills.trim().replace(/,$/, '');
                const itemsArray = trimmedString.split(',');
                const badgesHTML = itemsArray.map(createBadgeHTML).join('');

                document.getElementById('title').innerHTML = title
                document.getElementById('skills').innerHTML = badgesHTML
                document.getElementById('salary').innerHTML = salary
                document.getElementById('deadline').innerHTML = deadline

                await getApplications(id)

                $('#applications-modal').modal('show')
            })
        }

        async function getApplications(id) {
            document.getElementById('applicationList').innerHTML = ''

            showLoader()
            let res = await axios.get(`{{ url('/api/job') }}/${id}/applications`)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']['data']

                data.forEach(item => {
                    content = `
                        <tr>
                            <td>${item['id']}</td>
                            <td>
                                <img class="rounded-circle" src="{{ url('') }}/${item['candidate']['profileImg']}" height="35px" width="35px">&nbsp;&nbsp;
                                <span>${item['candidate']['firstName']} ${item['candidate']['lastName']}</span>
                            </td>
                            <td><button class="btn btn-sm btn-primary viewDetail" data-application-id="${item['id']}" data-id="${item['candidate']['id']}"><i class="fas fa-eye"></i></button></td>
                            <td><span class="badge bg-secondary">${item['status']}</span></td>
                            <td>` +
                                (item['status'] === 'REJECTED' ? `<button class="btn btn-sm btn-success accept" data-job-id="${id}" data-id="${item['id']}">Accept</button>` : '') +
                                (item['status'] === 'ACCEPTED' ? `<button class="btn btn-sm btn-danger reject" data-job-id="${id}" data-id="${item['id']}">Reject</button>` : '')
                            + `</td>
                        </tr>
                    `

                    document.getElementById('applicationList').innerHTML += content
                });

                $('.viewDetail').click(async function () {
                    let id = $(this).data('id')
                    let applicationId = $(this).data('application-id')

                    await getProfile(id)
                    await getEducation(id)
                    await getTraining(id)
                    await getExperience(id)

                    document.getElementById('applicationId').innerText = applicationId
                    $('#detail-modal').modal('show')
                })

                $('.accept').click(async function () {
                    let id = $(this).data('id')
                    let jobId = $(this).data('job-id')

                    showLoader()
                    let res = await axios.post(`{{ url('/api/job-application') }}/${id}/update-status`, {status : "ACCEPTED"})
                    hideLoader()

                    if (res.data['status'] === 'success') {
                        alert(res.data['message'])

                        await getApplications(jobId)
                    } else {
                        alert(res.data['message'])
                    }
                })

                $('.reject').click(async function () {
                    let id = $(this).data('id')
                    let jobId = $(this).data('job-id')

                    showLoader()
                    let res = await axios.post(`{{ url('/api/job-application') }}/${id}/update-status`, {status : "REJECTED"})
                    hideLoader()

                    if (res.data['status'] === 'success') {
                        alert(res.data['message'])

                        await getApplications(jobId)
                    } else {
                        alert(res.data['message'])
                    }
                })

            } else {
                alert(res.data['message'])
            }
        }

        async function getProfile(id) {
            showLoader()
            let res = await axios.get(`{{ url('/api/candidate') }}/${id}/profile`)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                document.getElementById('profileImg').src = "{{ url('') }}" + '/' + data['profileImg']
                document.getElementById('name').innerText = `${data['firstName']} ${data['lastName']}`
                document.getElementById('fatherName').innerText = data['fatherName']
                document.getElementById('motherName').innerText = data['motherName']
                document.getElementById('dob').innerText = data['dob']
                document.getElementById('email').innerText = data['user']['email']
                document.getElementById('contact').innerText = data['contact']
                document.getElementById('nid').innerText = data['nid']
                document.getElementById('bloodGroup').innerText = data['bloodGroup']
                document.getElementById('address').innerText = data['address']

                if (data['emergencyContact']) {
                    document.getElementById('econtact').innerText = data['emergencyContact']
                    $('#ecWrapper').removeClass('d-none')
                } else {
                    document.getElementById('econtact').innerText = ''
                    $('#ecWrapper').addClass('d-none')
                }
                if (data['passport']) {
                    document.getElementById('passport').innerText = data['passport']
                    $('#psWrapper').removeClass('d-none')
                } else {
                    document.getElementById('passport').innerText = ''
                    $('#psWrapper').addClass('d-none')
                }
                if (data['personalWebsite']) {
                    document.getElementById('website').innerText = data['personalWebsite']
                    $('#webWrapper').removeClass('d-none')
                } else {
                    document.getElementById('website').innerText = ''
                    $('#webWrapper').addClass('d-none')
                }
                if (data['whatsapp']) {
                    document.getElementById('whatsapp').innerText = data['whatsapp']
                    $('#waWrapper').removeClass('d-none')
                } else {
                    document.getElementById('whatsapp').innerText = ''
                    $('#waWrapper').addClass('d-none')
                }
                if (data['linkedin']) {
                    document.getElementById('linkedin').innerText = data['linkedin']
                    $('#lkWrapper').removeClass('d-none')
                } else {
                    document.getElementById('linkedin').innerText = ''
                    $('#lkWrapper').addClass('d-none')
                }
                if (data['dribble']) {
                    document.getElementById('dribble').innerText = data['dribble']
                    $('#drWrapper').removeClass('d-none')
                } else {
                    document.getElementById('dribble').innerText = ''
                    $('#drWrapper').addClass('d-none')
                }
                if (data['behance']) {
                    document.getElementById('behance').innerText = data['behance']
                    $('#beWrapper').removeClass('d-none')
                } else {
                    document.getElementById('behance').innerText = ''
                    $('#beWrapper').addClass('d-none')
                }
                if (data['github']) {
                    document.getElementById('github').innerText = data['github']
                    $('#ghWrapper').removeClass('d-none')
                } else {
                    document.getElementById('github').innerText = ''
                    $('#ghWrapper').addClass('d-none')
                }
                if (data['slack']) {
                    document.getElementById('slack').innerText = data['slack']
                    $('#slWrapper').removeClass('d-none')
                } else {
                    document.getElementById('slack').innerText = ''
                    $('#slWrapper').addClass('d-none')
                }
                if (data['twitter']) {
                    document.getElementById('twitter').innerText = data['twitter']
                    $('#twWrapper').removeClass('d-none')
                } else {
                    document.getElementById('twitter').innerText = ''
                    $('#twWrapper').addClass('d-none')
                }
            }
        }

        async function getEducation(id) {
            showLoader()
            let res = await axios.get(`{{ url('/api/candidate/education') }}/${id}`)
            hideLoader()

            document.getElementById('SSC').innerHTML = ''
            document.getElementById('HSC').innerHTML = ''
            document.getElementById('Bachelor/Honors').innerHTML = ''

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                data.forEach(item => {
                    content = `
                        <td>${item['degreeType']}</td>
                        <td>${item['institution']}</td>
                        <td>${item['department']}</td>
                        <td>${item['cgpa']}</td>
                        <td>${item['passingYear']}</td>
                        <td><a href="{{ url('') }}/${item['certificate']}" target="_blank">Certificate</a></td>
                    `

                    document.getElementById(item['degreeType']).innerHTML = content
                });
            }
        }

        async function getTraining(id) {
            showLoader()
            let res = await axios.get(`{{ url('/api/candidate/job-experience') }}/${id}`)
            hideLoader()

            document.getElementById('job-experience-wrapper').innerHTML = 'content'

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                data.forEach(element => {
                    content = `
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <p>Company : <b>${element['company']}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <p>Designation : <b>${element['designation']}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <p>Service Time : <b>${element['joiningDate']} to ${element['quittingDate']}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3 d-flex align-items-center justify-content-between">` +
                                        (element['isCurrentJob'] ? `✅ Current Job` : '')
                                    + `</div>
                                </div>
                            </div>
                    `

                    document.getElementById('job-experience-wrapper').innerHTML += content
                });
            }
        }

        async function getExperience(id) {
            showLoader()
            let res = await axios.get(`{{ url('/api/candidate/training') }}/${id}`)
            hideLoader()

            document.getElementById('training-wrapper').innerHTML = ''

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                data.forEach(element => {
                    content = `
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <p>Institution Name : <b>${element['institution']}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <p>Title : <b>${element['title']}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating mb-3">
                                        <p>Completion Year : <b>${element['completionYear']}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3 d-flex align-items-center justify-content-between">` +
                                        (element['certificate'] ? `<a href="{{ url('') }}/${element['certificate']}" target="_blank">Certificate</a>` : '')
                                    + `</div>
                                </div>
                            </div>
                    `

                    document.getElementById('training-wrapper').innerHTML += content
                });
            }
        }

        async function getAvailableJobs(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']['data']

                if (res.data['data']['next_page_url']) {
                    document.getElementById('available-load-btn').innerHTML = `<button id="loadMoreAvailable" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMoreAvailable').click(async function () {
                        let url = $(this).data('url')

                        await getAvailableJobs(url)
                    })
                } else {
                    document.getElementById('available-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    const deadline = new Date(element['deadline']);
                    const options = { year: 'numeric', month: 'short', day: 'numeric'};
                    const deadlineDate = deadline.toLocaleString('en-US', options);

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['salary']}</td>
                            <td>${deadlineDate}</td>
                            <td>${element['job_applications_count']}</td>
                            <td><button class="btn btn-sm btn-success job" data-id="${element['id']}" data-title="${element['title']}" data-skills="${element['skills']}" data-salary="${element['salary']}" data-deadline="${deadlineDate}">Applications</button></td>
                        </tr>`

                    document.getElementById('available-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function getUnavailableJobs(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']['data']

                if (res.data['data']['next_page_url']) {
                    document.getElementById('unavailable-load-btn').innerHTML = `<button id="loadMoreUnavailable" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMoreUnavailable').click(async function () {
                        let url = $(this).data('url')

                        await getUnavailableJobs(url)
                    })
                } else {
                    document.getElementById('unavailable-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    const deadline = new Date(element['deadline']);
                    const options = { year: 'numeric', month: 'short', day: 'numeric'};
                    const deadlineDate = deadline.toLocaleString('en-US', options);

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['salary']}</td>
                            <td>${deadlineDate}</td>
                            <td>${element['job_applications_count']}</td>
                            <td><button class="btn btn-sm btn-success job" data-id="${element['id']}" data-title="${element['title']}" data-skills="${element['skills']}" data-salary="${element['salary']}" data-deadline="${deadlineDate}">Applications</button></td>
                        </tr>`

                    document.getElementById('unavailable-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
