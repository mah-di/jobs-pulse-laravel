@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Saved Jobs</h6>
                <div>
                    <button id="clearSaved" class="btn btn-outline-danger d-none">Clear Saved Jobs List</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Company</th>
                            <th scope="col">Job Title</th>
                            <th scope="col">Deadline Date</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Job Type</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="content-wrapper">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>

        getSavedJobs()

        async function getSavedJobs() {
            showLoader()
            let res = await axios.get("{{ route('saved.job.showAll') }}")
            hideLoader()

            if (res.data['status'] === 'success') {
                document.querySelector('#content-wrapper').innerHTML = ''
                let data = res.data['data']

                if (data.length > 0) {
                    let clearBtn = $('#clearSaved')
                    clearBtn.removeClass('d-none')
                    clearBtn.click(async function () {
                        showLoader()
                        let res = await axios.delete("{{ route('saved.job.deleteAll') }}")
                        hideLoader()

                        if (res.data['status'] === 'success') {
                            alert(res.data['message'])

                            await getSavedJobs()
                        } else {
                            alert(res.data['message'])
                        }
                    })
                } else {
                    $('#clearSaved').addClass('d-none')
                }

                data.forEach(element => {
                    const deadline = new Date(element['deadline']);

                    const options = { year: 'numeric', month: 'short', day: 'numeric'};

                    const deadlineDate = deadline.toLocaleString('en-US', options);

                    let content = `<tr>
                            <td><a href="{{ url('/company') }}/${element['company']['id']}">${element['company']['name']}</a></td>
                            <td><a href="{{ url('/job') }}/${element['id']}">${element['title'].slice(0, 30)}</a></td>
                            <td>${deadlineDate}</td>
                            <td>${element['salary']}</td>
                            <td>${element['type']}</td>
                            <td><button class="btn btn-sm btn-outline-warning delete-saved" data-id="${element['id']}">Remove</button></td>
                        </tr>`

                    document.querySelector('#content-wrapper').innerHTML += content
                });

                $('.delete-saved').click(async function () {
                    let jobId = $(this).data('id')
                    await deleteSaved(jobId)

                    await getSavedJobs()
                })

            } else {
                alert(res.data['message'])
            }
        }

        async function deleteSaved(jobId) {
            showLoader()
            let res = await axios.delete(`{{ url('/api/saved-jobs') }}/${jobId}`)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
