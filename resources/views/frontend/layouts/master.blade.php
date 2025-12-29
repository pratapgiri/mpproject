<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'WJAM')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS --}}
    <link href="{{ asset('public/assetss/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assetss/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assetss/css/styleddaa.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assetss/css/new-style6482.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assetss/css/responsive.css') }}" rel="stylesheet">

    @stack('styles')
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-109229661-3');
  </script>

</head>

<body>
  <!---/.Header start-->
  <div class="side-logo-sec">
    <img style="padding: 7px; border-radius: 3px;" src="{{ asset('public/assetss/images/img/issn-logo.png')}}">

    <div class="icon-box">
      <a href="#"><img src="{{ asset('public/assetss/images/img/paper_plane.png')}}"> Make a
        Submission</a>
    </div>

    <div class="icon-box">
      <a href="#"><img src="{{ asset('public/assetss/images/img/microphone.png')}}"> Current
        Issues</a>
    </div>

    <div class="icon-box">
      <a href="article_abstract/index.html"><img src="{{ asset('public/assetss/images/img/download_article.png')}}"> Download
        Article</a>
    </div>

    <div class="icon-box">
      <a href="indexing.html"><img src="{{ asset('public/assetss/images/img//indexing.png')}}">
        Indexing </a>
    </div>
  </div>




@include('frontend.layouts.header')

@yield('content')

{{-- FOOTER --}}
<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="foot-sec d-flex">
                    <div class="designedby">
                        Powered By <a href="http://jrma.com/">WJAM</a> | All Right Reserved
                    </div>

                    <div class="counters">
                        <img src="http://counter5.01counter.com/private/freecounterstat.php?c=bfb29f54580cbbcedda887e079cbf7d7"
                             alt="wjam">
                    </div>

                    <div class="social-media">
                        <img src="{{ asset('public/assetss/images/bg/footer_icon.png') }}" usemap="#Map">
                        <map name="Map">
                            <area shape="rect" coords="101,3,127,27" href="http://facebook.com/" target="_blank">
                            <area shape="rect" coords="137,3,161,24" href="http://twitter.com/" target="_blank">
                            <area shape="rect" coords="172,3,195,24" href="http://linked.com/" target="_blank">
                        </map>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- CLOCK SCRIPT --}}
<script>
    const tday = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
    const tmonth = ["Jan","Feb","March","April","May","June","July","Aug","Sep","Oct","Nov","Dec"];

    function GetClock() {
        const d = new Date();
        let h = d.getHours(), m = d.getMinutes(), s = d.getSeconds();
        let ap = h >= 12 ? " PM" : " AM";
        h = h % 12 || 12;
        m = m < 10 ? "0"+m : m;
        s = s < 10 ? "0"+s : s;

        document.getElementById("clockbox").innerHTML =
            `${tday[d.getDay()]}, ${tmonth[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()} ${h}:${m}:${s}${ap}`;
    }

    window.onload = function () {
        GetClock();
        setInterval(GetClock, 1000);
    };
</script>

{{-- JS --}}
<script src="{{ asset('public/assetss/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/assetss/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/assetss/js/scripts.js') }}"></script>
<script src="{{ asset('public/assetss/js/main.js') }}"></script>

@stack('scripts')

</body>
</html>
