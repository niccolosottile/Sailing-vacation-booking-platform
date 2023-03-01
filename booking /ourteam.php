<?php
// Initialize the session
session_start();

require_once "config.php";

// Counting the number of reviews recorded in the DB
$sql = $link->query("SELECT ReviewID FROM reviews");
$nRows = $sql->num_rows;

// Calculating the total rating from the DB
$sql = $link->query("SELECT SUM(ratedIndex) as Total FROM reviews");
$rData = $sql->fetch_array();
$Total = $rData['Total'];

// Calculating the average rating left by confirmed customers
$Avg = $Total/$nRows;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Our Team</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        #consent-popup {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            opacity: 1;
            background-color: #fff;
            transition: opacity .8s ease;

            &.hidden {
                opacity: 0;
            }
        }

        @media (min-width: 769) {
            .box-reviews {
                margin-left: 100px;
                margin-right: 100px;
            }
        }

        @media (max-width: 768) {
            .box-reviews {
                margin-left: 10px;
                margin-right: 10px;
            }
        }

        .box-reviews {
            padding: 15px;
        }

    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MCGE8WE9JL"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-MCGE8WE9JL');

    </script>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top my-navbar">
            <br>
            <br>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand header-text-change" style="color:white;" href="#">Edenj Sail Adventures</a>
            </div>
            <!-- Collection of nav links, forms, and other content for toggling -->
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a href="index.php" style="font-size: 17px; margin-left: 5px;">HOME</a></li>
                    <li class="nav-item"><a href="theboat.php" style="font-size: 18px;">THE BOAT</a></li>
                    <li class="nav-item active"><a href="ourteam.php" style="font-size: 18px;">OUR TEAM</a></li>
                    <li class="nav-item"><a href="booknow.php" style="font-size: 18px;">ITINERARY</a></li>
                    <li class="nav-item"><a href="gallery.php" style="font-size: 18px;">GALLERY</a></li>
                    <li class="nav-item"><a href="enquire.php" style="font-size: 18px;">ENQUIRE</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                            
                          
                            // If session variable is not set it will not display the account option
                            if(!isset($_SESSION['email']) || empty($_SESSION['email'])){ ?>
                    <li><a href="login.php" style="font-size: 18px;"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <?php    
                            }
                        else { ?>
                    <li><a href="account.php" style="font-size: 18px;"><span class="glyphicon glyphicon glyphicon-user"></span> Account</a></li>
                    <?php }
                        ?>
                    <li style="margin-right: 30px;"><a href="cart.php" style="font-size: 17px;"><span class="glyphicon glyphicon-shopping-cart"></span><span id="cart-item" class="badge progress-bar-danger"></span></a></li>

                </ul>
            </div>
        </nav>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="row row-centered">
        <h2 class="master-text">Meet our team</h2>
        <hr>

        <div class="container-fluid text-container-adaptive" style="width:100%;">
            <br>
            <p> Elli and I love nature, discover, sailing and socializing at the same time! We are nice, open, able to talk about everything, calm and dynamic at the same time. True travel companions, not just skippers ... </p>

            <p> We each have unlimited nautical license, ICC (International Certificate of Sailing Competence) and 2 Royal Yachting Association certificates. We also have attended World Sailing sea survival course and Red Cross 18 hours first aid course, alongside other courses and experiences </p>

            <p> When we do not sail we live in Milan taking care of our city interests. In town we love simple things like "sophisticated" ones; but the optimum for us is life in contact with nature, traveling and discovering new places, preferably... sailing.
            </p>
            <br>
        </div>
        <br>
        <div class="column-team">
            <!-- Open The Modal -->
            <div class="card card-team">
                <img src="img/teamimage.jpg" alt="Daniele Sottile and Ellina Kazankova" style="width:100%">
                <div class="container-team">
                    <h2><a id="Myclick1">Daniele</a> and <a id="Myclick2">Ellina</a></h2>
                    <p class="title-team">Certified skippers</p>
                </div>
            </div>

            <!-- The Modal -->
            <div id="Mycareer1" class="modal">

                <!-- Modal content -->
                <div class="career-content" style="font-size:18px;">
                    <span class="close">&times;</span>
                    <p>I have been sailing since the late 90s: in 1998, a 4-day Laser course and a 4-week-ends big sailing boat course were my start.; in '99 4-day course on a F18 “acrobatic” catamaran. In '99 I bought my small catamaran: a Bimare 16ft, carbon mast and 80kg weight, a rocket! In 2000, 1 week coastal cruise course between Elba and Corsica. In 2001 I bought a 11 meter catamaran which I have sold in 2019 when starting to plan Edenj acquisition. In 2008 I also bought a 24 feet trimaran, the Corsair Sprint. I just love multihulls! </p>

                    <p> Since 2015, my wife Elli and myself decided to further consolidate our navigation skills for long travels; hence: RYA Day Skipper course and certificate, as well as ICC (International Certificate of Competence), which enables you to sail anywhere in the world. In 2016 we got the very selective and worldwide recognized Italian nautical license (without any distance limit from the coast). At the end of 2017 we got the RYA Coastal Skipper Certificate in the Canary Islands (with tide) which also enables night navigation, with or without electronics. Lot of sailing aboard chartered monohulls and catamarans, in the Mediterranean and the Caribbean, up to the arrive of Edenj </p>

                    <p>Since April 2021, we sail our brand new Edenj around the most beautiful places in the world.</p>
                </div>

            </div>
            <!-- The Modal -->
            <div id="Mycareer2" class="modal2">

                <!-- Modal content -->
                <div class="career-content" style="font-size:18px;">
                    <span class="close2">&times;</span>
                    <p>Sailing has been a dazzling discovery during a holiday with friends in Corsica in [.]. Sea, stars, discovers and sharing beautiful experiences together; what could you wish more? </p>

                    <p>Since 2015, my husband Daniele and myself decided to further consolidate our navigation skills for long travels; hence: RYA Day Skipper course and certificate, as well as ICC (International Certificate of Competence), which enables you to sail anywhere in the world. In 2016 we got the very selective and worldwide recognized Italian nautical license (without any distance limit from the coast). At the end of 2017 we got the RYA Coastal Skipper Certificate in the Canary Islands (with tide) which also enables night navigation, with or without electronics. Lot of sailing aboard chartered monohulls and catamarans, in the Mediterranean and the Caribbean, up to the arrive of Edenj</p>

                    <p>Since April 2021, we sail our brand new Edenj around the most beautiful places in the world.</p>
                </div>

            </div>
        </div>
        <br><br>
        <h2 class="master-text">WHAT OUR CUSTOMERS THINK ABOUT US</h2>
        <hr>


        <p>The average rating collected exclusively from certified customers is <b><?php echo round($Avg, 1); ?></b> (out of 5) stars</p>
        <br>
        <p>Writter reviews we received by our customers: </p>
        <br>


        <div class="jumbotron box-reviews">
            <p style="font-size: 21px; color:grey;"><i>"I want to personally thank Daniele and Ellina for hosting us on board of Edenj. An amazing luxury sailing catamaran which brought us to many beautiful locations while sailing peacefully. Perfect experience!"</i></p>
            <br>
        </div>
    </div>
    <br>
    <br>
    <br>
    <script type="text/javascript">
        $(document).ready(function() {
            load_cart_item_number();

            function load_cart_item_number() {
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {
                        cartItem: "cart_item"
                    },
                    success: function(response) {
                        $('#cart-item').html(response);
                    }
                });
            }
        });

        // Get the modal
        var modal = document.getElementById("Mycareer1");

        // Get the button that opens the modal
        var btn = document.getElementById("Myclick1");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Get the modal
        var modal2 = document.getElementById("Mycareer2");

        // Get the button that opens the modal
        var btn2 = document.getElementById("Myclick2");

        // Get the <span> element that closes the modal
        var span2 = document.getElementsByClassName("close2")[0];

        // When the user clicks on the button, open the modal
        btn2.onclick = function() {
            modal2.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span2.onclick = function() {
            modal2.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal2) {
                modal2.style.display = "none";
            }
        }

    </script>
    <?php include 'footer.html'; ?>
    <div id="consent-popup" class="hidden">
        <p>This site uses cookies.
            Click <a id="accept">here</a> to accept the use of these cookies.
            <a href="cookie-policy.html">View our cookie policy</a>.
        </p>
    </div>
    <script src="cookie-disclaimer.js"></script>

</body>

</html>
