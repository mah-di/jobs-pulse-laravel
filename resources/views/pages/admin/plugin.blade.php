@extends('layouts.dashboard')

@section('content')

    <div class="pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between">
                <h5 class="mb-4">Plugins</h5>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending" type="button" role="tab" aria-controls="nav-pending" aria-selected="true">Pending</button>
                    <button class="nav-link" id="nav-active-tab" data-bs-toggle="tab" data-bs-target="#nav-active" type="button" role="tab" aria-controls="nav-active" aria-selected="false">Active</button>
                    <button class="nav-link" id="nav-rejected-tab" data-bs-toggle="tab" data-bs-target="#nav-rejected" type="button" role="tab" aria-controls="nav-rejected" aria-selected="false">Rejected</button>
                </div>
            </nav>
            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                    <table class="table">
                        <thead>
                            <th>Company</th>
                            <th>Plugin</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="pending-wrapper"></tbody>
                    </table>
                    <div id="pending-load-btn"></div>
                </div>
                <div class="tab-pane fade" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
                    <table class="table">
                        <thead>
                            <th>Company</th>
                            <th>Plugin</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="active-wrapper"></tbody>
                    </table>
                    <div id="active-load-btn"></div>
                </div>
                <div class="tab-pane fade" id="nav-rejected" role="tabpanel" aria-labelledby="nav-rejected-tab">
                    <table class="table">
                        <thead>
                            <th>Company</th>
                            <th>Plugin</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="rejected-wrapper"></tbody>
                    </table>
                    <div id="rejected-load-btn"></div>
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
                                            <span>Rejection Feedback: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <span id="rejectionFeedback"></span>
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

    <div class="modal animated zoomIn" id="reject-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reject Company</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="d-none" id="id">
                                        <textarea class="form-control" placeholder="Details about the job" id="rejectionReason" style="height: 150px;"></textarea>
                                        <label for="floatingInput">Rejection Reason *</label>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button id="rejectClose" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                        <button onclick="reject()" class="btn btn-success">Reject</button>
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
            await getPendingPlugins("{{ route('company-plugin.index') }}?status=pending")
            await getActivePlugins("{{ route('company-plugin.index') }}?status=active")
            await getRejectedPlugins("{{ route('company-plugin.index') }}?status=rejected")

            $('.approve').click(async function () {
                let id = $(this).data('id')

                showLoader()
                let res = await axios.post(`{{ route('company-plugin.approve') }}`, {id : id})
                hideLoader()

                if (res.data['status'] === 'success') {
                    alert(res.data['message'])

                    reset()
                    await get()
                } else {
                    alert(res.data['message'])
                }
            })

            $('.reject').click(async function () {
                let id = $(this).data('id')

                document.getElementById('id').value = id

                $('#reject-modal').modal('show')
            })
        }

        function reset() {
            document.getElementById('pending-wrapper').innerHTML = ''
            document.getElementById('active-wrapper').innerHTML = ''
            document.getElementById('rejected-wrapper').innerHTML = ''
        }

        async function getPendingPlugins(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']['data']

                if (res.data['data']['next_page_url']) {
                    document.getElementById('pending-load-btn').innerHTML = `<button id="loadMorePending" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMorePending').click(async function () {
                        let url = $(this).data('url')

                        await getPendingPlugins(url)
                    })
                } else {
                    document.getElementById('pending-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    let actions = `<button class="btn btn-sm btn-success approve" data-company-id="${element['company_id']}" data-id="${element['id']}">Approve</button>&nbsp;&nbsp;<button class="btn btn-sm btn-danger reject" data-company-id="${element['company_id']}" data-id="${element['id']}">Reject</button>`

                    let content = `<tr class="p-3">
                            <td>${element['company']['name']}</td>
                            <td>${element['plugin']['title']}</td>
                            <td><span class="badge bg-secondary">${element['status']}</span></td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('pending-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function getActivePlugins(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']['data']

                if (res.data['data']['next_page_url']) {
                    document.getElementById('active-load-btn').innerHTML = `<button id="loadMoreActive" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMoreActive').click(async function () {
                        let url = $(this).data('url')

                        await getActivePlugins(url)
                    })
                } else {
                    document.getElementById('active-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    let actions = `<button class="btn btn-sm btn-danger reject" data-company-id="${element['company_id']}" data-id="${element['id']}">Reject</button>`

                    let content = `<tr class="p-3">
                            <td>${element['company']['name']}</td>
                            <td>${element['plugin']['title']}</td>
                            <td><span class="badge bg-success">${element['status']}</span></td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('active-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function getRejectedPlugins(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']['data']

                if (res.data['data']['next_page_url']) {
                    document.getElementById('rejected-load-btn').innerHTML = `<button id="loadMoreRejected" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMoreRejected').click(async function () {
                        let url = $(this).data('url')

                        await getRejectedPlugins(url)
                    })
                } else {
                    document.getElementById('rejected-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    let actions = `<button class="btn btn-sm btn-success approve" data-company-id="${element['company_id']}" data-id="${element['id']}">Approve</button>`

                    let content = `<tr class="p-3">
                            <td>${element['company']['name']}</td>
                            <td>${element['plugin']['title']}</td>
                            <td><span class="badge bg-danger">${element['status']}</span></td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('rejected-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function reject () {
            let id = document.getElementById('id').value
            let rejectionFeedback = document.getElementById('rejectionReason').value

            showLoader()
            let res = await axios.post(`{{ route('company-plugin.reject') }}`, {
                id : id,
                rejectionFeedback : rejectionFeedback
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                $("#reject-modal").modal('hide')
                reset()
                await get()
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
