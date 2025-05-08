<?php
$conn = new mysqli('localhost', 'root', '', 'pharma');
$conn->set_charset("utf8");

function updateStatusIfDateMatches($conn)
{
  $currentDate = date('Y-m-d');
  

  $updateQuery = "UPDATE `stock` SET `status` = 1 WHERE DATE(`exdate`) = '$currentDate' AND `status` != 1";


  if (mysqli_query($conn, $updateQuery)) {
    $affectedRows = mysqli_affected_rows($conn); 
    return $affectedRows > 0;
  } else {
    error_log("Error updating data: " . mysqli_error($conn)); 
    return false;
  }
}

$statusUpdated = updateStatusIfDateMatches($conn);
mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['statusUpdated' => $statusUpdated]);
