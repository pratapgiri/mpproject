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

        <!---/.center panel start--->

        <section class="middile-panel">

          <div class="head">

            <h1>Track Your Article</h1>
          </div>
          <div class="text">
            <nav>
            </nav>
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr class="trbg">
                    <th width="8%">SN.</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Kundlik</td>
                    <td>Research Article WJAM</td>
                    <td>Pending</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Santosh Kumar</td>
                    <td>Article Testing</td>
                    <td>Pending</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Kunal Deshmukh</td>
                    <td>EXTENDED RELEASE DRUG DELIVERY: BALANCING PHARMACOKINETICS, PATIENT COMPLIANCE, CURRENT
                      PERSPECTIVES AND ADVANCEMENTS IN EXTENDED-RELEASE TABLETS</td>
                    <td>Pending</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Shifa S. Hoble</td>
                    <td>Herbal Medicine and Infertility: An Integrative Approach to Reproductive Health</td>
                    <td>Pending</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Sayli R. Dabhade</td>
                    <td>ADR Reporting of Cyclophosphamide</td>
                    <td>Pending</td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <td>SHEHERBANU KHAN</td>
                    <td>DEVELOPMENT AND VALIDATION OF A UV SPECTROPHOTOMETRIC METHOD USING AREA UNDER THE CURVE FOR THE
                      SIMULTANEOUS ESTIMATION OF LOBEGLITAZONE SULPHATE AND DAPAGLIFLOZIN PROPANEDIOL MONOHYDRATE IN A
                      SYNTHET</td>
                    <td>Pending</td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td>YASH GAGARE</td>
                    <td>A Review On:-Anti-Diabetic Activity of Linagliptin by Using the RP-HPLC Method.</td>
                    <td>Pending</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <nav>
            </nav>
          </div>
        </section>
        <!---/.center panel End--->
      </div>
</div>
</div>
@endsection
