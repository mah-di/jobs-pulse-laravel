@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div id="content-wrapper" class="row g-4">

        </div>
    </div>

@endsection

@push('script')

    <script>

        getOverview()

        async function getOverview() {
            showLoader()
            let res = await axios.get("{{ route('admin.overview') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                data = res.data['data']

                let content = `
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded p-4">
                                    <p class="mb-2">Pending Companies</p>
                                    <h6 class="mb-0">${data['pendingCompanies']}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded p-4">
                                    <p class="mb-2">Active Companies</p>
                                    <h6 class="mb-0">${data['activeCompanies']}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded p-4">
                                    <p class="mb-2">Restricted Companies</p>
                                    <h6 class="mb-0">${data['restrictedCompanies']}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded p-4">
                                    <p class="mb-2">Pending Jobs</p>
                                    <h6 class="mb-0">${data['pendingJobs']}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded p-4">
                                    <p class="mb-2">Available Jobs</p>
                                    <h6 class="mb-0">${data['availableJobs']}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded p-4">
                                    <p class="mb-2">Site Admins</p>
                                    <h6 class="mb-0">${data['siteAdmins']}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded p-4">
                                    <p class="mb-2">Site Managers</p>
                                    <h6 class="mb-0">${data['siteManagers']}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded p-4">
                                    <p class="mb-2">Site Editors</p>
                                    <h6 class="mb-0">${data['siteEditors']}</h6>
                                </div>
                            </div>
                `

                document.getElementById('content-wrapper').innerHTML = content
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
