@extends('layouts.dashboard')

@section('content')

    <div class="pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between">
                <h5 class="mb-4">Employees</h5>
                @if (auth()->user()->role === 'Admin')
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">Create Employee</button>
                @endif
            </div>
            <div class="pt-3">
                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        @if (auth()->user()->role !== 'Editor')
                        <th>Verified</th>
                        @endif
                        @if (auth()->user()->role === 'Admin')
                        <th>Action</th>
                        @endif
                    </thead>
                    <tbody id="employee-wrapper"></tbody>
                </table>
            </div>
        </div>
    </div>

    @if (auth()->user()->role === 'Admin')
    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Employee</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="bg-light g-4">
                                <div class="p-3">
                                    <div class="row">
                                        <div class="form-floating mb-3 col-md-6">
                                            <input type="text" class="form-control" id="firstName" placeholder="name@example.com">
                                            <label for="floatingInput">First Name *</label>
                                        </div>
                                        <div class="form-floating mb-3 col-md-6">
                                            <input type="text" class="form-control" id="lastName" placeholder="name@example.com">
                                            <label for="floatingInput">Last Name *</label>
                                        </div>
                                        <div class="form-floating mb-3 col-md-9">
                                            <input type="email" class="form-control" id="email" placeholder="name@example.com">
                                            <label for="floatingInput">Email *</label>
                                        </div>
                                        <div class="form-floating mb-3 col-md-3">
                                            <select class="form-select mb-3" id="employeeRole">
                                                <option>Select a Role</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Editor">Editor</option>
                                            </select>
                                            <label for="floatingInput">Role *</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="password" placeholder="name@example.com">
                                            <label for="floatingInput">Password *</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="cpassword" placeholder="name@example.com">
                                            <label for="floatingInput">Confirm Password *</label>
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
    </div>
    @endif

@endsection

@push('script')

    <script>

        getEmployees()

        async function getEmployees() {
            showLoader()
            let res = await axios.get(`{{ route('employee.index.by.company') }}`)
            hideLoader()

            document.getElementById('employee-wrapper').innerHTML = ''

            if (res.data['status'] === 'success') {
                let canAct = (localStorage.getItem('role') === 'Admin')
                let data = res.data['data']

                data.forEach(element => {
                    let action = (canAct && element['role'] !== 'Admin') ? `<td><button class="btn btn-sm btn-danger delete" data-id="${element['id']}">Delete</button></td>` : ''
                    let verified = (localStorage.getItem('role') !== 'Editor') ? `<td>` + (element['emailVerifiedAt'] ? '✅' : '❌') + `</td>` : ''

                    let content = `<tr class="p-3">
                            <td>
                                <img src="{{ url('') }}/${element['profile']['profileImg']}" class="rounded-circle" heignt="30px" width="30px">&nbsp;&nbsp;
                                ${element['profile']['firstName']} ${element['profile']['lastName']}
                            </td>
                            <td>${element['email']}</td>
                            ${verified}
                            <td>` +
                                ((canAct && element['role'] !== 'Admin')
                                    ? `<select class="form-control assignRole" data-id="${element['id']}">
                                            <option value="Admin">Admin</option>
                                            <option value="Manager" ` + (element['role'] === 'Manager' ? 'selected' : '') + `>Manager</option>
                                            <option value="Editor" ` + (element['role'] === 'Editor' ? 'selected' : '') + `>Editor</option>
                                        </select>`
                                    : `${element['role']}`)
                            + `</td>
                            ${action}
                        </tr>`

                    document.getElementById('employee-wrapper').innerHTML += content
                });

                $('.delete').click(async function () {
                    if (confirm("Are you sure you want to delete the employee?")) {
                        let id = $(this).data('id')

                        await deleteEmployee(id)
                    }
                })

                $('.assignRole').change(async function () {
                    let id = $(this).data('id')
                    let role = $(this).val()

                    if (confirm(`Are you sure you want to assign the role of "${role}" to this employee?`))
                    await assignRole(id, role)
                })

            } else {
                alert(res.data['message'])
            }
        }

        @if (auth()->user()->role === 'Admin')
        async function deleteEmployee(id) {
            showLoader()
            let res = await axios.delete(`{{ url('/api/employee') }}/${id}`)
            hideLoader()

            if (res.data['status'] === 'success') {
                await getEmployees()

                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }

        async function assignRole(id, role) {
            showLoader()
            let res = await axios.post(`{{ url('/api/employee') }}/${id}`, {role : role})
            hideLoader()

            if (res.data['status'] === 'success') {
                await getEmployees()

                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }

        async function create() {
            let firstName = document.getElementById('firstName').value
            let lastName = document.getElementById('lastName').value
            let email = document.getElementById('email').value
            let role = document.getElementById('employeeRole').value
            let password = document.getElementById('password').value
            let cpassword = document.getElementById('cpassword').value

            if (password !== cpassword) {
                alert("Passwords do not match!")
            }

            showLoader()
            let res = await axios.post("{{ route('employee.create') }}", {
                firstName : firstName,
                lastName : lastName,
                email : email,
                role : role,
                password : password,
            })
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                document.getElementById('createClose').click()

                await getEmployees()
            } else {
                alert(res.data['message'])
            }
        }
        @endif

    </script>

@endpush
