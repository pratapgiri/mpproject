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

    <!--/.center panel start--->
    <section class="middile-panel">
      <div class="head">
        <h1>Instructions to Authors</h1>
      </div>
      <div class="text">
        <div class="auther-instruction">
          <p><strong>World Journal of Advance Medicine (WJAM)</strong> is a <strong>Monthly Research</strong>
            Journal which publishes original research articles, review articles, case reports, short communications
            in the field of Medical sciences.</p>
          <p><strong>World Journal of Advance Medicine (WJAM)</strong> allows free unlimited access to abstract and
            full-text. The journal focuses on rapid publication with facilities of, online research article tracking
            & Email/SMS alert etc. Manuscripts are accepted for review with the understanding that same work has not
            been published, that it is not under consideration for publication elsewhere, and that its submission
            for publication has been approved by all authors and institution where the actual work was carried out.
          </p>
          <p><strong>World Journal of Advance Medicine (WJAM)</strong> publishes the following manuscript types:</p>
          <ul class="mb-3">

            <li>Original Research Articles</li>

            <li>Review Articles</li>

            <li>Short Communications</li>

            <li>Case Study</li>

          </ul>
          <h4 class="main-heading">SUBMISSION OF THE MANUSCRIPT</h4>
          <p class="mb-3">All submissions must be in the English and should be submitted by the online submission
            system. Each manuscript will be provided with a manuscript ID and all correspondence is done through
            e-mail. Please always refer to the manuscript ID for any further enquiries. Authors are invited to
            suggest up to three potential reviewers, together with their contact details (e-mail addresses are
            essential). In case of any problem through the online submission, submit manuscripts to our mail: <a
              href="#">editor.wjam@gmail.com</a> or <a href="#">editor@wjam.com</a> along with a covering letter
            preferably by the corresponding author.</p>
          <h4 class="main-heading">MANUSCRIPT STRUCTURE</h4>

          <h4 class="main-snd-heading">RESEARCH ARTICLE FORMAT</h4>
          <p>The preferred format of all manuscripts are in MS office (2003 or above). Manuscript should be
            concisely typewritten in 1.5 spaces in A4 sized sheets. The pages shall be numbers consequently. Only on
            one side, with a 1″ margin on all sides. The manuscript shall be prepared in Times New Roman using a
            font size of 12 and title shall be font size of 14, bold space capitals. All section titles in the
            manuscript shall be in font size 12, bold face capitals and subtitles in each section shall be in font
            size 12, bold face lower case. Illustrations (Figures & Tables) must be inserted at appropriate place in
            the article. Standard International Units should be used throughout the text. Pages should be numbered
            properly. There shall not be decorative borders anywhere in the text including the title page. The
            manuscript should be starting with the title page and the text should be arranged in the following
            order:</p>
          <ul class="mb-3">

            <li>Title Page</li>

            <li>Abstract</li>

            <li>Keywords</li>

            <li>Introduction</li>

            <li>Materials and Methods</li>

            <li>Results and Discussion</li>

            <li>Conclusion</li>

            <li>Acknowledgements</li>

            <li>References</li>

          </ul>
          <h4 class="main-heading">Title Page</h4>

          <p class="mb-3">The title should be as short as possible on the first page and provide precise information
            about the contents. The title should be followed by full names of author (s), affiliations of author (s)
            and institutional addresses.</p>
          <h4 class="main-heading">Authors and Co-Authors Details and Their Affiliations</h4>

          <p class="mb-3">Each author must provide their full name including their forenames and surname. The
            Corresponding Author of the manuscript must be marked with an asterisk*, and should be listed first. In
            addition the corresponding author must include Telephone and E-mail address at the bottom left corner of
            the title page. If any of the co-authors are from different organizations, their addresses too should be
            mentioned and indicated using numbers after their names. Maximum 6 authors should be allowed.</p>

          <h4 class="main-heading">Abstract</h4>

          <p class="mb-3">Provide on a separate page an abstract of not more than150-250 words. A concise and
            factual abstract is required. The Abstract should be informative and completely self-explanatory,
            briefly present the topic, state the scope of the experiments, indicate significant data, and point out
            major findings and conclusions. An abstract is often presented separately from the article, so it must
            be able to stand alone. For this reason, standard nomenclature should be used and abbreviations and
            references should be avoided.</p>
          <h4 class="main-heading">Keywords</h4>

          <p class="mb-3">Provide three to six appropriate keywords after the abstract.</p>
          <h4 class="main-heading">Materials and Methods</h4>

          <p class="mb-3">It should be complete enough to allow experiments to be reproduced. All the procedures
            should be described in detail, previously published procedures should be cited, and important
            modifications of published procedures should be mentioned briefly. Capitalize trade names and include
            the manufacturer's name and address. Subheadings should be used. Methods in general use need not be
            described in detail.</p>
          <h4 class="main-heading">Results</h4>

          <p class="mb-3">Results and their significance should be presented clearly and concisely, preferably in
            the form of graphs and tables which should be self explanatory.</p>
          <h4 class="main-heading">Discussion</h4>

          <p class="mb-3">It should contain a critical review of the results in the light of relevant literature.
            Results and Discussion may be combined.</p>
          <h4 class="main-heading">Conclusions</h4>

          <p class="mb-3">This should state clearly the main conclusions of the research and give a clear
            explanation of their importance and relevance. Summary illustrations may be included.</p>
          <h4 class="main-heading">Acknowledgement</h4>

          <p class="mb-3">Acknowledgements should be placed in a separate section after the conclusion. If external
            funding has been obtained for the study, then that should be mentioned under a separate header
            “Funding”, after the acknowledgements.</p>
          <h4 class="main-heading">References</h4>
          <p class="mb-3">The authors are responsible for the accuracy of the bibliographic information. It must be
            numbered consecutively in the order that they are cited in the text and designated by superscript with
            square brackets after the punctuation marks. ([X]) A list should be included on separate 1.5spaced pages
            at the end of the text. For the proper abbreviations of the journal titles, refer to “Chemical
            Abstracts”. The style and punctuation of the references should confirm to the following examples:</p>
          <h4 class="main-heading">Journal references</h4>
          <ol class="mb-3">

            <li>Cantarelli MA, Pellerano RG, Marchevsky EJ, Camina JM. (Title of article). Anal Sci, 2011; 27(1):
              73-8.</li>

            <li>Sather BC, Forbes JJ, Starck DJ, Rovers JP. (Title of article). J Am Pharm Assoc, 2007; 47(1): 82-5.
            </li>

          </ol>
          <p><strong>Books</strong></p>
          <ul class="mb-3">

            <li>Meltzer PS, Kallioniemi A, Trent JM. Chromosome alterations in human solid tumors. In: Vogelstein B
              and Kinzler KW (eds.). The Genetic Basis of Human Cancer, New York; McGraw-Hill: 2002, pp. 93-113.
            </li>

            <li>Bard AJ, Faulkner LR. Electrochemical Methods: Fundamentals and Applications. 2nd ed., New York;
              John Wiley and Sons: 2001.</li>

          </ul>
          <p><strong>Patents</strong></p>

          <ul class="mb-3">

            <li>Aviv H, Friedman D, Bar-Ilan A, Vered M. US Patent, US 5496811, 1996.</li>

          </ul>
          <p><strong>Websites</strong></p>

          <ul class="mb-3">

            <li>Database of Natural Matrix Reference Materials, Compilation prepared by International Atomic Energy
              Agency (IAEA), http://www.iaea.org/programmes/nahunet/e4/nmrm/browse.htm/.

              For other types of citation, please see “Uniform Requirement for Manuscripts Submitted to Biomedical
              Journals: Sample References” at www.nlm.nih.gov/bsd/uniform_requirements.html</li>

          </ul>
          <p><strong>Tables</strong></p>

          <ul class="mb-3">

            <li>These should be numbered with Arabic numerals. Each table should be typed using a table format
              (i.e., each variable must be typed into a separate cell in the table). The title should be typed at
              the top of the table in the sentence case format, i.e., only the first name should be in capital
              letters; as appropriate. Any footnote should be typed at the bottom of the table in italic.</li>

          </ul>
          <div class="row">

            <div class="col-sm-10 col-sm-offset-1">

              <div class="table-responsive">
                <table class="table table-bordered">

                  <thead>
                    <tr>
                      <th>S. No.</th>
                      <th>Title</th>
                      <th>Title</th>
                      <th>Title</th>
                      <th>Title</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>1</th>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <th>2</th>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <th>3</th>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <p><strong>Illustrations and Figures</strong></p>

          <p class="mb-3">

            Figures must be numbered independently of tables, multimedia, and 3D models and cited as the relevant
            point in the manuscript text, e.g. "Fig. 1", "Fig. 2", etc. All figures including photographs should be
            numbered consecutively in Arabic numerals in the order of their appearance in the text and bear a brief
            title in lower case bold face letters below the figure. Do not duplicate data by presenting it both in
            the text and in a figure. For any figure directly extracted from previously published materials, you
            must have written permission from the publisher of that figure for reprint use. A copy of that
            permission release must be submitted with your article.

          </p>
          <br />
          <h4 class="main-heading">REVIEW ARTICLES</h4>
          <p class="mb-3">Review articles should not be more than 25 pages and contain comprehensive coverage of
            relevant literature. Review articles should preferably be written by scientists who have in-depth
            knowledge of the topic. All format requirements are similar to those applicable to Research papers.
            Review articles need not to be divided into sections such as Materials and methods, and Results and
            discussion, but should definitely have an abstract and introduction.</p>
          <h4 class="main-heading">SHORT COMMUNICATIONS</h4>
          <p>The research and technical communications section of this journal (maximum 3,000 words) is open to
            interesting results worthy of publication without requiring extensive introduction and discussion. This
            section should be organized as follows: Abstract, Introduction, Materials and methods, Results and
            discussion (combined). Not more than 10 references should be provided. Tables, figures and references
            are to be arranged in the same way as for research papers. Brevity of presentation is essential for this
            section.</p>
          <p><strong>Note: Figures and tables should be included at appropriate place in the manuscript</strong></p>
          <p><strong>Chemical Terminology:</strong> The chemical nomenclature used must be in accordance with that
            used in the Chemical Abstracts</p>
          <p><strong>Biological Nomenclature:</strong> Names of plants, animals and bacteria should be in
            <i>italics</i>.
          </p>
          <p><strong>Enzyme Nomenclature:</strong> The trivial names recommended by the IUPAC-IUB Commission should
            be used. When the enzyme is the main subject of a paper, its code number and systematic name should be
            stated in its first citation in the paper.</p>
          <p class="mb-3"><strong>Symbols and Abbreviations:</strong> Use only standard abbreviations. The use of
            non-standard abbreviations can be extremely confusing to readers. Avoid abbreviations in the title. The
            full term for which an abbreviation stands should precede its first use in the text unless it is a
            standard unit of measurement.</p>
          <h4 class="main-heading">ETHICAL MATTERS</h4>
          <p class="mb-3">Authors involving in the usage of experimental animals and human subjects in their
            research work should seek approval from the appropriate Institutional Animal Ethics Committee in
            accordance with "Principles of Laboratory Animal Care". The material and methods section of the
            manuscript should include a statement to prove that the investigation was approved and that informed
            consent was obtained.</p>
          <h4 class="main-heading">PUBLICATION MALPRACTICE</h4>

          <p class="mb-3">The World Journal of Advance Medicine (WJAM) is committed to upholding the highest
            standards of publication ethics and takes all possible measures against any publication malpractices.
            All authors submitting their works to theWorld Journal of Advance Medicine (WJAM)for publication as
            original articles attest that the submitted works represent their authors’ contributions and have not
            been copied or plagiarized in whole or in part from other works. The authors acknowledge that they have
            disclosed all and any actual or potential conflicts of interest with their work or partial benefits
            associated with it. In the same manner, the WJPMR journal is committed to objective and fair
            double-blind peer-review of the submitted for publication works and to prevent any actual or potential
            conflict of interests between the editorial and review personnel and the reviewed material. Any
            departures from the above-defined rules should be reported directly to the Editors-in-Chief, who is
            unequivocally committed to providing swift resolutions to any of such a type of problems.</p>
          <h4 class="main-heading">AUTHORSHIP</h4>
          <p>

            A manuscript will be considered for the publication based on the below understanding:

          <ol class="mb-3">

            <li>All named authors should agree to its submission</li>

            <li>It is not currently being considered for the publication by another journal</li>

            <li>If the paper is accepted, it will not be subsequently published in the same or similar form in any
              language without the consent of publishers Any changes to the author list after submission, viz., a
              change in the order of the authors, deletion or addition of the authors needs to be approved by a
              signed letter from each author.</li>
          </ol>
          </p>
          <h4 class="main-heading">COPYRIGHT</h4>
          <p class="mb-3">Submission of the manuscript represents that the manuscript has not been published
            previously and is not considered for publication elsewhere. Authors would be required to sign a Copy
            Right Transfer Agreement Form once the manuscript is accepted.</p>
          <h4 class="main-heading">GALLEY PROOFS</h4>
          <p class="mb-3">Unless indicated otherwise, galley proofs are sent to the address given for
            correspondence. It is the responsibility of the corresponding author to ensure that the galley proofs
            are returned without delay.</p>
          <h4 class="main-heading">PRIVACY STATEMENT</h4>
          <p class="mb-3">The names and email addresses entered in this journal site will be used exclusively for
            the stated purposes of this journal and will not be made available for any other purpose or to any other
            party.</p>
          <br />
          <h4 class="main-heading">AUTHOR FEES</h4>
          <p class="mb-3">This journal charges the following author fees.<br />

            Article Submission: 0.00 (INR)<br />

            Authors are required to pay zero rupees for an Article Submission never pay Fee as part of the

            submission process to contribute to review costs.<br />

            If this paper is accepted for publication, you will be asked to pay an Article Publication Fee to

            cover publications costs.
          </p>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Article category</th>
                  <th>Articles from outside India & UK</th>
                  <th>Articles from within UK</th>
                  <th>Articles from within India</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>Research article (Original article)</th>
                  <td>$50 USD</td>
                  <td>�40 GBP</td>
                  <td>Rs 1400</td>
                </tr>
                <tr>
                  <th>Review Article</th>
                  <td>$50 USD</td>
                  <td>�40 GBP</td>
                  <td>Rs 1400</td>
                </tr>
                <tr>
                  <th>Case reports</th>
                  <td>$50 USD</td>
                  <td>�40 GBP</td>
                  <td>Rs 1400</td>
                </tr>
                <tr>
                  <th>Short Communication</th>
                  <td>$50 USD</td>
                  <td>�40 GBP</td>
                  <td>Rs 1400</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    <!---/.center panel End--->
  </div>
</div>
</div>
@endsection
