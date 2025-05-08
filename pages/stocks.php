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
            <div class="col-md-12">
              <div class="card card-success card-outline">
                <div class="card-header">
                  <div class="row align-items-center">
                    <div class="col-md-6">
                      <div class="card-title float-left">
                        <h3 class="card-title">List Of Stocks</h3>
                      </div>
                    </div>
                    <div class="col-md-6">

                      <button type="button" class="btn btn-success  float-right mr-3" data-toggle="modal" data-target="#modal-addstccks">
                        <i class="fa-solid fa-plus"></i>
                        Add Stocks
                      </button>

                    </div>
                  </div>
                </div>
                <div class="card-body">

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Medicine Code</th>
                        <th>Medicine Name</th>
                        <th>Stock Qty /Pad</th>
                        <th>Tablets</th>
                        <th>Status</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      $displayStock = displayStock($conn);
                      while ($result = mysqli_fetch_array($displayStock)) {
                        extract($result);

                        // Calculate total pads and the odd quantity
                        $totalstocks = $total_quantity / $medtablets;
                        $totalPads = floor($totalstocks); // Integer division for pads
                        $oddQuantity = $total_quantity % $medtablets; // Remaining tablets

                        $maxStock = 100;

                        // Determine status based on the total number of pads
                        if ($totalPads === 0) {
                          $statusClass = "danger";
                          $statusText = "Insufficient";
                        } else {
                          $percentage = ($totalPads / $maxStock) * 100;

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
                      ?>

                        <tr>
                          <td><?php echo $medcode; ?></td>
                          <td><?php echo $medname; ?></td>
                          <td><?php echo $totalPads . " pad(s)"; ?></td>
                          <td><?php echo $oddQuantity . " pcs"; ?></td>
                          <td>
                            <span class="badge bg-<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                          </td>
                        </tr>

                      <?php } ?>
                    </tbody>
                  </table>



                </div>

              </div>
            </div>
          </div>

        </div>
      </section>
      <?php include 'modal/add-stocks.php' ?>

    </div>

    <?php include '../includes/footer.php' ?>


    <aside class="control-sidebar control-sidebar-dark">

    </aside>

  </div>
  <?php include '../includes/script.php' ?>
  <script>
    $(document).ready(function() {
      let scannedCode = '';
      let barcodeTimeout;
      let isFetchingData = false;

      // Handle scanning of the barcode
      $(document).on('keydown', function(e) {
        if (e.key.length === 1 || e.key === 'Enter') {
          if (barcodeTimeout) clearTimeout(barcodeTimeout);

          if (e.key !== 'Enter') {
            scannedCode += e.key;
          }
          if (e.key === 'Enter') {
            e.preventDefault();
            if (!isFetchingData) {
              isFetchingData = true;
              $('#medcodefetch').val(scannedCode);
              fetchMedicineData(scannedCode);

              scannedCode = '';
            }
          }
          barcodeTimeout = setTimeout(() => {
            scannedCode = '';
            isFetchingData = false;
          }, 300);
        }
      });

      function fetchMedicineData(medcode) {
        if (medcode.length > 0) {
          $.ajax({
            url: '../inc/fetch.php',
            method: 'POST',
            data: {
              medcode: medcode
            },
            dataType: 'json',
            success: function(response) {
              console.log(response);

              if (response.success) {
                $('#mednamefetch').val(response.medname);
                $('#medcodefetch').val(response.medcode);
                $('#medregisteridfetch').val(response.medregisterid);
              } else {
                $('#mednamefetch').val('');
                $('#medcodefetch').val('');
                $('#medregisterid').val('');

                // SweetAlert notification
                Swal.fire({
                  icon: 'error',
                  title: 'Not Found',
                  text: 'Medicine not found!'
                });
              }

              isFetchingData = false;
            },
            error: function(xhr, status, error) {
              console.error('Error fetching data from server:', error);

              // SweetAlert for server error
              Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Error fetching data from the server!'
              });

              isFetchingData = false;
            }
          });
        }
      }


    });
  </script>

</body>

</html>