<div class="our-services section-pad-t30">
    <div class="container">
        <!-- Section Tittle -->
        <div class="row">
            <div class="col-lg-12">
                <div class="section-tittle text-center">
                    <h2>Companies That Trusts Us</h2>
                </div>
            </div>
        </div>
        <div id="top-companies" class="row d-flex justify-contnet-center">
        </div>
    </div>
</div>

<script>

    async function getTopCompanies() {
        showLoader()
        let res = await axios.get("{{ route('company.top') }}")
        hideLoader()

        res.data['data'].forEach(element => {
            let card = `
                <div class="col-xl-2 col-lg-2 col-md-4">
                    <div class="single-services text-center mb-30">
                        <div class="services-ion d-flex align-items-center justify-content-center">
                            <a href="{{ url('/company') }}/${element['id']}"><img src="${element['logo']}" height="85px" width="85px" /></a>
                        </div>
                        <div class="services-cap">
                            <h5><a href="{{ url('/company') }}/${element['id']}">${element['name']}</a></h5>
                        </div>
                    </div>
                </div>
            `

            document.querySelector('#top-companies').innerHTML += card
        });
    }

</script>
