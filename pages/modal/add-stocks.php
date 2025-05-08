<form id="addstocksForm">
  <div class="modal fade" id="modal-addstccks">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Stocks</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Medicine Code</label>
            <input type="hidden" id="medregisteridfetch" name="medregisteridfetch">
            <input type="text" class="form-control" name="medcode" id="medcodefetch" autofocus readonly>
          </div>
          <div class="form-group">
            <label>Medicine Name</label>
            <input type="text" class="form-control" name="medname" readonly id="mednamefetch" style="text-transform: uppercase;">
          </div>

          <div class="form-group">
            <label>Quantity/Pad</label>
            <input type="number" class="form-control" name="squantity" required style="text-transform: uppercase;">
          </div>

          <div class="form-group">
            <label>Expiration Date</label>
            <input type="date" class="form-control" name="exdate"  required style="text-transform: uppercase;">
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" name="addstocksForm" class="btn btn-info">Submit Changes</button>
        </div>
      </div>
    </div>
  </div>
</form>