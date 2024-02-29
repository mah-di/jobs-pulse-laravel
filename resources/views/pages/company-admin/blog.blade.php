@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div id="content-wrapper" class="row g-4">

        </div>
    </div>

@endsection

@push('script')

    <script>

        check()

        async function check() {
            showLoader()
            let res = await axios.get(`{{ url('/api/company-plugin') }}/2/check`)
            hideLoader()

            if (res.data['status'] === 'success' && res.data['data'] === 1) {
                document.getElementById('content-wrapper').innerHTML = `<h2>Blog (Active)</h2>`
            } else {
                window.location.href = "{{ route('company.dashboard.view') }}"
            }
        }

    </script>

@endpush
