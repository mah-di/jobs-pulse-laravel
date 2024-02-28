@extends('layouts.app')

@section('main')

    <!-- job post company Start -->
    <div class="job-post-company pt-120 pb-120">
        <div class="container">
            <div id="wrapper" class="row justify-content-between">
                <!-- Left Content -->
                <div class="col-xl-7 col-lg-8">
                    <!-- job single -->
                    <div class="single-job-items mb-50">
                        <div class="job-items">
                            <div class="company-img company-img-details">
                                <a class="company-link"><img height="85px" width="85px" id="company-logo" alt=""></a>
                            </div>
                            <div class="job-tittle">
                                    <h4 id="job-title"></h4>
                                <ul>
                                    <a class="company-link"><b><li id="company-name-1"></li></b></a>
                                    <li><i class="fas fa-map-marker-alt"></i><span id="company-address"></span></li>
                                    <li>$<span id="salary-1"></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                      <!-- job single End -->

                    <div class="job-post-details">
                        <div class="post-details1 mb-50">
                            <!-- Small Section Tittle -->
                            <div class="small-section-tittle">
                                <h4>Job Description</h4>
                            </div>
                            <p id="job-description"></p>
                        </div>
                    </div>

                </div>
                <!-- Right Content -->
                <div class="col-xl-4 col-lg-4">
                    <div class="post-details3  mb-50">
                        <!-- Small Section Tittle -->
                       <div class="small-section-tittle">
                           <h4>Job Overview</h4>
                       </div>
                      <ul>
                          <li>Posted date : <span id="postDate"></span></li>
                          <li>Job nature : <span id="type"></span></li>
                          <li>Salary :  <span>$<span id="salary-2"></span> monthly</span></li>
                          <li>Application deadline : <span id="deadlineDate"></span></li>
                      </ul>

                        @if (auth()->user() and auth()->user()->role === 'Candidate')
                        <div class="apply-btn2">
                            <button class="btn" onclick="apply()">Apply Now</button>
                        </div>
                        @endif

                   </div>
                    <div class="post-details4  mb-50">
                        <!-- Small Section Tittle -->
                       <div class="small-section-tittle">
                           <h4>Company Information</h4>
                       </div>
                          <span id="company-name-2"></span>
                        <ul>
                            <li>Company: <a class="company-link"><span id="company-name-3"></span></a></li>
                            <li>Contact: <span id="company-contact"></span></li>
                            <li>Website: <a id="website-link" href=""><span id="company-website"></span></a></li>
                            <li>Email: <span id="company-email"></span></li>
                        </ul>
                   </div>
                </div>
            </div>
        </div>
    </div>
    <!-- job post company End -->

@endsection

@push('script')

    <script>

        getJob()

        async function getJob() {
            // Get the current URL
            const currentUrl = window.location.href;

            // Split the URL by '/'
            const urlParts = currentUrl.split('/');

            // Get the ID from the URL
            const jobId = urlParts[urlParts.length - 1];

            showLoader();
            // Make the API call using Axios
            let response = await axios.get(`{{ url('/api/job') }}/${jobId}`)
            hideLoader();

            if (response.data['status'] === 'success') {
                let job = response.data['data']
                let company = response.data['data']['company']

                if (job['status'] !== 'AVAILABLE') {
                    document.getElementById('wrapper').innerHTML = "<h2>This job is unavailable!</h2>"
                }

                const posted = new Date(job['created_at']);
                const deadline = new Date(job['deadline']);

                const options = { year: 'numeric', month: 'short', day: 'numeric'};

                const postDate = posted.toLocaleString('en-US', options);
                const deadlineDate = deadline.toLocaleString('en-US', options);

                document.getElementById('job-title').innerText = job['title']
                document.getElementById('job-description').innerText = job['description']
                document.getElementById('salary-1').innerText = job['salary']
                document.getElementById('salary-2').innerText = job['salary']
                document.getElementById('type').innerText = job['type']
                document.getElementById('postDate').innerText = postDate
                document.getElementById('deadlineDate').innerText = deadlineDate
                document.getElementById('company-logo').src = `{{ url('') }}/${company['logo']}`
                document.getElementById('company-name-1').innerText = company['name']
                document.getElementById('company-name-2').innerText = company['name']
                document.getElementById('company-name-3').innerText = company['name']
                document.getElementById('company-address').innerText = company['address']
                document.getElementById('company-contact').innerText = '+880' + company['contact']
                document.getElementById('company-email').innerText = company['email']
                document.getElementById('company-website').innerText = company['website']
                document.getElementById('website-link').href = company['website']

                let companyLinks = document.querySelectorAll('.company-link')

                companyLinks.forEach(link => {
                    link.href = `{{ url('/company') }}/${company['id']}`
                });
            }
        }

        async function apply() {
            const currentUrl = window.location.href;
            const urlParts = currentUrl.split('/');
            const jobId = urlParts[urlParts.length - 1];

            showLoader();
            let res = await axios.get(`{{ url('/api/job-application') }}/${jobId}`)
            hideLoader();

            if (res.data['status'] === 'success') {
                alert(res.data['message'])
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
