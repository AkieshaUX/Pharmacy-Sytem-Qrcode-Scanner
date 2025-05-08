<script type="text/javascript" src="../../dist/js/jquery.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../plugins/raphael/raphael.min.js"></script>
<script src="../plugins/chart.js/Chart.min.js"></script>
<script src="../plugins/sparklines/sparkline.js"></script>
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../plugins/summernote/summernote-bs4.min.js"></script>
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script src="../plugins/filterizr/jquery.filterizr.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<script src="../plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="../plugins/moment/moment.min.js"></script>
<script src="../plugins/daterangepicker/daterangepicker.js"></script>
<script src="../plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- <script src="../../dist/js/custom.js"></script> -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../plugins/select2/js/select2.full.min.js"></script>
<script src="../dist/js/sweetalert2.all.min.js"></script>
<script src="../dist/manific/jquery.magnific-popup.min.js"></script>
<script src="../inc/ajax.js"></script>



<script>
  $("#example1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "searching": true,
    "ordering": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  $(document).ready(function() {
    $("table tr").each(function(index) {
      $(this).delay(index * 100).queue(function(next) {
        $(this).addClass("fade-in");
        next();
      });
    });
  });

  $('.select2').select2()
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })


  setInterval(() => {
    fetch('../inc/check_expired.php')
      .then(response => response.json())
      .then(data => {
        if (data.statusUpdated) { 
          console.log('Status updated. Reloading section...');
          $('#reloadpages').load('stocks.php #reloadpages');
        } else {
          console.log('No status updates.');
        }
      })
      .catch(error => console.error('Error:', error));
  }, 60000); 
</script>