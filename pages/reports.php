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
          <!-- <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
              </ol>
            </div>
          </div> -->
        </div>
      </div>



      <section class="content" id="reloadpages">
        <div class="container-fluid">
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
              <?php include '../inc/chartproduct.php' ?>
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Medicine Chart</h3>
                </div>
                <div class="card-body">
                  <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-success card-outline">
                <div class="card-header">
                  <div class="row align-items-center">
                    <div class="col-md-6">
                      <div class="card-title float-left">
                        <h2 class="card-title">List Of Sold Medicines</h2>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card-title float-right">
                        <form method="GET" action="" style="display: flex; gap: 15px;">
                          <input name="datetime" type="month" id="datetime" class="form-control" value="<?php echo isset($_GET['datetime']) ? $_GET['datetime'] : ''; ?>">
                          <div class="btn-wrap d-flex">
                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                            <button type="button" id="resetFilter" class="btn btn-danger">Reset</button>
                          </div>
                        </form>

                      </div>
                    </div>

                  </div>
                </div>
                <div class="card-body">

                  <?php

                  $datetime = isset($_GET['datetime']) ? $_GET['datetime'] : '';

                  $displaySales = displaySales($conn, $datetime);
                  ?>

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Medicine Code</th>
                        <th>Medicine Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $total_soldprice_sum = 0;
                      while ($result = mysqli_fetch_array($displaySales)) {
                        extract($result);
                        $total_soldprice_sum += $total_price;

                        // Calculate pads and pcs based on total_sold_quantity and medtablets
                        if ($medtablets > 0) {
                          // Total pads (whole pads)
                          $totalPads = floor($total_sold_quantity / $medtablets); // Full pads
                          // Remaining pcs (pieces that don't complete a full pad)
                          $remainingPcs = $total_sold_quantity % $medtablets; // Remaining pieces

                          // Prepare display of quantity
                          if ($totalPads > 0 && $remainingPcs > 0) {
                            $quantityDisplay = $totalPads . ' pad(s) and ' . $remainingPcs . ' pcs';
                          } elseif ($totalPads > 0) {
                            $quantityDisplay = $totalPads . ' pad(s)';
                          } else {
                            $quantityDisplay = $remainingPcs . ' pcs';
                          }
                        } else {
                          $quantityDisplay = number_format($total_sold_quantity) . ' pcs'; // If medtablets is zero or missing
                        }
                      ?>
                        <tr>
                          <td><?php echo $medcode ?></td>
                          <td><?php echo $medname ?></td>
                          <td><?php echo $quantityDisplay ?></td>
                          <td>₱ <?php echo number_format($total_price, 2) ?></td>
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

  <script>
    var productIds = <?php echo json_encode($products); ?>;
    var totalSoldQuantities = <?php echo json_encode($total_sold_quantities); ?>;
    var productNames = <?php echo json_encode($product_names); ?>;
  </script>

  <script>
    document.getElementById('resetFilter').addEventListener('click', function() {
      // Clear the month input and reload the page
      document.getElementById('datetime').value = '';
      window.location.href = window.location.pathname;
    });
  </script>














  <?php
  // Get the selected datetime filter (month)
  $datetime = isset($_GET['datetime']) ? $_GET['datetime'] : '';

  // Fetch sales data based on the filter
  $displaySales = displaySales($conn, $datetime);
  $salesData = [];

  while ($result = mysqli_fetch_assoc($displaySales)) {
    $salesData[] = [
      'medname' => $result['medname'],
      'total_sold_quantity' => $result['total_sold_quantity']
    ];
  }
  ?>

  <script>
    // Pass PHP data to JavaScript
    var salesData = <?php echo json_encode($salesData); ?>;

    // Process the sales data for the pie chart
    var productNames = salesData.map(function(item) {
      return item.medname;
    });
    var productQuantities = salesData.map(function(item) {
      return item.total_sold_quantity;
    });

    // Define a fixed set of colors for each product (you can extend this array)
    var fixedColors = ['#FF5733', '#33FF57', '#3357FF', '#F9A825', '#8E24AA', '#0288D1', '#C2185B', '#7B1FA2'];

    // Assign colors to each product slice (if there are more products than colors, it will reuse colors)
    var colors = productNames.map(function(_, index) {
      return fixedColors[index % fixedColors.length]; // Loop through the colors if there are more products than colors
    });

    // Create dataset for the pie chart
    var pieData = {
      labels: productNames,
      datasets: [{
        data: productQuantities,
        backgroundColor: colors // Use the fixed color scheme
      }]
    };

    // Options for the pie chart
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true
    };

    // Initialize the pie chart
    var pieChartCanvas = document.getElementById('pieChart').getContext('2d');
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    });
  </script>





</body>

</html>