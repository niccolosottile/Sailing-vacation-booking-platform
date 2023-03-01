<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$email = $firstname = $lastname = $DOB = $nationality = $phone = $password = $confirm_password = "";
$email_err = $firstname_err = $lastname_err = $DOB_err = $nationality_err = $phone_err = $password_err = $confirm_password_err = "";

// Function to verifiy recaptcha which returns success or not
function reCaptcha($recaptcha){
  $secret = "6Lc2YFoaAAAAAHUOqID7PWtmRkkHFASpl4m3lP6o";
  $ip = $_SERVER['REMOTE_ADDR'];

  $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
  $url = "https://www.google.com/recaptcha/api/siteverify";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
  $data = curl_exec($ch);
  curl_close($ch);

  return json_decode($data, true);
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $recaptcha = $_POST['g-recaptcha-response'];
    $res = reCaptcha($recaptcha);
    // if recaptcha is false then block from logging in
    if(!$res['success']){
      // Error
    }  
    else{
        
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
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
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Please confirm password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Password did not match.';
        }
    }
    
    //Prepare empty inputs
    if(empty(trim($_POST['firstname']))){
        $firstname_err = "Please enter your first name.";
    } else{
        $firstname = trim($_POST['firstname']);
    }
    if(empty(trim($_POST['lastname']))){
        $lastname_err = "Please enter your last name.";
    } else{
         $lastname = trim($_POST['lastname']);
    }
    if(empty(trim($_POST['DOB']))){
        $DOB_err = "Please enter your date of birth.";
    } else{
        $DOB = trim($_POST['DOB']);
    }
    if(empty(trim($_POST['nationality']))){
        $nationality_err = "Please enter your nationality.";
    } else{
        $nationality = trim($_POST['nationality']);
    }
    if(empty(trim($_POST['phone']))){
        $phone_err = "Please enter your phone number.";
    } else{
        $phone = trim($_POST['phone']);
    }
    
    
    
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($firstname_err) && empty($lastname_err) && empty($DOB_err) && empty($nationality_err) && empty($phone_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO customers (email, firstname, lastname, DOB, nationality, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_email, $param_firstname, $param_lastname, $param_DOB, $param_nationality, $param_phone, $param_password);
            
            // Set parameters
            $param_email = $email;
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_DOB = $DOB;
            $param_nationality = $nationality;
            $param_phone = $phone;

            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sign Up</title>
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .login-container {
            margin-top: 125px;
            margin-top: 100px;
            width: 100%;
            background-color: #F2F2F2;
            background-blend-mode: lighten;
            margin-left: 0;
            margin-right: 0;
            min-width: 100%;
        }

        @media (min-width:768px) {
            .login-form {
                padding-left: 200px;
                padding-right: 200px;
            }
        }

    </style>
    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- API for recaptcha google used in forms -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
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
    <div class="container login-container">
        <h2 class="login-form">Sign Up</h2>
        <p class="login-form">Please fill this form to create an account.</p>
        <br>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label>Email:<sup>*</sup></label>
                        <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" style="width:250px;">
                        <span class="help-block"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                        <label>First name:<sup>*</sup></label>
                        <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>" style="width:250px;">
                        <span class="help-block"><?php echo $firstname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                        <label>Last name:<sup>*</sup></label>
                        <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>" style="width:250px;">
                        <span class="help-block"><?php echo $lastname_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($DOB_err)) ? 'has-error' : ''; ?>">
                        <label>Date of birth:<sup>*</sup></label>
                        <input type="date" name="DOB" class="form-control" value="<?php echo $DOB; ?>" style="width:250px;">
                        <span class="help-block"><?php echo $DOB_err; ?></span>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group <?php echo (!empty($nationality_err)) ? 'has-error' : ''; ?>">
                        <label>Nationality:<sup>*</sup></label>
                        <input type="text" name="nationality" class="form-control" value="<?php echo $nationality; ?>" style="width:250px;">
                        <span class="help-block"><?php echo $nationality_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                        <label>Phone number (include prefix):<sup>*</sup></label>
                        <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" style="width:250px;">
                        <span class="help-block"><?php echo $phone_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password:<sup>*</sup></label>
                        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" style="width:250px;">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label>Confirm Password:<sup>*</sup></label>
                        <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" style="width:250px;">
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <br>
                    <div class="form-group">
                        <!-- recaptcha "i'm not a robot" -->
                        <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Lc2YFoaAAAAAETzqwZG7eTvrvk1NQRd3AyBVoIR"></div>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-default" value="Reset">
                    </div>
                </div>
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
    <br>
    <br>
    <br>
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
</body>

</html>
