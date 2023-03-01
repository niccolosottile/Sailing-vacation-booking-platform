<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
  $_SESSION['previous'] = 'checkout.php';
  header("location: login.php");
  exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
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
                    <li class="nav-item"><a href="gallery.php" style="font-size: 18px;">GALLERY</a></li>
                    <li class="nav-item"><a href="enquire.php" style="font-size: 18px;">ENQUIRE</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php 
                            // If session variable is not set it will not display the account option
                            if(!isset($_SESSION['email']) || empty($_SESSION['email'])){ ?>
                    <li class="nav-item"><a href="login.php" style="font-size: 18px;"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <?php    
                            }
                        else { ?>
                    <li class="nav-item"><a href="account.php" style="font-size: 18px;"><span class="glyphicon glyphicon glyphicon-user"></span> Account</a></li>
                    <?php }
                        ?>
                    <li style="margin-right: 30px;" class="nav-item"><a href="cart.php" style="font-size: 17px;"><span class="glyphicon glyphicon-shopping-cart"></span><span id="cart-item" class="badge progress-bar-danger"></span></a></li>

                </ul>
            </div>
        </nav>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php
          require_once 'config.php';
          $sales_total = 0;
          //Store trip titles for every trip added //
          $allTripTitles ='';
          $tripTitles = array(); 
        
          $CustomerID = $_SESSION['CustomerID'];

          $sql = "SELECT trips.title, cart.total_price FROM cart INNER JOIN trips ON cart.TripID = trips.TripID WHERE cart.CustomerID=?";
          $stmt = $link->prepare($sql);
          // Bind variables to the prepared statement
          mysqli_stmt_bind_param($stmt, "i",$CustomerID);
          $stmt->execute();
          $result = $stmt->get_result();

          while($row = $result->fetch_assoc()){
            //Adding each title in cart to arrays//
            $tripTitles[] = $row['title'];
            // Adding total prices to calculate sales total //
            $sales_total +=$row['total_price'];
            }
         //Convert to string //
         $allTripTitles = implode(", ", $tripTitles);
         // Adding sales total to session for checkout //
        $_SESSION['sales_total'] = $sales_total;
        ?>
    <div id="order">
        <div class="container-fluid text-container">
            <h2>Finish booking your trip!</h2>
            <hr>
            <div class="jumbotron p-3 mb-2 text-center">
                <!-- Here you can display your key order data before payment -->
                <h6 class="lead"><b>Trip(s) : </b><?= $allTripTitles; ?></h6>
                <h5 class="lead"><b>Total amount payable : </b>€ <?= number_format($sales_total,2) ?></h5>
            </div>
            <!-- Here I will add payment methods -->

            <div id="paypal-button" type="submit"></div>
            <br>
            <script src="https://www.paypalobjects.com/api/checkout.js"></script>
            <script>
                paypal.Button.render({
                    // Configure environment
                    env: 'sandbox',
                    client: {
                        sandbox: 'AY-ZE5--kWb8RzUHNGql3gwiuKU0bUSzYiOaAxWmdPy8fLS2Gw5o3R1ZTogcL_0RU1mx1GHxsXenf67R'

                    },
                    // Customize button (optional)
                    locale: 'en_US',
                    style: {
                        size: 'responsive',
                        color: 'gold',
                        shape: 'pill',
                        label: 'pay',
                        fundingicons: 'true',
                        layout: 'horizontal',
                    },

                    // Enable Pay Now checkout flow (optional)
                    commit: true,

                    // Set up a payment
                    payment: function(data, actions) {
                        return actions.payment.create({
                            transactions: [{
                                amount: {
                                    total: '<?php echo $sales_total; ?>',
                                    currency: 'EUR'
                                }
                            }]
                        });
                    },
                    // Execute the payment
                    onAuthorize: function(data, actions) {
                        return actions.payment.execute().then(function() {
                            window.location.replace("https://edenjsailadventures.com/payment-action.php");
                            <?php $_SESSION['previous'] = 'checkout.php'; ?>
                        });
                    }
                }, '#paypal-button');

            </script>
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
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <?php include 'footer.html'; ?>
    </div>

    <br>


</body>

</html>
