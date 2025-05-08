

<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'pharma');
$conn->set_charset("utf8");
extract($_POST);
extract($_GET);
extract($_SESSION);


if (isset($_POST['medcode'])) {
  $medcode = $_POST['medcode']; 
  $query = "SELECT * FROM `medregister` WHERE `medcode` = '$medcode' AND `status` = 1";
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
 
    ]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Medicine not found']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>

