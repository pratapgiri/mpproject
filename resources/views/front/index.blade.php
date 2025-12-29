<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>International Journal of Research in Medicine and Ayurveda (IJRMA)</title>

  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", sans-serif;
      background: #fff;
      color: #111;
    }

    /* HEADER */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      flex-wrap: wrap;
    }

    .logo {
      width: 80px;
    }

    .title h2 {
      margin: 0;
      color: #145a1d;
      font-weight: 700;
    }

    .title span {
      color: #066e26;
    }

    .subtitle {
      color: #0a8a2f;
      font-size: 13px;
    }

    .issn-logo {
      width: 90px;
    }

    /* NAVBAR */
    .navbar {
      background: #145a1d;
    }

    .navbar ul {
      margin: 0;
      padding: 0;
      display: flex;
      flex-wrap: wrap;
      list-style: none;
      justify-content: center;
    }

    .navbar a {
      display: block;
      padding: 12px 18px;
      color: #fff;
      text-decoration: none;
      font-size: 14px;
    }

    .navbar a:hover {
      background: #0a8a2f;
    }

    /* HERO */
    .hero {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      background: linear-gradient(90deg, #0a8a2f, #3b7bc3);
      color: white;
      padding: 40px;
    }

    .hero img {
      width: 400px;
      border-radius: 6px;
      max-width: 100%;
    }

    .hero h1 {
      font-size: 20px;
      line-height: 1.5;
    }

    .email span {
      background: yellow;
      color: black;
      padding: 3px 6px;
      border-radius: 4px;
    }

    /* ABOUT */
    .about {
      padding: 40px;
      text-align: center;
    }

    .about p {
      max-width: 900px;
      margin: 0 auto;
      line-height: 1.6;
    }

    .btn {
      display: inline-block;
      background: #145a1d;
      color: white;
      padding: 8px 16px;
      margin-top: 20px;
      text-decoration: none;
      border-radius: 4px;
    }

    /* COVER AREAS */
    .cover-areas {
      background: #ecfff2;
      padding: 40px;
      text-align: center;
    }

    .divider {
      width: 100px;
      height: 3px;
      background: #145a1d;
      margin: 10px auto 30px auto;
      border-radius: 2px;
    }

    .area-grid {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .area {
      flex: 1 1 300px;
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: left;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .area h3 {
      color: #145a1d;
      margin-bottom: 10px;
    }

    .area ul {
      padding-left: 20px;
      margin: 0;
    }

    /* INDEXING */
    .indexing {
      padding: 40px;
      background: #f3fce9;
      text-align: center;
    }

    .index-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .index-grid img {
      background: white;
      border-radius: 8px;
      padding: 10px;
      max-width: 100%;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* BENEFITS */
    .benefits {
      padding: 40px;
      background: #fff;
      text-align: center;
    }

    .benefits ul {
      max-width: 800px;
      margin: auto;
      list-style: circle;
      color: #145a1d;
      text-align: left;
      line-height: 1.8;
    }

    /* FOOTER */
    .footer {
      background: #0a8a2f;
      color: white;
      text-align: center;
      padding: 15px;
    }

    .footer a {
      color: yellow;
      text-decoration: none;
    }

    .footer .social img {
      width: 22px;
      margin: 0 5px;
      vertical-align: middle;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .hero {
        text-align: center;
        flex-direction: column;
      }
      .hero img {
        margin-top: 20px;
      }
      .area {
        flex: 1 1 100%;
      }
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <header class="header">
    <div class="top-bar">
      <div class="logo-section">
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/8b/Caduceus_symbol.svg" alt="IJRMA Logo" class="logo" />
        <div class="title">
          <h2>International Journal of <br> <span>Research in Medicine and Ayurveda</span></h2>
          <p class="subtitle">An International Peer Reviewed Journal for Medical Research.</p>
        </div>
      </div>

      <div class="issn-section">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/52/ISSN_Logo_2013.svg" alt="ISSN Logo" class="issn-logo" />
        <p>
          <b>ISSN (Print):</b> 3051-2999<br>
          <b>ISSN (Online):</b> 3051-3006
        </p>
      </div>
    </div>

    <!-- NAVIGATION -->
    <nav class="navbar">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Instruction to Author</a></li>
        <li><a href="#">Current Issue</a></li>
        <li><a href="#">Manuscript Submission</a></li>
        <li><a href="#">Processing Fees</a></li>
        <li><a href="#">Track Your Article</a></li>
        <li><a href="#">Archive</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
    </nav>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="hero-text">
      <h1>WELCOME TO INTERNATIONAL JOURNAL OF<br>RESEARCH IN MEDICINE AND AYURVEDA</h1>
      <p>An International Peer Reviewed Journal for Pharmaceutical and Medical Research and Technology.</p>
      <p class="email">Submit all communication / article on <span>editor@ijrma.net</span></p>
    </div>
    <div class="hero-image">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Research_lab_2.jpg/640px-Research_lab_2.jpg" alt="Research Lab">
    </div>
  </section>

  <!-- ABOUT -->
  <section class="about">
    <h2>Welcome to International Journal of Research in Medicine and Ayurveda</h2>
    <p>
      The International Journal of Research in Medicine and Ayurveda (IJRMA) is an internationally reputed,
      peer-reviewed, open-access research journal that publishes original research in medical, pharmaceutical,
      and biological sciences. Established in 2012, IJRMA provides a platform for researchers and scientists
      to share their high-quality findings and contribute to medical innovation.
    </p>
    <a href="#" class="btn">Learn More</a>
  </section>

  <!-- COVER AREAS -->
  <section class="cover-areas">
    <h2>IJRMA COVER FOLLOWING AREA</h2>
    <div class="divider"></div>

    <div class="area-grid">
      <div class="area">
        <h3>Medical Sciences</h3>
        <ul>
          <li>Endocrinology</li>
          <li>Pathology</li>
          <li>Oncology</li>
          <li>Dermatology</li>
          <li>Radiology</li>
          <li>Public Health</li>
        </ul>
      </div>

      <div class="area">
        <h3>Pharmaceutical Sciences</h3>
        <ul>
          <li>Pharmaceutics</li>
          <li>Pharmacology</li>
          <li>Medicinal Chemistry</li>
          <li>Nanotechnology</li>
          <li>Pharmacognosy</li>
        </ul>
      </div>

      <div class="area">
        <h3>Biological Sciences</h3>
        <ul>
          <li>Microbiology</li>
          <li>Genetics</li>
          <li>Cell Biology</li>
          <li>Zoology</li>
          <li>Environmental Sciences</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- INDEXING -->
  <section class="indexing">
    <h2>INDEXING</h2>
    <div class="index-grid">
      <img src="https://upload.wikimedia.org/wikipedia/commons/3/31/Google_Scholar_logo.svg" alt="Google Scholar">
      <img src="https://upload.wikimedia.org/wikipedia/commons/d/d2/Index_Copernicus_logo.png" alt="Index Copernicus">
      <img src="https://upload.wikimedia.org/wikipedia/commons/8/85/Academia_edu_logo.svg" alt="Academia">
      <img src="https://upload.wikimedia.org/wikipedia/commons/b/bc/Web_of_Science_logo.svg" alt="Web of Science">
    </div>
  </section>

  <!-- BENEFITS -->
  <section class="benefits">
    <h2>BENEFITS OF ARTICLE PUBLICATION IN IJRMA</h2>
    <ul>
      <li>ISO Approved International Journal</li>
      <li>Peer-Reviewed with High Research Quality</li>
      <li>High Impact Factor Journal</li>
      <li>Open Access with Author Copyright</li>
      <li>Indexed in Major National & International Databases</li>
      <li>Free Online Publication Certificate</li>
    </ul>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <p>Powered by <a href="#">IJRMA</a> | All Rights Reserved</p>
    <div class="social">
      <img src="https://upload.wikimedia.org/wikipedia/commons/c/c3/Facebook_icon_%28black%29.svg" alt="Facebook">
      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Logo_of_Twitter.svg" alt="Twitter">
      <img src="https://upload.wikimedia.org/wikipedia/commons/8/81/LinkedIn_icon.svg" alt="LinkedIn">
    </div>
  </footer>

</body>
</html>
