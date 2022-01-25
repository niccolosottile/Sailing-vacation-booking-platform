<?php
// Initialize the session
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Linking style with page-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .table-container {
            border: 2px solid;
            color: black;
            text-align: center;
            width: 80%;
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

    <div class="container-fluid text-container">
        <h2>Successful Login as Admin!</h2>
        <hr>
        <h2>You just logged in with the email: <?php echo $_SESSION['email']; ?></h2>
        <p>In this section you can manage your activities</p>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container-fluid table-container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped text-center center">
                    <thead>
                        <tr>
                            <td colspan="14">
                                <h2 class="text-center m-0">Enquiries received by potential customers</h2>
                            </td>
                        </tr>
                        <tr style="font-size:16px;">
                            <th colspan="2">Name</th>
                            <th colspan="3">Email</th>
                            <th colspan="4">Phone number</th>
                            <th colspan="5">Request details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                    require_once 'config.php';
                                
                                        $stmt = $link->prepare("SELECT * FROM enquire");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
    
                                        while($row = $result->fetch_assoc()):
                                    ?>
                        <tr>
                            <td colspan="2"><?= $row['name'] ?></td>
                            <td colspan="3"><a href="mailto:<?= $row['email'] ?>"><?= $row['email'] ?></a></td>
                            <td colspan="4"><?= $row['phone'] ?></td>
                            <td colspan="5"><?= $row['details'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
