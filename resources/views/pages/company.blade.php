@extends('layouts.app')

@section('main')

    <div class="job-post-company pt-120">
        <div class="container">
            <div class="row justify-content-between">
                <!-- Left Content -->
                <div class="col-xl-7 col-lg-8">
                    <!-- job single -->
                    <div class="single-job-items mb-50">
                        <div class="job-items">
                            <div class="company-img company-img-details">
                                <img height="85px" width="85px" id="logo" src="" alt="">
                            </div>
                            <div class="job-tittle">
                                <h4 id="name-1"></h4>
                                <ul>
                                    <li><i class="fas fa-map-marker-alt"></i><span id="address"></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                      <!-- job single End -->

                    <div class="job-post-details">
                        <div class="post-details1 mb-50">
                            <!-- Small Section Tittle -->
                            <div class="small-section-tittle">
                                <h4>About Us</h4>
                            </div>
                            <p id="description"></p>
                        </div>
                    </div>

                </div>
                <!-- Right Content -->
                <div class="col-xl-4 col-lg-4">
                    <div class="post-details4  mb-50 mt-50">
                        <!-- Small Section Tittle -->
                       <div class="small-section-tittle">
                           <h4>Company Overview</h4>
                       </div>
                          <span id="name-2"></span>
                        <ul>
                            <li>Establish Date: <span id="establish"></span></li>
                            <li>Contact: <span id="contact"></span></li>
                            <li>Website: <span id="website"></span></li>
                            <li>Email: <span id="email"></span></li>
                            <li>Jobs Posted: <span id="jobsPosted"></span></li>
                        </ul>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <div class="job-listing-area pt-120">
        <div class="container">
            <section class="featured-job-area">
                <div id="jobsPanel" class="container">
                    <!-- Count of Job list Start -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="count-job mb-35">
                                <b>Open Jobs</b>
                            </div>
                        </div>
                    </div>
                    <!-- Count of Job list End -->
                </div>
            </section>
        </div>
    </div>

    <div class="pagination-area pb-55 text-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="single-wrap d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            <ul id="paginate" class="pagination justify-content-start">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>

        getCompany()


        async function getCompany() {
            // Get the current URL
            const currentUrl = window.location.href;

            // Split the URL by '/'
            const urlParts = currentUrl.split('/');

            // Get the ID from the URL
            const companyId = urlParts[urlParts.length - 1];

            showLoader();
            // Make the API call using Axios
            let response = await axios.get(`{{ url('/api/company') }}/${companyId}`)
            hideLoader();

            if (response.data['status'] === 'success') {
                let company = response.data['data']

                const establish = new Date(company['establishDate']);

                const options = { year: 'numeric', month: 'short', day: 'numeric'};

                const establishDate = establish.toLocaleString('en-US', options);

                document.getElementById('logo').src = `{{ url('') }}/${company['logo']}`
                document.getElementById('name-1').innerText = company['name']
                document.getElementById('name-2').innerText = company['name']
                document.getElementById('address').innerText = company['address']
                document.getElementById('description').innerText = company['description']
                document.getElementById('establish').innerText = establishDate
                document.getElementById('contact').innerText = '+880' + company['contact']
                document.getElementById('email').innerText = company['email']
                document.getElementById('website').innerText = company['website']
                document.getElementById('jobsPosted').innerText = company['jobsPosted']
            }

            await getJobs(`{{ url('/api/job/company') }}/${companyId}`)
        }

        function createBadgeHTML(item) {
            return `<span style="cursor: pointer" class="badge badge-primary mr-2 skill">${item}</span>`;
        }

        async function getJobs(url) {
            showLoader()
            let response = await axios.get(url);
            hideLoader()

            document.querySelector('#paginate').innerHTML = ``
            if (response.data['data']['next_page_url']) {
                document.querySelector('#paginate').innerHTML = `<li class="page-item"><span id="loadMore" data-url="${response.data['data']['next_page_url']}" class="page-link">Load More</span></li>`

                $('#loadMore').click(() => {
                    let url = $('#loadMore').data('url')
                    getJobs(url)
                })
            }

            response.data['data']['data'].forEach(element => {
                const posted = new Date(element['created_at']);
                const deadline = new Date(element['deadline']);

                const options = { year: 'numeric', month: 'short', day: 'numeric'};

                const postDate = posted.toLocaleString('en-US', options);
                const deadlineDate = deadline.toLocaleString('en-US', options);

                const trimmedString = element['skills'].trim().replace(/,$/, '');

                // Split the string into an array using commas as the delimiter
                const itemsArray = trimmedString.split(',');

                // Create HTML string for badges and append them to the container
                const badgesHTML = itemsArray.map(createBadgeHTML).join('');

                const canApply = localStorage.getItem('role') === 'Candidate'

                let card = `
                <!-- single-job-content -->
                <div class="single-job-items mb-30">
                    <div class="job-items overflow-hidden">
                        <div class="company-img">
                            <a href="{{ url('/job') }}/${element['id']}"><img src="{{ url('') }}/${element['company']['logo']}" alt="${element['company']['name']}" height="85px" width="85px"></a>
                            </div>
                            <div class="job-tittle">
                                <a href="{{ url('/job') }}/${element['id']}"><h4>${element['title']}</h4></a>
                                <ul>
                                    <li><a class="text-dark" href="{{ url('/company') }}/${element['company_id']}"><b>${element['company']['name']}</b></a></li>
                                    <li>$${element['salary']}</li>
                                </ul>
                                ${badgesHTML}
                            </div>
                        </div>
                        <div>` +
                            (canApply ? `<button class="saveJob" style="border:none;background-color: rgba(255, 255, 255, 0);padding:0;cursor:pointer" data-id="${element['id']}"><i class="far fa-1x fa-heart text-danger"></i></button>` : '')
                        + `</div>
                        <div class="items-link f-right">
                            <a href="{{ route('jobs.view') }}?type=${element['type'].toLowerCase()}">${element['type']}</a>` +
                            (canApply ? `<a href="{{ url('/job') }}/${element['id']}">Apply</a>` : '')
                            + `<small>Posted: ${postDate}</small><br>
                            <small>Deadline: ${deadlineDate}</small>
                        </div>
                    </div>
                </div>`

                document.querySelector('#jobsPanel').innerHTML += card
            });

            $('.saveJob').click(async function () {
                let id = $(this).data('id')

                showLoader()
                let res = await axios.get(`{{ url('/api/job/save') }}/${id}`)
                hideLoader()

                if (res.data['status'] === 'success') {
                    alert(res.data['message'])
                } else {
                    alert(res.data['message'])
                }
            })

            const skillElements = document.querySelectorAll('.skill');

            // Iterate over each skill element and attach the click event listener
            skillElements.forEach(skillElement => {
                skillElement.addEventListener('click', () => {
                    let skill = skillElement.innerText;

                    const currentUrl = window.location.href;

                    // Create a URL object
                    const url = new URL("{{ route('jobs.view') }}");

                    // Update or append the query parameter with the selected value
                    url.searchParams.set('skill', skill);

                    // Redirect to the new URL
                    window.location.href = url.toString();
                });
            });

        }

    </script>

@endpush
