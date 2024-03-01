@extends('layouts.dashboard')

@section('content')

    <div class="pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between">
                <h5 class="mb-4">Companies</h5>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending" type="button" role="tab" aria-controls="nav-pending" aria-selected="true">Pending</button>
                    <button class="nav-link" id="nav-active-tab" data-bs-toggle="tab" data-bs-target="#nav-active" type="button" role="tab" aria-controls="nav-active" aria-selected="false">Active</button>
                    <button class="nav-link" id="nav-restricted-tab" data-bs-toggle="tab" data-bs-target="#nav-restricted" type="button" role="tab" aria-controls="nav-restricted" aria-selected="false">Restricted</button>
                </div>
            </nav>
            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                    <table class="table">
                        <thead>
                            <th>Company</th>
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
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="active-wrapper"></tbody>
                    </table>
                    <div id="active-load-btn"></div>
                </div>
                <div class="tab-pane fade" id="nav-restricted" role="tabpanel" aria-labelledby="nav-restricted-tab">
                    <table class="table">
                        <thead>
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Company Information</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">
                                    <div class="mb-3 d-flex justify-content-center">
                                        <img id="logo" class="rounded-circle mb-2" height="200px" width="200px" src="" alt="">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Company Name: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="name"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Address: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="address"></b>
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
                                            <span>Contact: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="contact"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Email: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="email"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Website: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="website"></b>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <span>Establish Date: </span>
                                        </div>
                                        <div class="col-md-9">
                                            <b id="establishDate"></b>
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
            await getPendingCompanies("{{ url('/api/jobs-pulse/admin/company') }}/pending")
            await getActiveCompanies("{{ url('/api/jobs-pulse/admin/company') }}/active")
            await getRestrictedCompanies("{{ url('/api/jobs-pulse/admin/company') }}/restricted")

            $('.viewCompany').click(async function () {
                let id = $(this).data('id')

                showLoader()
                let res = await axios.get(`{{ url('/api/company') }}/${id}`)
                hideLoader()

                if (res.data['status'] === 'success') {
                    let data = res.data['data']

                    document.getElementById('logo').src = "{{ url('') }}" + '/' + data['logo']
                    document.getElementById('name').innerText = data['name']
                    document.getElementById('address').innerText = data['address']
                    document.getElementById('description').innerText = data['description']
                    document.getElementById('contact').innerText = data['contact']
                    document.getElementById('email').innerText = data['email']
                    document.getElementById('website').innerText = data['website']
                    document.getElementById('establishDate').innerText = data['establishDate']
                    document.getElementById('status').innerText = data['status']
                    document.getElementById('restrictionFeedback').innerText = (data['status'] === 'RESTRICTED' ? data['restrictionFeedback'] : '')

                    $('#detail-modal').modal('show')
                } else {
                    alert(res.data['message'])
                }
            })

            $('.approve').click(async function () {
                let id = $(this).data('id')

                showLoader()
                let res = await axios.post(`{{ route('company.approve') }}`, {id : id})
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

                document.getElementById('id').value = id

                $('#restrict-modal').modal('show')
            })
        }

        function reset() {
            document.getElementById('pending-wrapper').innerHTML = ''
            document.getElementById('active-wrapper').innerHTML = ''
            document.getElementById('restricted-wrapper').innerHTML = ''
        }

        async function getPendingCompanies(url) {
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

                        await getPendingCompanies(url)
                    })
                } else {
                    document.getElementById('pending-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    let actions = `<button class="btn btn-sm btn-primary viewCompany" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    actions += canUpdate ? `&nbsp;&nbsp;<button class="btn btn-sm btn-success approve" data-id="${element['id']}">Approve</button>&nbsp;&nbsp;<button class="btn btn-sm btn-danger restrict" data-id="${element['id']}">Restrict</button>` : ''

                    let content = `<tr class="p-3">
                            <td>${element['name']}</td>
                            <td><span class="badge bg-secondary">${element['status']}</span></td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('pending-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function getActiveCompanies(url) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                let canUpdate = ['Site Admin', 'Site Manager'].includes(localStorage.getItem('role'))

                let data = res.data['data']['data']

                if (res.data['data']['next_page_url']) {
                    document.getElementById('active-load-btn').innerHTML = `<button id="loadMoreActive" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMoreActive').click(async function () {
                        let url = $(this).data('url')

                        await getActiveCompanies(url)
                    })
                } else {
                    document.getElementById('active-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    let actions = `<button class="btn btn-sm btn-primary viewCompany" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    actions += canUpdate ? `&nbsp;&nbsp;<button class="btn btn-sm btn-danger restrict" data-id="${element['id']}">Restrict</button>` : ''

                    let content = `<tr class="p-3">
                            <td>${element['name']}</td>
                            <td><span class="badge bg-success">${element['status']}</span></td>
                            <td>${actions}</td>
                        </tr>`

                    document.getElementById('active-wrapper').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function getRestrictedCompanies(url) {
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

                        await getRestrictedCompanies(url)
                    })
                } else {
                    document.getElementById('restricted-load-btn').innerHTML = ''
                }

                data.forEach(element => {
                    let actions = `<button class="btn btn-sm btn-primary viewCompany" data-id="${element['id']}"><i class="fas fa-eye"></i></button>`

                    actions += canUpdate ? `&nbsp;&nbsp;<button class="btn btn-sm btn-success approve" data-id="${element['id']}">Approve</button>` : ''

                    let content = `<tr class="p-3">
                            <td>${element['name']}</td>
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
            let restrictionFeedback = document.getElementById('restrictionReason').value

            showLoader()
            let res = await axios.post(`{{ route('company.restrict') }}`, {
                id : id,
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

    </script>

@endpush
