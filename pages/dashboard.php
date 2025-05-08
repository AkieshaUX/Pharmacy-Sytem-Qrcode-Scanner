<?php include '../inc/session.php' ?>
<?php include '../inc/queries.php' ?>
<!DOCTYPE html>
<html lang="en">

<?php include '../includes/link.php' ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">


    <?php include '../includes/sidebar.php' ?>


    <div class="content-wrapper">

      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div>
      </div>



      <section class="content">
        <div class="container-fluid">

          <div class="row">


            <div class="col-md-4">

              <?php
              $sql = "SELECT SUM(soldprice) AS total_sales FROM sold  WHERE MONTH(datetime) = MONTH(CURRENT_DATE)  AND YEAR(datetime) = YEAR(CURRENT_DATE)";

              $result = mysqli_query($conn, $sql);
              $row = mysqli_fetch_assoc($result);
              $totalSales = $row['total_sales'] ? $row['total_sales'] : 0;

              $totalSalesFormatted = number_format($totalSales, 2);
              ?>

              <div class="small-box bg-success">
                <div class="inner">
                  <h3>₱ <?php echo $totalSalesFormatted; ?></h3>
                  <p>SALES FOR THIS MONTH</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="reports.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>


            </div>

            <?php
            $sql = "SELECT SUM(soldprice) AS total_sales FROM sold WHERE MONTH(datetime) = MONTH(CURRENT_DATE) - 1 AND YEAR(datetime) = YEAR(CURRENT_DATE)";

            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalSales = $row['total_sales'] ? $row['total_sales'] : 0;

            $totalSalesFormatted = number_format($totalSales, 2);
            ?>

            <div class="col-md-4">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>₱ <?php echo $totalSalesFormatted; ?></h3>
                  <p>SALES FOR LAST MONTH</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="reports.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>




            <?php
            $sql = "SELECT SUM(soldprice) AS total_sales FROM sold WHERE YEAR(datetime) = YEAR(CURRENT_DATE) - 1";

            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalSales = $row['total_sales'] ? $row['total_sales'] : 0;

            $totalSalesFormatted = number_format($totalSales, 2);
            ?>

            <div class="col-md-4">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>₱ <?php echo $totalSalesFormatted; ?></h3>
                  <p>SALES FOR LAST YEAR</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="reports.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>





          </div>

          <div class="row">
            <div class="col-md-6">
              <?php include '../inc/chartsales.php' ?>
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Sales Chart</h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card card-success">
                <div class="card-header border-0">
                  <h3 class="card-title">Today Sales</h3>
                </div>
                <div class="card-body table-responsive p-0" style="height: 287px;">
                  <table class="table table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        <!-- <th>Medicine Code</th> -->
                        <th>Medicine Name</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displaydashboardsales = displaydashboardsales($conn);
                      while ($result = mysqli_fetch_array($displaydashboardsales)) {
                        extract($result);

                        // Calculate total pads and pcs
                        if ($medtablets > 0) {
                          // Total pads (whole pads)
                          $totalPads = floor($soldquantity / $medtablets); // Full pads
                          // Remaining pcs (pieces that don't complete a full pad)
                          $remainingPcs = $soldquantity % $medtablets; // Remaining pieces

                          // Prepare display of quantity
                          if ($totalPads > 0 && $remainingPcs > 0) {
                            $quantityDisplay = $totalPads . ' pad(s) and ' . $remainingPcs . ' pcs';
                          } elseif ($totalPads > 0) {
                            $quantityDisplay = $totalPads . ' pad(s)';
                          } else {
                            $quantityDisplay = $remainingPcs . ' pcs';
                          }
                        } else {
                          $quantityDisplay = $soldquantity . ' pcs'; // If medtablets is zero or missing
                        }
                      ?>
                        <tr>
                          <!-- <td><?php echo $medcode ?></td> -->
                          <td><?php echo $medname ?></td>
                          <td><?php echo $quantityDisplay ?></td>
                          <td><?php echo number_format($soldprice, 2) ?></td>
                          <td><?php echo date('M d, Y h:i A', strtotime($datetime)) ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header border-0">
                <h3 class="card-title">List Of Medicines</h3>
              </div>
              <div class="card-body table-responsive p-0" style="height: 287px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Medicine Code</th>
                      <th>Medicine Name</th>
                      <th>Price/Pad</th>
                      <th>Number of tablets</th>
                      <th>Price/Each</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $displayRegisterMeds = displayRegisterMeds($conn);
                    while ($result = mysqli_fetch_array($displayRegisterMeds)) {
                      extract($result);
                    ?>

                      <tr>
                        <td><?php echo $medcode; ?></td>
                        <td><?php echo $medname; ?></td>
                        <td><?php echo $medprice; ?></td>
                        <td><?php echo $medtablets; ?></td>
                        <td><?php echo $medpriceeach; ?></td>

                      </tr>

                    <?php } ?>
                  </tbody>

                </table>
              </div>
            </div>
          </div>


          <div class="col-md-6">
            <div class="card card-success">
              <div class="card-header border-0">
                <h3 class="card-title">List of Low Stocks</h3>
              </div>
              <div class="card-body table-responsive p-0" style="height: 287px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Medicine Code</th>
                      <th>Medicine Name</th>
                      <th>Stock Quantity</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $displayStock = displayStock($conn);
                    while ($result = mysqli_fetch_array($displayStock)) {
                      extract($result);

                      $totalQuantity = intval($total_quantity);
                      $maxStock = 100;

                      if ($totalQuantity === 0) {
                        $statusClass = "danger";
                        $statusText = "Insufficient";
                      } else {
                        $percentage = ($totalQuantity / $maxStock) * 100;

                        if ($percentage > 75) {
                          $statusClass = "success";
                          $statusText = "Sufficient";
                        } elseif ($percentage > 50) {
                          $statusClass = "warning";
                          $statusText = "Moderate";
                        } else {
                          $statusClass = "danger";
                          $statusText = "Low";
                        }
                      }

                      if ($statusClass === 'warning' || $statusClass === 'danger') {
                    ?>
                        <tr>
                          <td><?php echo $medcode; ?></td>
                          <td><?php echo $medname; ?></td>
                          <td><?php echo $total_quantity; ?></td>
                          <td class="project-actions">
                            <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                          </td>
                        </tr>
                    <?php
                      }
                    }
                    ?>
                  </tbody>

                </table>
              </div>
            </div>
          </div>


        </div>



    </div>
    </section>

  </div>

  <?php include '../includes/footer.php' ?>


  <aside class="control-sidebar control-sidebar-dark">

  </aside>

  </div>
  <?php include '../includes/script.php' ?>

  <script>
    var salesMonths = <?php echo json_encode($final_months); ?>;
    var thisYearSales = <?php echo json_encode($final_this_year); ?>;
    var lastYearSales = <?php echo json_encode($final_last_year); ?>;
  </script>

  <script>
    var barChartCanvas = document.getElementById('barChart').getContext('2d');

    // Data structure for Bar Chart
    var barChartData = {
      labels: salesMonths, // Months from PHP
      datasets: [{
          label: 'This year',
          backgroundColor: '#28a745',
          borderColor: '#28a745',
          data: thisYearSales // Sales data for this year
        },
        {
          label: 'Last year',
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: lastYearSales // Sales data for last year
        }
      ]
    };

    // Bar Chart Options
    var barChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false
    };

    // Create the Bar Chart
    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    });
  </script>
</body>

</html>