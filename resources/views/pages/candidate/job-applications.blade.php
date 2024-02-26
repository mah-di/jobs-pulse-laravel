@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-center mb-4">
                <h6 class="mb-0">Job Applications</h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Company</th>
                            <th scope="col">Job Title</th>
                            <th scope="col">Application Date</th>
                            <th scope="col">Deadline Date</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Job Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="content-wrapper">
                    </tbody>
                </table>
            </div>
        </div>
        <div id="paginate" class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-center mb-4"></div>
        </div>
    </div>

@endsection

@push('script')

    <script>

        getApplications("{{ route('candidate.job.application') }}")

        async function getApplications(url, reset = false) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (res.data['status'] === 'success') {
                if (reset === true) {
                    document.querySelector('#content-wrapper').innerHTML = ''
                }

                let data = res.data['data']['data']

                data.forEach(element => {
                    const applied = new Date(element['created_at']);
                    const deadline = new Date(element['job']['deadline']);

                    const options = { year: 'numeric', month: 'short', day: 'numeric'};

                    const appliedDate = applied.toLocaleString('en-US', options);
                    const deadlineDate = deadline.toLocaleString('en-US', options);

                    let content = `<tr>
                            <td><a href="{{ url('/company') }}/${element['job']['company']['id']}">${element['job']['company']['name']}</a></td>
                            <td><a href="{{ url('/job') }}/${element['job_id']}">${element['job']['title'].slice(0, 30)}</a></td>
                            <td>${appliedDate}</td>
                            <td>${deadlineDate}</td>
                            <td>${element['job']['salary']}</td>
                            <td>${element['job']['type']}</td>
                            <td>${element['status']}</td>
                            <td>` +
                                (element['status'] !== 'ACCEPTED' ? `<button class="btn btn-sm btn-danger delete-application" data-id="${element['id']}">Delete</button>` : '')
                            + `</td>
                        </tr>`

                    document.querySelector('#content-wrapper').innerHTML += content
                });

                if (res.data['data']['next_page_url']) {
                    document.querySelector('#paginate').innerHTML = `<div class="d-flex align-items-center justify-content-center mb-4">
                            <button id="loadMore" type="button" class="btn btn-success rounded-pill m-2" data-url="${res.data['data']['next_page_url']}">Load More</button>
                        </div>`

                    $('#paginate').removeClass('d-none')

                    $('#loadMore').click(async function () {
                        let url = $(this).data('url')
                        await getApplications(url)
                    })
                } else {
                    $('#paginate').addClass('d-none')
                }

                $('.delete-application').click(async function () {
                    if (confirm("Are yoy sure you want to delete this job application?")) {
                        let id = $(this).data('id')
                        await deleteApplication(id)

                        await getApplications("{{ route('candidate.job.application') }}", true)
                    }
                })

            } else {
                alert(res.data['message'])
            }
        }

        async function deleteApplication(id) {
            showLoader()
            let res = await axios.delete(`{{ url('/api/job-application') }}/${id}`)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
