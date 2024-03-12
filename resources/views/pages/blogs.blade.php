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

    <section class="blog_area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar">
                        <div class="count-job mb-35">
                            <span><i id="total"></i> Blogs found <span id="catName"></span></span>
                        </div>
                        <div id="blogs-wrapper"></div>

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
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">

                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 id="categoryTitle" class="widget_title"></h4>
                            <ul id="catList" class="list cat-list">
                            </ul>
                        </aside>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')

    <script>

        getPageDetails()

        getCategories().then(() => {
            const urlParams = new URLSearchParams(window.location.search);
            const catParam = urlParams.get('category');

            if (catParam) {
                let catName = document.getElementById(`cat-${catParam}`).innerText
                document.getElementById('catName').innerHTML = `in <b>${catName}</b> Category`
            }

        })

        const url = constructUrl()

        getData(url)

        async function getPageDetails() {
            showLoader()
            let res = await axios.get(`{{ url('/api/page') }}/blogs`)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                let div = document.getElementById('cover')
                div.style.backgroundImage = `url("{{ url('') }}/${data['coverImg']}")`

                document.getElementById('title').innerText = data['title']
                document.getElementById('categoryTitle').innerText = data['description']['categoryTitle']
            }
        }

        async function getCategories(){
            showLoader()
            let res = await axios.get("{{ route('blog.category.index') }}")
            hideLoader()
            if (res.data['status'] === 'success') {
                let html = ''

                res.data['data'].forEach(element => {
                    html += `<li>
                                <a href="{{ route('blogs.view') }}?category=${element['id']}" class="d-flex">
                                    <p id="cat-${element['id']}">${element['name']}</p>
                                </a>
                            </li>`
                });

                document.querySelector('#catList').innerHTML = html
            }
        }

        function constructUrl() {
            const windowUrl = window.location.href;
            const params = windowUrl.split('?')[1];
            const urlParams = new URLSearchParams(params);

            const category = urlParams.get('category');

            let route = "{{ route('blog.index') }}"

            if (category) {
                route = `{{ url('') }}/api/blog/category/${category}`
            }

            return route;
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

                const optionDay = {day: 'numeric'};
                const optionMonth = {month: 'short'};

                const postDay = posted.toLocaleString('en-US', optionDay);
                const postMonth = posted.toLocaleString('en-US', optionMonth);

                let card = `
                <article class="blog_item">
                    <div class="blog_item_img">
                        <img class="card-img rounded-0" src="{{ url('') }}/${element['coverImg']}" alt="">
                        <a href="{{ url('/blog') }}/${element['id']}" class="blog_item_date">
                            <h3>${postDay}</h3>
                            <p>${postMonth}</p>
                        </a>
                    </div>

                    <div class="blog_details">
                        <a class="d-inline-block" href="{{ url('/blog') }}/${element['id']}">
                            <h2>${element['title']}</h2>
                        </a>
                        <p>${element['body'].slice(0, 50)}</p>
                        <ul class="blog-info-link">
                            <li><a href="{{ url('/blogs') }}?category=${element['category']['id']}"><i class="fa fa-user"></i>${element['category']['name']}</a></li>
                        </ul>
                    </div>
                </article>`

                document.querySelector('#blogs-wrapper').innerHTML += card
            });
        }

    </script>

@endpush
