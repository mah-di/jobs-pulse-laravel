@extends('layouts.dashboard')

@section('content')

    <div class="pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between">
                <h5 class="mb-4">Jobs</h5>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending" type="button" role="tab" aria-controls="nav-pending" aria-selected="true">Pending</button>
                    <button class="nav-link" id="nav-available-tab" data-bs-toggle="tab" data-bs-target="#nav-available" type="button" role="tab" aria-controls="nav-available" aria-selected="false">Available</button>
                    <button class="nav-link" id="nav-restricted-tab" data-bs-toggle="tab" data-bs-target="#nav-restricted" type="button" role="tab" aria-controls="nav-restricted" aria-selected="false">Restricted</button>
                </div>
            </nav>
            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Status</th>
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
                            <th>Company</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="available-wrapper"></tbody>
                    </table>
                    <div id="available-load-btn"></div>
                </div>
                <div class="tab-pane fade" id="nav-restricted" role="tabpanel" aria-labelledby="nav-restricted-tab">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="restricted-wrapper"></tbody>
                    </table>
                    <div id="restricted-load-btn"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal animated zoomIn" id="detail-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Job Information</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">
                                    <div class="mb-5 d-flex justify-content-center">
                                        <img id="logo" class="rounded-circle" height="48px" width="48px" src="" alt="">
                                        <h1 class="ps-4" id="name"></h1>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Job Title: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="title"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Description: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <span id="description"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Skills: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="skills"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Salary: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="salary"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Type: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="type"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Post Date: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="posted"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Deadline Date: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="deadline"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Status: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="status"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Restriction Feedback: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <span id="restrictionFeedback"></span>
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

    <div class="modal animated zoomIn" id="restrict-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Restrict Company</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="d-none" id="companyId">
                                        <input type="text" class="d-none" id="id">
                                        <textarea class="form-control" placeholder="Details about the job" id="restrictionReason" style="height: 150px;"></textarea>
                                        <label for="floatingInput">Restriction Reason *</label>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button id="restrictClose" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                        <button onclick="restrict()" class="btn btn-success">Restrict</button>
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
            await getPendingJobs("{{ url('/api/jobs-pulse/admin/job') }}/pending")
            await getAvailableJobs("{{ url('/api/jobs-pulse/admin/job') }}/available")
            await getRestrictedJobs("{{ url('/api/jobs-pulse/admin/job') }}/restricted")

            $('.viewJob').click(async function () {
                let id = $(this).data('id')

                showLoader()
                let res = await axios.get(`{{ url('/api/job') }}/${id}`)
                hideLoader()

                if (res.data['status'] === 'success') {
                    let data = res.data['data']

                    const posted = new Date(data['created_at'])
                    const deadline = new Date(data['deadline'])

                    const options = { year: 'numeric', month: 'short', day: 'numeric'}

                    const postDate = posted.toLocaleString('en-US', options)
                    const deadlineDate = deadline.toLocaleString('en-US', options)

                    const trimmedString = data['skills'].trim().replace(/,$/, '')
                    const itemsArray = trimmedString.split(',')
                    const skills = itemsArray.map(createBadgeHTML).join('')

                    document.getElementById('logo').src = "{{ url('') }}" + '/' + data['company']['logo']
                    document.getElementById('name').innerText = data['company']['name']
                    document.getElementById('title').innerText = data['title']
                    document.getElementById('description').innerText = data['description']
                    document.getElementById('salary').innerText = data['salary']
                    document.getElementById('type').innerText = data['type']
                    document.getElementById('skills').innerHTML = skills
                    document.getElementById('deadline').innerText = deadlineDate
                    document.getElementById('posted').innerText = postDate
                    document.getElementById('status').innerText = data['status']
                    document.getElementById('restrictionFeedback').innerText = (data['status'] === 'RESTRICTED' ? data['restrictionFeedback'] : '')

                    $('#detail-modal').modal('show')
                } else {
                    alert(res.data['message'])
                }
            })

            $('.approve').click(async function () {
                let id = $(this).data('id')
                let companyId = $(this).data('companyId')

                showLoader()
                let res = await axios.post(`{{ route('job.approve') }}`, {
                    id : id,
                    companyId : companyId,
                })
                hideLoader()

                if (res.data['status'] === 'success') {
                    alert(res.data['message'])

                    reset()
                    await get()
                } else {
                    alert(res.data['message'])
                }
            })

            $('.restrict').click(async function () {
                let id = $(this).data('id')
                let companyId = $(this).data('company-id')

                document.getElementById('id').value = id
                document.getElementById('companyId').value = companyId

                $('#restrict-modal').modal('show')
            })
        }

        function reset() {
            document.getElementById('pending-wrapper').innerHTML = ''
            document.getElementById('available-wrapper').innerHTML = ''
            document.getElementById('restricted-wrapper').innerHTML = ''
        }

        async function getPendingJobs(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let canUpdate = ['Site Admin', 'Site Manager'].includes(localStorage.getItem('role'))

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
                    let actions = `<button class="btn btn-sm btn-primary viewJob" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    actions += canUpdate ? `&nbsp;&nbsp;<button class="btn btn-sm btn-success approve" data-company-id="${element['company_id']}" data-id="${element['id']}">Approve</button>&nbsp;&nbsp;<button class="btn btn-sm btn-danger restrict" data-company-id="${element['company_id']}" data-id="${element['id']}">Restrict</button>` : ''

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['company']['name']}</td>
                            <td><span class="badge bg-secondary">${element['status']}</span></td>
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
                let canUpdate = ['Site Admin', 'Site Manager'].includes(localStorage.getItem('role'))

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
                    let actions = `<button class="btn btn-sm btn-primary viewJob" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    actions += canUpdate ? `&nbsp;&nbsp;<button class="btn btn-sm btn-danger restrict" data-company-id="${element['company_id']}" data-id="${element['id']}">Restrict</button>` : ''

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['company']['name']}</td>
                            <td><span class="badge bg-success">${element['status']}</span></td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('available-wrapper').innerHTML += content
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
                let canUpdate = ['Site Admin', 'Site Manager'].includes(localStorage.getItem('role'))

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
                    let actions = `<button class="btn btn-sm btn-primary viewJob" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    actions += canUpdate ? `&nbsp;&nbsp;<button class="btn btn-sm btn-success approve" data-company-id="${element['company_id']}" data-id="${element['id']}">Approve</button>` : ''

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['company']['name']}</td>
                            <td><span class="badge bg-danger">${element['status']}</span></td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('restricted-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function restrict () {
            let id = document.getElementById('id').value
            let companyId = document.getElementById('companyId').value
            let restrictionFeedback = document.getElementById('restrictionReason').value

            showLoader()
            let res = await axios.post(`{{ route('job.restrict') }}`, {
                id : id,
                companyId : companyId,
                restrictionFeedback : restrictionFeedback
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                $("#restrict-modal").modal('hide')
                reset()
                await get()
            } else {
                alert(res.data['message'])
            }
        }

        function createBadgeHTML(item) {
            return `<span class="badge bg-primary ms-2">${item}</span>`;
        }

    </script>

@endpush
