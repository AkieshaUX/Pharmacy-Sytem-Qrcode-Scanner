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
                        <h2 class="card-title ">List Of Expired Medicines</h2>
                      </div>
                    </div>
                    
                  </div>
                </div>
                <div class="card-body">

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Medicine Code</th>
                        <th>Medicine Name</th>
                        <th>Stock Quantity</th>
                        <th>Expired Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $displayExpiered = displayExpiered($conn);
                      while ($result = mysqli_fetch_array($displayExpiered)) {
                        extract($result);
                      ?>

                        <tr>
                          <td><?php echo $medcode; ?></td>
                          <td><?php echo $medname; ?></td>
                          <td><?php echo $total_quantity; ?></td>
                          <td><span class="badge bg-danger"><?php echo date('M d, Y', strtotime($exdate)); ?></span></td>
                          <td>
                            <span class="badge bg-danger">Expired</span>
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


</body>

</html>