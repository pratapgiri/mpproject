@extends('frontend.layouts.master')

@section('title', 'WJAM | Home')

@section('content')
<style>
    .table td {
      font-family: Century;
    }

    .table th {
      font-family: Century;
    }
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
            <h1>Editorial Board</h1>
          </div>

          <div class="text">
            <div class="editorial-board">





              <div class="row">
                <div class="col-md-12">

                  <div class="head">
                    <h4 class="green">Editor in Chief</h4>
                  </div>


                  <div style="width:80%;  float:left;  margin-bottom:5px; margin-left:45px;">

                    <div style="float:left; margin-left:-20px; margin-top:10px;">
                      <!--<img src="https://www.wjam.net/assets/images/Valentina.jpg"  >-->
                    </div>

                    <!--<div style="margin:60px 0px 10px 15px; float:left;">-->
                    <div style="margin:1px 0px 10px -32px; float:left;">
                      <div style="font-size:17px; font-family:Century; font-weight:bold;">Sergey Garchenko</div>
                      <div style="font-size:16px; margin:3px 0px 10px 0px; font-family:Century; color:#666;">
                        Taurusavenue 105, 2122 LS, Hoofddorp </div>
                      <div style="margin-top:-10px; font-family:Century; font-size:14px;">
                        <br />
                        Netherlands<br />
                      </div>
                    </div>

                  </div>
                </div>

              </div>



              <div style="display:none;" class="row">
                <div class="col-md-12">

                  <div class="head">
                    <h4 class="green">Associate Editor</h4>
                  </div>


                  <div style="width:80%;  float:left;  margin-bottom:5px; margin-left:45px;">

                    <div style="float:left; margin-left:-20px; margin-top:10px;">
                      <!--<img src="https://www.wjam.net/assets/images/Valentina.jpg"  >-->
                    </div>

                    <!--<div style="margin:60px 0px 10px 15px; float:left;">-->
                    <div style="margin:1px 0px 10px -32px; float:left;">
                      <div style="font-size:17px; font-family:Century; font-weight:bold;">Dr. N.S. Neki</div>
                      <div style="font-size:13px; margin:3px 0px 10px 0px; font-family:Century; color:#333;">
                        (MD , DTN & H, FRCP (Edin),FRCP(Ire),FRCP(Glas), FCCP(USA),
                        <br />FRCP(Lon),FACC(USA),FACP (USA), FACE(USA),
                        <br />FESC, FICP, FGSI, FRSM(London),
                        <br />FNCCP , FICN, FACN(USA), FSCH(Ind))

                      </div>
                      <!--
     <div style="font-size:16px; margin:3px 0px 10px 0px; font-family:Century; color:#666;">Vice Dean of Foreign students education and International Integration, </div>
	 -->
                      <br />
                      <div style="margin-top:-15px; font-family:Century; font-size:14px;">
                        Professor of Medicine, <br />
                        Govt. Medical College, <br />
                        Amritsar, Punjab, India<br />
                      </div>
                    </div>

                  </div>
                </div>

              </div>



              <div class="row clearfix">
                <div class="col-md-12 column">
                  <div class="editorial_member">

                    <div class="head">
                      <h4 class="green">Editorial Board Member</h4>
                    </div>

                    <div class="table-responsive editorialtable">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th width="8%">S.No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Country</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Professor. Dr. K. M. Girhepunje</td>
                            <td>principal@krcollegeofpharmacy.com</td>
                            <td>Principal, Dr. K. R. College of Pharmacy & Research, M.H.</td>
                            <td>
                              <p>India</p>
                            </td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>Professor. Narayan D. Gaidhani</td>
                            <td>narayan@krcollegeofpharmacy.com</td>
                            <td>HOD, Dr. K. R. College of Pharmacy & Research, M.H. India</td>
                            <td>
                              <p>India</p>
                            </td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>Quality Control Pharmacist, Dr. Eva Troja</td>
                            <td>eva.troja@profarma.al</td>
                            <td>Quality Control Pharmacist, Quality Control Department, Microbiology laboratory,
                              Profarma Sh.a, (Health/Medical/Pharmaceutical), Albania</td>
                            <td>
                              <p>Albania</p>
                            </td>
                          </tr>
                          <tr>
                            <td>4</td>
                            <td>Prof. Dr. Ranju Pal Girhepunje</td>
                            <td>ranju@krcollegeofpharmacy.com</td>
                            <td>Professor, Department of Pharmacology, Dr. K. R. College of Pharmacy & Research,
                              Lakhani, Maharashtra, INDIA</td>
                            <td>
                              <p>INDIA</p>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row clearfix">
                <div class="col-md-12 column">
                  <div class="editorial_member">

                    <div class="head">
                      <h4 class="green">Advisory Board Member</h4>
                    </div>

                    <div class="table-responsive editorialtable">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th width="8%">S.No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Country</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Lecturer, Ghanshyam .C. Nagalwade</td>
                            <td>ghanshyam@krcollegeofpharmacy.com</td>
                            <td>Lecturer, Department of Pharmaceutics, Dr. K. R. College of Pharmacy & Research,
                              Lakhani, Maharashtra, INDIA</td>
                            <td>
                              <p>INDIA</p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>
              </div>


              <div class="row clearfix">
                <div class="col-sm-12">
                  <div>
                    <p style="font-size:18px; color:#C00;">Join As a Editorial Board Member</p>
                    <a href="pdf/editorial_form.pdf">Download Form</a>
                    <br /><br />
                  </div>

                </div>
              </div>

            </div>
          </div>
        </section>
        <!---/.center panel End--->
      </div>
    </div>
  </div>
@endsection
