<?php
require_once('/home/mhsa/includes/include.php');

if(!isset($_SESSION['twitter_name'])) {
  header('Location: /');
}

$username = $_SESSION['twitter_name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>MHS Assassins</title>

  <!-- Bootstrap Core CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- Custom CSS -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet" type="text/css">

  <!-- Custom Fonts -->
  <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

  <link rel="icon" href="favicon.ico" type="image/x-icon"/>

  <style>
  .twitter_login {
    background: 0;
    padding: 0;
  }

  .twitter_login img {
    width: 100%;
  }

  .center-row {
    margin: 0 auto;
    float: none;
  }
  </style>

  <!-- IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body>
  <!-- Header -->
  <header id="top" class="header">
    <div class="text-vertical">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5 col-md-offset-1 center-row">
            <h1><span style="float:left;">ASSASSINS</span> <label style="float: left; margin-top: 13px; margin-left: 25px; font-size: 17px;" class="label label-danger label-small"> 2016</label></h1>

            <p class="text-center">Hey, @<?=$username?>! Only one more step...<br>Are you ready to purge?!?</p>

            <form id="contactForm" novalidate>
              <div class="row control-group">
                <div class="form-group col-lg-6 floating-label-form-group controls no-pad-right">
                  <label for="email" class="sr-only control-label">Email</label>
                  <input type="email" class="form-control input-lg text-center" placeholder="Email" id="email" required data-validation-required-message="Please enter your email address.">
                  <span class="help-block text-danger"></span>
                </div>
                <div class="form-group col-lg-12 floating-label-form-group controls">
                  <label for="phone" class="sr-only control-label">Your Phone #</label>
                  <input type="tel" class="form-control input-lg text-center" placeholder="Your Phone #" id="phone" required data-validation-required-message="Please enter your phone number.">
                  <span class="help-block text-danger"></span>
                </div>
              </div>
              <div id="success" style="text-shadow: none;"></div>
              <div class="row">
                <div class="form-group col-xs-12">
                  <button type="submit" class="btn btn-lg btn-block btn-danger">Finish Sign Up</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


</header>
<!-- footer -->
<footer>
  <div class="container text-muted text-center wow fadeIn">
    <h2 class="heading"><a href="index.html#top">ASSASSINS <i class="fa fa-heartbeat"></i></a></h2>
    <p> 2016 Martin High School Assassins Game</p>
  </div>
</footer>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/hybrid.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/jquery.placeholder.min.js"></script>
<script src="js/TimeCircles.js"></script>

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
            $.ajax({
                url: "/ajax/twitterRegister.php",
                type: "POST",
                data: {
                    phone: phone,
                    email: email
                },
                cache: false,
                success: function(data) {
					switch (data) {
						case "-1":
							$('#success').html("<div class='alert alert-danger'>");
							$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
								.append("</button>");
							$('#success > .alert-danger').append("<strong>Sorry " + firstName + ", it seems there is a problem with our system. Please try again later!</strong>");
							$('#success > .alert-danger').append('</div>');
						break;
						case "0":
							$('#success').html("<div class='alert alert-success'>");
							$('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
								.append("</button>");
							$('#success > .alert-success')
								.append("<strong>Please confirm your registration by responding to the confirmation text. </strong>");
							$('#success > .alert-success')
								.append('</div>');
                document.getElementById("contactForm").reset();
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

    $("a[data-toggle=\"tab\"]").click(function(e) {
        e.preventDefault();
        $(this).tab("show");
    });
});
</script>

</body>
</html>
