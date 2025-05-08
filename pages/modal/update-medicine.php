<form id="updatemedicinesForm" method="POST">
  <div class=" modal fade" id="modal-updatemedicines">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Medicine</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Medicine Code</label>
            <input type="hidden" name="medregisterid" id="medregisterid">
            <input type="text" class="form-control" name="medcode" id="medcodes" required autofocus readonly>
          </div>
          <div class="form-group">
            <label>Medicine Name</label>
            <input type="text" class="form-control" name="medname" id="medname" required style="text-transform: uppercase;">
          </div>
          <div class="form-group">
            <label>Medicine Price</label>
            <input type="number" class="form-control" name="medprice" id="medprice" required style="text-transform: uppercase;">
          </div>
          <div class="form-group">
            <label>Number of Tablets</label>
            <input type="number" class="form-control" name="medtablets" id="medtablets" required  style="text-transform: uppercase;">
          </div>
          <div class="form-group">
            <label>Medicine Price/Each</label>
            <input type="number" class="form-control" name="medpriceeach" id="medpriceeach" required readonly style="text-transform: uppercase;">
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info text-white">Submit Update</button>
        </div>
      </div>
    </div>
  </div>
</form>