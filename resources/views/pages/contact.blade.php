@extends('layouts.app')

@section('main')

    <div class="slider-area ">
        <div id="cover" class="single-slider section-overly slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2 id="title"></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title" id="heading"></h2>
                </div>
                <div class="col-lg-8">
                    <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder=" Enter Message"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder="Enter Subject">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">Send</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3><span id="city"></span>, <span id="state"></span>.</h3>
                            <p><span id="area"></span>, <span id="house"></span></p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3 id="contact"></h3>
                            <p id="activeHours"></p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3 id="email"></h3>
                            <p>Send us your query anytime!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.main.top-companies')

@endsection

@push('script')

    <script>

        getContact()
        getTopCompanies()

        async function getContact() {
            showLoader()
            let res = await axios.get(`{{ url('/api/page') }}/contact`)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                let div = document.getElementById('cover')
                div.style.backgroundImage = `url("{{ url('') }}/${data['coverImg']}")`

                document.getElementById('title').innerText = data['title']
                document.getElementById('heading').innerText = data['description']['heading']
                document.getElementById('city').innerText = data['description']['city']
                document.getElementById('state').innerText = data['description']['state']
                document.getElementById('area').innerText = data['description']['area']
                document.getElementById('house').innerText = data['description']['house']
                document.getElementById('contact').innerText = data['description']['contact']
                document.getElementById('activeHours').innerText = data['description']['activeHours']
                document.getElementById('email').innerText = data['description']['email']
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
