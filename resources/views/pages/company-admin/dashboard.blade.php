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
            let res = await axios.get("{{ route('company.overview') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                data = res.data['data']

                let content = `
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Jobs Posted</p>
                                        <h6 class="mb-0">${data['posted']}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-hourglass fa-3x text-primary"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Pending</p>
                                        <h6 class="mb-0">${data['pending']}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-check fa-3x text-success"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Available</p>
                                        <h6 class="mb-0">${data['available']}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-times fa-3x text-info"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Unavailable</p>
                                        <h6 class="mb-0">${data['unavailable']}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-exclamation-triangle fa-3x text-danger"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Restricted</p>
                                        <h6 class="mb-0">${data['restricted']}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                    <i class="fa fa-users fa-3x text-secondary"></i>
                                    <div class="ms-3">
                                        <p class="mb-2">Employees</p>
                                        <h6 class="mb-0">${data['employees']}</h6>
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
