<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'pharma');
$conn->set_charset("utf8");
extract($_POST);
extract($_GET);
extract($_SESSION);
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['login'])) {
  $admin_user = $_POST['admin_user'];
  $admin_pass = $_POST['admin_pass'];
  $stmt = $conn->prepare("SELECT * FROM `admin` WHERE `admin_user` = ?");
  $stmt->bind_param("s", $admin_user);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    if ($admin_pass === $admin['admin_pass']) {
      $_SESSION['admin_id'] = $admin['admin_id'];
      $_SESSION['admin_user'] = $admin['admin_user'];
      header('Location: ../pages/dashboard.php');
      exit();
    } else {
      header('Location: ../index.php?invalid');
      exit();
    }
  } else {
    header('Location: ../index.php?invalid');
    exit();
  }
  $stmt->close();
}

if (isset($addmedicinesForm)) {
  $check_sql = "SELECT * FROM `medregister` WHERE `medcode` = '$medcode'  AND `status` = 1";
  $check_query = $conn->query($check_sql);

  if ($check_query->num_rows > 0) {
    echo json_encode([
      'exists' => true,
      'success' => false
    ]);
  } else {
    $insert_sql = "INSERT INTO `medregister`(`medname`, `medcode`,`medprice`,`medtablets`,`medpriceeach`, `status`) VALUES ('$medname','$medcode','$medprice','$medtablets','$medpriceeach',1)";
    $insert_query = $conn->query($insert_sql);

    if ($insert_query) {
      echo json_encode([
        'exists' => false,
        'success' => true
      ]);
    }
  }
  exit();
}

if (isset($_GET['updatemeds'])) {
  $medregisterid = $_GET['medregisterid'];
  $sql = "SELECT * FROM `medregister` WHERE `medregisterid` = '$medregisterid'";
  $result = $conn->query($sql);
  echo json_encode($result->fetch_assoc());
  exit();
}

if (isset($updatemedicinesForm)) {
  $sql = "UPDATE `medregister` SET `medname`='$medname',`medcode`='$medcode',`medprice` = '$medprice',`medtablets` = '$medtablets',`medpriceeach` = '$medpriceeach' WHERE `medregisterid` ='$medregisterid'";
  $query = $conn->query($sql);
  exit();
}


if (isset($_GET['removemeds'])) {
  $medregisterid = $_GET['medregisterid'];

  $sql = "UPDATE `medregister` SET `status` = 0 WHERE `medregisterid` = '$medregisterid'";
  $query = $conn->query($sql);
  exit();
}


if (isset($addstocksForm)) {
  $fetchmeds = "SELECT `medtablets` FROM `medregister` WHERE `medregisterid` = $medregisteridfetch";
  $result = $conn->query($fetchmeds);
  $row = $result->fetch_array();
  $tables = $row['medtablets'];
  $addstock = $squantity * $tables;

  $sql = "INSERT INTO `stock`(`medregisterid`, `squantity`, `rquantity`, `exdate`, `sdate`, `status`) VALUES ('$medregisteridfetch','$addstock','$addstock','$exdate',NOW(),0)";
  $query = $conn->query($sql);
  exit();
}













if (isset($_GET['acceptbuyall'])) {

  // Query to select all records with status = 0
  $querysold = "SELECT * FROM `sold` WHERE `status` = 0";
  $result = $conn->query($querysold);

  // Check if there are any records with status = 0
  if ($result->num_rows > 0) {
    // Update all records where status is 0 to 1
    $updatesold = "UPDATE `sold` SET `status` = 1 WHERE `status` = 0";
    if ($conn->query($updatesold)) {
      echo "All records have been updated successfully.";
    } else {
      echo "Error updating records: " . $conn->error;
    }
  } else {
    echo "No records found with status 0.";
  }
  exit();
}










if (isset($addtocartform)) {
  $padquantity = isset($padquantity) ? $padquantity : 0;
  $eachquantity = isset($eachquantity) ? $eachquantity : 0;

  // Fetch the current stock
  $sql1 = "SELECT SUM(rquantity) AS current_stocks FROM `stock` WHERE `medregisterid` = $medregisteridfetch AND `rquantity` != 0  AND `status` = 0";
  $result = $conn->query($sql1);
  $row = $result->fetch_array();
  $current_stocks = $row['current_stocks'];

  // Fetch medicine details
  $fetchmeds = "SELECT * FROM `medregister` WHERE `medregisterid` = $medregisteridfetch";
  $result = $conn->query($fetchmeds);
  $row = $result->fetch_array();

  $price_pad = $row['medprice'];
  $price_each = $row['medpriceeach'];
  $medtablets = $row['medtablets'];

  // Validate divisor for pads calculation
  if ($medtablets <= 0) {
      echo json_encode(["status" => "error", "message" => "Invalid medicine data: tablets per pad cannot be zero."]);
      exit();
  }

  $buypads = $padquantity * $medtablets;

  // Ensure requested quantity does not exceed available stock
  $total_requested = $buypads + $eachquantity;
  if ($total_requested > $current_stocks) {
      echo json_encode(["status" => "error", "message" => "Not enough available stock to complete the Withdraw process."]);
      exit();
  }

  // Process the stock withdrawal
  $soldquantity = 0;
  $soldprice = 0;

  $sql1 = "SELECT * FROM `stock` WHERE `medregisterid` = $medregisteridfetch AND `rquantity` != 0 ORDER BY `stockid` ASC";
  $result = $conn->query($sql1);

  while ($row = $result->fetch_array()) {
      $availstocks = $row['rquantity'];

      // Handle padquantity
      if ($buypads > 0) {
          if ($buypads <= $availstocks) {
              $soldquantity += $buypads;
              $soldprice += $price_pad * $padquantity;
              $totalquant = $availstocks - $buypads;
              $update = "UPDATE `stock` SET `rquantity` = '$totalquant' WHERE `stockid` = '$row[0]' AND `medregisterid` = $medregisteridfetch";
              $conn->query($update);
              $buypads = 0;
          } else {
              $soldquantity += $availstocks;
              $soldprice += $price_pad * floor($availstocks / $medtablets);
              $buypads -= $availstocks;
              $update = "UPDATE `stock` SET `rquantity` = 0 WHERE `stockid` = '$row[0]' AND `medregisterid` = $medregisteridfetch";
              $conn->query($update);
          }
      }

      // Handle eachquantity
      if ($eachquantity > 0) {
          if ($eachquantity <= $availstocks) {
              $soldquantity += $eachquantity;
              $soldprice += $price_each * $eachquantity;
              $totalquant = $availstocks - $eachquantity;
              $update = "UPDATE `stock` SET `rquantity` = '$totalquant' WHERE `stockid` = '$row[0]' AND `medregisterid` = $medregisteridfetch";
              $conn->query($update);
              $eachquantity = 0;
          } else {
              $soldquantity += $availstocks;
              $soldprice += $price_each * $availstocks;
              $eachquantity -= $availstocks;
              $update = "UPDATE `stock` SET `rquantity` = 0 WHERE `stockid` = '$row[0]' AND `medregisterid` = $medregisteridfetch";
              $conn->query($update);
          }
      }

      if ($buypads == 0 && $eachquantity == 0) {
          break;
      }
  }

  // Insert the sold record if successful
  $sql2 = "INSERT INTO `sold`(`medregisterid`, `soldquantity`, `soldprice`, `datetime`, `status`) 
           VALUES ('$medregisteridfetch', '$soldquantity', '$soldprice', NOW(), 0)";
  if ($conn->query($sql2)) {
      echo json_encode(["status" => "success", "message" => "Item added to cart."]);
  } else {
      echo json_encode(["status" => "error", "message" => "Error adding to cart."]);
  }

  exit();
}

