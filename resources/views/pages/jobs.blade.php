@extends('layouts.app')

@section('main')

    <!-- Hero Area Start-->
    <div class="slider-area ">
        <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="assets/img/hero/about.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Get your job</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->
    <!-- Job List Area Start -->
    <div class="job-listing-area pt-120">
        <div class="container">
            <div class="row">
                <!-- Left content -->
                <div class="col-xl-3 col-lg-3 col-md-4">
                    <div class="row">
                        <div class="col-12">
                                <div class="small-section-tittle2 mb-45">
                                <div class="ion"> <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="20px" height="12px">
                                <path fill-rule="evenodd"  fill="rgb(27, 207, 107)"
                                    d="M7.778,12.000 L12.222,12.000 L12.222,10.000 L7.778,10.000 L7.778,12.000 ZM-0.000,-0.000 L-0.000,2.000 L20.000,2.000 L20.000,-0.000 L-0.000,-0.000 ZM3.333,7.000 L16.667,7.000 L16.667,5.000 L3.333,5.000 L3.333,7.000 Z"/>
                                </svg>
                                </div>
                                <h4>Filter Jobs</h4>
                            </div>
                        </div>
                    </div>
                    <!-- Job Category Listing start -->
                    <div class=" mb-50" id="filterTab">
                        <!-- single one -->
                        <div class="">
                            <div class="small-section-tittle2">
                                <h4>Job Category</h4>
                            </div>
                            <!-- Select job items start -->
                            <div class="form-select">
                                <select style="display:block; width:100%; border:1px solid lightgray; padding:5px" name="select" id="selectCategory">
                                </select>
                            </div>
                            <!-- select-Categories End -->
                        </div>
                        <!-- single two -->
                        <div class="mt-4">
                            <div class="small-section-tittle2">
                                <h4>Job Type</h4>
                            </div>
                            <!-- Select job items start -->
                            <div class="form-select">
                                <select id="selectType" style="display:block; width:100%; border:1px solid lightgray; padding:5px" name="select">
                                    <option value="">Select An Option</option>
                                    <option value="on-site">On-Site</option>
                                    <option value="remote">Remote</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>
                            <!--  Select job items End-->
                        </div>
                    </div>
                    <!-- Job Category Listing End -->
                </div>
                <!-- Right content -->
                <div class="col-xl-9 col-lg-9 col-md-8">
                    <!-- Featured_job_start -->
                    <section class="featured-job-area">
                        <div id="jobsPanel" class="container">
                            <!-- Count of Job list Start -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="count-job mb-35">
                                        <span><i id="total"></i> Jobs found</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Count of Job list End -->
                        </div>
                    </section>
                    <!-- Featured_job_end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Job List Area End -->
    <!--Pagination Start  -->
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
    <!--Pagination End  -->

@endsection

@push('script')

    <script>

        if (window.location.search) {
            let clearFilterBtn = `<div class="mt-5"><button id="clearFilters" class="btn btn-lg" style="width:100%">Clear Filters</button></div>`

            document.getElementById('filterTab').innerHTML += clearFilterBtn

            $('#clearFilters').click(() => {
                window.location.href = "{{ route('jobs.view') }}"
            })
        }

        let url = constructUrl()

        $('#selectCategory').niceSelect('destroy');
        $('#selectType').niceSelect('destroy');

        getCategories().then(() => {
            const urlParams = new URLSearchParams(window.location.search);
            const catParam = urlParams.get('category');

            // If the "type" query parameter exists and matches one of the option values, set it as selected
            if (catParam) {
                const selectCat = document.getElementById('selectCategory');
                const optionCat = selectCat.querySelector(`option[value="${catParam}"]`);

                if (optionCat) {
                    optionCat.selected = true;
                }
            }

        })

        getData(url)

        function clearFilters(){

        }

        async function getCategories(){
            showLoader()
            let res = await axios.get("{{ route('job.category.index') }}")
            hideLoader()
            if (res.data['status'] === 'success') {
                let html = `<option value="">Select An Option</option>`

                res.data['data'].forEach(element => {
                    html += `<option value="${element['id']}">${element['name']}</option>`
                });

                document.querySelector('#selectCategory').innerHTML = html
            }
        }

        function constructUrl() {
            // Get the current window URL
            const windowUrl = window.location.href;
            const params = windowUrl.split('?')[1];
            // Extract the URL parameters
            const urlParams = new URLSearchParams(params);

            // Get the values of the parameters you need
            const category = urlParams.get('category');
            const type = urlParams.get('type');
            const skill = urlParams.get('skill');

            let route = "{{ route('job.search') }}"

            // Create the API URL
            const apiParams = new URLSearchParams();
            if (category) {
                apiParams.append('category', category);
            }
            if (type) {
                apiParams.append('type', type);
            }
            if (skill) {
                apiParams.append('skill', skill);
            }

            // Append the URL parameters to the API URL
            return `${route}?${apiParams.toString()}`;
        }

        function createBadgeHTML(item) {
            return `<span style="cursor: pointer" class="badge badge-primary mr-2 skill">${item}</span>`;
        }

        async function getData(url) {
            showLoader()
            let response = await axios.get(url);
            hideLoader()

            document.querySelector('#total').innerText = response.data['data']['total']

            document.querySelector('#paginate').innerHTML = ``
            if (response.data['data']['next_page_url']) {
                document.querySelector('#paginate').innerHTML = `<li class="page-item"><span id="loadMore" data-url="${response.data['data']['next_page_url']}" class="page-link">Load More</span></li>`

                $('#loadMore').click(() => {
                    let url = $('#loadMore').data('url')
                    getData(url)
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
                        <div class="items-link f-right">` +
                            (canApply ? `<a href="{{ url('/job') }}/${element['id']}">Apply</a>` : '')
                            + `<a href="{{ route('jobs.view') }}?type=${element['type'].toLowerCase()}">${element['type']}</a><small>Posted: ${postDate}</small><br>
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
                    const url = new URL(currentUrl);

                    // Update or append the query parameter with the selected value
                    url.searchParams.set('skill', skill);

                    // Redirect to the new URL
                    window.location.href = url.toString();
                });
            });

        }

        // Get the select element
        const selectType = document.getElementById('selectType');

        // Add event listener to the select element
        selectType.addEventListener('change', function() {
            // Get the selected value
            const selectedValue = this.value;

            if (selectedValue.length === 0) {
                return
            }

            // Get the current window URL
            const currentUrl = window.location.href;

            // Create a URL object
            const url = new URL(currentUrl);

            // Update or append the query parameter with the selected value
            url.searchParams.set('type', selectedValue);

            // Redirect to the new URL
            window.location.href = url.toString();
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Get the value of the "type" query parameter from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const typeParam = urlParams.get('type');

            // If the "type" query parameter exists and matches one of the option values, set it as selected
            if (typeParam) {
                const selectType = document.getElementById('selectType');
                const optionType = selectType.querySelector(`option[value="${typeParam}"]`);

                if (optionType) {
                    optionType.selected = true;
                }
            }
        });

        // Get the select element
        const selectCategory = document.getElementById('selectCategory');

        // Add event listener to the select element
        selectCategory.addEventListener('change', function() {
            // Get the selected value
            const selectedValue = this.value;

            if (selectedValue.length === 0) {
                return
            }

            // Get the current window URL
            const currentUrl = window.location.href;

            // Create a URL object
            const url = new URL(currentUrl);

            // Update or append the query parameter with the selected value
            url.searchParams.set('category', selectedValue);

            // Redirect to the new URL
            window.location.href = url.toString();
        });

    </script>

@endpush
