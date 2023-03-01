<?php
// Initialize the session
session_start();

// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$name = $email = $phone = $details = "";
$name_err = $email_err = $phone_err = $details_err = "";

require "/home/zt45incd/public_html/PHPMailer-master/src/PHPMailer.php";
require "/home/zt45incd/public_html/PHPMailer-master/src/SMTP.php";
require "/home/zt45incd/public_html/PHPMailer-master/src/Exception.php";
                
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
        
    //Prepare empty inputs
    if(empty(trim($_POST['name']))){
        $name_err = "Please enter your name.";
    } else{
        $name = trim($_POST['name']);
    }
    if(empty(trim($_POST['email']))){
        $email_err = "Please enter an email.";
    } else{
         $email = trim($_POST['email']);
    }
    if(empty(trim($_POST['phone']))){
        $phone_err = "Please enter your phone number.";
    } else{
        $phone = trim($_POST['phone']);
    }
    if(empty(trim($_POST['details']))){
        $details_err = "Please enter details of your request (including desired dates).";
    } else{
        $details = trim($_POST['details']);
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($phone_err) && empty($details_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO enquire (name, email, phone, details) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss",$param_name,$param_email,$param_phone,$param_details);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_phone = $phone;
            $param_details = $details;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                //Send email to admin to let him know a new request has appeared

                $mail = new PHPMailer();

                //Send mail using gmail
                
                    //$mail->IsSMTP(); // telling the class to use SMTP
                    //$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
                    //$mail->SMTPAuth = true; // enable SMTP authentication
                    //$mail->SMTPSecure = "tls"; // sets the prefix to the servier
                    //$mail->Port = "587"; // set the SMTP port for the GMAIL server
                    //$mail->Username = "edenjsailadventures1@gmail.com"; // GMAIL username
                    //$mail->Password = "EDENJ1sail!"; // GMAIL password
                
                //Send mail with server email
                
                    $mail->IsSMTP(); // telling the class to use SMTP
                    $mail->Host = "ssl://authsmtp.securemail.pro"; // sets email server as the SMTP server
                    $mail->SMTPAuth = true; // enable SMTP authentication
                    $mail->SMTPSecure = "tls"; // sets the prefix to the server
                    $mail->Port = "465"; // set the SMTP port for the email server
                    $mail->Username = "noreply@edenjsailadventures.com"; //  username
                    $mail->Password = "bowdu7-mopvav-tiwjUf"; // password
                

                //Typical mail data
                $mail->Subject = "|| NEW Client request ||";
                $mail->SetFrom("noreply@edenjsailadventures.com", "Edenj Sail Adventures");
                $mail->IsHTML(true);
                $mail->Body = "<h3>A new request has arrived.</h3><h4>Log into your admin panel to read it!</h4><br><a href='https://edenjsailadventures.com/admin-login.php'><b>Click here to view the details<b></a>";
                $mail->AddAddress("edenjsailadventures1@gmail.com"); // Whatever email the owner wants to receive notifications at
                
                if( $mail->Send() ){
                    echo "Email Sent!";
                }
                else{
                    echo "Error!";
                }
                
                $mail->smtpClose();
                
                // Redirect to login page
                header("location: enquire.php");
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
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enquire</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        #consent-popup {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            opacity: 1;
            background-color: #fff;
            transition: opacity .8s ease;

            &.hidden {
                opacity: 0;
            }
        }

    </style>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MCGE8WE9JL"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-MCGE8WE9JL');

    </script>

    <!-- API for recaptcha google used in forms -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body style="text-align: center;">
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
                    <li class="nav-item active"><a href="enquire.php" style="font-size: 18px;">ENQUIRE</a></li>
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
    <div class="container-fluid">
        <div class="bg">
            <br>
            <br>
            <br>
            <br>
            <div class="form-enquire">
                <h1>Rent the ITA 14.99</h1>
                <hr id="white">
                <h2 class="text-form">Specify the dates ( 6 days minimum )</h2>
            </div>
            <br>
            <br>
            <form class="form-enquire" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                <h1>Request a quote</h1>
                <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                    <label>
                        <h2 class="text-form">Name<sup>*</sup></h2>
                    </label>
                    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" style="width: 260px;">
                    <span class="help-block"><?php echo $name_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>
                        <h2 class="text-form">Email<sup>*</sup></h2>
                    </label>
                    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" style="width: 260px;">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                    <label>
                        <h2 class="text-form">Phone (include prefix)<sup>*</sup></h2>
                    </label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" style="width: 260px;">
                    <span class="help-block"><?php echo $phone_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($details_err)) ? 'has-error' : ''; ?>">
                    <label>
                        <h2 class="text-form">Details<sup>*</sup></h2>
                    </label>
                    <textarea class="form-control" rows="3" name="details" value="<?php echo $details; ?>"></textarea>
                    <span class="help-block"><?php echo $details_err; ?></span>
                </div>
                <div class="form-group">
                    <!-- recaptcha "i'm not a robot" -->
                    <div class="g-recaptcha brochure__form__captcha" data-sitekey="6Lc2YFoaAAAAAETzqwZG7eTvrvk1NQRd3AyBVoIR"></div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
            </form>
            <br>
            <br>
            <br>
            <br>
        </div>
    </div>
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
    <div id="consent-popup" class="hidden">
        <p>This site uses cookies.
            Click <a id="accept">here</a> to accept the use of these cookies.
            <a href="cookie-policy.html">View our cookie policy</a>.
        </p>
    </div>
    <script src="cookie-disclaimer.js"></script>

</body>

</html>
