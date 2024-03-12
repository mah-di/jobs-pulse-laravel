@extends('layouts.dashboard')

@section('content')

    <div class="pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between">
                <h5 class="mb-4">Blogs</h5>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#create-modal">Create Blog</button>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-my-tab" data-bs-toggle="tab" data-bs-target="#nav-my" type="button" role="tab" aria-controls="nav-my" aria-selected="true">My Blogs</button>
                    <button class="nav-link" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="false">All Blogs</button>
                </div>
            </nav>
            <div class="tab-content pt-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-my" role="tabpanel" aria-labelledby="nav-my-tab">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Publish Date</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="my-wrapper"></tbody>
                    </table>
                    <div id="my-load-btn"></div>
                </div>
                <div class="tab-pane fade" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Publish Date</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="all-wrapper"></tbody>
                    </table>
                    <div id="all-load-btn"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Blog</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="bg-light g-4">
                            <div class="p-3">
                                <div class="form-floating mb-3">
                                    <select class="form-select mb-3" aria-label="Default select example" id="createCategory">
                                        <option value="">Select a Category</option>
                                    </select>
                                    <label for="floatingInput">Category *</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <img id="displayCreate" class="mb-2" height="100%" width="100%" src="{{ asset('assets/img/defaults/default-cover-image.jpg') }}" alt="">
                                    <input oninput="displayCreate.src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="createCoverImg">
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="createTitle" placeholder="name@example.com">
                                    <label for="floatingInput">Title *</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Details about the job" id="createBody" style="height: 250px;"></textarea>
                                    <label for="floatingInput">Body *</label>
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
                    <h5 class="modal-title" id="exampleModalLabel">Update Blog</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="bg-light g-4">
                            <div class="p-3">
                                <input id="updateID" type="text" class="d-none">
                                <div class="form-floating mb-3">
                                    <select class="form-select mb-3" aria-label="Default select example" id="updateCategory">
                                        <option value="">Select a Category</option>
                                    </select>
                                    <label for="floatingInput">Category *</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <img id="displayUpdate" class="mb-2" height="100%" width="100%" alt="">
                                    <input oninput="displayUpdate.src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="updateImage">
                                    <input type="text" class="d-none" id="updateCoverImg">
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="updateTitle" placeholder="name@example.com">
                                    <label for="floatingInput">Title *</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Details about the job" id="updateBody" style="height: 250px;"></textarea>
                                    <label for="floatingInput">Body *</label>
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-primary w-50" onclick="update()">Update</button>
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
        getMyBlogs()
        getAllBlogs()

        async function getBlogCategories() {
            showLoader()
            let res = await axios.get(`{{ route('blog.category.index') }}`)
            hideLoader()

            if (res.data['status'] === 'success') {
                res.data['data'].forEach(element => {
                    let content = `<option value="${element['id']}">${element['name']}</option>`

                    document.getElementById('createCategory').innerHTML += content
                    document.getElementById('updateCategory').innerHTML += content
                });
            } else {
                alert(res.data['message'])
            }
        }

        async function getMyBlogs(url = `{{ route('blog.index.by.user', auth()->user()->profile()->pluck('id')->first()) }}`) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (url === `{{ route('blog.index.by.user', auth()->user()->profile()->pluck('id')->first()) }}`) {
                document.getElementById('my-wrapper').innerHTML = ''
            }

            if (res.data['status'] === 'success') {
                if (res.data['data']['next_page_url']) {
                    document.getElementById('my-load-btn').innerHTML = `<button id="loadMoreMy" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMoreMy').click(async function () {
                        let url = $(this).data('url')

                        await getMyBlogs(url)
                    })
                } else {
                    document.getElementById('my-load-btn').innerHTML = ''
                }

                res.data['data']['data'].forEach(element => {
                    const posted = new Date(element['created_at']);

                    const optionDate = {year: 'numeric', month: 'short', day: 'numeric'};

                    const postDate = posted.toLocaleString('en-US', optionDate);

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['profile']['firstName']} ${element['profile']['lastName']}</td>
                            <td>${element['category']['name']}</td>
                            <td>${postDate}</td>
                            <td><a href="{{ url('/blog') }}/${element['id']}" class="btn btn-success"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;<button class="btn btn-primary update" data-id="${element['id']}">Update</button>&nbsp;&nbsp;<button class="btn btn-danger delete" data-id="${element['id']}">Delete</button></td>
                        </tr>`

                    document.getElementById('my-wrapper').innerHTML += content
                });

                $('.update').click(async function () {
                    let id = $(this).data('id')

                    showLoader()
                    let res = await axios.get(`{{ url('/api/blog') }}/${id}`)
                    hideLoader()

                    if (res.data['status'] === 'success') {
                        let data = res.data['data']

                        document.getElementById('updateID').value = data['id']
                        document.getElementById('updateCategory').value = data['blog_category_id']
                        document.getElementById('displayUpdate').src = `{{ url('') }}/${data['coverImg']}`
                        document.getElementById('updateCoverImg').value = data['coverImg']
                        document.getElementById('updateTitle').value = data['title']
                        document.getElementById('updateBody').value = data['body']

                        $('#update-modal').modal('show')
                    } else {
                        alert(res.data['message'])
                    }
                })

                $('.delete').click(async function  () {
                    let id = $(this).data('id')

                    if (confirm("Are you sure you want to delete this blog?")) {
                        showLoader()
                        let res = await axios.delete(`{{ url('/api/blog') }}/${id}`)
                        hideLoader()

                        if (res.data['status'] === 'success') {
                            alert(res.data['message'])
                        } else {
                            alert(res.data['message'])
                        }
                    }
                })
            } else {
                alert(res.data['message'])
            }
        }

        async function getAllBlogs(url = `{{ route('blog.index') }}`) {
            showLoader()
            let res = await axios.get(url)
            hideLoader()

            if (url === `{{ route('blog.index') }}`) {
                document.getElementById('all-wrapper').innerHTML = ''
            }

            if (res.data['status'] === 'success') {
                if (res.data['data']['next_page_url']) {
                    document.getElementById('all-load-btn').innerHTML = `<button id="loadMoreAll" class="btn btn-success w-100 rounded" data-url="${res.data['data']['next_page_url']}">Load More</button>`

                    $('#loadMoreAll').click(async function () {
                        let url = $(this).data('url')

                        await getAllBlogs(url)
                    })
                } else {
                    document.getElementById('all-load-btn').innerHTML = ''
                }

                res.data['data']['data'].forEach(element => {
                    const posted = new Date(element['created_at']);

                    const optionDate = {year: 'numeric', month: 'short', day: 'numeric'};

                    const postDate = posted.toLocaleString('en-US', optionDate);

                    let content = `<tr class="p-3">
                            <td>${element['title']}</td>
                            <td>${element['profile']['firstName']} ${element['profile']['lastName']}</td>
                            <td>${element['category']['name']}</td>
                            <td>${postDate}</td>
                            <td><a href="{{ url('/blog') }}/${element['id']}" class="btn btn-success"><i class="fa fa-eye"></i></a>` + ("{{ auth()->user()->role }}" === 'Site Admin' ? `&nbsp;&nbsp;<button class="btn btn-danger delete" data-id="${element['id']}">Delete</button>` : '') + `</td>
                        </tr>`

                    document.getElementById('all-wrapper').innerHTML += content
                });

                $('.delete').click(async function  () {
                    let id = $(this).data('id')

                    if (confirm("Are you sure you want to delete this blog?")) {
                        showLoader()
                        let res = await axios.delete(`{{ url('/api/blog') }}/${id}`)
                        hideLoader()

                        if (res.data['status'] === 'success') {
                            alert(res.data['message'])
                        } else {
                            alert(res.data['message'])
                        }
                    }
                })
            } else {
                alert(res.data['message'])
            }
        }

        async function update() {
            let id = document.getElementById('updateID').value
            let blog_category_id = document.getElementById('updateCategory').value
            let title = document.getElementById('updateTitle').value
            let body = document.getElementById('updateBody').value
            let coverImg = document.getElementById('updateCoverImg').value
            let image = document.getElementById('updateImage').files[0] ?? null

            if (blog_category_id.length === 0) {
                return alert("Plesae select a category.")
            }

            let data = new FormData()

            data.append('blog_category_id', blog_category_id)
            data.append('title', title)
            data.append('body', body)
            data.append('coverImg', coverImg)
            image !== null ? data.append('image', image) : null

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post(`{{ url('/api/blog') }}/${id}`, data, config)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                document.getElementById('updateClose').click()

                await getMyBlogs()
                await getAllBlogs()
            } else {
                alert(res.data['message'])
            }
        }

        async function create() {
            let blog_category_id = document.getElementById('createCategory').value
            let title = document.getElementById('createTitle').value
            let body = document.getElementById('createBody').value
            let image = document.getElementById('createCoverImg').files[0] ?? null

            if (blog_category_id.length === 0) {
                return alert("Plesae select a category.")
            }

            let data = new FormData()

            data.append('blog_category_id', blog_category_id)
            data.append('title', title)
            data.append('body', body)
            image !== null ? data.append('image', image) : null

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post(`{{ route('blog.create') }}`, data, config)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                document.getElementById('createClose').click()

                await getMyBlogs()
                await getAllBlogs()
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
