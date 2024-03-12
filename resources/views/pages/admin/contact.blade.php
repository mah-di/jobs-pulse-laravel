@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light g-4">
            <div class="m-3 pt-3">
                <h3>Edit Pages - Contact Page</h3>
                <hr>
                <div class="form-floating mb-3">
                    <input type="text" class="d-none" id="coverImg">
                    <img id="display" class="mb-2" height="350px" width="100%" src="" alt="">
                    <input oninput="display.src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="image">
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title" placeholder="name@example.com">
                    <label for="floatingInput">Page Title *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="heading" placeholder="name@example.com">
                    <label for="floatingInput">Heading *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="state" placeholder="name@example.com">
                    <label for="floatingInput">State *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="city" placeholder="name@example.com">
                    <label for="floatingInput">City *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="area" placeholder="name@example.com">
                    <label for="floatingInput">Area *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="house" placeholder="name@example.com">
                    <label for="floatingInput">House N/O *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="contact" placeholder="name@example.com">
                    <label for="floatingInput">Contact N/O *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="activeHours" placeholder="name@example.com">
                    <label for="floatingInput">Active Hours *</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                    <label for="floatingInput">Email *</label>
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
            let res = await axios.get("{{ url('/api/page') }}/contact")
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                document.getElementById('display').src = "{{ url('') }}" + '/' + data['coverImg']
                document.getElementById('coverImg').value = data['coverImg']
                document.getElementById('title').value = data['title']
                document.getElementById('heading').value = data['description']['heading']
                document.getElementById('state').value = data['description']['state']
                document.getElementById('city').value = data['description']['city']
                document.getElementById('area').value = data['description']['area']
                document.getElementById('house').value = data['description']['house']
                document.getElementById('contact').value = data['description']['contact']
                document.getElementById('activeHours').value = data['description']['activeHours']
                document.getElementById('email').value = data['description']['email']
            } else {
                alert(res.data['message'])
            }
        }

        async function save() {
            let coverImg = document.getElementById('coverImg').value
            let image = document.getElementById('image').files[0] ?? null
            let title = document.getElementById('title').value
            let heading = document.getElementById('heading').value
            let state = document.getElementById('state').value
            let city = document.getElementById('city').value
            let area = document.getElementById('area').value
            let house = document.getElementById('house').value
            let contact = document.getElementById('contact').value
            let activeHours = document.getElementById('activeHours').value
            let email = document.getElementById('email').value

            let data = new FormData()

            image !== null ? data.append('image', image) : null
            data.append('coverImg', coverImg)
            data.append('title', title)
            data.append('type', 'Contact')
            data.append('heading', heading)
            data.append('state', state)
            data.append('city', city)
            data.append('area', area)
            data.append('house', house)
            data.append('contact', contact)
            data.append('activeHours', activeHours)
            data.append('email', email)

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
