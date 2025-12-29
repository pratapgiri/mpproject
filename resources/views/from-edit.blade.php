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
          <p> We glad to announce that the World Journal of Advance Medicine (WJAM) Scientific Journals were developed
            with the aim to assist researchers to grow at all levels - research scholars, scientists, professors,
            post-docs and students who are seeking publishing opportunities for their research work.
            The journals aim to publish a broad ranging open access journal, Eminent editorials from thought out the
            world, Fast online submission, rapid publication High visibility, Expert peer-reviewed research that will
            serve to create a innovative information of the human .</p>
          <p>
            We are abstracted and indexed reputed international journals/publications.
          </p>
          <p>
            wjpps Journals inviting you to submit an manuscript which provides envisioned to publish high-quality,
            peer-reviewed research, reports, review articles, technical briefs, Software review, datasets briefs,
            product news, company news, thesis report, book review and case study in all areas of Biological,
            Pharmaceutical and Chemical technology that will serve to create a holistic understanding of the human
            dimension in these society. We are inviting authors to send for the same".
          </p>
          <br />
          Editor In Chief<br />
        </section>
        <!---/.center panel End--->
      </div>
    </div>
  </div>

@endsection
