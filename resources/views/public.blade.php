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
            <h1>Publication Ethics</h1>
          </div>
          <div class="text">
            <div class="d_publication_ethics">

              <p class="mb-3">
                World Journal of Advance Medicine (WJAM) is electronic peer reviewed International Research Journal
                committed to upholding the highest standards of publication ethics. In order to provide our readers with
                a journal of highest quality we state the following principles of Publication Ethics and Malpractice
                Statement. All articles not in accordance with these standards will be removed from the publication if
                malpractice is discovered at any time even after the publication. WJERT is checking all papers in a peer
                review process.
              </p>

              <h5 class="main-snd-heading">Duties of Editors</h5>
              <p class="mb-3">Editor must ensure a fair double-blind peer-review of the submitted articles for
                publication. They will strive to prevent any potential conflict of interests between the author and
                editorial and review personnel. Editors will also ensure that all the information related to submitted
                manuscripts is kept as confidential before publishing. Editor-in-Chief will coordinate the work of the
                editors.</p>

              <h5 class="main-snd-heading">Duties of Reviewers</h5>
              <p class="mb-3">Reviewer evaluate manuscripts based on content without regard to ethnic origin, gender,
                sexual orientation, citizenship, religious belief or political philosophy of the authors. They must
                ensure that all the information related to submitted manuscripts is kept as confidential and must report
                to the Editor-in-Chief if they are aware of copyright infringement and plagiarism on the authors side.
                They must evaluate the submitted works objectively as well as present clearly their opinions on the
                works in a clear way in the review form. A reviewer who feels unqualified to review the research
                reported in a manuscript or knows that its prompt review will be impossible should notify the
                Editor-in-Chief and excuse himself from the review process.</p>

              <h5 class="main-snd-heading">Duties of Authors</h5>

              <p>
                <b>Reporting standards:</b> Authors of reports of original research should present an accurate account
                of the work performed as well as an objective discussion of its significance. Underlying data should be
                represented accurately in the paper. A paper should contain sufficient detail and references to permit
                others to replicate the work. Fraudulent or knowingly inaccurate statements constitute unethical
                behaviour and are unacceptable.
              </p>

              <p>
                <b>Data Access and Retention:</b> Authors are asked to provide the raw data in connection with a paper
                for editorial review, and should be prepared to provide public access to such data, if practicable, and
                should in any event be prepared to retain such data for a reasonable time after publication.
              </p>

              <p>
                <b>Originality and Plagiarism:</b> The authors should ensure that they have written entirely original
                works, and if the authors have used the work and/or words of others that this has been appropriately
                cited or quoted.
              </p>

              <p>
                <b> Multiple, Redundant or Concurrent Publication:</b> An author should not in general publish
                manuscripts describing essentially the same research in more than one journal or primary publication.
                Submitting the same manuscript to more than one journal concurrently constitutes unethical publishing
                behaviour and is unacceptable.
              </p>

              <p>
                <b>Acknowledgement of Sources:</b> Proper acknowledgment of the work of others must always be given.
                Authors should cite publications that have been influential in determining the nature of the reported
                work.
              </p>

              <p>
                <b> Authorship of the Paper:</b> Authorship should be limited to those who have made a significant
                contribution to the conception, design, execution, or interpretation of the reported study. All those
                who have made significant contributions should be listed as co-authors. Where there are others who have
                participated in certain substantive aspects of the research project, they should be acknowledged or
                listed as contributors. The corresponding author should ensure that all appropriate co-authors and no
                inappropriate co-authors are included on the paper, and that all co-authors have seen and approved the
                final version of the paper and have agreed to its submission for publication.
              </p>

              <p>
                <b>Hazards and Human or Animal Subjects:</b> If the work involves chemicals, procedures or equipment
                that have any unusual hazards inherent in their use, the author must clearly identify these in the
                manuscript. If author involve human or animal in the study, he must submit ethical committee permission
                details to the editor along with manuscript.
              </p>

              <p>
                <b>Disclosure and Conflicts of Interest:</b> All authors should disclose in their manuscript any
                financial or other substantive conflict of interest that might be construed to influence the results or
                interpretation of their manuscript. All sources of financial support for the project should be
                disclosed.
              </p>

              <p class="mb-3">
                <b>Fundamental errors in published works:</b> When an author discovers a significant error or inaccuracy
                in his/her own published work, it is the authors obligation to promptly notify the journal editor or
                publisher and cooperate with the editor to retract or correct the paper.
              </p>

            </div>
          </div>
        </section>
        <!---/.center panel End--->
      </div>
</div>
</div>
@endsection
