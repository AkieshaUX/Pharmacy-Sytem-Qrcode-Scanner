<?php

$conn = new mysqli('localhost', 'root', '', 'pharma');


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$sql_this_year = "SELECT SUM(soldprice) AS total_sales, MONTH(datetime) AS sale_month  FROM `sold`WHERE status = 1 AND YEAR(datetime) = YEAR(CURDATE()) GROUP BY MONTH(datetime)";
$result_this_year = $conn->query($sql_this_year);


$sql_last_year = "SELECT SUM(soldprice) AS total_sales, MONTH(datetime) AS sale_month FROM `sold` WHERE status = 1 AND YEAR(datetime) = YEAR(CURDATE()) - 1  GROUP BY MONTH(datetime)";
$result_last_year = $conn->query($sql_last_year);

$months = [];
$this_year_sales = [];
$last_year_sales = [];


while ($row = $result_this_year->fetch_assoc()) {
  $months[$row['sale_month']] = date("F", mktime(0, 0, 0, $row['sale_month'], 1));
  $this_year_sales[$row['sale_month']] = $row['total_sales'];
}


while ($row = $result_last_year->fetch_assoc()) {
  $months[$row['sale_month']] = date("F", mktime(0, 0, 0, $row['sale_month'], 1));
  $last_year_sales[$row['sale_month']] = $row['total_sales'];
}


ksort($months);

$final_months = array_values($months);
$final_this_year = [];
$final_last_year = [];

foreach ($months as $month_number => $month_name) {
  $final_this_year[] = isset($this_year_sales[$month_number]) ? $this_year_sales[$month_number] : 0;
  $final_last_year[] = isset($last_year_sales[$month_number]) ? $last_year_sales[$month_number] : 0;
}


