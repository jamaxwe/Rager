<!DOCTYPE html>
<html>

<head>
  @extends('Admin.layout')
  <title>@yield('title')</title>
  <link href="{{ asset('/css/footer.css') }}" type="text/css" rel="stylesheet">
</head>

<body>
  <footer class="for-bg">
    <div class="container box-footer">
      <div class="ft-bg d-flex justify-content-center">
        <div class="big-footer row">
          <div class="col-sm-12 col-md-4">
            <div class="collab-section">
              <h2>Collabo<strong style="color: red;">r</strong>ate</h2>
              <div id="colab-drop-down">
                <p>Interested in collaborating with Rager's Clothing?</p>
                <p>We'd love to hear from you! Whether you're a designer, influencer, or have a unique idea, get in
                  touch with us.</p>
                <a href="mailto:isaacgahol22@gmail.com" class="btn btn-eml btn-outline-light" style="border-radius: 0; font-size:13px ">Email Us</a>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="soc-med-section">
              <h2>Follow Us</h2>
              <div class="">
                <div class="fb d-flex">
                  <a href="">
                    <i class="fa-brands fa-facebook-f"></i>
                  </a>
                  <a href="">
                    <p>Rager</p>
                  </a>
                </div>
                <div class="insta d-flex">
                  <a href="">
                    <i class="fa-solid fa-hashtag"></i>
                  </a>
                  <a href="">
                    <p>rager.kta</p>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-4">
            <div class="newsletter-section">
              <h2>Newsletter</h2>
              <div class="input-group mb-3">
                <input type="text" class="form-control" style="border-radius: 0px 0px 0px 0px; "placeholder="Email...@gmail.com" aria-label="Email...@gmail.com"
                  aria-describedby="targe-id">
                <a href=""><span class="input-group-text btn btn-light" style="border-radius: 0px 0px 0px 0px; height:35px"
                    id="targe-id">Subscribe</span></a>
                <br>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree to receive personalized updates and marketing messages about Rager's clothing based on my
                    information, interests, activities, website visits, and device data.
                  </label>
                </div>
                <p>For information about how we use your personal information, please see our <a href="#">Privacy
                    Policy.</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  @include('user.footerbtm')
</body>

</html>