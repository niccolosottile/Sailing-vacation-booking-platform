<?php
session_start();

if(isset($_SESSION['alert_success'])){
                    unset($_SESSION['alert_success']);
                }


// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$title = $start_event = $end_event = $departure_location = $arrival_location = $event_description = $trip_price = $trip_image = $trip_code = $state_booking = $TripID = "";
$title_err = $start_event_err = $end_event_err = $departure_location_err = $arrival_location_err = $event_description_err = $trip_price_err = $trip_image_err = $trip_code_err = $state_booking_err = $TripID_err = "";

$state_booking = 'available';

// Processing form data when form is submitted
if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['enter1'])){
 
    //Prepare empty inputs
    if(empty(trim($_POST['title']))){
        $title_err = "Please enter the trip title.";
    } else{
        $title = trim($_POST['title']);
    }
    if(empty(trim($_POST['start_event']))){
        $start_event_err = "Please select a departure date.";
    } else{
         $start_event = trim($_POST['start_event']);
    }
    if(empty(trim($_POST['end_event']))){
        $end_event_err = "Please select an arrival date.";
    } else{
        $end_event = trim($_POST['end_event']);
    }
    if(empty(trim($_POST['departure_location']))){
        $departure_location_err = "Please enter a departure location.";
    } else{
        $departure_location = trim($_POST['departure_location']);
    }
    if(empty(trim($_POST['arrival_location']))){
        $arrival_location_err = "Please enter an arrival location.";
    } else{
        $arrival_location = trim($_POST['arrival_location']);
    }
    if(empty(trim($_POST['event_description']))){
        $event_description_err = "Please enter a description.";
    } else{
        $event_description = trim($_POST['event_description']);
    }
    if(empty(trim($_POST['trip_price']))){
        $trip_price_err = "Please enter a price.";
    } else{
        $trip_price = trim($_POST['trip_price']);
    }
    if(empty(trim($_POST['trip_image']))){
        $trip_image_err = "Please enter an image directory.";
    } else{
        $trip_image = trim($_POST['trip_image']);
    }
    if(empty(trim($_POST['trip_code']))){
        $trip_code_err = "Please enter a trip code.";
    } else{
        $trip_code = trim($_POST['trip_code']);
    }
    
    
    // Check input errors before inserting in database
    if(empty($title_err) && empty($start_event_err) && empty($end_event_err) && empty($departure_location_err) && empty($arrival_location_err) && empty($event_description_err) && empty($trip_price_err) && empty($trip_image_err) && empty($trip_code_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO trips (title, start_event, end_event, departure_location, arrival_location, state_booking, event_description, trip_price, trip_image, trip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss", $param_title, $param_start_event, $param_end_event, $param_departure_location, $param_arrival_location, $param_state_booking, $param_event_description, $param_trip_price, $param_trip_image, $param_trip_code);
            
            // Set parameters
            $param_title = $title;
            $param_start_event = $start_event;
            $param_end_event = $end_event;
            $param_departure_location = $departure_location;
            $param_arrival_location = $arrival_location;
            $param_state_booking = $state_booking;
            $param_event_description = $event_description;
            $param_trip_price = $trip_price;
            $param_trip_image = $trip_image;
            $param_trip_code = $trip_code;
            
            $alert_success = "";
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                unset($_SESSION['alert_success']);
                $alert_success = '<div class="alert alert-success alert-dismissible mt-2">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>New trip successfully added to the website!</strong>
                  </div>';
                $_SESSION['alert_success'] = $alert_success;
                // Reload page to reset fields
                header("location: admin-add-trip.php");
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
// Processing form data when form is submitted
if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['update1'])){
 
    //Prepare empty inputs
    if(empty(trim($_POST['state_booking']))){
        $state_booking_err = "Please select a booking status";
    } else{
        $state_booking = trim($_POST['state_booking']);
    }
    //Prepare empty inputs
    if(empty(trim($_POST['TripID']))){
        $TripID_err = "Please enter a valid Trip id";
    } else{
        $TripID = trim($_POST['TripID']);
    }
    
    // Check input errors before updating in database
    if(empty($state_booking_err) && (empty($TripID_err))){
        
        // Prepare an update statement
        $sql = "UPDATE trips SET state_booking=? WHERE TripID=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si",$param_state_booking,$param_tripID);
            
            // Set parameters
            $param_state_booking = $state_booking;
            $param_tripID = $TripID;
        
            $alert_success = '';
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                unset($_SESSION['alert_success']);
                $alert_success = '<div class="alert alert-success alert-dismissible mt-2">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Booking status updated!</strong>
                  </div>';
                $_SESSION['alert_success'] = $alert_success;
                // Reload page to reset fields
                header("location: admin-add-trip.php");
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
// Processing form data when form is submitted
if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['delete1'])){
 
    //Prepare empty inputs
    if(empty(trim($_POST['TripID']))){
        $TripID_err = "Please enter a valid Trip id";
    } else{
        $TripID = trim($_POST['TripID']);
    }
    
    // Check input errors before deleting in database
    if(empty($TripID_err)){
        
        // Prepare a delete statement
        $sql = "DELETE FROM trips WHERE TripID=? ";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i",$param_TripID);
            
            // Set parameters
            $param_TripID = $TripID;
            
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
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manage trips</title>
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .login-container {
            margin-top: 100px;
            width: 100%;
            background-color: #F2F2F2;
            background-blend-mode: lighten;
            margin-left: 0;
            margin-right: 0;
            min-width: 100%;
        }

        @media (min-width:769px) {
            .login-form {
                padding-left: 200px;
                padding-right: 200px;
            }
        }

        thead {
            background-color: #354375 !important;
            color: white !important;
        }

    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
                    <li class="nav-item active"><a href="admin-add-trip.php" style="font-size: 17px; margin-left: 5px;">MANAGE TRIPS</a></li>
                    <li class="nav-item"><a href="admin-manage.php" style="font-size: 17px; margin-left: 5px;">MANAGE BOOKINGS</a></li>
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
    <?php
        echo $_SESSION['alert_success'];
        ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="container login-container">
                    <h2 class="login-form">Add trip to calendar</h2>
                    <br>
                    <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                                    <label>Title:<sup>*</sup></label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                                    <span class="help-block"><?php echo $title_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($start_event_err)) ? 'has-error' : ''; ?>">
                                    <label>Select departure date:<sup>*</sup></label>
                                    <input type="date" name="start_event" class="form-control" value="<?php echo $start_event; ?>">
                                    <span class="help-block"><?php echo $start_event_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($end_event_err)) ? 'has-error' : ''; ?>">
                                    <label>Select arrival date:<sup>*</sup></label>
                                    <input type="date" name="end_event" class="form-control" value="<?php echo $end_event; ?>">
                                    <span class="help-block"><?php echo $end_event_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($departure_location_err)) ? 'has-error' : ''; ?>">
                                    <label>Departure location:<sup>*</sup></label>
                                    <input type="text" name="departure_location" class="form-control" value="<?php echo $departure_location; ?>">
                                    <span class="help-block"><?php echo $departure_location_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($arrival_location_err)) ? 'has-error' : ''; ?>">
                                    <label>Arrival location:<sup>*</sup></label>
                                    <input type="text" name="arrival_location" class="form-control" value="<?php echo $arrival_location; ?>">
                                    <span class="help-block"><?php echo $arrival_location_err; ?></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group <?php echo (!empty($event_description_err)) ? 'has-error' : ''; ?>">
                                    <label>Description of trip:<sup>*</sup></label>
                                    <textarea type="text" name="event_description" class="form-control" rows="3" value="<?php echo $event_description; ?>"></textarea>
                                    <span class="help-block"><?php echo $event_description_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($trip_price_err)) ? 'has-error' : ''; ?>">
                                    <label>Price per cabin (€):<sup>*</sup></label>
                                    <input type="text" name="trip_price" class="form-control" value="<?php echo $trip_price; ?>">
                                    <span class="help-block"><?php echo $trip_price_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($trip_image_err)) ? 'has-error' : ''; ?>">
                                    <label>Enter image directory (e.g. img/filename.png):<sup>*</sup></label>
                                    <input type="text" name="trip_image" class="form-control" value="<?php echo $trip_image; ?>">
                                    <span class="help-block"><?php echo $trip_image_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($trip_code_err)) ? 'has-error' : ''; ?>">
                                    <label>Enter trip code (e.g. p1043):<sup>*</sup></label>
                                    <input type="text" name="trip_code" class="form-control" value="<?php echo $trip_code; ?>">
                                    <span class="help-block"><?php echo $trip_code_err; ?></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="enter1" value="Submit">
                                    <input type="reset" class="btn btn-default" value="Reset">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped text-center center">
                    <thead>
                        <tr>
                            <h2 class="text-center m-0">Manually update booking status</h2>
                            <hr>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"><label>Select booking status:</label></td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" method="post">
                                <td colspan="3">
                                    <select name="state_booking" class="form-control">
                                        <option value="available">Available</option>
                                        <option value="booked">Booked</option>
                                    </select>
                                    <span class="help-block"><?php echo $state_booking_err; ?></span>
                                </td>
                                <td colspan="2"><label>Enter Trip id:</label></td>
                                <td colspan="2">
                                    <input type="number" name="TripID" class="form-control" value="<?php echo $TripID; ?>">
                                    <span class="help-block"><?php echo $TripID_err; ?></span>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" name="update1" value="Update">
                                    </div>
                                </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped text-center center">
                    <thead>
                        <tr>
                            <h2 class="text-center m-0">Section to delete trips</h2>
                            <hr>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2"><label>Enter Trip id to delete:</label></td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" method="post">
                                <td colspan="3">

                                    <input type="number" name="TripID" class="form-control" value="<?php echo $TripID; ?>">
                                    <span class="help-block"><?php echo $TripID_err; ?></span>

                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input type="submit" name="delete1" class="btn btn-primary" value="Delete">
                                    </div>
                                </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped text-center center">
                    <thead>
                        <tr>
                            <td colspan="14">
                                <h2 class="text-center m-0">Trips in database filtered by availability</h2>
                            </td>
                        </tr>
                        <tr style="font-size:16px;">
                            <th colspan="1">Trip id</th>
                            <th colspan="1">Image</th>
                            <th colspan="2">Title</th>
                            <th colspan="3">Departure</th>
                            <th colspan="3">Arrival</th>
                            <th colspan="2">Description</th>
                            <th colspan="1">Price per cabin</th>
                            <th colspan="1">Booking state</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                    require_once 'config.php';
                                
                                        $stmt = $link->prepare("SELECT * FROM trips");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
    
                                        while($row = $result->fetch_assoc()):
                                    ?>
                        <tr>
                            <td colspan="1"><?= $row['TripID']?></td>
                            <td colspan="1"><img src="<?= $row['trip_image'] ?>" width="60"> </td>
                            <td colspan="2"><?= $row['title']?></td>
                            <td colspan="3">Departure date:&nbsp;&nbsp;<?= $row['start_event'] ?> from&nbsp;&nbsp;<?= $row['departure_location']?></td>
                            <td colspan="3">Arrival date:&nbsp;&nbsp;<?= $row['end_event'] ?> at&nbsp;&nbsp;<?= $row['arrival_location'] ?></td>
                            <td colspan="2"><?= $row['event_description']?></td>
                            <td colspan="1">€ &nbsp;<?= number_format($row['trip_price'],2)?></td>
                            <th colspan="1"><?= $row['state_booking']?></th>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
