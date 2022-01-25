
<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=zt45incd_edenjsailadventures', 'zt45incd_edenj', 'bowdu7-mopvav-tiwjUf');

$data = array();
$state_booking='';

$query = "SELECT * FROM trips ORDER BY TripID";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
$state_booking = $row['state_booking'];
if($state_booking=='available'){
 
 $data[] = array(
  'id'   => $row["TripID"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}
}
echo json_encode($data);

?>
