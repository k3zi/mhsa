<?php
require_once('/home/mhsa/includes/include.php');
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
  </style>

  <!-- IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body>

  <!-- Navigation -->
  <a id="menu-toggle" href="index.html#" class="btn btn-dark btn-lg toggle"><i class="fa fa-1x fa-bars"></i></a>
  <nav id="sidebar-wrapper">
    <!--  Optional: close button
    <a id="menu-close" href="#" class="btn btn-light btn-lg pull-right toggle"><i class="fa fa-2x fa-times"></i></a> -->
    <ul class="sidebar-nav">
      <li class="sidebar-brand">
        <a href="index.html#top">Assassins</a>
      </li>
      <li>
        <a href="index.html#top">Home</a>
      </li>
      <li>
        <a href="index.html#about">About</a>
      </li>
      <li>
        <a href="index.html#rules">Rules</a>
      </li>
      <li>
        <a href="index.html#instructions">Instructions</a>
      </li>
      <li>
        <a href="index.html#statistics" data-toggle="modal" data-target="#statistics">Statistics</a>
      </li>
      <li>
        <a href="index.html#countdown">Countdown</a>
      </li>
      <li>
        <a href="index.html#contact">Contact</a>
      </li>
    </ul>
  </nav>

  <!-- Header -->
  <header id="top" class="header">
    <div class="text-vertical">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5 col-md-offset-1">
            <h1><span style="float:left;">ASSASSINS</span> <label style="float: left; margin-top: 13px; margin-left: 25px; font-size: 17px;" class="label label-danger label-small"> 2016</label></h1>
            <h2><i class="fa fa-info-circle"></i> About</h2>

            <p>The game of Assassins is a student run tradition held at Martin. Through the years the game has been run by different students who elect themselves to take on the project. The game is simple, you are assigned a target to “assassinate” meanwhile someone is assigned to “assassinate” you. Last man standing wins.<br><strong><em>Only seniors are allowed to participate.</em></strong></p>

          </div>

          <div class="col-md-4 col-md-offset-1">
            <h2>Sign up now</h2>
            <p>It's 100% free. Feel free to leave a tip tho!</p>

            <div id="contactForm">
              <div class="row">
                <div class="form-group col-xs-12">
                  <a href="/signUpWithTwitter"><button class="btn btn-lg btn-block twitter_login"><img src="images/twitter.png"/></button></a>
                  <!--<center><div class="alert alert-info" role="alert">Registrations are now closed!</div></center>-->
                </div>
              </div>

              <p class="text-center">OR</p>

              <form id="contactForm" style="padding: 0" novalidate>
                <div class="row control-group">
                  <div class="form-group col-lg-6 floating-label-form-group controls">
                    <label for="name" class="sr-only control-label">Full Name</label>
                    <input type="text" class="form-control input-lg" placeholder="Full Name" id="name" required data-validation-required-message="Please enter your name.">
                    <span class="help-block text-danger"></span>
                  </div>
                  <div class="form-group col-lg-6 floating-label-form-group controls no-pad-right">
                    <label for="email" class="sr-only control-label">Email</label>
                    <input type="email" class="form-control input-lg" placeholder="Email" id="email" required data-validation-required-message="Please enter your email address.">
                    <span class="help-block text-danger"></span>
                  </div>
                  <div class="form-group col-lg-6 floating-label-form-group controls">
                    <label for="phone" class="sr-only control-label">Your Phone #</label>
                    <input type="tel" class="form-control input-lg" placeholder="Phone" id="phone" required data-validation-required-message="Please enter your phone number.">
                    <span class="help-block text-danger"></span>
                  </div>
                </div>
                <div id="success"></div>
                <div class="row">
                  <div class="form-group col-xs-12">
                    <button type="submit" class="btn btn-lg btn-block btn-danger">Sign Up</button>
                    <!--<center><div class="alert alert-info" role="alert">Registrations are now closed!</div></center>-->
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- mouse -->
        <span class="scroll-btn hidden-xs wow fadeInDownBig">
          <a href="index.html#about"><span class="mouse"><span></span></span></a>
        </span>
        <!-- mouse -->
      </div>
    </div>


  </header>

  <!-- about -->
  <section id="about" class="about">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 text-center wow fadeIn">
          <h2 class="heading">About Assassins</h2>
          <p class="lead">The game of Assassins is a student run tradition held at Martin each year. Through the years the game has been run by different students who elect themselves to take on the project. The game is simple, although changes are made with each passing year, rules are added and modified, it has evolved much since its original version.<br><br>
            The game starts with students registering themselves as contestants. This is done specifically so that the competition is by choice only. Next, these players are all randomly assigned targets. This is done in a way so that every student has a different target, and every student has someone targeting them.<br><br>
            Once the hunt begins each student attempts to seek out their target and “assassinate” them. This is done by surprising their target and marking their skin with a sharpie marker. Once marked, that player is officially eliminated from the game. The assassin is then given his victim’s target.<br><br>
            When eliminated, both players must text (817)-435-2347. The person who made the kill will send the message “eliminated” and the person killed will send “rip”. From there the target will be taken out of the system, and the system will inform the assassin of their new target.<br><br>
            This idea is continued until there is only two players left in the pool. Each of them would have each other as targets so the last man standing wins.<br><br>
            One of the newer additions to the game is the “swiper no swiping” rule. Players are allowed to call out this phrase if they spot their assassin first which would grant them immunity from being assassinated by that assassin for the rest of the day. This ability can only be used once by the hunted for that particular assassin. If the assassin gets killed, his target is given the ability one more time against his new assassin.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- rules -->
    <section id="rules" class="head">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 text-center wow fadeIn">
            <h2 class="heading">The Rules</h2>
            <p class="lead">The rules are simple and must be ahered to at all times, otherwise you will face disqualification.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="services">
      <div class="container-fluid">
        <div class="col-lg-10 col-lg-offset-1">
          <div class="row wow fadeIn" data-wow-delay=".2s">
            <div class="col-lg-3 col-md-6 col-sm-6" style="min-height: 175px;">
              <h3><i class="fa fa-building fa-lg"></i> #1</h3>
              <p> No assassinating at someone’s workplace or house</p>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6" style="min-height: 175px;">
              <h3><i class="fa fa-book fa-lg"></i> #2</h3>
              <p> No assassinating inside classrooms</p>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6" style="min-height: 175px;">
              <h3><i class="fa fa-car fa-lg"></i> #3</h3>
              <p> No assassinating inside vehicles</p>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6" style="min-height: 175px;">
              <h3><i class="fa fa-user-times fa-lg"></i> #4</h3>
              <p> No assassinating on someone’s face</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- case-study -->
    <section id="instructions" class="head">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 text-center wow fadeIn">
            <h2 class="heading">Instructions</h2>
            <p class="lead">A quick how-to on playing Assassins</p>
          </div>
        </div>
      </div>
    </section>

    <section class="case-study">
      <div class="container-fluid">
        <div class="col-lg-10 col-lg-offset-1">
          <div class="row">
            <div class="container-fluid">
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-sm-12 wow fadeIn" data-wow-delay=".2s">
                    <h3><i class="fa fa-clock-o fa-lg"></i> Start/End</h3>
                    <p>On the 2nd of April the game officially started at 12:01 AM.<br>Registrations closed 24 hours before the game starts.<br>It all ends when there is one man left standing.</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 wow fadeIn" data-wow-delay=".6s">
                    <h3><i class="fa fa-pencil fa-lg"></i> Tagging</h3>
                    <p>If you are tagged or you get tagged:<br>
                      <ul>
                        <li>If you were the assassin text “eliminated” to (817)-435-2347</li>
                        <li>If you were assassinated text “rip” to (817)-435-2347</li>
                      </ul>
                      Note: both messages must be within five minutes of each other</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 wow fadeIn" data-wow-delay=".8s">
                      <h3><i class="fa fa-book fa-lg"></i> Tagging rules</h3>
                      <p>An official tag consists of a mark that is:<br>
                        <ul>
                          <li>Anywhere but on the face</li>
                          <li>At least a centimeter</li>
                          <li>Agreed as valid by both parties</li>
                        </ul>
                      </p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 wow fadeIn" data-wow-delay=".8s">
                      <h3><i class="fa fa-group fa-lg"></i> Joining</h3>
                      <p>To join simply fill out the form at the top  this page. Once you have done that, you should immediately receive a text/e-mail message to confirm you are in our system. Once the start countdown finishes, you will receive your target via text, if you eliminate your target, you will receive a message with the name of your new target as soon as the system confirms the assassination.</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 wow fadeIn" data-wow-delay=".8s">
                      <h3><i class="fa fa-cog fa-lg"></i> Commands</h3>
                      <p>To learn more about the functions available during the game, <a href='index.html#commands' onClick="window.location = '#commands'">click here</a>.</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-5 col-lg-offset-1 hidden-sm img-case-study-greed text-center wow fadeInRight">
                  <img src="images/res2.png" alt="">
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Portfolio Grid Section -->
      <section id="countdown" class="head">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 text-center wow fadeIn">
              <h2 class="heading">The Countdown</h2>
              <h3>Are you ready? Time elapsed:</h3>
            </div>
          </div>
        </div>
      </section>

      <!-- Statistics Modal -->
      <div class="statistics-modal modal fade" id="statistics" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
          <div class="close-modal" data-dismiss="modal">
            <i class="fa fa-times fa-3x fa-fw"></i>
          </div>
          <div class="modal-body">
            <h2>Statistics</h2>
            <hr>
            <p><b>Players:</b> <span id="stat_reg_users"><em>Loading...</em></span></p>
            <p><b>Players alive:</b> <span id="stat_alive"><em>Loading...</em></span></p>
            <p><b>Players dead:</b> <span id="stat_dead"><em>Loading...</em></span></p>
            <p><b>Players assassinated:</b> <span id="stat_assassinated"><em>Loading...</em></span></p>
            <p><b>Players suicided:</b> <span id="stat_suicided"><em>Loading...</em></span></p>
            <p><b>Top 10:</b></p>
            <p id="stat_top10">Loading...</p>
            <p>To see the full leaderboard, <a href="index.html#leaderboard" onclick="window.location = '#leaderboard'">click here</a>.</p>
            <button type="button" class="border-button-black" data-dismiss="modal">CLOSE</button>
          </div>
        </div>
      </div>

      <!-- Leaderboard Modal -->
      <div class="statistics-modal modal fade" id="leaderboard" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
          <div class="close-modal" data-dismiss="modal">
            <i class="fa fa-times fa-3x fa-fw"></i>
          </div>
          <div class="modal-body">
            <h2>Leaderboard</h2>
            <hr>
            <p>Ranking is done primarily by number of kills, then secondarily by time of last kill or time of death, then tertiarily by whether the player is alive or dead, where dead players are always at the bottom of their kill level.<br>And just if you are in 1st place is does not mean you are "winning", the last man standing wins, although you still get 1st place bragging rights. :)</p>
            <p id="players_leaderboard">Loading...</p>
            <button type="button" class="border-button-black" data-dismiss="modal">CLOSE</button>
          </div>
        </div>
      </div>

      <!-- Commands Modal -->
      <div class="statistics-modal modal fade" id="commands" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
          <div class="close-modal" data-dismiss="modal">
            <i class="fa fa-times fa-3x fa-fw"></i>
          </div>
          <div class="modal-body">
            <h2>Commands</h2>
            <hr>
            <p>To use any of these commands you must text them to (817)-435-2347.</p>
            <p><b>#&lt;message&gt;</b> - This messages the administrators of the game, and we can reply directly through the Assassins number.</p>
            <p><b>top</b> - Gives you a list of the top 10 ranked players and a link to the statistics page</p>
            <p><b>eliminated</b> - Text this only when you have eliminated your target</p>
            <p><b>rip &lt;pin&gt;</b> - Text rip followed by your PIN when you've been assassinated, e.g. rip 1234</p>
            <p><b>suicide &lt;pin&gt;</b> - Text suicide followed by your PIN if you want to leave the game at any time</p>
            <p><b>pin(email)</b> - Texting pin gives you a link the page where you can set your PIN; texting pinemail emails you this link</p>
            <p><b>status</b> - Status tells you your current status in the game, either: alive/dead/suicided/assassinated/not_registered</p>
            <p><b>test</b> - This shows which of the verification steps you have completed</p>
            <p><b>about &lt;command&gt;</b> - Text about followed by one of the possible commands to find out more about how to use that command</p>
            <p><b>target</b> - This gives you the name of your target</p>
            <p><b>whois</b> - This simply returns your own name, to verify whose account the phone is attached to</p>
            <p><b>me</b> - This gives you the link to your personal statistics page</p>
            <p><b>rank</b> - This tells you what your rank in the game is</p>
            <p><b>subscribe [carrier]</b> - This allows you to subscribe to instant SMS updates, further instructions are given when you text subscribe</p>
            <p>
              <button type="button" class="border-button-black" data-dismiss="modal">CLOSE</button>
            </div>
          </div>
        </div>

        <!-- testimonials -->
        <section id="testimonials">
          <div class="container text-center">
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <div class="countdown-time animated bounceIn" data-date="2016-04-01 00:01:00"></div>
              </div>
            </div>
          </div>
        </section>

        <!-- sponsors -->
        <div id="sponsor">
          <div class="container-fluid">
            <div class="row sponsor text-center wow fadeInLeftBig">
              <div class="col-md-10 gray col-md-offset-1">
                <a href="index.html# 2016"><img src="images/year.png" alt="" class = "img-responsive"></a>
              </div>
            </div>
          </div>
        </div>

        <!-- contacts -->
        <div id="contact">
          <div class="container-fluid overlay text-center">
            <div class="col-md-6 col-md-offset-3 wow fadeIn">
              <h2 class="heading">Contact Us</h2>
              <h2><i class="fa fa-phone fa-fw"></i>(817)-435-2347</h2>
              <p>Feel free to text us to provide some feedback, give us suggestions, or even to just say hello!</p>
              <ul class="list-inline">
                <li>
                  <a href="https://twitter.com/MartinAssassins"><i class="fa fa-twitter fa-2x fa-fw"></i></a>
                </li>
                <li>
                  <a href="mailto:admin@mhsa.io"><i class="fa fa-envelope-o fa-2x  fa-fw"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>

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
        $('a[data-toggle="modal"][data-target="#statistics"]').click(function() {
          window.location.hash = "statistics";
          $.get("/ajax/statistics.php", function(data) {
            data = $.parseJSON(data);
            $("#stat_reg_users").html(data.registered_users);
            $("#stat_alive").html(data.alive_players);
            $("#stat_dead").html(data.dead_players);
            $("#stat_assassinated").html(data.assassinations);
            $("#stat_suicided").html(data.suicides);
            var top10 = "<ol>";
            for (var i = 0; i < data.top10.length; ++i) {
              top10 += "<li>"+data.top10[i][0]+", "+data.top10[i][1]+" kill"+((data.top10[i][1] == 1) ? "" : "s")+""+((data.top10[i][2] == 1) ? " <small>(deceased)</small>" : "")+"</li>";
              console.log(data.top10[i]);
            }
            top10 += "</ol>";
            $("#stat_top10").html(top10);
          });
          $("#statistics").modal('show');

          $("#sidebar-wrapper").removeClass("active");
        });

        function update_leaderboard() {
          $.get("/ajax/leaderboard.php", function(data) {
            data = $.parseJSON(data);
            var all = "<ol>";
            for (var i = 0; i < data.all.length; ++i) {
              all += "<li><a href='/u/"+data.all[i][3]+"' onClick='window.location=\"/u/"+data.all[i][3]+"\"'>"+data.all[i][0]+"<a/>, "+data.all[i][1]+" kill"+((data.all[i][1] == 1) ? "" : "s")+""+((data.all[i][2] == 1) ? " <small>(deceased)</small>" : "")+"</li>";
            }
            all += "</ol>";
            $("#players_leaderboard").html(all);
          });
        }

        var countdown =  $('.countdown-time');

        createTimeCicles();

        $(window).on('resize', windowSize);
        $(document).ready(function() {
          if (window.location.hash == "#statistics") {
            $('a[data-toggle="modal"][data-target="#statistics"]').trigger('click');
            document.title = "MHS Assassins | Statistics";
          } else if (window.location.hash == "#commands") {
            $("#commands").modal('show');
            document.title = "MHS Assassins | Commands";
          } else if (window.location.hash == "#leaderboard") {
            $("#leaderboard").modal('show');
            update_leaderboard();
            document.title = "MHS Assassins | Leaderboard";
          }
        });

        $(window).bind('hashchange', function(e) {
          if (window.location.hash == "#commands") {
            $("#commands").modal('show');
            document.title = "MHS Assassins | Commands";
          } else if (window.location.hash == "#leaderboard") {
            $("#leaderboard").css("display", "block").attr("aria-hidden", "false");
            $("#leaderboard").modal('show');
            update_leaderboard();
            document.title = "MHS Assassins | Leaderboard";
          } else if (window.location.hash == "#statistics") {
            $("#leaderboard").css("display", "none").attr("aria-hidden", "true");
            $('a[data-toggle="modal"][data-target="#statistics"]').trigger('click');
            document.title = "MHS Assassins | Statistics";
          } else {
            $("#commands").modal('hide');
            $("#statistics").modal('hide');
            $("#leaderboard").modal('hide');
          }
        });

        $('#statistics,#commands,#leaderboard').on('hidden.bs.modal', function() {
          window.location.hash = "!";
          document.title = "MHS Assassins";
        });

        function windowSize() {
          countdown.TimeCircles().destroy();
          createTimeCicles();
          countdown.on('webkitAnimationEnd mozAnimationEnd oAnimationEnd animationEnd', function() {
            countdown.removeClass('animated bounceIn');
          });
        }

        function createTimeCicles() {
          countdown.addClass('animated bounceIn');
          countdown.TimeCircles({
            fg_width: 0.013,
            bg_width: 0.6,
            circle_bg_color: '#ffffff',
            time: {
              Days: {color: '#19B5FE'}
              ,	   Hours: {color: '#19B5FE'}
              ,	 Minutes: {color: '#19B5FE'}
              ,	 Seconds: {color: '#19B5FE'}
            }
          });
          countdown.on('webkitAnimationEnd mozAnimationEnd oAnimationEnd animationEnd', function() {
            countdown.removeClass('animated bounceIn');
          });
        }

        $(function() {
            $("input,textarea").jqBootstrapValidation({
                preventSubmit: true,
                submitError: function($form, event, errors) {
                    // additional error messages or events
                },
                submitSuccess: function($form, event) {
                    event.preventDefault(); // prevent default submit behaviour
                    // get values from FORM
                    var name = $("input#name").val();
                    var phone = $("input#phone").val();
                    var email = $("input#email").val();
                    var firstName = name; // For Success/Failure Message
                    // Check for white space in name for Success/Fail message
                    if (firstName.indexOf(' ') >= 0) {
                        firstName = name.split(' ').slice(0, -1).join(' ');
                    }
                    $.ajax({
                        url: "/ajax/register",
                        type: "POST",
                        data: {
                            name: name,
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
        								.append("<strong>Please confirm your registration by responding to the confirmation text.</strong>");
        							$('#success > .alert-success')
        								.append('</div>');
        							document.getElementById("contactForm").reset();
        						break;
        						case "1": // email invalid
        							$('#success').html("<div class='alert alert-danger'>");
        							$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
        								.append("</button>");
        							$('#success > .alert-danger').append("<strong>Plase enter a valid e-mail address.</strong>");
        							$('#success > .alert-danger').append('</div>');
        						break;
        						case "2": // phone invalid
        							$('#success').html("<div class='alert alert-danger'>");
        							$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
        								.append("</button>");
        							$('#success > .alert-danger').append("<strong>Please enter a valid US phone number.</strong>");
        							$('#success > .alert-danger').append('</div>');
        						break;
        						case "3": // name invalid
        							$('#success').html("<div class='alert alert-danger'>");
        							$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
        								.append("</button>");
        							$('#success > .alert-danger').append("<strong>Please enter your first & last name.</strong>");
        							$('#success > .alert-danger').append('</div>');
        						break;
        						case "4": // phone duplicate
        							$('#success').html("<div class='alert alert-danger'>");
        							$('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
        								.append("</button>");
        							$('#success > .alert-danger').append("<strong>The phone number you entered is already registered.</strong>");
        							$('#success > .alert-danger').append('</div>');
        						break;
                    case "5": // email duplicate
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
                            //clear all fields
                            document.getElementById("contactForm").trigger("reset");
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
