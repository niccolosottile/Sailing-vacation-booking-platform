<?php 

require 'config.php';

require "/home/zt45incd/public_html/PHPMailer-master/src/PHPMailer.php";
require "/home/zt45incd/public_html/PHPMailer-master/src/SMTP.php";
require "/home/zt45incd/public_html/PHPMailer-master/src/Exception.php";
                
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email_err='';

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

if(isset($_POST['email'])){
                
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
                                $email = trim($_POST["email"]);
                            } else{
                                $email_err = "Enter a valid email.";
                            }
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
                if(empty($email_err)){
        
                $emailTo = $_POST['email'];
                
                $code = uniqid(true);
                $query = mysqli_query($link, "INSERT INTO resetPasswords(code, email) VALUES ('$code','$emailTo')");
                if(!$query){
                    exit("Error");
                }
                    
                //Send email with link to reset the password
                $mail = new PHPMailer();
             
                //Send mail with server email
                $mail->IsSMTP(); // telling the class to use SMTP
                $mail->Host = "ssl://authsmtp.securemail.pro"; // sets email server as the SMTP server
                $mail->SMTPAuth = true; // enable SMTP authentication
                $mail->SMTPSecure = "tls"; // sets the prefix to the server
                $mail->Port = "465"; // set the SMTP port for the email server
                $mail->Username = "noreply@edenjsailadventures.com"; //  username
                $mail->Password = "bowdu7-mopvav-tiwjUf"; // password   

                //Typical mail data
                $url = "https://edenjsailadventures.com/resetPassword.php?code=$code";
                $mail->Subject = "Your password reset link";
                $mail->SetFrom("noreply@edenjsailadventures.com", "Edenj Sail Adventures");
                $mail->IsHTML(true);
                $mail->Body = "<h3>You requested a password reset for your account</h3><br><a href='$url'><b>Click here to reset your password!<b></a>";
                $mail->AddAddress($emailTo);
                
                if( $mail->Send() ){
                    echo '<div style="height:200px;font: sans-serif; text-align: center; margin-top: 250px;margin-top: 250px;width: 100%;background-color: #F2F2F2;background-blend-mode: lighten;margin-left: 0;margin-right: 0;min-width: 100%;"><br><br><h3> An email has been sent. Check your inbox!</h3></div>
                    ';
                }
                else{
                    echo "Error!";
                }
                
                $mail->smtpClose();
                exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Reset password</title>
    <style type="text/css">
        body {
            font: 14px sans-serif;
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
    <div class="update-container">
        <br>
        <h3 class="update-form"> Enter the email associated with your account </h3>
        <form class="update-form" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Account email:</label>
                <input type="text" name="email" class="form-control" autocomplete='off' style="width: 35%;">
                <span class="help-block"><?php echo $email_err; ?></span>
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
        <br>
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
