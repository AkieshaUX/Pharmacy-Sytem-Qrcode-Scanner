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



      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-success card-outline">
                <div class="card-header">
                  <div class="row align-items-center">
                    <div class="col-md-6">
                      <div class="card-title float-left">
                        <h3 class="card-title">List Of Medicines</h3>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <button type="button" class="btn btn-success  float-right" data-toggle="modal" data-target="#modal-addmedicines">
                        <i class="fa-solid fa-plus"></i>
                        Add Medicine
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
                        <th>Medicine Price/Pad</th>
                        <th>Number of tablets</th>
                        <th>Medicine Price/Each</th>
                        <th></th>
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
                          <td class="project-actions">
                            <button class="btn btn-info btn-sm updatemeds" id="updatemeds" data-medicine-id="<?php echo $medregisterid ?>" data-toggle="modal" data-target="#modal-updatemedicines">
                              <i class="fas fa-pencil-alt"></i> Edit
                            </button>

                            <button class="btn btn-danger btn-sm removemeds" id="removemeds" data-medicine-id="<?php echo $medregisterid ?>">
                              <i class="fa-solid fa-trash"></i> Delete
                            </button>
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
      <?php include 'modal/add-medicine.php' ?>
      <?php include 'modal/update-medicine.php' ?>

    </div>

    <?php include '../includes/footer.php' ?>


    <aside class="control-sidebar control-sidebar-dark">

    </aside>

  </div>
  <?php include '../includes/script.php' ?>
  <script>
  $(document).ready(function() {
    // Function to calculate price per tablet for the first set of inputs (medpricecalc, medtabletscalc)
    $('#medpricecalc, #medtabletscalc').on('input', function() {
      var medpricecalc = parseFloat($('#medpricecalc').val());
      var medtabletscalc = parseFloat($('#medtabletscalc').val());
      
      if (!isNaN(medpricecalc) && !isNaN(medtabletscalc) && medtabletscalc != 0) {
        var priceEachcalc = medpricecalc / medtabletscalc;
        $('#medpriceeachcalc').val(priceEachcalc.toFixed(2)); // Display result with 2 decimal places
      } else {
        $('#medpriceeachcalc').val(''); // Clear field if inputs are invalid
      }
    });

    // Function to calculate price per tablet for the second set of inputs (medprice, medtablets)
    $('#medprice, #medtablets').on('input', function() {
      var medprice = parseFloat($('#medprice').val());
      var medtablets = parseFloat($('#medtablets').val());

      if (!isNaN(medprice) && !isNaN(medtablets) && medtablets != 0) {
        var priceEach = medprice / medtablets;
        $('#medpriceeach').val(priceEach.toFixed(2)); // Display result with 2 decimal places
      } else {
        $('#medpriceeach').val(''); // Clear field if inputs are invalid
      }
    });
  });
</script>





</body>

</html>