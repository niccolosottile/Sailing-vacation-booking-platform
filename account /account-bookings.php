<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

if (isset($_POST['save'])){
    
    $CustomerID = $_SESSION['CustomerID'];
    $ratedIndex = $_POST['ratedIndex'];
    
    $ratedIndex = $ratedIndex + 1;
    
    $comment = $_POST['comment'];
    
    $stmt = $link->prepare("INSERT INTO reviews (ratedIndex, comment, CustomerID) VALUES (?,?,?)");
    $stmt->bind_param("isi",$ratedIndex, $comment, $CustomerID);
    $stmt->execute();
    
    echo '<div class="alert alert-success alert-dismissible mt-2">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Thank you for leaving a review!</strong>
                  </div>';
    
}
?>
<!DOCTYPE html>
<html lang="en" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Account</title>
    <style type="text/css">
        @media (min-width:768px) {
            .update-form {
                padding-left: 15px;
                padding-right: 15px;
            }

            .update-container {
                margin-left: 50px;
                margin-right: 50px;
                width: auto;
            }
        }

        @media (max-width:767px) {
            .account-container {
                width: 100%;
            }
        }

        .update-container {

            margin-top: 120px;
            background-color: #F2F2F2;
            background-blend-mode: lighten;
            font: 14px sans-serif;
            text-align: center;
            border: 2px solid;
            color: black;

        }

        #btn-offers {
            background-color: #334996;
            border: 1px solid white;
            color: white;
            pointer-events: unset;
        }

        #btn-light {
            background-color: #fff;
            color: #334996 !important;
        }

        ul.a {
            list-style-type: circle;
        }

        @media (min-width: 769px) {
            .container-scroll-basic {
                width: 80%;
                padding: 10px;
            }
        }

    </style>
    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style-account.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="https://use.fontawesome.com/releases/v5.15.2/js/all.js" data-auto-replace-svg="nest"></script>

    <!-- Jquery Calendar integration-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

</head>
<?php 
if (isset($_POST['save'])){
    exit;
}
?>

<body>

    <!-- Sidebar -->
    <nav id="sidebar">
        <!-- Link to closeNav() function, shown inside sidebar as a cross symbol -->
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="position: absolute; top: 0; right: 25px; font-size: 40px; margin-left: 50px;">&times;</a>
        <div class="sidebar-header">
            <img src="img/Logo.png" width="270px" style="padding:10px;" alt="edenj sail adventures">
        </div>
        <ul class="list-unstyled components" id="checklinks">
            <p>My account</p>
            <br>
            <li>
                <a href="account.php">Welcome</a>
            </li>
            <li>
                <a href="account-info.php">My details</a>
            </li>
            <li class="active">
                <a href="account-bookings.php">My bookings</a>
            </li>
            <li>
                <a href="logout.php">Logout</a>
            </li>
        </ul>
        <ul class="list-unstyled" style="padding:20px;">
            <li>
                <a href="enquire.php" id="btn-light" class="btn" role="button">Contact us</a>
            </li>
            <br>
            <li>
                <a href="booknow.php" id="btn-offers" class="btn btn-offers">View our offers!</a>
            </li>
        </ul>
    </nav>

    <div id="main">
        <!-- Button that will run the openNav() function on click -->
        <button class="openbtn" onclick="openNav()">&#9776; Open Sidebar</button>
        <br>
        <br>
        <br>

        <!-- Success message outputted when a review is submitted -->
        <div class="message"></div>

        <div class="update-container">
            <div class="row phone-view-block">
                <div class="col-sm-8">
                    <div class="calendar-container">
                        <h2 class="master-text" style="text-align: left;">PERSONAL CALENDAR</h2>
                        <hr style="border-top: 2px solid #000;">
                        <div id="calendar"></div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="container-scroll-basic">
                        <h2 class="update-form" style="text-align: left;">BOOKINGS</h2>
                        <hr style="border-top: 2px solid #000;">
                    </div>
                    <div class="container-scroll" id="scrollbox">
                        <?php
                    //Displaying bookings made from customer
                    $CustomerID = $_SESSION['CustomerID'];
                    $stmt = $link->prepare("SELECT * FROM ((tripsorders INNER JOIN trips ON tripsorders.TripID = trips.TripID) INNER JOIN orders ON orders.OrderID = tripsorders.OrderID) WHERE orders.CustomerID=?");
                    // Bind variables to the prepared statement
                    $stmt->bind_param("i",$CustomerID);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()):
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
                                    events: 'load-account.php',
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
                                            element.style.backgroundColor = "#F2F2F2";
                                        }, 5000)
                                    },

                                });
                            });

                        </script>

                        <div class="card" style="padding-left:5px;padding-right:5px;padding-top:5px; width: 310px; margin-left: auto; margin-right: auto;" id="<?= $row['title'] ?>">

                            <img class="card-img-top" src="<?= $row['trip_image']?>" alt="Image showing your sailing adventure" style="width: 100%;">

                            <div class="card-body" style="text-align: left;">
                                <h3 class="card-title" style="text-align: left;"><?= $row['title'] ?></h3>
                                <ul class="a">
                                    <?php $Departure_Date =  date_create($row['start_event']); ?>
                                    <li>
                                        <p class="card-text" style="text-align: left;">Departure date:&nbsp;&nbsp;<?= date_format($Departure_Date,"d/m/Y H:i"); ?> from&nbsp;&nbsp;<?= $row['departure_location'] ?></p>
                                    </li>
                                    <?php $Arrival_Date =  date_create($row['end_event']); ?>
                                    <li>
                                        <p class="card-text" style="text-align: left;">Arrival date:&nbsp;&nbsp;<?= date_format($Arrival_Date,"d/m/Y H:i"); ?> at&nbsp;&nbsp;<?= $row['arrival_location'] ?></p>
                                    </li>
                                    <li>
                                        <p class="card-text" style="text-align: left;">Number of cabins booked: <?= $row['CabinNo']?></p>
                                    </li>
                                    <li>
                                        <p class="card-text" style="text-align: left;">Number of adults: <?= $row['AdultNo']?></p>
                                    </li>
                                    <li>
                                        <p class="card-text" style="text-align: left;">Number of children: <?= $row['ChildNo']?></p>
                                    </li>
                                    <li>
                                        <p class="card-text" style="text-align: left;">Total amount payed: € &nbsp;<?= number_format($row['total_price'],2)?></p>
                                    </li>
                                </ul>
                                <br><br>
                                <?php
                    
                                // Comparing current date with arrival date of vacation
                                $today = date("Y-m-d H:i:s");

                                if ($today > $row['end_event']){

                                //Displaying review only if it hasn't been sent yet by the customer
                                $query = $link->prepare("SELECT * FROM reviews WHERE CustomerID=?");

                                // Bind variables to the prepared statement
                                $query->bind_param("i",$CustomerID);
                                $query->execute();
                                $res = $query->get_result();
                                $rows = mysqli_fetch_row($res);
                                if ($rows != 0){ ?>

                                <h4>Thank you for leaving a review. We take your suggestions seriously and always aim at improving!</h4>
                                <br><br>
                                <?php 
                                }
                                else { 

                                ?>
                                <h4>We do our best to offer you a beautiful experience. Leave us a review so that we can improve the quality of our services.</h4>
                                <!-- Rating system for the vacation -->
                                <div align="center" style="background: #000;">
                                    <form class="form-submit">
                                        <div class="form-group" style="padding: 30px;">
                                            <i class="fa fa-star fa-2x" data-index="0"></i>
                                            <i class="fa fa-star fa-2x" data-index="1"></i>
                                            <i class="fa fa-star fa-2x" data-index="2"></i>
                                            <i class="fa fa-star fa-2x" data-index="3"></i>
                                            <i class="fa fa-star fa-2x" data-index="4"></i>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="comment" style="width: 90%;" rows="5" placeholder="Comment on your experience"></textarea>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-light review-submit" value="Submit">
                                        </div>
                                        <br>
                                    </form>
                                </div>
                                <br>
                                <br>
                                <?php } } ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script> -->
    <script>
        var ratedIndex = -1,
            comment = '';

        $(document).ready(function() {
            resetStarColors();

            //When the user clicks on the star the rating is added to the variable ratedIndex
            $('.fa-star').on('click', function() {
                ratedIndex = parseInt($(this).data('index'));

            });

            //When the user clicks on the submit button the comment (if any) is stored and form sent
            $('.review-submit').on('click', function(e) {
                e.preventDefault();
                if (ratedIndex != -1) {
                    var $form = $(this).closest(".form-submit");
                    comment = $form.find(".comment").val();
                    saveToTheDB();
                }
            });

            // When user overs over star it changes colour to yellow
            $('.fa-star').mouseover(function() {
                resetStarColors();

                var currentIndex = parseInt($(this).data('index'));
                setStars(currentIndex);
            });

            // When user stops pointing on the stars the colour is reset to white and if he rated the start colour is fixed to yellow
            $('.fa-star').mouseleave(function() {
                resetStarColors();

                if (ratedIndex != -1)
                    setStars(ratedIndex);
            });
        });

        function saveToTheDB() {
            $.ajax({
                url: "account-bookings.php",
                method: "POST",
                data: {
                    save: 1,
                    ratedIndex: ratedIndex,
                    comment: comment
                },
                success: function(response) {
                    $(".message").html(response);
                    window.scrollTo(0, 0);

                }

            });
        }

        function setStars(max) {
            for (var i = 0; i <= max; i++)
                $('.fa-star:eq(' + i + ')').css('color', 'yellow');
        }

        // Reset to white the colour of the stars
        function resetStarColors() {
            $('.fa-star').css('color', 'white');
        }

    </script>
    <!-- Allows for the smooth sidebar transition -->
    <script>
        /* Set the width of the sidebar to 270px and the left margin of the page content to 270px */
        function openNav() {
            document.getElementById("sidebar").style.width = "270px";
            document.getElementById("main").style.marginLeft = "270px";
        }

        /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
        function closeNav() {
            document.getElementById("sidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }

    </script>
</body>

</html>
