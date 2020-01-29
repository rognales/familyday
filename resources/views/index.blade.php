<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/freelancer.min.css') }}" rel="stylesheet">

    <!-- Navigation -->

</head>
<body id="page-top" class="index">
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header page-scroll">
        <a class="navbar-brand" href="#page-top">kelab TM Ibu Pejabat</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    </div>
    <!-- /.navbar-collapse -->
</div>
<!-- /.container-fluid-fluid -->
</nav>

    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                <img class="img-rounded" src="{{URL::asset('/images/Capture1.jpg')}} " />
                @empty ($participant)
                <button class="btn btn-primary btn-lg" role="button" type="button"><a href="#portfolio">Click Here To Register</a></button>
                @endempty
                </div>
            </div>
        </div>
    </header>
<section id="portfolio">
<div class="container-fluid">


                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->

                </div>


        @include('registration.index')
</div>
    </section>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        //dynamically add dependant form
        $( "#add_dependant" ).click(function() {
          $( "#dependant_list" ).clone().find('input').val('').end().appendTo( "#dependant_set" );
        });
      });

    </script>

    <!-- Theme JavaScript -->
    <script src="{{ asset('js/freelancer.min.js') }}"></script>
</body>
</html>
