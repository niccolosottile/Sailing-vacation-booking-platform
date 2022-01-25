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
    <title>The Boat</title>
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
                    <li class="nav-item active"><a href="theboat.php" style="font-size: 18px;">THE BOAT</a></li>
                    <li class="nav-item"><a href="ourteam.php" style="font-size: 18px;">OUR TEAM</a></li>
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
    <div class="container-slide-carousel">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <!--<ol class="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1"></li>
                  <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol> -->

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">

                    <img src="img/ITAExterior1.jpeg" alt="ita 14.99 sailing" style="width:100%; max-height: 620px;">
                </div>

                <div class="item">

                    <img src="img/ITAExterior2.jpg" alt="ita 14.99 sailing" style="width:100%; max-height: 620px;">
                </div>

                <div class="item">

                    <img src="img/ITAExterior3.jpeg" alt="ita 14.99 sailing" style="width:100%; max-height: 620px;">
                </div>
                <div class="item">
                    <img src="img/ITAInterior1.jpg" alt="Interior" style="width:100%; max-height: 620px;">
                </div>

                <div class="item">

                    <img src="img/ITAInterior2.jpg" alt="Interior" style="width:100%; max-height: 620px;">
                </div>

                <div class="item">

                    <img src="img/ITAInterior3.jpg" alt="Interior" style="width:100%; max-height: 620px;">
                </div>

                <div class="item">

                    <img src="img/ITAInterior4.jpg" alt="Interior" style="width:100%; max-height: 620px;">
                </div>

                <div class="item">

                    <img src="img/ITAInterior5.jpg" alt="Interior" style="width:100%; max-height: 620px;">
                </div>
            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>


    <!-- 21:9 aspect ratio -->
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive" src="https://www.youtube.com/embed/O3O3H5OvHz0?start=20&end=3:10&autoplay=1&rel=0" frameborder="0"></iframe>
    </div>
    <br>
    <div class="container-fluid text-container-adaptive">
        <h2>The boat</h2>
        <hr>
        <p>Edenj is a brand new Itacatamaran 14.99, a (very) fast luxury cruising 15mt (50ft) catamaran, with Hi-Tech construction and innovative solutions.</p>

        <p>100% built in epoxy and carbon infusion, with carbon mast, Edenj is conceived and built around 3 equally important pillars:</p>

        <p>- Safety</p>

        <p>- Comfort</p>

        <p>- Speed</p>
        <div class="image-text-container">
            <img src="img/ITA14.99Design.jpg" alt="The boat's original design">
        </div>
        <br>
        <p><b>SAFETY:</b> One of the very few cruising catamaran models in the world with hulls and deck built in one single piece, Edenj offers unparalleled safety and stability while going at sea. Its innovative waterline design, with flat and wide bottoms, contributes to a smooth as well as a comfortable passage over waves. </p>
        <p> Safety is also taken care by fully retractable daggerboards, heavy weather specific sails, latest generation navigation electronics, state of the art lightning protection system, Quantum radar, AIS700, EPIRB, on board satellite communications, strobe light, propeller with rope cutters, etc.</p>
        <div class="image-text-container-resized">
            <img src="img/ITA14.99Wheel.png" alt="View from the wheel">
        </div>
        <br>
        <p> There is no gas on board Edenj, just electricity with a full array of solar panels providing self-sufficiency.</p>

        <p><b>COMFORT:</b> Italian design and finishing, top quality appliances and a full list of comfort amenities provide luxury on board in a relaxed atmosphere: full A/C and heating, hot water, water maker, generator, 3 fridges and 1 freezer, TV/Home Theatre, Hi-Fi, electric and reversible Harken winches controllable from both helm stations for fingertip sailing, electronic engine throttles, 220 V plugs, etc.. Even the washing machine! </p>

        <p>The external lounge with table, sofa, daybed, and 360° removable sun shades provide a cozy and fresh atmosphere, on the same level whith the luxury appointed salon, creating a single large open space.</p>
        <div class="image-text-container-resized">
            <img src="img/ITA14.99OpenSaloon.jpg" alt="View from the wheel">
        </div>
        <br>
        <p>The front deck and comfortable nets offer a vast additional sunny area and may be covered by a large sun canopy for a refreshing stay at anchor at all times.</p>

        <p>Unlike basic super crowded charters, Edenj has 2 cabins with 2 bathrooms available to guests, and hosts just 4 persons at a time, ensuring a true luxury experience on a 15m long /150 total sqm catamaran! For large families with kids an additional double bed is available in the saloon.</p>

        <p>Finally <b>SPEED:</b> an amazing 10.5 tons lightweight displacement thanks to its Hi-Tech construction, carbon mast, innovative waterlines, retractable daggerboards and latest generation sails (including a powerful Code O), all ensure fast sailing and getting first to the best place in the next bay! You can look yourself at the attached video where Itacatamaran n. 1 reaches 18,7 kts speed!</p>
        <div class="image-text-container-resized">
            <img src="img/ITA14.99Bow.png" alt="The equipped carbon bow">
        </div>
        <br>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 position-info-left">
                <div class="card card-info">
                    <div class="card-body">
                        <h2 class="card-title" id="title-info" style="font-size:18px;">TECHNICAL CHARACTERISTICS </h2>
                        <hr id="white">
                        <br>
                        <p class="card-text" id="p-info">Length Overall: 14.99 m / 49.18 ft </p>
                        <p class="card-text" id="p-info">Mast Length: 21.5 m / 70.54 ft</p>
                        <p class="card-text" id="p-info">Weight: 10.5 tons</p>
                        <p class="card-text" id="p-info">Sail surface: 140 m2</p>
                        <p class="card-text" id="p-info">Number of double beds: 3</p>
                        <p class="card-text" id="p-info">Saloon Headroom: 2.1 m / 6.89 ft</p>
                        <p class="card-text" id="p-info">Hull Headroom: 2 m / 6.56 ft</p>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 position-info-right">
                <img src="img/itaplanimetry.png" class="planimetry">
            </div>
        </div>
    </div>
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
