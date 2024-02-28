@extends('layouts.dashboard')

@section('content')

    <div class="pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between">
                <h5 class="mb-4">Jobs</h5>
                @if (in_array(auth()->user()->role, ['Admin', 'Manager']))
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">Post A Job</button>
                @endif
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true">All</button>
                    <button class="nav-link" id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending" type="button" role="tab" aria-controls="nav-pending" aria-selected="false">Pending</button>
                    <button class="nav-link" id="nav-available-tab" data-bs-toggle="tab" data-bs-target="#nav-available" type="button" role="tab" aria-controls="nav-available" aria-selected="false">Available</button>
                    <button class="nav-link" id="nav-unavailable-tab" data-bs-toggle="tab" data-bs-target="#nav-unavailable" type="button" role="tab" aria-controls="nav-unavailable" aria-selected="false">Unavailable</button>
                    <button class="nav-link" id="nav-restricted-tab" data-bs-toggle="tab" data-bs-target="#nav-restricted" type="button" role="tab" aria-controls="nav-restricted" aria-selected="false">Restricted</button>
                </div>
            </nav>
            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Salary</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Applications</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="all-wrapper"></tbody>
                    </table>
                    <div id="all-load-btn"></div>
                </div>
                <div class="tab-pane fade" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Salary</th>
                            <th>Deadline</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="pending-wrapper"></tbody>
                    </table>
                    <div id="pending-load-btn"></div>
                </div>
                <div class="tab-pane fade" id="nav-available" role="tabpanel" aria-labelledby="nav-available-tab">
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
                <div class="tab-pane fade" id="nav-restricted" role="tabpanel" aria-labelledby="nav-restricted-tab">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Salary</th>
                            <th>Deadline</th>
                            <th>Feedback</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="restricted-wrapper"></tbody>
                    </table>
                    <div id="restricted-load-btn"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Post Job</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">
                                    <div class="form-floating mb-3">
                                        <select class="form-select mb-3" aria-label="Default select example" id="createCat">
                                            <option>Job Category *</option>
                                        </select>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="createTitle" placeholder="name@example.com">
                                        <label for="floatingInput">Title *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Details about the job" id="createDescription" style="height: 150px;"></textarea>
                                        <label for="floatingInput">Description *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="createSkills" placeholder="name@example.com">
                                        <label for="floatingInput">Skills (Use Commas to differentiate multiple skills) *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="createSalary" placeholder="name@example.com">
                                        <label for="floatingInput">Salary *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select mb-3" aria-label="Default select example" id="createType">
                                            <option>Job Type *</option>
                                            <option value="On-Site">On-Site</option>
                                            <option value="Remote">Remote</option>
                                            <option value="Hybrid">Hybrid</option>
                                        </select>
                                        <label for="floatingInput">Job Type *</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="createDeadline" placeholder="name@example.com">
                                        <label for="floatingInput">Deadline *</label>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-primary w-50" onclick="create()">Save</button>
                                        <button id="createClose" class="btn btn-danger w-50" data-bs-dismiss="modal" aria-label="Close">Close</button>
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

        async function get() {
            await getAllJobs("{{ route('company.jobs') }}")
            await getPendingJobs("{{ route('company.jobs') }}?status=pending")
            await getAvailableJobs("{{ route('company.jobs') }}?status=available")
            await getUnavailableJobs("{{ route('company.jobs') }}?status=unavailable")
            await getRestrictedJobs("{{ route('company.jobs') }}?status=restricted")
            await getJobCategories()

            $('.availability').change(async function () {
                let id = $(this).data('id')
                let status = this.checked === true ? 'AVAILABLE' : 'UNAVAILABLE'

                showLoader()
                let res = await axios.post(`{{ url('/api/job') }}/${id}/availability`, {status : status})
                hideLoader()

                if (res.data['status'] === 'success') {
                    alert(res.data['message'])

                    reset()
                    await get()
                } else{
                    alert(res.data['message'])
                }
            })

            $('.updateJobs').click(async function () {
                let id = $(this).data('id')

                showLoader()
                let res = await axios.get(`{{ url('/api/job') }}/${id}`)
                hideLoader()

                if (res.data['status'] === 'success') {
                    let data = res.data['data']

                    document.getElementById('updateID').value = data['id']
                    document.getElementById('updateCat').value = data['job_category_id']
                    document.getElementById('updateTitle').value = data['title']
                    document.getElementById('updateDescription').value = data['description']
                    document.getElementById('updateSkills').value = data['skills'].slice(0, -1)
                    document.getElementById('updateSalary').value = data['salary']
                    document.getElementById('updateType').value = data['type']
                    document.getElementById('updateDeadline').value = data['deadline']

                    $('#update-modal').modal('show')
                } else {
                    alert(res.data['message'])
                }
            })
        }

        function reset() {
            document.getElementById('all-wrapper').innerHTML = ''
            document.getElementById('pending-wrapper').innerHTML = ''
            document.getElementById('available-wrapper').innerHTML = ''
            document.getElementById('unavailable-wrapper').innerHTML = ''
            document.getElementById('restricted-wrapper').innerHTML = ''
        }

        async function getJobCategories() {
            showLoader()
            let res = await axios.get("{{ route('job.category.index') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                data.forEach(item => {
                    let option = `<option value="${item['id']}">${item['name']}</option>`

                    document.getElementById('createCat').innerHTML += option
                    document.getElementById('updateCat').innerHTML += option
                })

            } else {
                alert(res.data['message'])
            }
        }

        async function getAllJobs(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let canUpdate = ['Admin', 'Manager'].includes(localStorage.getItem('role'))

                let data = res.data['data']['data']

                if (res.data['data']['next_page_url']) {
                    document.getElementById('all-load-btn').innerHTML = `<button id="loadMoreAll" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMoreAll').click(async function () {
                        let url = $(this).data('url')

                        await getAllJobs(url)
                    })
                } else {
                    document.getElementById('all-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    const deadline = new Date(element['deadline']);
                    const options = { year: 'numeric', month: 'short', day: 'numeric'};
                    const deadlineDate = deadline.toLocaleString('en-US', options);

                    let actions = `<button class="btn btn-sm btn-secondary updateJobs" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    if (canUpdate && ['AVAILABLE', 'UNAVAILABLE'].includes(element['status'])) {
                        checked = (element['status'] === 'AVAILABLE' ? 'checked' : '')
                        actions += `&nbsp;&nbsp;<input class="form-check-input form-switch availability" type="checkbox" role="switch" data-id="${element['id']}" ${checked}><small> Availability</small>`
                    }

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['salary']}</td>
                            <td>${deadlineDate}</td>
                            <td><span class="badge bg-secondary">${element['status']}</span></td>
                            <td>${element['job_applications_count']}</td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('all-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function getPendingJobs(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let canUpdate = ['Admin', 'Manager'].includes(localStorage.getItem('role'))

                let data = res.data['data']['data']

                if (res.data['data']['next_page_url']) {
                    document.getElementById('pending-load-btn').innerHTML = `<button id="loadMorePending" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMorePending').click(async function () {
                        let url = $(this).data('url')

                        await getPendingJobs(url)
                    })
                } else {
                    document.getElementById('pending-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    const deadline = new Date(element['deadline']);
                    const options = { year: 'numeric', month: 'short', day: 'numeric'};
                    const deadlineDate = deadline.toLocaleString('en-US', options);

                    let actions = `<button class="btn btn-sm btn-secondary updateJobs" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['salary']}</td>
                            <td>${deadlineDate}</td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('pending-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function getAvailableJobs(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let canUpdate = ['Admin', 'Manager'].includes(localStorage.getItem('role'))

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

                    let actions = `<button class="btn btn-sm btn-secondary updateJobs" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    if (canUpdate && ['AVAILABLE', 'UNAVAILABLE'].includes(element['status'])) {
                        checked = (element['status'] === 'AVAILABLE' ? 'checked' : '')
                        actions += `&nbsp;&nbsp;<input class="form-check-input form-switch availability" type="checkbox" role="switch" data-id="${element['id']}" ${checked}><small> Availability</small>`
                    }

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['salary']}</td>
                            <td>${deadlineDate}</td>
                            <td>${element['job_applications_count']}</td>
                            <td>${actions}</td>
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
                let canUpdate = ['Admin', 'Manager'].includes(localStorage.getItem('role'))

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

                    let actions = `<button class="btn btn-sm btn-secondary updateJobs" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    if (canUpdate && ['AVAILABLE', 'UNAVAILABLE'].includes(element['status'])) {
                        checked = (element['status'] === 'AVAILABLE' ? 'checked' : '')
                        actions += `&nbsp;&nbsp;<input class="form-check-input form-switch availability" type="checkbox" role="switch" data-id="${element['id']}" ${checked}><small> Availability</small>`
                    }

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['salary']}</td>
                            <td>${deadlineDate}</td>
                            <td>${element['job_applications_count']}</td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('unavailable-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function getRestrictedJobs(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let canUpdate = ['Admin', 'Manager'].includes(localStorage.getItem('role'))

                let data = res.data['data']['data']

                if (res.data['data']['next_page_url']) {
                    document.getElementById('restricted-load-btn').innerHTML = `<button id="loadMoreRestricted" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMoreRestricted').click(async function () {
                        let url = $(this).data('url')

                        await getRestrictedJobs(url)
                    })
                } else {
                    document.getElementById('restricted-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    const deadline = new Date(element['deadline']);
                    const options = { year: 'numeric', month: 'short', day: 'numeric'};
                    const deadlineDate = deadline.toLocaleString('en-US', options);

                    let actions = `<button class="btn btn-sm btn-secondary updateJobs" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['salary']}</td>
                            <td>${deadlineDate}</td>
                            <td>${element['restrictionFeedback']}</td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('restricted-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function update() {
            let id = document.getElementById('updateID').value
            let job_category_id = document.getElementById('updateCat').value
            let title = document.getElementById('updateTitle').value
            let description = document.getElementById('updateDescription').value
            let skills = document.getElementById('updateSkills').value
            let salary = document.getElementById('updateSalary').value
            let type = document.getElementById('updateType').value
            let deadline = document.getElementById('updateDeadline').value

            showLoader()
            let res = await axios.post(`{{ url('/api/job/') }}/${id}`, {
                job_category_id : job_category_id,
                title : title,
                description : description,
                skills : skills,
                salary : salary,
                type : type,
                deadline : deadline,
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])
                document.getElementById('updateClose').click()

                reset()
                await get()
            } else {
                alert(res.data['message'])
            }
        }

        async function create() {
            let job_category_id = document.getElementById('createCat').value
            let title = document.getElementById('createTitle').value
            let description = document.getElementById('createDescription').value
            let skills = document.getElementById('createSkills').value
            let salary = document.getElementById('createSalary').value
            let type = document.getElementById('createType').value
            let deadline = document.getElementById('createDeadline').value

            showLoader()
            let res = await axios.post("{{ route('job.create') }}", {
                job_category_id : job_category_id,
                title : title,
                description : description,
                skills : skills,
                salary : salary,
                type : type,
                deadline : deadline,
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])
                document.getElementById('createClose').click()

                reset()
                await get()
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
