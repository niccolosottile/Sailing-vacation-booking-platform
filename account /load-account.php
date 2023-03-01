<?php

session_start();

//load.php

$connect = new PDO('mysql:host=localhost;dbname=zt45incd_edenjsailadventures', 'zt45incd_edenj', 'bowdu7-mopvav-tiwjUf');

$data = array();
$CustomerID = $_SESSION['CustomerID'];

$query = "SELECT * FROM ((tripsorders INNER JOIN trips ON tripsorders.TripID = trips.TripID) INNER JOIN orders ON orders.OrderID = tripsorders.OrderID) WHERE orders.CustomerID= :CustomerID ORDER BY trips.TripID";

$statement = $connect->prepare($query);
$statement->bindParam(':CustomerID', $CustomerID, PDO::PARAM_INT);
$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 
 $data[] = array(
  'id'   => $row["TripID"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}

echo json_encode($data);

?>
