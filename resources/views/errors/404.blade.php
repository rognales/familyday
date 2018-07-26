
<!DOCTYPE html>
<html lang="en">

  <head>

    <!-- Meta Tag -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Lost - 404 Error Page</title>

    <link href="https://bootswatch.com/united/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

    <!-- Main CSS Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/lost.css')}}">

    <!-- Google Web Fonts  -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700|Monoton">


    <!-- HTML5 shiv and Respond.js support IE8 or Older for HTML5 elements and media queries -->
    <!--[if lt IE 9]>
	   <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


 </head>

  <body>


    <!-- Grained Background Start -->
    <div id="lost">

    <!-- Error Page Start -->
    <section class="error-page-background">
       <div class="container">

         <div class="row">

           <div class="col-md-12">


                  <!-- Error Page Content Start -->

                  <div class="text-center">
                  <a href="" data-toggle="modal" data-target="#reason" title="Why You Are Seeing 404 Page"><i class="icon-question bounce"></i></a>
                        </div>

                            <h2>404</h2>
                            <p>The Page You Are Looking For Doesn't Exist.</p>

                             <div class="text-center">
                               <a class="button button-style" href="javascript:history.back()">Go Back</a>
                            </div>

                            <!-- Error Page Content End -->

                   </div>
              </div>
            </div>
        </section>
        <!-- Error Page End -->

       </div>
       <!-- Grained Background End -->




       <!-- Reason Popup Start -->
       <div class="modal fade reason-popup-box padding-top-120" id="reason" role="dialog">
         <div class="modal-dialog">


         <div class="modal-content">
            <div class="modal-body">
               <div class="row">
                  <div class="col-sm-12">

                   <div class="box-padding">
                     <button type="button" class="btn pull-right" data-dismiss="modal"><i class="icon-close"></i></button>
                      <h3>Why You Are Seeing 404 Page ?</h3>

                       <div class="margin-top-20">

                          <ul class="list-icon size-sm">
                            <li>Maybe, The page is removed.</li>
                            <li>Maybe, The page name have changed.</li>
                            <li>Maybe, You did typed wrong keyword.</li>
                            <li>Maybe, The link is temporarily unavailable.</li>
                           </ul>

                           </div>

                         </div>


                     </div>
                    </div>
                 </div>
             </div>
          </div>
       </div>
       <!-- Reason Popup End -->


       <!-- UiPasta Credit Start
        <div class="uipasta-credit">Design By <a href="http://www.uipasta.com" target="_blank">UiPasta</a></div>
        UiPasta Credit End -->



        <script src="{{ asset('js/manifest.js') }}"></script>
        <script src="{{ asset('js/vendor.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{asset('js/grained.js')}}"></script>

    <!-- Main Javascript File  -->
    <script type="text/javascript">

      $("document").ready(function () {

      var lost = {
        "animate": true,
        "patternWidth": 100,
        "patternHeight": 100,
        "grainOpacity": 0.57,
        "grainDensity": 2.1,
        "grainWidth": 3.55,
        "grainHeight": 1
      }

      grained("#lost", lost);

      });
    </script>

  </body>
 </html>
