@extends('layouts.dashboard')

@section('content')

        <div class="container-fluid pt-4 px-4">
            <div class="bg-light g-4">
                <div class="m-3 pt-3">
                    <h3>Company Information</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="d-none" id="logoUrl">
                                <img id="display" class="rounded-circle mb-2" height="200px" width="200px" src="" alt="">
                                @if (auth()->user()->role !== 'Editor')
                                <input oninput="display.src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="logo">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="comName" placeholder="name@example.com"
                                @if (auth()->user()->role === 'Editor')
                                disabled
                                @endif
                                >
                                <label for="floatingInput">Company Name *</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="address" placeholder="name@example.com"
                                @if (auth()->user()->role === 'Editor')
                                disabled
                                @endif
                                >
                                <label for="floatingInput">Address *</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Details about the job" id="description" style="height: 150px;"
                                @if (auth()->user()->role === 'Editor')
                                disabled
                                @endif
                                ></textarea>
                                <label for="floatingInput">Description *</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="contact" placeholder="name@example.com"
                                @if (auth()->user()->role === 'Editor')
                                disabled
                                @endif
                                >
                                <label for="floatingInput">Contact *</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="email" placeholder="name@example.com"
                                @if (auth()->user()->role === 'Editor')
                                disabled
                                @endif
                                >
                                <label for="floatingInput">Email *</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="website" placeholder="name@example.com"
                                @if (auth()->user()->role === 'Editor')
                                disabled
                                @endif
                                >
                                <label for="floatingInput">Website</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="establishDate" placeholder="name@example.com"
                                @if (auth()->user()->role === 'Editor')
                                disabled
                                @endif
                                >
                                <label for="floatingInput">Establish Date *</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded p-1" style="background-color: #eeeeee">
                                <small>Status</small><br>
                                <span id="status"></span>
                            </div>
                        </div>
                        <div id="feedback-wrapper" class="col-md-12 d-none">
                            <div class="rounded p-1" style="background-color: #eeeeee">
                                <small>Restriction Feedback</small><br>
                                <span id="restrictionFeedback"></span>
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->role !== 'Editor')
                    <div class="pt-3 pb-4">
                        <button class="btn btn-primary w-100" onclick="update()">Save</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

@endsection

@push('script')

    <script>

        getCompany()

        async function getCompany() {
            showLoader()
            let res = await axios.get(`{{ url('/api/company') . '/' . auth()->user()->company_id }}`)
            hideLoader()

            if (res.data['status'] === 'success') {
                if (res.data['data'].length !== null) {
                    let data = res.data['data']

                    document.getElementById('display').src = `{{ url('') }}/${data['logo']}`
                    document.getElementById('logoUrl').value = data['logo']
                    document.getElementById('comName').value = data['name']
                    document.getElementById('address').value = data['address']
                    document.getElementById('description').value = data['description']
                    document.getElementById('contact').value = data['contact']
                    document.getElementById('email').value = data['email']
                    document.getElementById('website').value = data['website']
                    document.getElementById('establishDate').value = data['establishDate']
                    document.getElementById('status').innerText = data['status']

                    if (data['status'] === 'RESTRICTED') {
                        $('#feedback-wrapper').removeClass('d-none')
                        document.getElementById('restrictionFeedback').innerText = data['restrictionFeedback']
                    }
                }
            }
        }

        @if (auth()->user()->role !== 'Editor')
        async function update() {
            let logo = document.getElementById('logo').files[0] ?? null
            let logoUrl = document.getElementById('logoUrl').value
            let name = document.getElementById('comName').value
            let address = document.getElementById('address').value
            let description = document.getElementById('description').value
            let contact = document.getElementById('contact').value
            let email = document.getElementById('email').value
            let website = document.getElementById('website').value
            let establishDate = document.getElementById('establishDate').value

            let data = new FormData()

            logo !== null ? data.append('logo', logo) : null
            data.append('logoUrl', logoUrl)
            data.append('name', name)
            data.append('address', address)
            data.append('description', description)
            data.append('contact', contact)
            data.append('email', email)
            data.append('website', website)
            data.append('establishDate', establishDate)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post("{{ route('company.update') }}", data, config)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }
        @endif

    </script>

@endpush
