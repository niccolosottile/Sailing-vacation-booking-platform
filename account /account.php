<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

?>
<!DOCTYPE html>
<html lang="en" class="fontawesome-i2svg-active fontawesome-i2svg-complete">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Account</title>
    <style type="text/css"> 
        @media (min-width:768px){
        .update-form{
            padding-left: 200px;
            padding-right: 200px;
            text-align: center;
            }
        .account-container{
            margin-left: 100px;
            margin-right: 100px;
            width: 75%;
            }
        }
        @media (max-width:767px){
            .account-container{
            width: 100%;
            }
        }
        .update-container{
            
            margin-top: 250px;
            background-color: #F2F2F2;
            background-blend-mode: lighten;
            font: 14px sans-serif; 
            text-align: center;
            
            
        }
        .account-container{
            border: 2px solid;
            color: black;
            text-align: center;
           
        }
        #btn-offers{
            background-color: #334996;
            border: 1px solid white;
            color: white;
            pointer-events: unset;
        }
        #btn-light{
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
                <li class="active">
                    <a href="account.php">Welcome</a>
                </li>
                <li>
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
                        <a href="booknow.php" id="btn-offers" class="btn">View our offers!</a>
                    </li>
                </ul>
        </nav>
        <div id="main">
            <!-- Button that will run the openNav() function on click -->
            <button class="openbtn" onclick="openNav()">&#9776; Open Sidebar</button>
            <div class="update-container account-container">
                <h2 class="update-form">Welcome to your account <?php echo $_SESSION["firstname"]; ?> !</h2>
                <hr>
                <p>In this section of the website you can: </p>
                <ul style="list-style-type: none;">
                    <li><p>- view personal information</p> </li>
                    <li><p>- manage your account state</p></li>
                    <li><p>- modify account information</p></li>
                    <li><p>- reset your password </p></li>
                    <li><p>- view your booked sailing vacations</p></li>
                </ul>
                <br>
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
