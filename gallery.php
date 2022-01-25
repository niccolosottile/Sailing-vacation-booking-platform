<?php
// Initialize the session
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gallery</title>
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
                    <li class="nav-item"><a href="ourteam.php" style="font-size: 18px;">OUR TEAM</a></li>
                    <li class="nav-item"><a href="booknow.php" style="font-size: 18px;">ITINERARY</a></li>
                    <li class="nav-item active"><a href="gallery.php" style="font-size: 18px;">GALLERY</a></li>
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
    <div class="container-slide">
        <div class="row row-centered">
            <br>
            <p class="subtitle"> ~ View our itinerary since Edenj was launched! ~</p>
            <br>
            <iframe src="https://www.google.com/maps/d/embed?mid=1LKRE4gRWMnL20ZNLw8ggb4J1vFZX1ldV" width="100%" height="600"></iframe>
        </div>
        <div class="row row-centered">
            <h2 class="master-text">Gallery</h2>

            <hr>
            <p class="subtitle"> ~ Beautiful locations we have been to ~ </p>

        </div>
        <br>
        <div class="row row-centered">
            <div class="column col-xs-12 col-sm-6 col-md-3 col-lg-3 column-gallery">
                <div class="card card-gallery">
                    <img src="img/samplelandscapes.png" alt="" width="100%" height="325px">
                </div>
            </div>

            <div class="column col-xs-12 col-sm-6 col-md-3 col-lg-3 column-gallery">
                <div class="card card-gallery">
                    <img src="img/Sample%20landscapes%204.jpg" alt="" width="100%" height="325px">
                </div>
            </div>

            <div class="column col-xs-12 col-sm-6 col-md-3 col-lg-3 column-gallery">
                <div class="card card-gallery">
                    <img src="img/samplelandscapes2.png" alt="" width="100%" height="325px">
                </div>
            </div>

            <div class="column col-xs-12 col-sm-6 col-md-3 col-lg-3 column-gallery">
                <div class="card card-gallery">
                    <img src="img/samplelandscapes3.png" alt="" width="100%" height="325px">
                </div>
            </div>

        </div>
        <br>
        <div class="row row-centered">
            <div class="column col-xs-12 col-sm-6 col-md-3 col-lg-3 column-gallery">
                <div class="card card-gallery">
                    <img src="img/Sample%20landscapes%205.jpg" alt="" width="100%" height="325px">
                </div>
            </div>

            <div class="column col-xs-12 col-sm-6 col-md-3 col-lg-3 column-gallery">
                <div class="card card-gallery">
                    <img src="img/Sample%20landscapes%206.jpg" alt="" width="100%" height="325px">
                </div>
            </div>

            <div class="column col-xs-12 col-sm-6 col-md-3 col-lg-3 column-gallery">
                <div class="card card-gallery">
                    <img src="img/Sample%20landscapes%207.jpeg" alt="" width="100%" height="325px">
                </div>
            </div>

            <div class="column col-xs-12 col-sm-6 col-md-3 col-lg-3 column-gallery">
                <div class="card card-gallery">
                    <img src="img/Sample%20landscapes%208.jpg" alt="" width="100%" height="325px">
                </div>
            </div>

        </div>
    </div>

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
