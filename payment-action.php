<?php

            session_start();
    
            require 'config.php';

            require "/home/zt45incd/public_html/PHPMailer-master/src/PHPMailer.php";
            require "/home/zt45incd/public_html/PHPMailer-master/src/SMTP.php";
            require "/home/zt45incd/public_html/PHPMailer-master/src/Exception.php";

            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;
            
             //Adding cart items to order table //
            $sales_total = $_SESSION['sales_total'];
    
            $CustomerID = $_SESSION['CustomerID'];
    if (isset($_SESSION['previous'])) {
            $stmt = $link->prepare("INSERT INTO orders (amount_payed,CustomerID) VALUES (?,?)");
            $stmt->bind_param("si",$sales_total,$CustomerID);
            $stmt->execute();

            $last_id = $link->insert_id;
            $_SESSION['OrderID'] = $last_id;
            
          $sql = "SELECT trips.TripID,cart.CabinNo, cart.AdultNo, cart.ChildNo, cart.trip_message, cart.total_price FROM cart INNER JOIN trips ON cart.TripID = trips.TripID WHERE cart.CustomerID=?";
          $stmt = $link->prepare($sql);
          // Bind variables to the prepared statement
          mysqli_stmt_bind_param($stmt, "i",$CustomerID);
          $stmt->execute();
          $result = $stmt->get_result();

          while($row = $result->fetch_assoc()){
             //Adding variables to enter into tripsorders table //
             $tripID = $row['TripID'];
             $CabinNo = $row['CabinNo'];
             $AdultNo = $row['AdultNo'];
             $ChildNo = $row['ChildNo'];
             $trip_message = $row['trip_message'];
             $total_price = $row['total_price'];
              
            $stmt = $link->prepare("INSERT INTO tripsorders (OrderID,TripID,CabinNo,AdultNo,ChildNo,trip_message,total_price) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiiiiss",$last_id,$tripID,$CabinNo,$AdultNo,$ChildNo,$trip_message,$total_price);
            $stmt->execute();
             
            // Automatically updating booking status //
            $state_booking = '';
            $CabinNo=0;
              
            $stmt = $link->prepare("SELECT trips.state_booking, tripsorders.CabinNo FROM trips INNER JOIN tripsorders ON trips.TripID = tripsorders.TripID WHERE tripsorders.TripID=?");
            $stmt->bind_param("i",$tripID);
            $stmt->execute();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()){
                $state_booking = $row['state_booking'];
                $CabinNo +=$row['CabinNo'];
            }
            if(($state_booking == 'available') && ($CabinNo==2)){
                
                    // Updating booking status //
                    $stmt = $link->prepare("UPDATE trips SET state_booking ='booked' WHERE TripID=?");
                    $stmt->bind_param("i",$tripID);
                    $stmt->execute();
            
            }
              
            }
    
            $stmt = $link->prepare("DELETE FROM cart WHERE CustomerID=?");
            $stmt->bind_param("i",$CustomerID);
            $stmt->execute();
        
                //Set the receiver of confirmation email 
                $emailTo = $_SESSION['email'];
        
                //Send email

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
    
                $mail->Subject = "Order confirmation";
                $mail->SetFrom("noreply@edenjsailadventures.com", "Edenj Sail Adventures");
                $mail->IsHTML(true);
                $mail->CharSet = "UTF-8";
                $mail->Body = "
            <div style=\"width:100%;border: 2px solid;color: black;text-align: center;height: 100%;\">
                <h2>Order number: #{$_SESSION['OrderID']}</h2>
                <h2>We cannot wait to see you on board  {$_SESSION['firstname']} !</h2>
                <div style=\"border-color: black;border-width: 2px;\">
                <hr>
                </div>
                <h4>Here you can find a recap of your order</h4>
                <p>Email us if you have any queries before your arrival</p>
                <div style=\"margin-top:2px;\">
                            <table style=\"margin-left:10px;margin-right:10px;margin-bottom:10px;\" width=\"100%\" align=\"center\" border=\"0\" bgcolor=\"#dbdbdb\">               
                                <thead>
                                    <tr>
                                        <th colspan=\"2\">Title</th>
                                        <th colspan=\"1\">Departure</th>
                                        <th colspan=\"1\">Arrival</th>
                                        <th colspan=\"1\">Cabins</th>
                                        <th colspan=\"1\">Adults</th>
                                        <th colspan=\"1\">Children</th>
                                        <th colspan=\"3\">Your message</th>
                                        <th colspan=\"1\">Amount Payed</th>
                                    </tr>
                                </thead>
                                <tbody>";
                                    
                                            
                                            $CustomerID = $_SESSION['CustomerID'];
                                            $OrderID = $_SESSION['OrderID'];
                                            $stmt = $link->prepare("SELECT * 
                                            FROM ((tripsorders 
                                            INNER JOIN trips ON tripsorders.TripID = trips.TripID) 
                                            INNER JOIN orders ON orders.OrderID = tripsorders.OrderID) WHERE orders.CustomerID=? AND tripsorders.OrderID=?");
                                            
                                            $stmt->bind_param("ii",$CustomerID,$OrderID);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while($row = $result->fetch_assoc()):
                                            $total_price = number_format($row['total_price'],2);
                                            
                      $mail->Body .= "                     
                                        <tr>
                                        <td colspan=\"2\"> {$row['title']}</td>
                                        <td colspan=\"1\">Departure date:&nbsp;&nbsp; {$row['start_event']} from&nbsp;&nbsp; {$row['departure_location']}</td>
                                        <td colspan=\"1\">Arrival date:&nbsp;&nbsp; {$row['end_event']} at&nbsp;&nbsp; {$row['arrival_location']}</td>
                                        <td colspan=\"1\"> {$row['CabinNo']}</td>
                                        <td colspan=\"1\"> {$row['AdultNo']}</td>
                                        <td colspan=\"1\"> {$row['ChildNo']}</td>
                                        <td colspan=\"3\"> {$row['trip_message']}</td>
                                        <td colspan=\"1\">€ {$total_price}</td>

                                    </tr>
                                    ";
                                         endwhile;
                                        $sales_totaled = number_format($sales_total,2);
            $mail->Body .= "   
                                    <tr>
                                        <td colspan=\"10\"><label>Total amount paid</label></td>
                                        <td><b>€ {$sales_totaled}</b></td>
                                    </tr>
                                </tbody>
                            </table>
            </div>
        </div>";
        
                $mail->AddAddress($emailTo);
                
                $mail->Send();

                $mail->smtpClose();
            
            // Allowing order / email confirmation to be made only once //
            unset($_SESSION['previous']);
    
            
  }          
    ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Confirmation</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
        
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- Linking style with page-->
        <link rel="stylesheet" type="text/css" href="css/style.css">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    </head>
    <body>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        
            <div class="container-fluid text-container" style="width:90%;">
            <h2>Order number: #<?php echo $_SESSION['OrderID']; ?></h2>
            <h2>Thank you for booking a trip with us <?php echo $_SESSION['firstname']; ?>!</h2>
            <p><b><i>~ We cannot wait to see you on board ~</i></b></p>
            <hr>
            <h2>We sent a confirmation email to:  <?php echo $_SESSION['email']; ?></h2>
            <p>Here you can find a recap of your order</p>
            <!-- Order recap -->
                <div class="table-responsive mt-2">
                            <table class="table table-bordered table-striped text-center center">
                                <thead>
                                    <tr>
                                        <th colspan="1">Image</th>
                                        <th colspan="2">Title</th>
                                        <th colspan="1">Departure</th>
                                        <th colspan="1">Arrival</th>
                                        <th colspan="1">Cabins</th>
                                        <th colspan="1">Adults</th>
                                        <th colspan="1">Children</th>
                                        <th colspan="2">Your message</th>
                                        <th colspan="1">Amount Payed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            //Displaying order made from customer//
                                            $CustomerID = $_SESSION['CustomerID'];
                                            $OrderID = $_SESSION['OrderID'];
                                            $stmt = $link->prepare("SELECT * 
                                            FROM ((tripsorders 
                                            INNER JOIN trips ON tripsorders.TripID = trips.TripID) 
                                            INNER JOIN orders ON orders.OrderID = tripsorders.OrderID) WHERE orders.CustomerID=? AND tripsorders.OrderID=?");
                                            // Bind variables to the prepared statement
                                            $stmt->bind_param("ii",$CustomerID,$OrderID);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while($row = $result->fetch_assoc()):
                                        ?>    
                                        <tr>
                                        <td><img src="<?= $row['trip_image'] ?>" width="60"> </td>
                                        <td colspan="2"><?= $row['title']?></td>
                                        <td colspan="1">Departure date:&nbsp;&nbsp;<?= $row['start_event'] ?> from&nbsp;&nbsp;<?= $row['departure_location']?></td>
                                        <td colspan="1">Arrival date:&nbsp;&nbsp;<?= $row['end_event'] ?> at&nbsp;&nbsp;<?= $row['arrival_location'] ?></td>
                                        <td colspan="1"><?= $row['CabinNo']?></td>
                                        <td colspan="1"><?= $row['AdultNo']?></td>
                                        <td colspan="1"><?= $row['ChildNo']?></td>
                                        <td colspan="2"><?= $row['trip_message']?></td>
                                        <td colspan="1">€ &nbsp;<?= number_format($row['total_price'],2)?></td>

                                    </tr>
                                        <?php endwhile; ?>

                                    <tr>
                                        <td colspan="10"><label>Total amount paid</label></td>
                                        <td><b>€ &nbsp;<?= number_format($sales_total,2)?></b></td>
                                    </tr>
                                </tbody>
                            </table>
            </div>
        </div>
  </body>

</html>