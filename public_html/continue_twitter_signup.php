<?php
header('Location: /');
die();
require_once '/home/mhsa/includes/include.php';

if (!isset($_SESSION['twitter_name'])) {
    header('Location: /');
}

$username = $_SESSION['twitter_name'];
?>

<!-- Hello curious visitor. If you think that somehow looking through this source code will allow you to find your assassin, you're WRONG. Go back to doing your regulars algebra homework because you obviously don't have the knowledge to realize that what you are doing is futile.-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>MHS Assassins</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/lightbox.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
  <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">

  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="images/favicon.ico">
</head><!--/head-->

<body>

  <!--.preloader-->
  <div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>
  <!--/.preloader-->

  <header id="home">
    <div class="main-nav">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="/">
            <h1><center><img class="img-responsive logo" src="images/logo.png" alt="logo"></center></h1>
          </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="scroll"><a href="/">&nbsp;</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <section id="register" class="parallax">
    <div>
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2">
            <div class="twitter-icon text-center">
              <h2>FINISH REGISTRATION</h2>
            </div>
            <div id="success"></div>
            <div id="twitter-carousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="item active wow fadeIn" data-wow-duration="1000ms" data-wow-delay="300ms">
                  <div id="contactForm">
                    <form id="contactForm" style="padding: 0" novalidate>
                      <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                          <label for="name" class="sr-only control-label">Full Name</label>
                          <input type="text" class="form-control" placeholder="Full Name" id="name" required data-validation-required-message="Please enter your name.">

                          <br>

                          <label for="email" class="sr-only control-label">Email</label>
                          <input type="email" class="form-control" placeholder="Email" id="email" required data-validation-required-message="Please enter your email address.">

                          <br>

                          <label for="phone" class="sr-only control-label">Your Phone #</label>
                          <input type="tel" class="form-control" placeholder="Phone" id="phone" required data-validation-required-message="Please enter your phone number.">

                          <span class="help-block text-danger"></span>
                        </div>
                      </div>
                      <div id="success"></div>
                      <div class="row">
                        <div class="form-group col-xs-12">
                          <button id="submitBT" type="submit" class="btn-submit">Finish</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer id="footer">
    <div class="footer-top wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
      <div class="container text-center">
        <div class="footer-logo ">
          <center><a href="index.html" class = "white"><img class="img-responsive" src="images/logo.png" alt="">MHS ASSASSINS 2016</a></center>
        </div>
        <div class="social-icons">
          <ul>
            <li><a class="twitter" target="_blank" href="http://www.twitter.com/martinassassins"><i class="fa fa-twitter"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.inview.min.js"></script>
  <script type="text/javascript" src="js/wow.min.js"></script>
  <script type="text/javascript" src="js/mousescroll.js"></script>
  <script type="text/javascript" src="js/smoothscroll.js"></script>
  <script type="text/javascript" src="js/jquery.countTo.js"></script>
  <script type="text/javascript" src="js/lightbox.min.js"></script>
  <script type="text/javascript" src="js/jquery.countdown.min.js"></script>
  <script type="text/javascript" src="js/jqBootstrapValidation.js"></script>
  <script type="text/javascript" src="js/main.js"></script>

  <script>
  $(function() {
      $("input,textarea").jqBootstrapValidation({
          preventSubmit: true,
          submitError: function($form, event, errors) {
              // additional error messages or events
          },
          submitSuccess: function($form, event) {
              event.preventDefault();
              var phone = $("input#phone").val();
              var email = $("input#email").val();
              var firstName = '@<?=$username?>';
              document.getElementById("submitBT").disabled = true;
              $.ajax({
                  url: "/ajax/twitter_register",
                  type: "POST",
                  data: {
                      phone: phone,
                      email: email
                  },
                  cache: false,
                  success: function(data) {
                      document.getElementById("submitBT").disabled = false;
            					switch (data) {
            						case "-1":
            							$('#success').html("<div class='alert alert-danger'>");
            							$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            								.append("</button>");
            							$('#success > .alert-danger').append("<strong>Sorry " + firstName + ", it seems there is a problem with our system. Please try again later!</strong>");
            							$('#success > .alert-danger').append('</div>');
            						break;
            						case "0":
            							window.location.replace("https://mhsa.io/complete");
            						break;
            						case "1": // phone invalid
            							$('#success').html("<div class='alert alert-danger'>");
            							$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            								.append("</button>");
            							$('#success > .alert-danger').append("<strong>Please enter a valid US phone number.</strong>");
            							$('#success > .alert-danger').append('</div>');
            						break;
            						case "2": // phone duplicate
            							$('#success').html("<div class='alert alert-danger'>");
            							$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            								.append("</button>");
            							$('#success > .alert-danger').append("<strong>The phone number you entered is already registered.</strong>");
            							$('#success > .alert-danger').append('</div>');
            						break;
                        case "3": // email invalid
                          $('#success').html("<div class='alert alert-danger'>");
                          $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                          $('#success > .alert-danger').append("<strong>Plase enter a valid e-mail address.</strong>");
                          $('#success > .alert-danger').append('</div>');
                        break;
                        case "4": // email duplicate
                          $('#success').html("<div class='alert alert-danger'>");
                          $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                          $('#success > .alert-danger').append("<strong>The email you entered is already registered.</strong>");
                          $('#success > .alert-danger').append('</div>');
                        break;
            					}
                            },
                            error: function() {
                                // Fail message
                                $('#success').html("<div class='alert alert-danger'>");
                                $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                                    .append("</button>");
                                $('#success > .alert-danger').append("<strong>Sorry " + firstName + ", it seems there is a problem with our system. Please try again later!");
                                $('#success > .alert-danger').append('</div>');
                            },
                        })
                    },
                    filter: function() {
                        return $(this).is(":visible");
                    },
                });
            });
      </script>
    </body>
</html>
