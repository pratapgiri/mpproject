@extends('frontend.layouts.master')

@section('title', 'WJAM | Home')

@section('content')

<div class="contante_wrapper">
    <div class="row">
      <div class="col-sm-3 smpadding01">

        <!---/.left panel start--->
        <section class="left-panel">

          <style>
            .head h2 a {
              color: #fff;
            }

            .head h2 img {
              width: auto !important;
            }
          </style>

          <div class="cover_page">
            <div class="head">
              <!--<h2>Cover</h2>-->

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

        <!---/.center panel start--->
        <section class="middile-panel">

          <div class="head">

            <h1>Contact us</h1>

          </div>

          <div class="text">

            <div class="d_contactus">

              <div class="innercen_panel"><!--Main Content -->

                <br>

                <!--<b style="font-size:16px;">For any query please contact on :</b><br/><br/><br/>-->

                <b style="font-size:20px; color:#0e2c34;">Office
                  Address:</b><br>
                <p class="cu_p">Taurusavenue 105, 2122 LS, Hoofddorp,
                  Netherlands</p>
                <br>

                <b style="font-size:20px;">Principal
                  Contact:</b><br>
                <p class="cu_p">Name: Sergey Garchenko</p>
                <p class="cu_p">Address: Taurusavenue 105, 2122 LS, Hoofddorp,
                  Netherlands</p>
                <p class="cu_p">Phone: +31 651220423</p>
                <p class="cu_p">Email: <a href="mailto:sergeygarchenko82@gmail.com">sergeygarchenko82@gmail.com</a></p>
                <br>

                <b style="font-size:20px; color:#0e2c34;">Support
                  Contact:</b><br>
                <p class="cu_p">Name: Sergey Garchenko</p>
                <p class="cu_p">Phone: +31 651220423</p>
                <p class="cu_p">Email: <a href="mailto:sergeygarchenko82@gmail.com">sergeygarchenko82@gmail.com</a></p>
                <br>

                <b style="font-size:20px; color:#0e2c34;">Email IDs :-</b><br>
                <p class="cu_p"><a href="mailto:editor.wjpmr@gmail.com">editor.wjam@gmail.com</a></p>
                <p class="cu_p"><a href="mailto:editor@wjpmr.com">editor@wjam.net</a></p>
                <br>

                <b style="font-size:20px; color:#0e2c34;">Website:-</b><br>
                <p class="cu_p"><a href="https://www.wjpmr.com/">
                    www.wjam.net</a></p>
                <br>

             

              </div>

            </div>

          </div>

        </section>
        <!---/.center panel End--->

      </div>

    </div>

  </div>

@endsection
