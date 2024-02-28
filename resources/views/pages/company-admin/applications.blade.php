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

    <div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Job</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">
                                    <input type="hidden" class="d-none" id="updateID">
                                    <div class="form-floating mb-3">
                                        <select class="form-select mb-3" aria-label="Default select example" id="updateCat">
                                            <option>Job Category *</option>
                                        </select>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="updateTitle" placeholder="name@example.com">
                                        <label for="floatingInput">Title *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Details about the job" id="updateDescription" style="height: 150px;"></textarea>
                                        <label for="floatingInput">Description *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="updateSkills" placeholder="name@example.com">
                                        <label for="floatingInput">Skills (Use Commas to differentiate multiple skills) *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="updateSalary" placeholder="name@example.com">
                                        <label for="floatingInput">Salary *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select mb-3" aria-label="Default select example" id="updateType">
                                            <option>Job Type *</option>
                                            <option value="On-Site">On-Site</option>
                                            <option value="Remote">Remote</option>
                                            <option value="Hybrid">Hybrid</option>
                                        </select>
                                        <label for="floatingInput">Job Type *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="updateDeadline" placeholder="name@example.com">
                                        <label for="floatingInput">Deadline *</label>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-primary w-50" onclick="update()">Save</button>
                                        <button id="updateClose" class="btn btn-danger w-50" data-bs-dismiss="modal" aria-label="Close">Close</button>
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
                            <td><button class="btn btn-sm btn-primary viewDetail" data-id="${item['candidate']['id']}"><i class="fas fa-eye"></i></button></td>
                            <td><span class="badge bg-secondary">${item['status']}</span></td>
                            <td>` +
                                (item['status'] === 'REJECTED' ? `<button class="btn btn-sm btn-success accept" data-job-id="${id}" data-id="${item['id']}">Accept</button>` : '') +
                                (item['status'] === 'ACCEPTED' ? `<button class="btn btn-sm btn-danger reject" data-job-id="${id}" data-id="${item['id']}">Reject</button>` : '')
                            + `</td>
                        </tr>
                    `

                    document.getElementById('applicationList').innerHTML += content
                });

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
