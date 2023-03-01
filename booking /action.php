<?php 
    session_start();
    
    require 'config.php';

    if(isset($_POST['pid']) && isset($_POST['pcustomerid'])){
        $pid = $_POST['pid'];
        $pcustomerid = $_POST['pcustomerid'];
        
        $pprice = $_POST['pprice'];
        
        $pcabinno = $_POST['pcabinno'];
        $padultno = $_POST['padultno'];
        $pchildno = $_POST['pchildno'];
        $pmessage = $_POST['pmessage'];
        
        $ptotal = $pprice*$pcabinno;
       
        $stmt = $link->prepare("SELECT trips.trip_code FROM cart INNER JOIN trips ON cart.TripID = trips.TripID WHERE cart.TripID=? AND cart.CustomerID=?");
        $stmt->bind_param("ii",$pid,$pcustomerid);
        $stmt->execute();
        $res = $stmt->get_result();
        $r = $res->fetch_assoc();
        $code = $r['trip_code'];
        
        if(!$code){
            $query = $link->prepare("INSERT INTO cart (CabinNo,AdultNo,ChildNo,trip_message,total_price,TripID,CustomerID) VALUES (?,?,?,?,?,?,?)");
            $query->bind_param("iiissis",$pcabinno,$padultno,$pchildno,$pmessage,$ptotal,$pid,$pcustomerid);
            $query->execute();
            
            echo '<div class="alert alert-success alert-dismissible mt-2">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Trip added to your cart!</strong>
                  </div>';
        }
        else{
            
            echo '<div class="alert alert-danger alert-dismissible mt-2">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Trip already added to your cart!</strong>
                  </div>';
        }
    }
        
    if(isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item'){
        if(isset($_SESSION['email'])){
    
        $CustomerID = $_SESSION['CustomerID'];
        $stmt = $link->prepare("SELECT * FROM cart WHERE CustomerID=?");
        $stmt->bind_param("i",$CustomerID);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        
        echo $rows;
        }
        else{
            
        $_currentSessionId = $_COOKIE['YOUR_SID'];
        $stmt = $link->prepare("SELECT * FROM cart WHERE CustomerID=?");
        $stmt->bind_param("s",$_currentSessionId);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        
        echo $rows;
        }
    }
    if(isset($_GET['remove'])){
        $CartID = $_GET['remove'];
        
        $stmt = $link->prepare("DELETE FROM cart WHERE CartID=?");
        $stmt->bind_param("i",$CartID);
        $stmt->execute();
        
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'Trip removed from the cart';
        header('location:cart.php');
    }
    if(isset($_GET['clear'])){
        if(isset($_SESSION['email'])){
            $CustomerID = $_SESSION['CustomerID'];
            $stmt = $link->prepare("DELETE FROM cart WHERE CustomerID=?");
            $stmt->bind_param("i",$CustomerID);
            $stmt->execute();
            $_SESSION['showAlert'] = 'block';
            $_SESSION['message'] = 'All trips removed from the cart';
            header('location:cart.php');
        }
        else{
            $_currentSessionId = $_COOKIE['YOUR_SID'];
            $stmt = $link->prepare("DELETE FROM cart WHERE CustomerID=?");
            $stmt->bind_param("s",$_currentSessionId);
            $stmt->execute();
            $_SESSION['showAlert'] = 'block';
            $_SESSION['message'] = 'All trips removed from the cart';
            header('location:cart.php');
        }  
    }
?>
