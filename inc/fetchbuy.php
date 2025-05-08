<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'pharma');
$conn->set_charset("utf8");
extract($_POST);
extract($_GET);
extract($_SESSION);

if (isset($_POST['medcode'])) {
  $medcode = $_POST['medcode']; 
  
  // Modified query with JOIN between medregister and sold tables, filtering by status = 1
  $query = "
    SELECT mr.*, s.*
    FROM `medregister` mr
    LEFT JOIN `sold` s ON mr.medregisterid = s.medregisterid
    WHERE mr.medcode = '$medcode' AND mr.status = 1 AND s.status = 0
  ";

  $result = mysqli_query($conn, $query);

  if ($result === false) {
    echo json_encode(['success' => false, 'message' => 'Error executing query']);
    exit();
  }

  if (mysqli_num_rows($result) > 0) {
    $med = mysqli_fetch_assoc($result);
    echo json_encode([
      'success' => true,
      'medcode' => $med['medcode'],
      'medname' => $med['medname'],
      'medregisterid' => $med['medregisterid'],
      // Add any other necessary fields from the medregister and sold tables
    ]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Medicine not found or not active']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
