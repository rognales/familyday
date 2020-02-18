<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>

  <!-- Bootstrap Core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
    type='text/css'>
  <link
    href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
    rel='stylesheet' type='text/css'>
  <link
    href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic'
    rel='stylesheet' type='text/css'>

  <!-- Theme CSS -->
  <link href="{{asset('css/creative.css')}}" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">

  <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
          data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand page-scroll" href="#page-top">{{ config('app.name') }}</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a class="page-scroll" href="#about">Family Day 2020</a>
          </li>
          <li>
            <a class="page-scroll" href="#registration">Registration</a>
          </li>
          <li>
            <a class="page-scroll" href="#contact">Contact</a>
          </li>
          <li>
            <a class="page-scroll" href="#location">Location</a>
          </li>
          @guest
          <li>
            <a href="{{ route('login') }}">Login</a>
          </li>
          @else
          <li>
            <a href="{{ route('admin_index') }}">Admin</a>
          </li>
          @endguest
        </ul>

      </div>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid-fluid -->
  </nav>

  <header>
    <div class="header-content">
      <div class="header-content-inner">

      </div>
      <div>
  </header>

  <section class="bg-primary" id="about">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 text-center">
          <h2 class="section-heading">Family Day 2020</h2>
          <hr class="light">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6 text-center">
          <div class="service-box">
            <i class="fa fa-calendar fa-5x" aria-hidden="true"></i>
            <h3>{{config('app.eventday')}}</h3>
          </div>
        </div>
        <div class="col-sm-6 text-center">
          <div class="service-box">
            <i class="fa fa-map-marker fa-5x" aria-hidden="true"></i>
            <h3>Bangi Wonderland</h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="registration">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <h2 class="section-heading text-center">Registration</h2>
          <hr class="primary">
          <form id="form" class="form-horizontal" method="POST" action="{{route('registration_create')}}">
            {{csrf_field()}}
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissable fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <fieldset>
              <legend>Participant</legend>

              <div class="form-group">
                <label for="staff_id" class="col-sm-3 control-label">Staff Id</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="staff_id" name="staff_id" value="{{old('staff_id')}}"
                    placeholder="TM12345" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"
                    placeholder="Ali Bin Abu" required>
                </div>
              </div>
              <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}"
                    placeholder="Use valid email address here" required>
                </div>
              </div>
            </fieldset>
            <fieldset id="dependant_set">
              <legend>Dependant</legend>
              <!---start--->
              @if (old('dependant_name')> 0)
              @foreach (old('dependant_name') as $key => $value)
              <div @if ($key==0) id="dependant_list" @endif class="row form-group">
                <div class="col-sm-3">
                  <select class="form-control" name="dependant_relationship[]">
                    <option value="">--Relationship--</option>
                    <option value="Spouse" @if (old('dependant_relationship'.".".$key)=='Spouse' ) selected="selected"
                      @endif>Spouse</option>
                    <option value="Kids" @if (old('dependant_relationship'.".".$key)=='Kids' ) selected="selected"
                      @endif>Kids</option>
                    <option value="Infant" @if (old('dependant_relationship'.".".$key)=='Infant' ) selected="selected"
                      @endif>Infant</option>
                    <option value="Others" @if (old('dependant_relationship'.".".$key)=='Others' ) selected="selected"
                      @endif>Others</option>
                  </select>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="dependant_name[]" placeholder="Name"
                    value="{{old('dependant_name'.".".$key)}}">
                </div>
                <div class="col-sm-2">
                  <input type="number" class="form-control" name="dependant_age[]" placeholder="Age" min="1" max="80"
                    value="{{old('dependant_age'.".".$key)}}">
                </div>
              </div>
              @endforeach
              @else
              <div id="dependant_list" class="row form-group">
                <div class="col-sm-3">
                  <select class="form-control" name="dependant_relationship[]">
                    <option selected="selected" value="">--Relationship--</option>
                    <option value="Spouse">Spouse</option>
                    <option value="Kids">Children</option>
                    <option value="Infant">Infant</option>
                    <option value="Others">Others</option>
                  </select>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="dependant_name[]" placeholder="Name">
                </div>
                <div class="col-sm-2">
                  <input type="number" class="form-control" name="dependant_age[]" placeholder="Age" min="1" max="80">
                </div>
              </div>
              @endif
              <!---end--->
            </fieldset>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-4">
                <button type="button" id="add_dependant" class="btn btn-info">Add More</button>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-primary" id="btn-register">Register</button>
                @Auth
                <small>Rule for TM HQ only : <mark>OFF</mark></small>
                @endauth
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <section id="terms" class="bg-dark">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-10 col-md-offset-1 call-to-action">
          <h2 class=" text-center">Terms &amp; Conditions</h2>
          <hr class="primary">
          <ol>
            <li>TM Family Day is open for all <em>TM HQ staff only</em>.</li>
            <li>Children age <em>3-10 years old</em> or with the <em>height of 90-130 cm</em> are categorized as
              <mark>Kids</mark>.</li>
            <li>Children <em>below 3 years old</em> or with <em>height less than 90 cm</em> are categorized as
              <mark>Infant</mark>.</li>
            <li>You may need to purchase additional ticket at the special counter provided during the event day for
              admission of non-family member such as Staff’s parents, sibling, relative or maid.</li>
            <li>Participation in games will be categorized by age and will be determined by the organizer.</li>
            <li>Every admission to the Family Day will be charged for <mark>RM10.00 per registration</mark> as
              commitment fee.</li>
            <li>Payment should be made after you received the QR code. You will be needed to show your QR code to the
              secretariat in-charge at the booth during the payment process.</li>
            <li>If a Staff withdraws the admission to the Family Day once the payment has been made, we will not issue a
              refund of the commitment fee.</li>
            <li>Registration and payment should be made before <mark>{{ \Carbon\Carbon::parse(config('app.paymentday'))->format('jS F Y') }}</mark>.</li>
            <li>For TM staff who are husband and wife, please register in two separate forms. Please make sure your
              children information are only in one of the form.</li>
            <li>Payment counter will be open as below :-</li>
          </ol>
          <table class="table table-condensed text-center">
            <thead>
              <th class="text-center">Location</th>
              <th class="text-center">Date</th>
            </thead>
            <tbody>
              @foreach (config('app.counters') as $counter)
              <tr @if (now()->greaterThan(\Carbon\Carbon::parse($counter['date'])))
                class="passed"
                @endif>
                <td>{{$counter['location']}}</td>
                <td>{{\Carbon\Carbon::parse($counter['date'])->format('jS F Y')}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <section id="contact">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 text-center">
          <h2 class="section-heading">Contact</h2>
          <hr class="primary">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 text-center">
          <p><i class="fa fa-phone sr-contact"></i>
            011-10009385</p>
          <p><i class="fa fa-user sr-contact"></i>
            Mohamad Yusri Mohamad Yusof</p>
          <p><i class="fa fa-envelope-o sr-contact"></i>
            <a href="mailto:mohdyusriyusof@tm.com.my">mohdyusriyusof@tm.com.my</a></p>
        </div>
        <div class="col-md-4 text-center">
          <p><i class="fa fa-phone sr-contact"></i>
            012-7009320</p>
          <p><i class="fa fa-user sr-contact"></i>
            Nur Syuhada Binti Zulkifli </p>
          <p><i class="fa fa-envelope-o sr-contact"></i>
            <a href="mailto:nursyuhada.zulkifli@tm.com.my">nursyuhada.zulkifli@tm.com.my</a></p>
        </div>
        <div class="col-md-4 text-center">
          <p><i class="fa fa-phone sr-contact"></i>
            013-3440364</p>
          <p><i class="fa fa-user sr-contact"></i>
            Nur Ashikin Binti Ahmad Kamal</p>
          <p><i class="fa fa-envelope-o sr-contact"></i>
            <a href="mailto:ashikin.kamal@tm.com.my">ashikin.kamal@tm.com.my</a></p>
        </div>
      </div>
    </div>
  </section>
  <section class="map" id="location">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2 text-center">
          <h2 class="section-heading">Location</h2>
          <hr class="primary">
        </div>
      </div>
    </div>
    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
      src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBD6fzCA2JRXb2ZxJROiHkP6jVih1rMH00&q=Bangi+Wonderland"></iframe>
    <br />
    <small>
      <a
        href="https://www.google.com/maps/embed/v1/place?key=AIzaSyBD6fzCA2JRXb2ZxJROiHkP6jVih1rMH00&q=Bangi+Wonderland"></a>
    </small>
    </iframe>
  </section>
  <section class="bg-dark">
  </section>
  <!--
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha256-U5ZEeKfGNOja007MMD3YBI0A3OSZOQbeG6z2f2Y0hu8=" crossorigin="anonymous"></script>
  <!-- Plugin JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/3.3.6/scrollreveal.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"
    integrity="sha256-4F7e4JsAJyLUdpP7Q8Sah866jCOhv72zU5E8lIRER4w=" crossorigin="anonymous"></script>
  <!-- Theme JavaScript -->

  <script type="text/javascript">
    (function($) {
    "use strict"; // Start of use strict

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1250, 'easeInOutExpo');
        event.preventDefault();
    });

    // Highlight the top nav as scrolling occurs
    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 51
    });

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function() {
        $('.navbar-toggle:visible').click();
    });

    // Offset for Main Navigation
    $('#mainNav').affix({
        offset: {
            top: 100
        }
    })

    // Initialize and Configure Scroll Reveal Animation
    window.sr = ScrollReveal();
    sr.reveal('.sr-icons', {
        duration: 600,
        scale: 0.3,
        distance: '0px'
    }, 200);
    sr.reveal('.sr-button', {
        duration: 1000,
        delay: 200
    });
    sr.reveal('.sr-contact', {
        duration: 600,
        scale: 0.3,
        distance: '0px'
    }, 300);

    })(jQuery); // End of use strict

    $(document).ready(function() {
      //Dynamically add dependant form
      $("#add_dependant").click(function() {
        $("#dependant_list").clone().removeAttr('id')
        .find('select').val('').end()
        .find('input').val('').end()
        .appendTo( "#dependant_set" );
      });

      $("#form").on('submit',function(){
        //Disabled register button after the first successful submission. Restored on page reload.
        $("#btn-register").prop('disabled',true);
      });

      $('.map').on('click', onMapClickHandler);

    });
    // Disable Google Maps scrolling
    // See http://stackoverflow.com/a/25904582/1607849
    // Disable scroll zooming and bind back the click event
    var onMapMouseleaveHandler = function(event) {
        var that = $(this);
        that.on('click', onMapClickHandler);
        that.off('mouseleave', onMapMouseleaveHandler);
        that.find('iframe').css("pointer-events", "none");
    }
    var onMapClickHandler = function(event) {
            var that = $(this);
            // Disable the click handler until the user leaves the map area
            that.off('click', onMapClickHandler);
            // Enable scrolling zoom
            that.find('iframe').css("pointer-events", "auto");
            // Handle the mouse leave event
            that.on('mouseleave', onMapMouseleaveHandler);
        }
    // Enable map zooming with mouse scroll when the user clicks the map
  </script>
</body>

</html>