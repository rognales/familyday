<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ config('familyday.eventname') }} by {{ config('app.name') }}">
    <meta name="author" content="Zaiman Noris <rognales@gmail.com>">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="designer" content="Laravel {{ app()->version() }}">

    <title>{{ config('familyday.eventname') }} - {{ config('app.name') }}</title>

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
    <link href="{{ asset('css/creative.css') }}" rel="stylesheet">

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
                        <a class="page-scroll" href="#about">{{ config('familyday.eventname') }}</a>
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
                    <h2 class="section-heading">{{ config('familyday.eventname') }}</h2>
                    <hr class="light">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-calendar fa-5x" aria-hidden="true"></i>
                        <h3>{{ \Carbon\Carbon::parse(config('familyday.eventday'))->format('l, jS F Y') }}</h3>
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
    @if (config('familyday.registration') || auth()->check())
        <section id="registration">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h2 class="section-heading text-center">Registration</h2>
                        <hr class="primary">
                        <form id="form" class="form-horizontal" method="POST"
                            action="{{ route('registration_create') }}">
                            {{ csrf_field() }}
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
                                        <input type="text" class="form-control" id="staff_id" name="staff_id"
                                            value="{{ old('staff_id') }}" placeholder="TM12345" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name') }}" placeholder="Ali Bin Abu" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" placeholder="Use valid email address here"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Meal Option</label>
                                    <div class="col-sm-9">
                                        <label class="radio-inline">
                                            <input type="radio" name="is_vege" value="0"
                                                @checked(old('is_vege', 0)) required> Normal
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="is_vege" value="1"
                                                @checked(old('is_vege', 1)) required> Vegetarian
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset id="dependant_set">
                                <legend>Dependant</legend>
                                <!---start--->
                                @if (old('dependant_name') > 0)
                                    @foreach (old('dependant_name') as $key => $value)
                                        <div @if ($key == 0) id="dependant_list" @endif
                                            class="row form-group">
                                            <div class="col-sm-3">
                                                <select class="form-control" name="dependant_relationship[]">
                                                    <option value="">--Relationship--</option>
                                                    <option value="Spouse"
                                                        @if (old('dependant_relationship' . '.' . $key) == 'Spouse') selected="selected" @endif>
                                                        Spouse</option>
                                                    <option value="Kids"
                                                        @if (old('dependant_relationship' . '.' . $key) == 'Kids') selected="selected" @endif>
                                                        Kids
                                                    </option>
                                                    <option value="Infant"
                                                        @if (old('dependant_relationship' . '.' . $key) == 'Infant') selected="selected" @endif>
                                                        Infant</option>
                                                    <option value="Others"
                                                        @if (old('dependant_relationship' . '.' . $key) == 'Others') selected="selected" @endif>
                                                        Others</option>
                                                    {{-- <option value="Oku"
                                                        @if (old('dependant_relationship' . '.' . $key) == 'Oku') selected="selected" @endif>
                                                        Oku</option> --}}
                                                </select>
                                            </div>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="dependant_name[]"
                                                    placeholder="Name"
                                                    value="{{ old('dependant_name' . '.' . $key) }}">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="number" class="form-control" name="dependant_age[]"
                                                    placeholder="Age" min="1" max="80"
                                                    value="{{ old('dependant_age' . '.' . $key) }}">
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
                                                {{-- <option value="Oku">OKU</option> --}}
                                            </select>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" name="dependant_name[]"
                                                placeholder="Name">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="number" class="form-control" name="dependant_age[]"
                                                placeholder="Age" min="1" max="80">
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
                                    <button type="submit" class="btn btn-primary"
                                        id="btn-register">Register</button>
                                    @auth
                                        <small>Rule for TM HQ only : <mark>OFF</mark></small>
                                    @endauth
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section id="registration">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h2 class="section-heading text-center">Registration</h2>
                        <hr class="primary">
                        <div class="mt-5 text-center">
                            <i class="fa fa-4x fa-heart text-primary mb-4"></i>
                            <h3 class="h4 mb-2">Whopps, registration is not yet open</h3>
                            <p class="text-muted mb-0">We will inform you once we're ready!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section id="terms" class="bg-dark">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 call-to-action">
                    <h2 class=" text-center">Terms &amp; Conditions</h2>
                    <hr class="primary">
                    <ol>
                        <li>TM Family Day is open for all TM HQ & Subsidaries HQ staff only.</li>
                        <li>Every admission to the Family Day will be charged as below:-
                            <table class="table table-sm table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Members of KTMIP
                                            <p> <a class="page-scroll" href="#contact"><span
                                                        class="label label-warning">Join
                                                        Us!</span></a> </p>
                                        </th>
                                        <th class="text-center" style="vertical-align:top">Non-members
                                            <p><span class="label label-success">Discount 50%</span></p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td><mark>Adult</mark> <br /> (age 13 &amp; above)</td>
                                        <td style="vertical-align: middle">
                                            RM {{ config('familyday.rate.adult.member') / 100 }}
                                        </td>
                                        <td style="vertical-align: middle">
                                            <s>RM {{ config('familyday.rate.adult.nonmember_old') / 100 }}</s>
                                            RM {{ config('familyday.rate.adult.nonmember') / 100 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><mark>Kids</mark> <br /> (age 4-12 years old)</td>
                                        <td style="vertical-align: middle">
                                            RM {{ config('familyday.rate.kids.member') / 100 }}
                                        </td>
                                        <td style="vertical-align: middle">
                                            <s>RM {{ config('familyday.rate.kids.nonmember_old') / 100 }}</s>
                                            RM {{ config('familyday.rate.kids.nonmember') / 100 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><mark>Infant</mark> <br /> (age 0-3 years old) </td>
                                        <td style="vertical-align: middle">Free</td>
                                        <td style="vertical-align: middle">Free</td>
                                    </tr>
                                    <tr class="secondary">
                                        <th class="text-center">#</th>
                                        <th class="text-center" colspan="2">Others: i.e. staff’s parents, siblings,
                                            cousins, relatives or maid.</th>
                                    </tr>
                                    <tr>
                                        <td><mark>Adult</mark> <br /> (age 13 &amp; above)</td>
                                        <td style="vertical-align: middle">
                                            RM {{ config('familyday.rate.adult.others') / 100 }}
                                        </td>
                                        <td style="vertical-align: middle">
                                            RM {{ config('familyday.rate.adult.others') / 100 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><mark>Kids</mark> <br /> (age 4-12 years old)</td>
                                        <td style="vertical-align: middle">
                                            RM {{ config('familyday.rate.kids.others') / 100 }}
                                        </td>
                                        <td style="vertical-align: middle">
                                            RM {{ config('familyday.rate.kids.others') / 100 }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><mark>Infant</mark> <br /> (age 0-3 years old) </td>
                                        <td style="vertical-align: middle">Free</td>
                                        <td style="vertical-align: middle">Free</td>
                                    </tr>
                                </tbody>
                            </table>
                        </li>
                        <li>Participation in games will be categorised by age and will be determined by the organiser.
                        </li>
                        <li>Payment can be made after you received email by fill up form proof of payment (receipt).
                        </li>
                        <li>The QR code (for park admission) & receipt will be generate after you made &amp; upload
                            proof of payment.</li>
                        <li>You will need to present your QR code at the admission booth on the event day.</li>
                        <li>If staff withdraws the admission to the Family Day once the payment has been made, no refund
                            will be made.</li>
                        <li>Registration and payment should be made before
                            <mark>{{ \Carbon\Carbon::parse(config('familyday.paymentday'))->format('jS F Y') }}</mark>.
                        </li>
                        <li>For TM staff who are husband and wife, please register in two separate forms. Do make sure
                            your children information are only in one of the form.</li>
                        <li>For information on locker &amp; tube rental, <a href="https://familyday2022.s3.ap-southeast-1.amazonaws.com/infopack/PENYEWAAN+LOKER+DAN+PELAMPUNG.pdf" target="_blank">view this infopack</a>.</li>
                        <li>For information on security aspect of Bangi Wonderland, <a href="https://familyday2022.s3.ap-southeast-1.amazonaws.com/infopack/Info+Keselamatan+Bangi+Wonderland+Theme+Park+and+Resort.pdf" target="_blank">view this security infopack</a>.</li>
                    </ol>
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
                <div class="col-md-5 col-md-offset-1 text-center" style="padding-top:2rem">
                    <p><i class="fa fa-user sr-contact"></i> Mohamad Yusri Mohamad Yusof</p>
                    <p><i class="fa fa-phone sr-contact"></i> 011-1000 9385</p>
                    <p><i class="fa fa-whatsapp sr-contact"></i> <a
                            href="https://api.whatsapp.com/send?phone=601110009385" target="_blank"> Whatsapp Me</a>
                    </p>
                </div>
                <div class="col-md-5 text-center" style="padding-top:2rem">
                    <p><i class="fa fa-user sr-contact"></i> Ruhil Ahlam</p>
                    <p><i class="fa fa-phone sr-contact"></i> 012-213 0902</p>
                    <p><i class="fa fa-whatsapp sr-contact"></i> <a
                            href="https://api.whatsapp.com/send?phone=60122130902" target="_blank"> Whatsapp Me</a>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 col-md-offset-1  text-center" style="padding-top:2rem">
                    <p><i class="fa fa-user sr-contact"></i> Hizamuddin</p>
                    <p><i class="fa fa-phone sr-contact"></i> 019-327 5754</p>
                    <p><i class="fa fa-whatsapp sr-contact"></i> <a
                            href="https://api.whatsapp.com/send?phone=60193275754" target="_blank"> Whatsapp Me</a>
                    </p>
                </div>
                <div class="col-md-5 text-center" style="padding-top:2rem">
                    <p><i class="fa fa-user sr-contact"></i> Hafiz Hamdan</p>
                    <p><i class="fa fa-phone sr-contact"></i> 013-501 4749</p>
                    <p><i class="fa fa-whatsapp sr-contact"></i> <a
                            href="https://api.whatsapp.com/send?phone=60135014749" target="_blank"> Whatsapp Me</a>
                    </p>
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
    </section>
    <section class="bg-dark">
    </section>
    <!--
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                    .appendTo("#dependant_set");
            });

            $("#form").on('submit', function(e) {
                var currentForm = this;
                e.preventDefault();
                bootbox.confirm({
                    title: "Are your sure want to join {{ config('familyday.eventname') }}?",
                    message: "<ul><li>I have read &amp; fully understand the terms &amp; conditions</li><li>I no longer can make changes to the registration</li><li>I understand that payment is to be made via online transfer to Kelab TM Ibu Pejabat. For more info, check your <mark>inbox</mark>. </li></ul><small><strong>Note:</strong> If you do not receive confirmation email in a few minutes, kindly check your <mark>spam</mark> folder</small>",
                    buttons: {
                        confirm: {
                            label: 'Yes, I agree. Proceed!',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No, I changed my mind.',
                            className: 'btn-danger'
                        }
                    },
                    callback: function(confirmed) {
                        console.log(confirmed)
                        if (confirmed)
                            currentForm.submit();
                    }
                });
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-1014386-11"></script>
    @production
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-1014386-11');
        </script>
    @endproduction
</body>

</html>
