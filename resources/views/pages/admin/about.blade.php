@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light g-4">
            <div class="m-3 pt-3">
                <h3>Edit Pages - About Page</h3>
                <hr>
                <div class="form-floating mb-3">
                    <input type="text" class="d-none" id="coverImg">
                    <img id="display" class="mb-2" height="350px" width="100%" src="{{ asset('') }}" alt="">
                    <input oninput="display.src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="image">
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title" placeholder="name@example.com">
                    <label for="floatingInput">Page Title *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="subHeading" placeholder="name@example.com">
                    <label for="floatingInput">Sub Heading *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="heading" placeholder="name@example.com">
                    <label for="floatingInput">Heading *</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Details about the job" id="shortDesc" style="height: 150px;"></textarea>
                    <label for="floatingInput">Short Description *</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Details about the job" id="longDesc" style="height: 250px;"></textarea>
                    <label for="floatingInput">Long Description *</label>
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
            let res = await axios.get("{{ url('/api/page') }}/about")
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                document.getElementById('display').src = "{{ url('') }}" + '/' + data['coverImg']
                document.getElementById('coverImg').value = data['coverImg']
                document.getElementById('title').value = data['title']
                document.getElementById('subHeading').value = data['description']['subHeading']
                document.getElementById('heading').value = data['description']['heading']
                document.getElementById('shortDesc').value = data['description']['shortDesc']
                document.getElementById('longDesc').value = data['description']['longDesc']
            } else {
                alert(res.data['message'])
            }
        }

        async function save() {
            let coverImg = document.getElementById('coverImg').value
            let image = document.getElementById('image').files[0] ?? null
            let title = document.getElementById('title').value
            let subHeading = document.getElementById('subHeading').value
            let heading = document.getElementById('heading').value
            let shortDesc = document.getElementById('shortDesc').value
            let longDesc = document.getElementById('longDesc').value

            let data = new FormData()

            image !== null ? data.append('image', image) : null
            data.append('coverImg', coverImg)
            data.append('title', title)
            data.append('subHeading', subHeading)
            data.append('heading', heading)
            data.append('shortDesc', shortDesc)
            data.append('longDesc', longDesc)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader()
            let res = await axios.post("{{ route('page.about.save') }}", data, config)
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
