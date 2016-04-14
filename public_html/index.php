<?php
require_once(substr(getcwd(), 0, strpos(getcwd(), 'public_html')).'includes/include.php');
?>

<!-- Hello troll. If you think that somehow looking through this source code will allow you to find your assassin, you're WRONG. Go back to doing your regulars algebra homework because you obviously don't have the knowledge to realize that what you are doing is futile.-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo SYSTEM_SITE_NAME; ?></title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/lightbox.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">
  <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">
  <link href="css/dataTables.bootstrap.min.css" rel="stylesheet">

  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="images/favicon.ico">

  <style>
  td, th {
      vertical-align: middle !important;
      text-align: center;
  }
  </style>
</head><!--/head-->

<body>

  <!--.preloader-->
  <div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>
  <!--/.preloader-->

  <header id="home">
    <div id="home-slider" class="carousel slide carousel-fade" data-ride="carousel">
      <div class="carousel-inner">
        <div class="item active" style="background: url(images/slider/assassins_bg.png) no-repeat center center fixed;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;">
          <div class="caption">
            <h1 class="animated fadeInLeftBig">Welcome to <span><?php echo SYSTEM_SITE_NAME; ?></span></h1>
            <p class="animated fadeInRightBig">Martin High School - Senior Class - Last One Standing Wins</p>
            <? if (SYSTEM_STARTED) { ?>
                <p class="animated fadeInLeftBig"><a href="https://twitter.com/MartinAssassins">The Game Has Begun</a></p>
            <? } else { ?>
                <div class="animated fadeInLeftBig" id="countdown"></div>
            <? } ?>
            <p class="animated fadeInRightBig">Total Players: <?=getTotalNumberOfPlayers()?> | Alive: <?=getNumberOfPlayersAlive()?> | Dead: <?=getNumberOfKills()?> | Suicide: <?=getNumberOfPlayersSuicide()?></p>
            <a data-scroll class="btn btn-start animated fadeInUpBig" href="#statistics-top">View Stats</a>
          </div>
        </div>
      </div>
      <a id="tohash" href="#about"><i class="fa fa-angle-down"></i></a>

    </div>
    <div class="main-nav">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">
            <h1><center><img class="img-responsive logo" src="images/logo.png" alt="logo"></center></h1>
          </a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="scroll active"><a href="#home">Home</a></li>
            <li class="scroll"><a href="#about">About</a></li>
            <li class="scroll"><a href="#rules">Rules</a></li>
            <li class="scroll"><a href="#instructions">Instructions</a></li>
            <li class="scroll"><a href="/terms">Terms</a></li>
            <li class="scroll"><a href="#statistics">Statistics</a></li>
            <li class="scroll"><a href="#contact">Contact</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <section id="about">
    <div class="container">
      <div class="heading wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
        <div class="row">
          <div class="text-center col-sm-8 col-sm-offset-2">
            <h2>About Assassins</h2>
            <p>The game of Assassins is a student run tradition held at Martin each year. Through the years the game has been run by different students who elect themselves to take on the project. The game is simple, although changes are made with each passing year, rules are added and modified, it has evolved much since its original version. We hope you enjoy this year's games as much as we enjoyed setting it up.</p>
          </div>
        </div>
      </div>
      <div class="text-center our-services">
        <div class="row">
          <div class="col-sm-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
            <div class="service-icon">
              <i class="fa fa-graduation-cap"></i>
            </div>
            <div class="service-info">
              <h3>Led by Seniors, for Seniors</h3>
              <p>This Martin tradition is entirely run by students at the school.</p>
            </div>
          </div>
          <div class="col-sm-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="450ms">
            <div class="service-icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <div class="service-info">
              <h3>Register as an Assassin</h3>
              <p>Simply register as an assassin and play the game! We hope to provide a great experience.</p>
            </div>
          </div>
          <div class="col-sm-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="550ms">
            <div class="service-icon">
              <i class="fa fa-cutlery"></i>
            </div>
            <div class="service-info">
              <h3>Predator or Prey?</h3>
              <p>Once the game starts you will be assigned a target to assassinate, but be careful, someone is after you too.</p>
            </div>
          </div>
          <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="650ms">
            <div class="service-icon">
              <i class="fa fa-pencil"></i>
            </div>
            <div class="service-info">
              <h3>A Sharpie is your Weapon</h3>
              <p>Assassinate your target by marking them with a sharpie marker. When marked, the player is eliminated from the game.</p>
            </div>
          </div>
          <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="750ms">
            <div class="service-icon">
              <i class="fa fa-mobile"></i>
            </div>
            <div class="service-info">
              <h3>Report Kills with your Phone</h3>
              <p>We have built the system so that you easily report kills with your mobile device. Learn more below.</p>
            </div>
          </div>
          <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="850ms">
            <div class="service-icon">
              <i class="fa fa-trophy"></i>
            </div>
            <div class="service-info">
              <h3>Last one Standing Wins</h3>
              <p>The game continues until there are two players left. This final showdown determines the overall, last-standing winner.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="rules" class="parallax">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="about-info wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
            <h1>Rules</h1>
            <h3>1. No marking someone's face or clothing </h3>
            <h3>2. No assassinating at your target's house or workplace (this includes anything on the property like the driveway)</h3>
            <h3>3. No assassinating targets in their vehicle</h3>
            <h3>4. No assassinating in any classroom at any time</h3>
            <h3>5. A classroom can also be any event that is being supervised by a teacher/coach. The student/player leaves the classroom when they leave the supervision of their teacher/coach.</h3>
            <h3>6. No excessive physical contact in an effort to mark a target</h3>
            <h3>7. No assassinating office aids while they are on the job. They are also banned from assassinating while on the job.</h3>
            <h3>8. All assassinations are final. If you text "rip" you are acknowledging that it was a good kill</h3>
            <h3>9. In order for us to determine the validity of a kill it is necessary for you to take a picture of the mark.</h3>
            <h3>10. If possible stay with your target until you see them text "rip"</h3>
            <h3>11. No assassinating anybody purchasing tickets in the prom/bash ticket lines. If while purchasing tickets, you think you're  being targeted, you may use Swiper no Swiping. It may only be used once per assassin. It is valid until the target is out of sight. Also make sure to yell out Swiper no Swiping so your assassin hears it.</h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="instructions">
    <div class="container">
      <div class="row">
        <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
          <h2>Instructions</h2>
          <p>Read the instructions carefully before the game starts. If you have any questions relating to the rules and questions, contact us.</p>
        </div>
      </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="single-table wow flipInY" data-wow-duration="1000ms" data-wow-delay="300ms">
              <h3>Start/End</h3>
              <ul>
                <li>> The game starts <?=SYSTEM_START_DATE_STRING?></li><br>
                <li>> The game ends when there is only one man left</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="single-table wow flipInY" data-wow-duration="1000ms" data-wow-delay="500ms">
              <h3>Registering</h3>
              <ul>
                <li>> Sign up with the form below</li><br>
                <li>> You will receive a confirmation text message shortly after</li><br>
                <li>> We will assign your targets using texts, so stay in touch</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="single-table wow flipInY" data-wow-duration="1000ms" data-wow-delay="800ms">
              <h3>Tagging</h3>
              <ul>
                <li>> Marks can be anywhere but the face or clothes.</li><br>
                <li>> Marks must be at least a centimeter in length</li><br>
                <li>> Marks must be agreed upon by the assassin and target</li><br>
                <li>> If you tag someone, text "eliminated" to #</li><br>
                <li>> If you get tagged, text "rip" to #</li>
              </ul>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
            <div class="single-table wow flipInY" data-wow-duration="1000ms" data-wow-delay="1100ms">
              <h3>Commands</h3>
              <ul>
                <?php foreach ($SYSTEM_COMMANDS as $command => $info) { ?>
                    <li><strong><?=$command?></strong> - <?=$info?></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
    </div>
  </section>

  <section id="register" class="parallax">
    <div>
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2">
            <div class="twitter-icon text-center">
              <h2>REGISTERATION IS CLOSED</h2>
            </div>
          </div>
        </div>
      </div>
      <div id="statistics-top"></div>
    </div>
  </section>

  <section id="statistics">
    <div class="container">
      <div class="row">
        <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
          <h2>Player Statistics</h2>

          <table id="statsTable" class="table table-bordered">
            <thead>
              <tr>
                <th>Pos.</th>
                <th>Name</th>
                <th>Kills</th>
                <th>XP</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            <?
            $i = 0;
            foreach (getTop10Players(-1) as $user) {
            $i++;
            ?>
              <tr>
                <td><?=$i?></td>
                <td><?=formatUsernameHTML($user)?></td>
                <td><?=$user['num_kills']?></td>
                <td><?=($user['points'] ? $user['points'] : 0)?></td>
                <td><?=formatUserStatus($user)?></td>
              </tr>
            <? } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <section id="contact">
    <div id="contact-us" class="parallax">
      <div class="container">
        <div class="row">
          <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms" style="padding-bottom: 0;">
            <h2>Contact Us</h2>
          </div>
        </div>
        <div class="contact-form wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
          <div class="row">
            <div class="col-sm-12">
              <div class="contact-info wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <p>The creators of assassins are trying our best to create the best experience possible, but if we get anything wrong, just let us know!</p>
                <ul class="address">
                  <li><i class="fa fa-phone"></i> <span> Phone:</span> (817) 200-7256  | Use the 'msg: ' command above</li>
                  <li><i class="fa fa-envelope"></i> <span> Email:</span><a href="mailto:<?php echo SYSTEM_ADMIN_EMAIL; ?>"> <?php echo SYSTEM_ADMIN_EMAIL; ?></a></li>
                </ul>
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
          <center><a href="index.html" class = "white"><img class="img-responsive" src="images/logo.png" alt=""><?php echo SYSTEM_SITE_NAME; ?> 2016</a></center>
        </div>
        <div class="social-icons">
          <ul>
            <li><a class="twitter" target="_blank" href="https://www.twitter.com/martinassassins"><i class="fa fa-twitter"></i></a></li>
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
  <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>

  <script>
  $(function() {
    $("#statsTable").DataTable();

	//on scolling, show/animate timeline blocks when enter the viewport
	$(window).on('scroll', function(){
		$timeline_block.each(function(){
			if( $(this).offset().top <= $(window).scrollTop()+$(window).height()*0.75 && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) {
				$(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
			}
		});
	});

    $("#countdown").countdown("<?=date('Y/m/d H:i:s', strtotime(SYSTEM_START_DATE_STRING))?>", function(event) {
        $(this).text(event.strftime('%D days | %H hours | %M minutes | %S seconds'));
    });
  });
  </script>
</body>
</html>
