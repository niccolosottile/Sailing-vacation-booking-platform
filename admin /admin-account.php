<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

// Define variables and initialize with empty values
$email = "";
$email_err = "";
$AdminID = $_SESSION['AdminID'];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } 
    else{
        // Prepare a select statement
        $sql = "SELECT email FROM admin WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        $email = trim($_POST["email"]);
    }
      // Check input errors before inserting in database
    if(empty($email_err)){
        
        // Prepare an update statement
        $sql = "UPDATE admin SET `email` = '$email' WHERE AdminID = $AdminID";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* Password is correct, so start a new session and
                            save the email to the session */
                            session_start();
                            $_SESSION['email'] = $email;
                // Redirect to account page
                header("location: admin-account.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
    <title>Admin Account</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
        }

        @media (min-width:768px) {
            .update-form {
                padding-left: 200px;
                padding-right: 200px;
                text-align: left;

            }
        }

        .update-container {

            margin-top: 250px;
            margin-top: 250px;
            width: 100%;
            background-color: #F2F2F2;
            background-blend-mode: lighten;
            margin-left: 0;
            margin-right: 0;
            min-width: 100%;
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
                    <li class="nav-item active"><a href="admin-panel.php" style="font-size: 17px; margin-left: 100px;">PANEL INFO</a></li>
                    <li class="nav-item"><a href="admin-add-trip.php" style="font-size: 17px; margin-left: 5px;">MANAGE TRIPS</a></li>
                    <li class="nav-item"><a href="admin-manage.php" style="font-size: 17px; margin-left: 5px;">MANAGE BOOKINGS</a></li>
                    <li class="nav-item"><a href="admin-analysis.php" style="font-size: 17px; margin-left: 5px;">ANALYSE DATA</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <li class="active"><a href="#" style="font-size: 17px;"><span class="glyphicon glyphicon glyphicon-user"></span> ACCOUNT</a></li>
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
    <div class="update-container">
        <br>
        <br>
        <h2 class="update-form">Welcome to your admin account <?php echo $_SESSION["email"]; ?> !</h2>
        <form class="update-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email:</label>
                <input type="text" name="email" class="form-control" placeholder="<?php echo ($_SESSION["email"]); ?>" style="width:250px;">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update email">
            </div>
        </form>
        <br>
        <br>
    </div>
    <br>
</body>

</html>
