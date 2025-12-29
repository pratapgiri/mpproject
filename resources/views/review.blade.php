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

<!--/.center panel start-->

<section class="middile-panel">

  <div class="head">

    <h1>Review Procedure</h1>

  </div>

  <div class="text">
    <div class="auther-instruction">

      <p><strong>World Journal of Advance Medicine (WJAM)</strong> Peer review process ensures that the quality
        Journal publishes good science which is of benefit to whole scientific community. Peer review is an
        integral part of scientific publication that confirms the authenticity of the science reported.</p>



      <p>After receiving a new manuscript, the editorial office will evaluate the article to confirm that the
        article is authentic, complete, ethically approved, correctly formatted, original research work,
        innovative, significance to the field, under the scope of the Journal, in the style of a scientific
        article and written in English language. If article has problems with any of the above criteria may be
        rejected.</p>

      <p><b>Double-Blind Peer Review Process</b></p>

      <p>Once an article manuscript is deemed suitable by the Editor(s)-in-Chief we follow the double-blind peer
        review process.</p>
      <p>In Double blind review process neither authors nor reviewers know each other's identities.</p>

      <p>Reviewers are given evaluation criteria and asked to provide comments to the author if any and may also
        provide feedback confidentially to the Editor office.</p>

      <p>Reviewers evaluate a manuscript for Originality and significance of contribution, Satisfactoriness of
        methodology, analysis, and comprehension, Interest to research community and International relevance.
      </p>

      <p>Once all reviews have been received, the Editor(s)-in-Chief, make reviews available to the author(s)
        and the comments to the author(s) of the manuscript</p>

      <p>If the manuscript is accepted, then the author will be provided with the formatting guidelines for
        final submission. If the manuscript requires substantial revisions, then the author will be expected to
        follow the reviewer’s commentary and also the formatting guidelines for the re-submission of the
        manuscript. If the manuscript is rejected, then the process ends.</p>
    </div>

  </div>
</section>

<!---/.center panel End--->

</div>

</div>
</div>
@endsection
