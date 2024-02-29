@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div id="content-wrapper" class="row g-4">

        </div>
    </div>

@endsection

@push('script')

    <script>

        get()

        async function get() {
            await getPlugins()
            await getStatus()
        }

        async function getPlugins() {
            showLoader()
            let res = await axios.get("{{ route('plugin.index') }}")
            hideLoader()

            document.getElementById('content-wrapper').innerHTML = ''

            if (res.data['status'] === 'success') {
                data = res.data['data']

                data.forEach(element => {
                    let content = `
                                <div class="col-md-6">
                                    <div class="bg-light rounded p-4">
                                        <h6 class="mb-2">${element['title']}</h6>
                                        <div id="plugin-${element['id']}">
                                            <button class="btn btn-sm btn-success request" data-id=${element['id']}>Request Plugin</button>
                                        </div>
                                    </div>
                                </div>
                    `

                    document.getElementById('content-wrapper').innerHTML += content
                });

                $('.request').click(async function () {
                    let id = $(this).data('id')

                    showLoader()
                    let res = await axios.post("{{ route('company-plugin.save') }}", {plugin_id : id})
                    hideLoader()

                    if (res.data['status'] === 'success') {
                        alert(res.data['message'])

                        await get()
                    } else {
                        alert(res.data['message'])
                    }
                })

            } else {
                alert(res.data['message'])
            }
        }

        async function getStatus() {
            showLoader()
            let res = await axios.get(`{{ route('company-plugin.index.get') }}`)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                data.forEach(element => {
                    let content = `
                        <p>Status : <span class="badge bg-secondary">${element['status']}</span></p>
                    `

                    content += (element['status'] === 'REJECTED') ? `<p>${element['rejectionFeedback']}</p>` : ''

                    document.getElementById(`plugin-${element['plugin_id']}`).innerHTML = content
                });

            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
