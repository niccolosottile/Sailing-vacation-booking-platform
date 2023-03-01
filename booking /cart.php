<?php
// Initialize the session
session_start();

$_currentSessionId = '';

// If user is not logged in, set cookie to track cart//
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
    <title>Cart</title>
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
                    <li style="margin-right: 30px;" class="nav-item active"><a href="cart.php" style="font-size: 17px;"><span class="glyphicon glyphicon-shopping-cart"></span><span id="cart-item" class="badge progress-bar-danger"></span></a></li>

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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div style="display:<?php if(isset($_SESSION['showAlert'])){echo $_SESSION['showAlert'];} elseif($Hide='0'){echo 'block';} else{echo 'none';} unset($_SESSION['showAlert']); ?>;" class="alert alert-success alert-dismissible mt-3">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];}elseif($Hide='0'){echo 'Trip removed from the cart';} unset($_SESSION['showAlert']);?></strong>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-striped text-center center">
                        <thead>
                            <tr>
                                <td colspan="6">
                                    <h2 class="text-center m-0">Trips in your cart!</h2>
                                </td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Cabin Number</th>
                                <th>Total Price</th>
                                <th>
                                    <a href="<?php echo 'action.php?clear=all'; ?>" class="progress-bar-danger badge p-1" onclick="return confirm('Are you sure you want to clear your cart?');"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;Clear cart</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                    require 'config.php';
                                
                                /* This is cart for user who has logged in before adding items */
                                if(isset($_SESSION['email']) && empty($_COOKIE['YOUR_SID'])){
                                        $CustomerID = $_SESSION['CustomerID'];
                                        $stmt = $link->prepare("SELECT * FROM cart INNER JOIN trips ON cart.TripID = trips.TripID WHERE cart.CustomerID=?");
                                        $stmt->bind_param("i",$CustomerID);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $grand_total = 0;
                                        while($row = $result->fetch_assoc()):
                                    
                                ?>
                            <tr>
                                <td><img src="<?= $row['trip_image'] ?>" width="60"> </td>
                                <td><?= $row['title']?></td>
                                <td>€ &nbsp;<?= number_format($row['trip_price'],2)?></td>
                                <td><?= $row['CabinNo']?></td>
                                <td>€ &nbsp;<?= number_format($row['total_price'],2)?></td>
                                <td>
                                    <a href="action.php?remove=<?= $row['CartID']?>" class="text-danger lead" onclick="return confirm('Are you sure you want to remove this trip?');"><span class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                            <?php $grand_total +=$row['total_price'] ?>
                            <?php endwhile; 
                                    }
                                
                                /* This is algorithm for user who views the cart but has not logged in yet */ 
                                if(empty($_SESSION['email']) && isset($_COOKIE['YOUR_SID'])){
                                        $_currentSessionId = $_COOKIE['YOUR_SID'];
                                        $stmt = $link->prepare("SELECT * FROM cart INNER JOIN trips ON cart.TripID = trips.TripID WHERE cart.CustomerID=?");
                                        $stmt->bind_param("s",$_currentSessionId);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $grand_total = 0;
                                        while($row = $result->fetch_assoc()):
                                    
                                ?>
                            <tr>
                                <td><img src="<?= $row['trip_image'] ?>" width="60"> </td>
                                <td><?= $row['title']?></td>
                                <td>€ &nbsp;<?= number_format($row['trip_price'],2)?></td>
                                <td><?= $row['CabinNo']?></td>
                                <td>€ &nbsp;<?= number_format($row['total_price'],2)?></td>
                                <td>
                                    <a href="action.php?remove=<?= $row['CartID']?>" class="text-danger lead" onclick="return confirm('Are you sure you want to remove this trip?');"><span class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>

                            <?php $grand_total +=$row['total_price'];
                                        endwhile;
                                } ?>

                            <?php 
                                /*This is cart for user who has added items and later logged in before cart */ 
                                if(isset($_SESSION['email']) && isset($_COOKIE['YOUR_SID'])){
                                
                                $CustomerID = $_SESSION['CustomerID'];
                                
                                        $stmt = $link->prepare("SELECT * FROM cart INNER JOIN trips ON cart.TripID = trips.TripID WHERE cart.CustomerID=?");
                                        $stmt->bind_param("i",$CustomerID);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $grand_total = 0;
                                        while($row = $result->fetch_assoc()):
                                    
                                ?>
                            <tr>
                                <td><img src="<?= $row['trip_image'] ?>" width="60"> </td>
                                <td><?= $row['title']?></td>
                                <td>€ &nbsp;<?= number_format($row['trip_price'],2)?></td>
                                <td><?= $row['CabinNo']?></td>
                                <td>€ &nbsp;<?= number_format($row['total_price'],2)?></td>
                                <td>
                                    <a href="action.php?remove=<?= $row['CartID']?>" class="text-danger lead" onclick="return confirm('Are you sure you want to remove this trip?');"><span class="glyphicon glyphicon-trash"></span></a>
                                </td>
                            </tr>
                            <?php $grand_total +=$row['total_price'] ?>
                            <?php endwhile; 
                                    } ?>

                            <tr>
                                <td colspan="2">
                                    <a href="booknow.php" class="btn btn-success">&nbsp;&nbsp;Continue Shopping</a>
                                </td>
                                <td colspan="2"><label>Grand Total</label></td>
                                <td><b>€ &nbsp;<?= number_format($grand_total,2)?></b></td>
                                <td>
                                    <a href="checkout.php" class="btn btn-primary <?= ($grand_total>1)?"":"disabled"; ?>"><span class="glyphicon glyphicon-credit-card"></span>&nbsp;&nbsp;Checkout</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
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

    </script>
    <br>
    <?php include 'footer.html'; ?>
</body>

</html>
