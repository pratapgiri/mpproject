@extends('frontend.layouts.master')

@section('title', 'WJAM | Home')

@section('content')

  <style>

    .middile-panel .comm_fee {
      display: block;
      width: 100%;
      border: 2px solid #0f5721;
      border-radius: 6px;
    }

    .middile-panel .comm_fee .heading {
      text-align: center;
    }

    .middile-panel .comm_fee .heading h3 {
      background: linear-gradient(106deg, rgba(15, 87, 33, 1) 0%, rgba(61, 145, 98, 1) 46%, rgba(67, 86, 204, 1) 100%);
      padding: 10px 0px;
      margin-top: 0px;
      color: #FFF;
    }

    .middile-panel .comm_fee .otr_info {
      padding: 20px 0px 30px 0px;
      text-align: center;
    }

    .middile-panel .comm_fee .otr_info p {
      text-align: center;
      font-size: 16px;
    }

    .middile-panel .comm_fee .otr_info p span {
      text-align: center;
      padding: 7px 18px;
      font-size: 17px;
      background-color: #FF0;
      border-radius: 6px;
    }

    .middile-panel .comm_fee .otr_info ul {
      text-align: center;
      padding: 20px 0px;
    }

    .middile-panel .comm_fee .otr_info ul li {
      display: inline;
    }

    .middile-panel .comm_fee .otr_info ul li span {}

    .middile-panel .comm_fee .otr_info ul li a {
      text-decoration: underline;
      color: #06f;
      font-size: 16px;
    }

    .middile-panel .comm_fee .otr_info ul li span a {
      padding: 8px 18px;
      background: -webkit-linear-gradient(#014e5c, #00262d);
      border-radius: 6px;
      font-weight: lighter;
      font-size: 16px;
      text-decoration: none;
      color: #FFF;
    }

    .middile-panel .comm_fee .otr_info ul li img {
      vertical-align: middle;
    }

    .middile-panel .comm_fee .otr_info ul li a span {
      text-decoration: none;
      color: #F00;
      font-size: 14px;
    }
  </style>



  <div class="contante_wrapper">
    <div class="row">

      <div class="col-sm-12">
        <!---/.center panel start--->
        <section class="middile-panel">

          <div class="comm_fee">
            <div class="heading">
              <h3>Publication Fees</h3>
            </div>
            <div class="otr_info">
              <p>The author(s) can submit Processing fees by using International Debit or Credit Card from below given
                link </p>
              <ul>
                <li><span><a href="http://wjpr.net/processingfees">For Fees Click here</a></span></li>
                <li><img src="assets/images/arrow_moving.gif" alt=""></li>
                <li>
                  <a href="http://wjpr.net/processingfeesn">http://wjpr.net/processingfeesn</a>
                  <br><br>
                  <span style="margin-left: 280px;font-weight: bold;font-size: 15px;">OR</span>
                  <br><br>
                  <a href="http://wjpr.net/processingfees"
                    style="margin-left: 284px;">http://wjpr.net/processingfees</a>
                </li>
              </ul>

              <p><span>Note: Kindly inform us through email after paying the fees.</span></p>

            </div>

          </div>


        </section>
        <!---/.center panel End--->
      </div>
    </div>
  </div>
@endsection
