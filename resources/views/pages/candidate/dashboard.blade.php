@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div id="content-wrapper" class="row g-4">

        </div>
    </div>

@endsection

@push('script')

    <script>

        getApplications()

        async function getApplications() {
            showLoader()
            let res = await axios.get("{{ route('candidate.overview') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                data = res.data['data']

                let content = `
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Applied</p>
                                        <h6 class="mb-0">${data['applied']}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-check fa-3x text-success"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Selected</p>
                                        <h6 class="mb-0">${data['accepted']}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-times fa-3x text-warning"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Rejected</p>
                                        <h6 class="mb-0">${data['rejected']}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-heart fa-3x text-danger"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Saved Jobs</p>
                                        <h6 class="mb-0">${data['savedJobs']}</h6>
                                    </div>
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
