<div class="modal fade" id="modal-viewinvoice">
  <div class="modal-dialog piedad" style="max-width: 365px  !important;">
    <form id="confirmationreference">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Order Receipt</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="invoiceContent">

          <div class="invoice p-3 mb-3">
            <!-- Header Section -->
            <?php
            $now = date("Y-m-d");
            ?>
            <style>
              .table-striped tbody tr:nth-of-type(odd) {
                background-color: unset !important;
              }
            </style>
            <div class="row" style="border-bottom: 2px dashed #000;">
              <div class="col-12 text-center">
                <i class="fa-solid fa-house-medical" style="font-size: 40px; color: red;"></i>
                <h5 style="font-weight: bold;font-family: cursive;">SecurePharma</h5>
                <p class="addressnme" style=" font-family: cursive;">Anytime, Anywhere Dinagat Inslands</span></p>
              </div>
            </div>

            <!-- Invoice Details -->
            <div class="row mt-0 mb-0" style="padding: 10px 0;border-bottom: 2px dashed #000;">
              <div class="col-12">
                <strong>
                  <p style="margin: 0;">Tel: <span>0909123456</span></p>
                  <p style="margin: 0;">Email: <span>Anytime@gmail.com</span></p>
                  <p style="margin: 0;">Date: <span><?php echo $now ?></span></p>
                </strong>
              </div>
            </div>



            <!-- Table Section with Product Details -->
            <div class="row border-bottom mb-3" style="border-bottom: 2px dashed #000 !important;">
              <table class="table table-striped">

                <thead>
                  <tr>

                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
            
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
                   
                          <td><?php echo $medname ?></td>
                          <td><?php echo $totalPads ?> pad(s)</td>
                          <td>₱ <?php echo number_format($medprice, 2) ?> / pad</td>
       
                        </tr>
                      <?php
                      }

                      // Display pcs row if applicable
                      if ($oddQuantity > 0) {
                        $grandTotal += $pcsTotalPrice;
                      ?>
                        <tr>
                   
                          <td><?php echo $medname ?></td>
                          <td><?php echo $oddQuantity ?> pcs</td>
                          <td>₱ <?php echo number_format($average_price_per_unit, 2) ?> / pcs</td>
                    
                        </tr>
                  <?php
                      }
                    } else {
                      // Log or display a warning for zero medtablets

                    }
                  }
                  ?>
                </tbody>




              </table>
            </div>

            <!-- Amount Section Below the Table -->
            <div class="row mb-3">
              <div class="col-12 text-left" style="font-size: 20px;">
                <p><strong>Total Amount:</strong> <span id="totalincome">₱ <?php echo number_format($grandTotal, 2) ?></span></p>
              </div>
            </div>

            <!-- Footer Message -->
            <div class="row mt-4">
              <div class="col-12 text-center">
                <p>Thank you! We appreciate your trust in us and look forward to serving you again. <br><i class="fa-solid fa-face-smile" style="color: #1eba9e;"></i></p>
              </div>
            </div>
          </div>
        </div>


        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-default" onclick="printInvoice()">
            <i class="fas fa-print"></i> Print
          </button>
        </div>
      </div>
    </form>
  </div>
</div>