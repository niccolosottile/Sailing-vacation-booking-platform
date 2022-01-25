<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

// Define variables and initialize with empty values
$email = $phone = $password = $confirm_password = "";
$email_err = $phone_err = $password_err = $confirm_password_err =  "";
$CustomerID = $_SESSION ['CustomerID'];

// Processing form data when form is submitted
if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['email1'])){
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } 
    else{
        // Prepare a select statement
        $sql = "SELECT CustomerID FROM customers WHERE email = ?";
        
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
        $sql = "UPDATE customers SET `email` = '$email' WHERE CustomerID = $CustomerID";
         
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
                header("location: account-info.php");
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
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['phone1'])){
    
    //Validate phone number
     if(empty(trim($_POST['phone']))){
        $phone_err = "Please enter your phone number.";
    } else{
        $phone = trim($_POST['phone']);
    }
    
      // Check input errors before inserting in database
    if(empty($phone_err)){
        
        // Prepare an update statement
        $sql = "UPDATE customers SET `phone` = '$phone' WHERE CustomerID = $CustomerID";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_phone);
            
            // Set parameters
            $param_phone = $phone;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* Password is correct, so start a new session and
                            save the email to the session */
                            session_start();
                            $_SESSION['phone'] = $phone;
                // Redirect to account page
                header("location: account-info.php");
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

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password1'])){
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password."; 
        $_SESSION['blockform'] = 1;
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must have at least 6 characters.";
        $_SESSION['blockform'] = 1;
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.'; 
        $_SESSION['blockform'] = 1;
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
            $_SESSION['blockform'] = 1;
        }
    }
    
    if(empty($password_err) && empty($confirm_password_err)){
    
    $password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
    
    
    $query = mysqli_query($link, "UPDATE customers SET password='$password' WHERE CustomerID='$CustomerID'");
    if($query){
        echo'<div style="height:200px;font: sans-serif; text-align: center; margin-top: 250px;margin-top: 250px;width: 100%;background-color: #F2F2F2;background-blend-mode: lighten;margin-left: 0;margin-right: 0;min-width: 100%;"><br><br><h3> Password successfully reset!</h3><br><p>Want to go back to your account?<a href="account.php">View Account</a>.</p></div>
        ';
        exit();
    }
    else{
        echo("Something went wrong");
    }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My details</title>
    <style type="text/css">
        @media (min-width:769px) {
            .update-form {
                padding-left: 200px;
                padding-right: 200px;
                text-align: left;
            }

            .account-container {
                margin-left: 100px;
                margin-right: 100px;
                width: 75%;
            }
        }

        @media (max-width:767px) {
            .account-container {
                width: 100%;
            }
        }

        @media (max-width:768px) {

            .update-form {
                padding-left: 10px;
                padding-right: 10px;
                text-align: left;
            }
        }

        .update-container {

            margin-top: 250px;
            background-color: #F2F2F2;
            background-blend-mode: lighten;
            font: 14px sans-serif;
            text-align: left;


        }

        .account-container {
            border: 2px solid;
            color: black;
            text-align: left;

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

    </style>
    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style-account.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Used to popup reset password menu -->
    <script>
        function showHideResetPassword() {
            if (document.getElementById('reset1').onclick) {
                document.getElementById('resetpassword1').style.display = 'block';
            } else {}
        }

    </script>
</head>

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
            <li class="active">
                <a href="account-info.php">My details</a>
            </li>
            <li>
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
        <div class="update-container account-container update-form">
            <h2>Here you can view or modify account information</h2>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email:</label>
                    <input type="text" name="email" class="form-control" placeholder="<?php echo ($_SESSION["email"]); ?>" style="width: 40%;" autocomplete="off">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="email1" class="btn btn-primary" value="Update email">
                </div>
            </form>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                    <label>Phone number:</label>
                    <input type="text" name="phone" class="form-control" placeholder="<?php echo ($_SESSION["phone"]); ?>" style="width: 40%;" autocomplete="off">
                    <span class="help-block"><?php echo $phone_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="phone1" class="btn btn-primary" value="Update phone">
                </div>
            </form>
            <br>
            <br>
            <div class="form-group">
                <label>Password:</label>
            </div>
            <br>
            <div class="form-group">
                <a id="reset1" class="btn btn-primary" style="width:240px;" onclick="showHideResetPassword()">Click here to reset your password</a>
            </div>
            <br>
            <br>
            <form id="resetpassword1" class="modify-form" method="post">
                <p>Enter a new password for your account</p>
                <br>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password:<sup>*</sup></label>
                    <input type="password" name="password" class="form-control" style="width: 40%;" autocomplete="off">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password:<sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control" style="width: 40%;" autocomplete="off">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <br>
                <div class="form-group">
                    <input name="password1" type="submit" class="btn btn-primary" value="Update password">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
                <br>
            </form>
            <?php if(isset($_SESSION['blockform'])){ ?>
            <script>
                showHideResetPassword();

            </script>
            <?php } unset($_SESSION['blockform']); ?>
        </div>
    </div>

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
