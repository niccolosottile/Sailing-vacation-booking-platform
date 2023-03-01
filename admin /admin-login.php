<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$email = $password = $AdminID = "";
$email_err = $password_err = "";
 
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
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = 'Please enter an email.';
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    

    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT email, AdminID, password FROM admin WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $email, $AdminID, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the email to the session */
                            session_start();
                            $_SESSION['email'] = $email;
                            $_SESSION['AdminID'] = $AdminID;
                            
                            header("location: admin-panel.php");
                             
                        } else{
                            // Display an error message if password is not valid
                            $password_err = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $email_err = 'No account found with that email.';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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

    <title>Admin Login</title>
    <style type="text/css">
        body {
            font: 14px sans-serif;
        }

        .login-container {
            margin-top: 250px;
            margin-top: 250px;
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- API for recaptcha google used in forms -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body>
    <div class="container login-container">
        <h2 class="login-form">Admin Login</h2>
        <p class="login-form">Please fill in your credentials to login.</p>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email:<sup>*</sup></label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" style="width: 250px;">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password:<sup>*</sup></label>
                <input type="password" name="password" class="form-control" style="width: 250px;">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <br>
            <div class="form-group">
                <!-- recaptcha "i'm not a robot" -->
                <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Lc2YFoaAAAAAETzqwZG7eTvrvk1NQRd3AyBVoIR"></div>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>
</body>

</html>
