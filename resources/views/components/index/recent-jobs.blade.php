<section class="featured-job-area mb-30">
    <div class="container">
        <!-- Section Tittle -->
        <div class="row">
            <div class="col-lg-12">
                <div class="section-tittle text-center">
                    <h2>Recent Jobs</h2>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs" id="tab" role="tablist">
        </ul>
        <div class="tab-content mt-5" id="tabContent">
        </div>
    </div>
</section>

<script>

    // Function to fetch categories from the API
    async function fetchCategories(apiUrl) {
        try {
            showLoader()
            const response = await axios.get(apiUrl);
            hideLoader()
            return response.data['data'];
        } catch (error) {
            console.error('Error fetching categories:', error);
            return [];
        }
    }

    // Function to fetch jobs for a specific category from the API
    async function fetchJobsForCategory(categoryId) {
        try {
            showLoader()
            const response = await axios.get("{{ url('/api/job/latest') }}" + `/${categoryId}`);
            hideLoader()

            return response.data['data'];
        } catch (error) {
            console.error('Error fetching jobs for category:', error);
            return [];
        }
    }

    // Function to create tab links and corresponding tab panes for categories
    function createCategoryTabs(categories) {
        const tabContainer = document.getElementById('tab');

        categories.forEach((category, index) => {
            const listItem = document.createElement('li');
            listItem.classList.add('nav-item');

            const tabLink = document.createElement('a');
            tabLink.classList.add('nav-link', 'text-dark', 'tab-item');
            tabLink.setAttribute('data-toggle', 'tab');
            tabLink.setAttribute('href', `#${category.id}`);
            tabLink.setAttribute('role', 'tab');
            tabLink.setAttribute('aria-controls', category.id);
            tabLink.setAttribute('aria-selected', 'false');
            tabLink.textContent = category.name;

            tabLink.addEventListener('click', async () => {
            const jobs = await fetchJobsForCategory(category.id);
            populateTabPane(category.id, jobs);
            });

            listItem.appendChild(tabLink);
            tabContainer.appendChild(listItem);

            const tabPane = document.createElement('div');
            tabPane.classList.add('tab-pane', 'fade');
            tabPane.setAttribute('id', category.id);
            tabPane.setAttribute('role', 'tabpanel');
            tabPane.setAttribute('aria-labelledby', category.id);

            const tabContentContainer = document.getElementById('tabContent');
            tabContentContainer.appendChild(tabPane);
        });
    }

    // Function to create HTML string for badge element
    function createBadgeHTML(item) {
        return `<span onclick="searchSkill('${item}')" style="cursor: pointer" class="badge badge-primary mr-2 skill">${item}</span>`;
    }

    function searchSkill(skill) {
        let url = `{{ route('jobs.view') }}?skill=${skill}`;

        window.location.href = url;
    }

    // Function to populate a tab pane with job data
    function populateTabPane(tabId, jobs) {
        const tabPane = document.getElementById(tabId);
        tabPane.innerHTML = '';

        jobs.forEach(element => {
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
                        (canApply ? `<button onclick="saveJob('${element['id']}')" style="border:none;background-color: rgba(255, 255, 255, 0);padding:0;cursor:pointer" data-id="${element['id']}"><i class="far fa-1x fa-heart text-danger"></i></button>` : '')
                    + `</div>
                    <div class="items-link f-right">
                        <a href="{{ route('jobs.view') }}?type=${element['type'].toLowerCase()}">${element['type']}</a>` +
                        (canApply ? `<a href="{{ url('/job') }}/${element['id']}">Apply</a>` : '')
                        + `<small>Posted: ${postDate}</small><br>
                        <small>Deadline: ${deadlineDate}</small>
                    </div>
                </div>
            </div>`

            tabPane.innerHTML += card;
        });

        if (tabPane.innerHTML !== '') {
            tabPane.innerHTML += `<div class="items-link">
                                    <a href="{{ route('jobs.view') }}?category=${tabId}">View More</a>
                                </div>`
        }
    }

    async function saveJob(id) {
        showLoader()
        let res = await axios.get(`{{ url('/api/job/save') }}/${id}`)
        hideLoader()

        if (res.data['status'] === 'success') {
            alert(res.data['message'])
        } else {
            alert(res.data['message'])
        }
    }

    // Main function to initialize the process
    async function recentJobsInitialize() {
        const apiUrl = "{{ route('job.category.index') }}";
        const categories = await fetchCategories(apiUrl);
        createCategoryTabs(categories);

        document.querySelector('.tab-item').click()
    }

</script>
