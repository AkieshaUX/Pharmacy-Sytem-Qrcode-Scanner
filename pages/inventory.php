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



      <section class="content" id="reloadinvetory">
        <div class="container-fluid">
          <div class="row">

            <div class="col-md-4">
              <div class="card  card-success">
                <div class="card-header">
                  <h3 class="card-title">Scan Here</h3>
                </div>

                <form id="addtocartform">
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Medicine Code</label>
                      <input type="hidden" id="medregisteridfetch" name="medregisteridfetch">
                      <input type="text" class="form-control" name="medcode" required id="medcodefetch" autofocus readonly>
                    </div>
                    <div class="form-group">
                      <label>Medicine Name</label>
                      <input type="text" class="form-control" name="medname" required readonly id="mednamefetch" style="text-transform: uppercase;">
                    </div>

                    <div class="form-group">
                      <label>Quantity/Pad</label>
                      <input type="number" class="form-control" name="padquantity" id="squantity_pad" style="text-transform: uppercase;">
                    </div>
                    <div class="form-group">
                      <label>Quantity/Tablet</label>
                      <input type="number" class="form-control" name="eachquantity" id="squantity_tablet" style="text-transform: uppercase;">
                    </div>
                  </div>

                  <div class="card-footer">
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" class="btn btn-success float-right">Add to Cart</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title"></h3>
                  <div class="card-tools">

                  </div>
                </div>
                <div class="card-body table-responsive p-0">

                   <table class="table table-striped table-valign-middle">
                    <thead>
                      <tr>
                        <th>Medicine Code</th>
                        <th>Medicine Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displayaddcart = displayaddcart($conn);
                      $grandTotal = 0;

                      while ($result = mysqli_fetch_array($displayaddcart)) {
                        extract($result);

                        // Safeguard: Ensure $medtablets is not zero to prevent division by zero
                        if ($medtablets > 0) {
                          // Calculate total pads and odd pieces
                          $totalstocks = $total_soldquantity / $medtablets;
                          $totalPads = floor($totalstocks); // Full pads
                          $oddQuantity = $total_soldquantity % $medtablets; // Remaining pieces

                          $padTotalPrice = $totalPads * $medprice;
                          $pcsTotalPrice = $oddQuantity * $average_price_per_unit; // Total price for pcs

                          // Display pads row if applicable
                          if ($totalPads > 0) {
                            $grandTotal += $padTotalPrice;
                      ?>
                            <tr>
                              <td><?php echo $medcode ?></td>
                              <td><?php echo $medname ?></td>
                              <td><?php echo $totalPads ?> pad(s)</td>
                              <td>₱ <?php echo number_format($medprice, 2) ?> / pad</td>
                              <td>₱ <?php echo number_format($padTotalPrice, 2) ?></td>
                            </tr>
                          <?php
                          }

                          // Display pcs row if applicable
                          if ($oddQuantity > 0) {
                            $grandTotal += $pcsTotalPrice;
                          ?>
                            <tr>
                              <td><?php echo $medcode ?></td>
                              <td><?php echo $medname ?></td>
                              <td><?php echo $oddQuantity ?> pcs</td>
                              <td>₱ <?php echo number_format($average_price_per_unit, 2) ?> / pcs</td>
                              <td>₱ <?php echo number_format($pcsTotalPrice, 2) ?></td>
                            </tr>
                      <?php
                          }
                        } else {
                          // Log or display a warning for zero medtablets

                        }
                      }
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4"><strong>Grand Total</strong></td>
                        <td>₱ <?php echo number_format($grandTotal, 2) ?></td>
                      </tr>
                      <tr>
                        <td colspan="4"></td>
                        <td>
                          <button type="button" id="acceptbuyall" class="btn btn-success acceptbuyall">Buy/Print</button>
                        </td>
                      </tr>
                    </tfoot>
                    </table>









                </div>

                <?php include 'modal/reciept.php' ?>

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

    $('#addtocartform').on('submit', function(event) {
      var padQuantity = $('#squantity_pad').val();
      var tabletQuantity = $('#squantity_tablet').val();
      if (!padQuantity && !tabletQuantity) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Please fill in at least one quantity (By-Pad or By-Tablet).',
        });

        event.preventDefault();
      }
    });
  </script>
  <script>
    $(document).ready(function() {
      // When a value is entered in "By-Pad", disable "By-Tablet"
      $('#squantity_pad').on('input', function() {
        if ($(this).val()) {
          $('#squantity_tablet').prop('disabled', true); // Disable "By-Tablet"
        } else {
          $('#squantity_tablet').prop('disabled', false); // Enable "By-Tablet"
        }
      });

      // When a value is entered in "By-Tablet", disable "By-Pad"
      $('#squantity_tablet').on('input', function() {
        if ($(this).val()) {
          $('#squantity_pad').prop('disabled', true); // Disable "By-Pad"
        } else {
          $('#squantity_pad').prop('disabled', false); // Enable "By-Pad"
        }
      });



    });
  </script>









</body>

</html>