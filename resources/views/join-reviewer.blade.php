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
            <h1>From Editor Desk</h1>
          </div>
          <div class="text">
            <div class="d_archive">

              <p>
                <b>World Journal of Advance Medicine (WJAM)</b> Will be pleased to accept services of experts in various
                fields of Pharmacy i.e. Pharmaceutics, Pharmaceutical Technology, Biopharmaceutics, Pharmaceutical
                Chemistry, Pharmaceutical Analysis and Quality Assurance, Medicinal Chemistry, Pharmacology and
                Toxicology, Pharmacy Practice includes Hospital Community and Clinical Pharmacy, Pharmacognosy and
                Phytochemistry, Pharmaceutical Microbiology and Biotechnology, Regulatory Affairs and Pharmaceutical
                Marketing Research, and Alternative Medicines as reviewers.
              </p>

              <p>
                One must have at least five years of experience in the relevant field after completion of the education
                in that field and at least three original research papers in journal. Please note that the acceptance of
                your application will be at the sole discretion of the editor. Please send your biodata with passport
                size photograph at <b>editor@wjam.net</b> or <b>editor.wjam@gmail.com</b>
              </p>

            </div>
          </div>
        </section>
        <!---/.center panel End--->
      </div>
    </div>
  </div>
@endsection
