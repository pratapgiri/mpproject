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

            <h1>Article Withdrawal & Refund Policy</h1>
          </div>
          <div class="text">

            <div class="d_contactus">
              <div class="innercen_panel"><!--Main Content -->
                <div class="entry-content">
                  <div class="col">


                    <p align="justify">World Journal of Pharmaceutical and Medical Research (WJPMR) is committed to
                      maintaining the integrity of the scholarly publication process while ensuring transparency and
                      fairness in its policies. This Article Withdrawal &amp; Refund Policy outlines the conditions
                      under which an article may be withdrawn and the associated refund procedures. By submitting an
                      article for consideration, the Corresponding Author acknowledges and agrees to abide by this
                      policy.</p>

                    <h3 class="heading-1 mt-3">Article Withdrawal Policy</h3>
                    <ol>
                      <li align="justify">
                        <strong>Formal Withdrawal Process:</strong><br>
                        Authors must not assume their manuscript has been withdrawn until they receive an official
                        <strong>Formal Withdrawal Confirmation Letter</strong> from World Journal of Pharmaceutical and
                        Medical Research (WJPMR). Without this confirmation, the journal retains the right to legally
                        object to the publication of the article in any other journal or platform.
                      </li>
                      <li align="justify">
                        <strong>Responsibility of Authors:</strong><br>
                        Submission of an article implies that the Corresponding Author has obtained consent from all
                        co-authors and relevant authorities (e.g., university, institution, employer, or research
                        committee) prior to submission. Any disputes arising from the lack of such consent will not
                        entitle authors to a refund or legal recourse against World Journal of Pharmaceutical and
                        Medical Research (WJPMR).
                      </li>
                      <li align="justify">
                        <strong>Post-Publication Actions:</strong><br>
                        If an article is found to violate copyright or ethical standards after publication, World
                        Journal of Pharmaceutical and Medical Research (WJPMR) reserves the right to remove the article
                        from its index without prior notice. In such cases, no refunds will be issued, and authors will
                        bear full responsibility for the consequences of their publication decision.
                      </li>
                    </ol>

                    <h3 class="heading-1 mt-3">Refund Policy</h3>
                    <ol>
                      <li align="justify">
                        <strong>Pre-Publication Refund Conditions:</strong><br>
                        <ul>
                          <li align="justify"><strong>APC Paid but Final Submission Pending:</strong> If the Article
                            Processing Charge (APC) has been paid but the final submission of the manuscript remains
                            incomplete, World Journal of Pharmaceutical and Medical Research (WJPMR) will deduct 50% of
                            the paid APC plus any applicable transaction charges. The remaining balance will be refunded
                            through feasible means determined by the journal.</li>
                          <li align="justify">Authors must notify World Journal of Pharmaceutical and Medical Research
                            (WJPMR) promptly to initiate the refund process in such cases.</li>
                        </ul>
                      </li>
                      <li align="justify">
                        <strong>No Refund After Final Submission or Publication:</strong><br>
                        If the APC has been paid and the final submission is completed, or if the article has already
                        been published, no refunds will be issued under any circumstances. This policy accounts for the
                        expenses incurred by World Journal of Pharmaceutical and Medical Research (WJPMR), including
                        article processing, reviewer remuneration, and logistics costs, which are borne promptly and in
                        good faith during the publication process.
                      </li>
                      <li align="justify">
                        <strong>Non-Refundable Scenarios:</strong><br>
                        <ul>
                          <li align="justify">Refunds will not be provided if an article is rejected by an author’s
                            university, institution, employer, project guide, supervisor, or research committee after
                            publication.</li>
                          <li align="justify">No refunds will be issued in cases where an article is withdrawn or
                            removed due to copyright infringement, ethical violations, or other breaches of World
                            Journal of Pharmaceutical and Medical Research (WJPMR)’s Terms and Conditions.</li>
                        </ul>
                      </li>
                    </ol>

                    <h3 class="heading-1 mt-3">General Provisions</h3>
                    <ul>
                      <li align="justify"><strong>Processing Costs:</strong> World Journal of Pharmaceutical and Medical
                        Research (WJPMR) incurs significant expenses to ensure timely and efficient publication
                        processes. As such, refunds are limited to the conditions outlined above to offset these costs.
                      </li>
                      <li align="justify"><strong>Author Acknowledgment:</strong> By submitting an article, authors
                        accept full responsibility for the outcomes of their publication decision and agree not to
                        pursue legal action or demand refunds from World Journal of Pharmaceutical and Medical Research
                        (WJPMR) or its affiliates for issues arising from withdrawal or non-publication.</li>
                      <li align="justify"><strong>Contact:</strong> For withdrawal requests or refund inquiries, authors
                        should contact the Editorial Team at <span class="contact">editor@ejpmr.com</span> with relevant
                        details.</li>
                    </ul>

                    <p align="left">Regards,</p>

                    <p align="left"><b>Editorial Team</b>, World Journal of Pharmaceutical and Medical Research (WJPMR)
                    </p>

                    <p align="left"><a href="https://www.ejpmr.com/"><b>www.ejpmr.com</b></a></p>

                 </div>

                </div>
              </div>
        </section>
      </div>
</div>
</div>
@endsection
