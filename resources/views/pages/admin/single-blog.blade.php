@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light g-4">
            <div class="m-3 pt-3">
                <h3>Edit Pages - Single Blog Page</h3>
                <hr>
                <div class="form-floating mb-3">
                    <input type="text" class="d-none" id="coverImg">
                    <img id="display" class="mb-2" height="350px" width="100%" alt="">
                    <input oninput="display.src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="image">
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title" placeholder="name@example.com">
                    <label for="floatingInput">Page Title *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="categoryTitle" placeholder="name@example.com">
                    <label for="floatingInput">Category Title *</label>
                </div>
                <div class="pt-3 pb-4">
                    <button class="btn btn-primary w-100" onclick="save()">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>

        get()

        async function get() {
            showLoader()
            let res = await axios.get("{{ url('/api/page') }}/single-blog")
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                document.getElementById('display').src = "{{ url('') }}" + '/' + data['coverImg']
                document.getElementById('coverImg').value = data['coverImg']
                document.getElementById('title').value = data['title']
                document.getElementById('categoryTitle').value = data['description']['categoryTitle']
            } else {
                alert(res.data['message'])
            }
        }

        async function save() {
            let coverImg = document.getElementById('coverImg').value
            let image = document.getElementById('image').files[0] ?? null
            let title = document.getElementById('title').value
            let categoryTitle = document.getElementById('categoryTitle').value

            let data = new FormData()

            image !== null ? data.append('image', image) : null
            data.append('coverImg', coverImg)
            data.append('title', title)
            data.append('type', 'Single-Blog')
            data.append('categoryTitle', categoryTitle)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post("{{ route('page.save') }}", data, config)
            hideLoader()

            if (res.data['status'] === 'success') {
                alert(res.data['message'])

                await get()
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
