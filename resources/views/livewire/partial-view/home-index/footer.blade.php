<div>
    <footer id="footer" class="footer light-background">

        <div class="container">
            <div class="row gy-3">

                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-telephone icon"></i>
                    <div>
                        <h4>Kontak</h4>
                        <p>
                            <strong>Telepon:</strong> <span>{{$siteInfo['SITE_INFO_PHONE']}}</span><br>
                            <strong>Email:</strong> <span>{{$siteInfo['SITE_INFO_EMAIL']}}</span><br>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-geo-alt icon"></i>
                    <div class="address">
                        <h4>Alamat</h4>
                        <p>{{$siteInfo['SITE_INFO_ADDRESS']}}</p>
                        <p></p>
                    </div>
                </div>

                @if(!empty($siteSocMed))
                <div class="col-lg-3 col-md-6">
                    <h4>Sosial Media</h4>
                    <div class="social-links d-flex">
                        @foreach($siteSocMed as $sosmed)
                        <a target="_blank" href="{{$sosmed['url']}}"><i class="bi {{$sosmed['icon']}}"></i></a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Primsky IfTech.</strong> <span>All Rights Reserved</span></p>
        </div>

    </footer>
</div>