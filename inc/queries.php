<?php
$conn = new mysqli('localhost', 'root', '', 'pharma');


function displayRegisterMeds($conn)
{
  $query = mysqli_query($conn, "SELECT * FROM `medregister` WHERE `status` = 1 ORDER BY `medregisterid` DESC");
  return $query;
}

function displayStock($conn)
{
  $query = mysqli_query($conn, "SELECT mr.medregisterid,mr.medcode , mr.medname, mr.medtablets, SUM(s.rquantity) AS total_quantity FROM `medregister` AS mr LEFT JOIN `stock` AS s ON mr.medregisterid = s.medregisterid WHERE s.status = 0 GROUP BY mr.medregisterid,mr.medcode, mr.medname");

  return $query;
}


function displayExpiered($conn)
{
  $query = mysqli_query($conn, "SELECT mr.medregisterid,mr.medcode , mr.medname, SUM(s.rquantity) AS total_quantity, s.exdate FROM `medregister` AS mr LEFT JOIN `stock` AS s ON mr.medregisterid = s.medregisterid WHERE s.status = 1 GROUP BY mr.medregisterid,mr.medcode, mr.medname,s.exdate");

  return $query;
}



function displayaddcart($conn)
{
  return mysqli_query($conn, "
    SELECT 
       mr.medprice, 
       mr.medtablets, 
       SUM(s.soldquantity) AS total_soldquantity, 
       SUM(s.soldprice) AS total_soldprice, 
       mr.medname, 
       mr.medcode, 
       SUM(s.soldprice) / SUM(s.soldquantity) AS average_price_per_unit 
    FROM `sold` AS s 
    JOIN `medregister` AS mr 
      ON s.medregisterid = mr.medregisterid 
    WHERE s.status = 0
    GROUP BY mr.medregisterid
  ");
}



function displaySales($conn, $datetime = '')
{
  // Basic query to get product details with summed sold quantities and medtablets
  $sql = "SELECT m.medname, m.medcode, m.medtablets, SUM(s.soldquantity) AS total_sold_quantity, SUM(s.soldprice) AS total_price
            FROM `medregister` m
            JOIN `sold` s ON m.medregisterid = s.medregisterid";

  // If a datetime filter is applied, add a WHERE clause to filter by year and month
  if ($datetime != '') {
    $year = substr($datetime, 0, 4);
    $month = substr($datetime, 5, 2);
    $sql .= " WHERE YEAR(s.datetime) = '$year' AND MONTH(s.datetime) = '$month'";
  }

  // Group by medname and medcode to get total sold quantity per product
  $sql .= " GROUP BY m.medname, m.medcode, m.medtablets";  // Grouping by medtablets as well

  return mysqli_query($conn, $sql);
}



function displaydashboardsales($conn)
{
  $query = mysqli_query($conn, "SELECT m.*, s.* FROM `medregister` m JOIN `sold` s ON m.medregisterid = s.medregisterid  WHERE s.status = 1 AND DATE(s.datetime) = CURDATE()");
  return $query;
}
