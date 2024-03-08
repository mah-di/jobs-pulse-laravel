@extends('layouts.app')

@section('main')

    <div class="slider-area ">
        <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="assets/img/hero/about.jpg" style="background-image: url(&quot;assets/img/hero/about.jpg&quot;);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Blog Details</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="blog_area single-post-area section-padding">
        <div class="container">
           <div class="row">
              <div class="col-lg-8 posts-list">
                 <div class="single-post">
                    <div class="feature-img">
                       <img class="img-fluid" id="coverImg" alt="">
                    </div>
                    <div class="blog_details">
                       <h2 id="title"></h2>
                       <ul class="blog-info-link mt-3 mb-4">
                          <li><a id="categoryLink" href="#"><i class="fa fa-user"></i> <span id="category"></span></a></li>
                          <li><i class="fa fa-calendar"></i> <span id="postDate"></span></li>
                       </ul>
                       <p id="body" class="excert"></p>
                    </div>
                 </div>
                 <div class="blog-author">
                    <div class="media align-items-center">
                       <img id="profileImg" alt="">
                       <div class="media-body">
                          <a href="#">
                             <h4 id="author"></h4>
                          </a>
                          <p><a id="company" class="text-dark"></a></p>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="col-lg-4">
                 <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Category</h4>
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

        getData()
        getCategories()

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

        async function getData() {
            let currentUrl = window.location.href;
            let urlParts = currentUrl.split('/');
            let blogId = urlParts[urlParts.length - 1];

            showLoader()
            let res = await axios.get(`{{ url('/api/blog') }}/${blogId}`)
            hideLoader()

            if (res.data['status'] === 'success') {
                let data = res.data['data']

                const posted = new Date(data['created_at']);

                const optionDate = {day: 'numeric', month: 'short', year: 'numeric'};

                const postDate = posted.toLocaleString('en-US', optionDate);

                document.getElementById('coverImg').src = `{{ url('') }}/${data['coverImg']}`
                document.getElementById('postDate').innerText = postDate
                document.getElementById('title').innerText = data['title']
                document.getElementById('body').innerText = data['body']
                document.getElementById('profileImg').src = `{{ url('') }}/${data['profile']['profileImg']}`
                document.getElementById('author').innerText = `${data['profile']['firstName']} ${data['profile']['lastName']}`
                document.getElementById('categoryLink').href = `{{ url('/blogs') }}?category=${data['category']['id']}`
                document.getElementById('category').innerText = data['category']['name']
                document.getElementById('company').innerText = (data['company'] !== null ? data['company']['name'] : "Jobs Pulse")
                document.getElementById('company').href = (data['company'] !== null ? `{{ url('/company') }}/${data['company']['id']}` : "{{ route('about.view') }}")
            } else {
                alert(res.data['message'])
            }
        }

    </script>

@endpush
