<?php
// Initialize the session
session_start();

$_currentSessionId = '';

// If user is not logged in, set cookie and session id //
if(empty($_SESSION['email']) && empty($_COOKIE['YOUR_SID'])){
    $_currentSessionId = session_id();
    // Set cookie expiry //
    $_expires = pow(2,31)-1;
    // Add session id to cookie //
    setcookie( 'YOUR_SID', $_currentSessionId, $_expires );
}
// If user comes back later, retrieve information from cookie //
if ( isset( $_COOKIE['YOUR_SID'] ) && empty($_SESSION['email']) ) {
    $_currentSessionId = $_COOKIE['YOUR_SID'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Itinerary</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Jquery Calendar integration with php and mysql -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <style>
        @media (min-width: 768px) {
            .container-scroll-basic {
                width: 80%;
                padding: 10px;
            }
        }

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
                    <li class="nav-item active"><a href="booknow.php" style="font-size: 18px;">ITINERARY</a></li>
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
    <div id="message"></div>
    <div class="row phone-view-block">
        <div class="col-sm-8">
            <div class="calendar-container">
                <h2 class="master-text">Schedule</h2>
                <hr>
                <div id="calendar"></div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="container-scroll-basic">
                <h2 class="master-text">RESERVE NOW</h2>
                <hr>
            </div>
            <div class="container-scroll" id="scrollbox">
                <?php
                                include 'config.php';
                                $state_booking='';
                                $stmt = $link->prepare("SELECT * FROM trips");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()):
                                    $tripID = $row['TripID'];
                                    $state_booking = $row['state_booking'];
                                    if($state_booking=='available'){
                                ?>
                <script>
                    $(document).ready(function() {
                        var calendar = $('#calendar').fullCalendar({
                            displayEventTime: false,
                            editable: true,
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: ''
                            },
                            events: 'load.php',
                            selectable: true,
                            selectHelper: true,

                            // On click event scroll to correct vacation in scrollbox and highlight in light grey
                            eventClick: function(calEvent, jsEvent, view) {
                                var element = document.getElementById(calEvent.title);
                                var topPos = element.offsetTop;
                                document.getElementById("scrollbox").scrollTo({
                                    top: topPos,
                                    behavior: 'smooth'
                                });
                                // Change background color //
                                element.style.backgroundColor = "#dbdbdb";
                                setTimeout(function() {
                                    element.style.backgroundColor = "#FFFFFF";
                                }, 5000)
                            },

                        });
                    });

                </script>
                <div class="card" style="padding-left:5px;padding-right:5px;padding-top:5px;" id="<?= $row['title'] ?>">
                    <img class="card-img-top" src="<?= $row['trip_image']?>" alt="Sample image" style="width: 100%;">
                    <div class="card-body">
                        <h2 class="card-title"><?= $row['title'] ?></h2>
                        <p class="card-text"><?= $row['event_description'] ?></p>
                        <?php $Departure_Date =  date_create($row['start_event']); ?>
                        <p class="card-text">Departure date:&nbsp;&nbsp;<?= date_format($Departure_Date,"d/m/Y H:i"); ?> from&nbsp;&nbsp;<?= $row['departure_location'] ?></p>
                        <?php $Arrival_Date =  date_create($row['end_event']); ?>
                        <p class="card-text">Arrival date:&nbsp;&nbsp;<?= date_format($Arrival_Date,"d/m/Y H:i"); ?> at&nbsp;&nbsp;<?= $row['arrival_location'] ?></p>
                        <script>
                            function showHideAddToCart<?= $row['TripID'] ?>() {
                                if (document.getElementById('form<?= $row['TripID'] ?>').onclick) {
                                    document.getElementById('forminfo<?= $row['TripID'] ?>').style.display = 'block';
                                } else {}
                            }

                        </script>
                        <a id="form<?= $row['TripID'] ?>" class="btn btn-primary btn-block btn-booking" onclick="showHideAddToCart<?= $row['TripID'] ?>()">Book your trip!</a>
                        <br>
                        <form id="forminfo<?= $row['TripID'] ?>" class="modify-form form-submit" action="">
                            <div class="form-group">
                                <label>Do you want to rent a cabin or the whole boat (2 cabins)? </label>
                                <select class="form-control pcabinno" name="CabinNo">
                                    <?php 
                                                    //Updating available cabin number depending on booking //
                                                    $CabinNo=0;
                                                    $stmt = $link->prepare("SELECT CabinNo FROM tripsorders WHERE TripID=?");
                                                    $stmt->bind_param("i",$tripID);
                                                    $stmt->execute();
                                                    $res = $stmt->get_result();
                                                    while($r = $res->fetch_assoc()):
                                                        $CabinNo +=$r['CabinNo'];
                                                    endwhile;
                                                    //Checking booked cabins number 
                                                    if($CabinNo==1){ ?>
                                    <option>1</option>
                                    <option disabled>2 <b>(not available)</b></option>
                                    <?php  } ?>
                                    <?php if($CabinNo==0){ ?>
                                    <option>1</option>
                                    <option>2</option>

                                    <?php  } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Label for passengers">Adults</label>
                                <select class="form-control padultno" name="AdultNo">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Label for passengers">Children</label>
                                <select class="form-control pchildno" name="ChildNo">
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Label for special requests">Add any special request</label>
                                <textarea class="form-control pmessage" id="Special requests" rows="3" value="trip_message"></textarea>
                            </div>
                            <label style="margin-left:15px;"> Price per cabin&nbsp;&nbsp; € &nbsp;<?= number_format($row['trip_price'],2)?> (includes VAT)</label>
                            <label style="font-size:11px;">*A safety deposit of € &nbsp;2000 will be requested on the date of departure</label>
                            <label style="font-size:11px;">*Offer includes (rent of cabin, skippers, snorkeling & activities gear, dinghy)</label>
                            <!-- Saving needed variables for cart table to be used in Javascript -->
                            <input type="hidden" class="pid" value="<?= $row['TripID'] ?>">
                            <input type="hidden" class="pcustomerid" value="<?php if(isset($_SESSION['CustomerID'])){echo $_SESSION['CustomerID'];}else{echo $_currentSessionId;}?>">
                            <input type="hidden" class="pprice" value="<?= $row['trip_price'] ?>">

                            <button type="submit" class="btn btn-primary btn-block btn-booking addTripBtn"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;&nbsp;Add to cart</button>
                        </form>
                    </div>
                    <br>
                    <hr>
                </div>

                <?php } endwhile; ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".addTripBtn").click(function(e) {
                e.preventDefault();
                var $form = $(this).closest(".form-submit");
                // 2 foreign keys that will be needed to join tables //
                var pid = $form.find(".pid").val();
                var pcustomerid = $form.find(".pcustomerid").val();
                //pprice is needed to calculate total_price in action.php//
                var pprice = $form.find(".pprice").val();

                //These variables are input from customer and will be translated to cart table and finally after purchase the order table//
                var pcabinno = $form.find(".pcabinno").val();
                var padultno = $form.find(".padultno").val();
                var pchildno = $form.find(".pchildno").val();
                var pmessage = $form.find(".pmessage").val();

                $.ajax({
                    url: "action.php",
                    method: "post",
                    data: {
                        pid: pid,
                        pcustomerid: pcustomerid,
                        pprice: pprice,
                        pcabinno: pcabinno,
                        padultno: padultno,
                        pchildno: pchildno,
                        pmessage: pmessage
                    },
                    success: function(response) {
                        $("#message").html(response);
                        window.scrollTo(0, 0);
                        load_cart_item_number();
                    }
                });
            });

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
    <br>
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
