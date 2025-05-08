<form id="addmedicinesForm" method="POST">
  <div class="modal fade" id="modal-addmedicines">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Medicine</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Medicine Code</label>
            <input type="text" class="form-control" name="medcode" id="medcode" autofocus readonly required>
          </div>
          <div class="form-group">
            <label>Medicine Name</label>
            <input type="text" class="form-control" name="medname" required style="text-transform: uppercase;">
          </div>
          <div class="form-group">
            <label>Medicine Price/Pad</label>
            <input type="number" class="form-control" name="medprice" id="medpricecalc" required style="text-transform: uppercase;">
          </div>
          <div class="form-group">
            <label>Number of Tablets</label>
            <input type="number" class="form-control" name="medtablets" id="medtabletscalc" required style="text-transform: uppercase;">
          </div>
          <div class="form-group">
            <label>Medicine Price/Each</label>
            <input type="number" class="form-control" name="medpriceeach" id="medpriceeachcalc" required readonly style="text-transform: uppercase;">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Submit Register</button>
        </div>
      </div>
    </div>
  </div>
</form>