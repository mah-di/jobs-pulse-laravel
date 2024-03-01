@extends('layouts.app')

@section('main')

    <!-- Hero Area Start-->
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
    <!-- Hero Area End -->
    <!-- Support Company Start-->
    <div class="support-company-area fix section-padding2">
        <div class="container">
            <div class="section-tittle section-tittle2">
                <span id="subHeading"></span>
                <h2 id="heading"></h2>
            </div>
            <div class="support-caption">
                <p class="pera-top" id="shortDesc"></p>
                <p id="longDesc"></p>
                <a href="{{ route('company.jobs.view') }}" class="btn post-btn">Post a job</a>
            </div>
        </div>
    </div>
    <!-- Support Company End-->
    <!-- How  Apply Process Start-->
    <div class="apply-process-area apply-bg pt-150 pb-150" data-background="{{ asset('assets/img/gallery/how-applybg.png') }}">
        <div class="container">
            <!-- Section Tittle -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle white-text text-center">
                        <span>Apply process</span>
                        <h2> How it works</h2>
                    </div>
                </div>
            </div>
            <!-- Apply Process Caption -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-process text-center mb-30">
                        <div class="process-ion">
                            <span class="flaticon-search"></span>
                        </div>
                        <div class="process-cap">
                            <h5>1. Search a job</h5>
                        <p>Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-process text-center mb-30">
                        <div class="process-ion">
                            <span class="flaticon-curriculum-vitae"></span>
                        </div>
                        <div class="process-cap">
                            <h5>2. Apply for job</h5>
                        <p>Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single-process text-center mb-30">
                        <div class="process-ion">
                            <span class="flaticon-tour"></span>
                        </div>
                        <div class="process-cap">
                            <h5>3. Get your job</h5>
                        <p>Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- How  Apply Process End-->

    @include('components.main.top-companies')

@endsection

@push('script')

    <script>

        getAbout()
        getTopCompanies()

        async function getAbout() {
            showLoader()
            let res = await axios.get(`{{ url('/api/page') }}/about`)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                let div = document.getElementById('cover')
                div.style.backgroundImage = `url("{{ url('') }}/${data['coverImg']}")`

                document.getElementById('title').innerText = data['title']
                document.getElementById('subHeading').innerText = data['description']['subHeading']
                document.getElementById('heading').innerText = data['description']['heading']
                document.getElementById('shortDesc').innerText = data['description']['shortDesc']
                document.getElementById('longDesc').innerText = data['description']['longDesc']
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
