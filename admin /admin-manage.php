<?php
// Initialize the session
session_start();

if(isset($_SESSION['alert_success'])){
                    unset($_SESSION['alert_success']);
                }

// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$OrderID = "";
$OrderID_err = "";
$CustomerID = "";
$CustomerID_err = "";

//Assume that the trip added is currently available
$state_booking = "available";


// Processing form data when form is submitted for deleting an order
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delorder'])){
 
    //Prepare empty inputs
    if(empty(trim($_POST['OrderID']))){
        $OrderID_err = "Please enter a valid order id.";
    } else{
        $OrderID = trim($_POST['OrderID']);
    }
    
    // Check input errors before deleting in database
    if(empty($OrderID_err)){
        
        // Prepare a delete statement
        $sql = "DELETE FROM orders WHERE OrderID=? ";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i",$param_OrderID);
            
            // Set parameters
            $param_OrderID = $OrderID;
            
            // Declaring variable for success message
            $alert_success = "";
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                unset($_SESSION['alert_success']);
                $alert_success = '<div class="alert alert-success alert-dismissible mt-2">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Order deleted from database!</strong>
                  </div>';
                $_SESSION['alert_success'] = $alert_success;
                // Reload page to reset fields
                header("location: admin-manage.php");
            } 
            else{
                echo '<div class="alert alert-danger alert-dismissible mt-2">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Something went wrong. Please try again later.</strong>
                  </div>';
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
// Processing form data when form is submitted for deleting a customer
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delcustomer'])){
 
    //Prepare empty inputs
    if(empty(trim($_POST['CustomerID']))){
        $CustomerID_err = "Please enter a valid customer id.";
    } else{
        $CustomerID = trim($_POST['CustomerID']);
    }
    
    // Check input errors before deleting in database
    if(empty($CustomerID_err)){
        
        // Prepare a delete statement
        $sql = "DELETE FROM customers WHERE CustomerID=? ";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i",$param_CustomerID);
            
            // Set parameters
            $param_CustomerID = $CustomerID;
            
            // Declaring variable for success message
            $alert_success = "";
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                unset($_SESSION['alert_success']);
                $alert_success = '<div class="alert alert-success alert-dismissible mt-2">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Customer deleted from database!</strong>
                  </div>';
                $_SESSION['alert_success'] = $alert_success;
                // Reload page to reset fields
                header("location: admin-manage.php");
            } 
            else{
                echo '<div class="alert alert-danger alert-dismissible mt-2">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Something went wrong. Please try again later.</strong>
                  </div>';
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage bookings</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        thead {
            background-color: #354375 !important;
            color: white !important;
        }

    </style>
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
                <a class="navbar-brand header-text-change" style="color:white;" href="#">Admin Panel for Edenj</a>
            </div>
            <!-- Collection of nav links, forms, and other content for toggling -->
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a href="admin-panel.php" style="font-size: 17px; margin-left: 100px;">PANEL INFO</a></li>
                    <li class="nav-item"><a href="admin-add-trip.php" style="font-size: 17px; margin-left: 5px;">MANAGE TRIPS</a></li>
                    <li class="nav-item active"><a href="#" style="font-size: 17px; margin-left: 5px;">MANAGE BOOKINGS</a></li>
                    <li class="nav-item"><a href="admin-analysis.php" style="font-size: 17px; margin-left: 5px;">ANALYSE DATA</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <li><a href="admin-account.php" style="font-size: 17px;"><span class="glyphicon glyphicon glyphicon-user"></span> ACCOUNT</a></li>
                    <li><a href="logout.php" style="font-size: 18px;margin-right: 10px;"><span class="	glyphicon glyphicon-log-out"></span> LOGOUT</a></li>
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
        echo $_SESSION['alert_success'];
        ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="table-responsive mt-2">
                    <table class="table table-bordered table-striped text-center center">
                        <thead>
                            <tr>
                                <td colspan="12">
                                    <h2 class="text-center m-0">Orders registered in the database!</h2>
                                </td>
                            </tr>
                            <tr style="font-size:16px;">
                                <th colspan="1">Order id</th>
                                <th colspan="1">Trip id</th>
                                <th colspan="1">Customer id</th>
                                <th colspan="1">Cabins</th>
                                <th colspan="1">Adults</th>
                                <th colspan="1">Children</th>
                                <th colspan="3">Trip message(s)</th>
                                <th colspan="1">Trip Total</th>
                                <th colspan="2">Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                    require_once 'config.php';
                                
                                        $stmt = $link->prepare("SELECT * FROM tripsorders INNER JOIN orders ON tripsorders.OrderID = orders.OrderID");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $sales_total = 0;
    
                                        while($row = $result->fetch_assoc()):
                                    ?>
                            <tr>
                                <td colspan="1"><?= $row['OrderID']?></td>
                                <td colspan="1"><?= $row['TripID']?></td>
                                <td colspan="1"><?= $row['CustomerID']?></td>
                                <td colspan="1"><?= $row['CabinNo']?></td>
                                <td colspan="1"><?= $row['AdultNo']?></td>
                                <td colspan="1"><?= $row['ChildNo']?></td>
                                <td colspan="3"><?= $row['trip_message']?></td>
                                <td colspan="1">€ &nbsp;<?= number_format($row['total_price'],2)?></td>
                                <td colspan="2"><?= $row['created_at']?></td>
                            </tr>
                            <?php $sales_total +=$row['total_price'];
                                    endwhile; ?>

                            <tr>
                                <td colspan="10"><label>Sales Total</label></td>
                                <td><b>€ &nbsp;<?= number_format($sales_total,2)?></b></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <table class="table table-bordered table-striped text-center center">
                    <thead>
                        <tr>
                            <h2 class="text-center m-0">Section to delete an order</h2>
                            <hr>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"><label>Enter Order id to delete:</label></td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" method="post">
                                <td colspan="3">

                                    <input type="number" name="OrderID" class="form-control" value="<?php echo $OrderID; ?>">
                                    <span class="help-block"><?php echo $OrderID_err; ?></span>

                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input type="submit" name="delorder" class="btn btn-primary" value="Delete" onclick="return confirm('Are you sure you want to delete this order?');">
                                    </div>
                                </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <table class="table table-bordered table-striped text-center center">
                    <thead>
                        <tr>
                            <td colspan="8">
                                <h2 class="text-center m-0">Registered Customers</h2>
                            </td>
                        </tr>
                        <tr style="font-size:16px;">
                            <th colspan="1">Customer id</th>
                            <th colspan="1">first name</th>
                            <th colspan="1">last name</th>
                            <th colspan="1">Date of birth</th>
                            <th colspan="1">Nationality</th>
                            <th colspan="1">Email</th>
                            <th colspan="1">Phone</th>
                            <th colspan="1">Creation date</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                    require_once 'config.php';
                                
                                        $stmt = $link->prepare("SELECT * FROM customers");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
    
                                        while($row = $result->fetch_assoc()):
                                    ?>
                        <tr>
                            <td colspan="1"><?= $row['CustomerID']?></td>
                            <td colspan="1"><?= $row['firstname']?></td>
                            <td colspan="1"><?= $row['lastname']?></td>
                            <td colspan="1"><?= $row['DOB']?></td>
                            <td colspan="1"><?= $row['nationality']?></td>
                            <td colspan="1"><?= $row['email']?></td>
                            <td colspan="1"><?= $row['phone']?></td>
                            <td colspan="1"><?= $row['created_at']?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <table class="table table-bordered table-striped text-center center">
                    <thead>
                        <tr>
                            <h2 class="text-center m-0">Section to delete a customer</h2>
                            <hr>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"><label>Enter Customer id to delete:</label></td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" method="post">
                                <td colspan="3">

                                    <input type="number" name="CustomerID" class="form-control" value="<?php echo $CustomerID; ?>">
                                    <span class="help-block"><?php echo $CustomerID_err; ?></span>

                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input type="submit" name="delcustomer" class="btn btn-primary" value="Delete" onclick="return confirm('Are you sure you want to delete this customer?');">
                                    </div>
                                </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
