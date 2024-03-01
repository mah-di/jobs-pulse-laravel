@extends('layouts.dashboard')

@section('content')

    <div class="pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between">
                <h5 class="mb-4">Departments</h5>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">Create Department</button>
            </div>
            <div class="pt-3">
                <table class="table">
                    <thead>
                        <th>Name</th>
                        @if (auth()->user()->role !== 'Site Editor')
                        <th>Action</th>
                        @endif
                    </thead>
                    <tbody id="department-wrapper"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Department</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" placeholder="name@example.com">
                                        <label for="floatingInput">Name *</label>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-primary w-50" onclick="create()">Create</button>
                                        <button id="createClose" class="btn btn-danger w-50" data-bs-dismiss="modal" aria-label="Close">Close</button>
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

        getDepartments()

        async function getDepartments() {
            showLoader()
            let res = await axios.get(`{{ route('department.index') }}`)
            hideLoader()

            document.getElementById('department-wrapper').innerHTML = ''

            if (res.data['status'] === 'success') {
                let canDelete = ['Site Admin', 'Site Manager'].includes(localStorage.getItem('role'))
                let data = res.data['data']

                data.forEach(element => {
                    let action = canDelete ? `<td><button class="btn btn-sm btn-danger delete" data-id="${element}">Delete</button></td>` : ''

                    let content = `<tr class="p-3">
                            <td>${element}</td>
                            ${action}
                        </tr>`

                    document.getElementById('department-wrapper').innerHTML += content
                });

                $('.delete').click(async function () {
                    if (confirm("Are you sure you want to delete the department?")) {
                        let id = $(this).data('id')

                        await deleteDepartment(id)
                    }
                })

            } else {
                alert(res.data['message'])
            }
        }

        @if (auth()->user()->role !== 'Site Editor')
        async function deleteDepartment(id) {
            showLoader()
            let res = await axios.delete(`{{ url('/api/department') }}/${id}`)
            hideLoader()

            if (res.data['status'] === 'success') {
                await getDepartments()

                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }
        @endif

        async function create() {
            let name = document.getElementById('name').value

            showLoader()
            let res = await axios.post("{{ route('department.save') }}", {name : name})
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                document.getElementById('createClose').click()

                await getDepartments()
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
