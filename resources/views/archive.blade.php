@extends('frontend.layouts.master')

@section('title', 'WJAM | Home')

@section('content')
<style>
 
    .head h2 a {
              color: #fff;
            }

            .head h2 img {
              width: auto !important;
            } 
  </style>

  <div class="contante_wrapper">

<div class="row">

<div class="col-sm-3 smpadding01">
        <!---/.left panel start--->
        <section class="left-panel">
          <div class="cover_page">
            <div class="head">
              <h2 style="font-size:16px;"><a href="#" class="cd-popup-trigger">SJIF Impact Factor: 6.842</a> <img
                  src="{{ asset('public/assetss/images/new.gif')}}" /></h2>
            </div>
            <div><img src="{{ asset('public/assetss/images/cover.png')}}" /></div>
          </div>
          <!-- cd-popup-container -->
          <div class="cd-popup r1" role="alert">

            <div class="cd-popup-container">

              <img src="{{ asset('public/assetss/images/WJPMR_Impact_Factor.jpg')}}" />

              <a href="#0" class="cd-popup-close img-replace"></a>

            </div>

          </div>

          <!------------------->

        </section> <!---/.left panel End--->
      </div>

      <div class="col-sm-9">

<!--.center panel start-->

<section class="middile-panel">

  <div class="head">

    <h1>ARCHIVE</h1>

  </div>

  <div class="text">

    <div class="d_archive ">

      <div class="row">
        <div class="col-sm-12">

          <h4><a href="archive.html">Issue 2025</a></h4>

          <div class="archive-list">

            <ul>
              <li> <i class="fa fa-caret-right"></i> &nbsp; <a href="VOLUME-1-ISSUE-1.html"> VOLUME 1, ISSUE 1.
                </a> </li>

            </ul>

          </div>

        </div>
      </div>
    </div>

  </div>
</section>

<!--.center panel End-->

</div>
</div>
</div>
@endsection
