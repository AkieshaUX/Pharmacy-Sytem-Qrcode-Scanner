<?php

$conn = new mysqli('localhost', 'root', '', 'pharma');


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT m.medregisterid, m.medname, SUM(s.soldquantity) AS total_sold FROM `medregister` m JOIN `sold` s ON m.medregisterid = s.medregisterid  WHERE s.status = 1 GROUP BY m.medregisterid";
$result = $conn->query($sql);


$products = [];
$total_sold_quantities = [];
$product_names = [];

while ($row = $result->fetch_assoc()) {
  $products[] = $row['medregisterid'];
  $total_sold_quantities[] = $row['total_sold'];
  $product_names[] = $row['medname']; 
}


