@extends('layouts.dashboard')

@section('content')

    <div class="pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between">
                <h5 class="mb-4">Blog Categories</h5>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">Create Blog Category</button>
            </div>
            <div class="pt-3">
                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="blog-category-wrapper"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Blog Category</h5>
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

    <div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Blog Category</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="bg-light g-4">
                            <div class="p-3">
                                <div class="form-floating mb-3">
                                    <input type="text" class="d-none" id="updateID">
                                    <input type="text" class="form-control" id="updateName" placeholder="name@example.com">
                                    <label for="floatingInput">Name *</label>
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-primary w-50" onclick="update()">Create</button>
                                    <button id="updateClose" class="btn btn-danger w-50" data-bs-dismiss="modal" aria-label="Close">Close</button>
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

        getBlogCategories()

        async function getBlogCategories() {
            showLoader()
            let res = await axios.get(`{{ route('blog.category.index') }}`)
            hideLoader()

            document.getElementById('blog-category-wrapper').innerHTML = ''

            if (res.data['status'] === 'success') {
                let canDelete = ['Site Admin', 'Site Manager'].includes(localStorage.getItem('role'))
                let data = res.data['data']

                data.forEach(element => {
                    let action = `<td><button class="btn btn-sm btn-primary update" data-id="${element['id']}" data-name="${element['name']}">Update</button>`
                    action += canDelete ? `&nbsp;&nbsp;<button class="btn btn-sm btn-danger delete" data-id="${element['id']}">Delete</button></td>` : '</td>'

                    let content = `<tr class="p-3">
                            <td>${element['name']}</td>
                            ${action}
                        </tr>`

                    document.getElementById('blog-category-wrapper').innerHTML += content
                });

                $('.delete').click(async function () {
                    if (confirm("Are you sure you want to delete the blog category?")) {
                        let id = $(this).data('id')

                        await deleteBlogCategory(id)
                    }
                })

                $('.update').click(async function () {
                    let name = $(this).data('name')

                    document.getElementById('updateName').value = name

                    $('#update-modal').modal('show')
                })

            } else {
                alert(res.data['message'])
            }
        }

        @if (auth()->user()->role !== 'Site Editor')
        async function deleteBlogCategory(id) {
            showLoader()
            let res = await axios.delete(`{{ url('/api/blog-category') }}/${id}`)
            hideLoader()

            if (res.data['status'] === 'success') {
                await getBlogCategories()

                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }
        @endif

        async function update() {
            let name = document.getElementById('updateName').value

            showLoader()
            let res = await axios.post(`{{ route('blog.category.save') }}`, {name : name})
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                document.getElementById('updateClose').click()

                await getBlogCategories()
            } else {
                alert(res.data['message'])
            }
        }

        async function create() {
            let name = document.getElementById('name').value

            showLoader()
            let res = await axios.post("{{ route('blog.category.save') }}", {name : name})
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                document.getElementById('createClose').click()

                await getBlogCategories()
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
