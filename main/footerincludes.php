<!-- Shoubham Templte -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<script src="main/dist/js/init-alpine.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script> -->
<!-- <script src="main/dist/js/charts-lines.js" defer></script> -->
<!-- <script src="main/dist/js/charts-pie.js" defer></script> -->
<style>
  .stickyframe {
    position: sticky;
    top: 0;
  }
</style>
<!-- jQuery -->
<script src="main/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="main/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="main/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="main/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="main/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="main/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="main/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="main/plugins/select2/js/select2.full.min.js"></script>

<!-- JQVMap -->
<script src="main/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="main/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

<!-- daterangepicker -->
<script src="main/plugins/moment/moment.min.js"></script>
<script src="main/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="main/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="main/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="main/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="main/dist/js/jquery-ui-timepicker-addon.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<!-- AdminLTE App -->
<script src="main/dist/js/adminlte.js"></script>
<script src="main/dist/js/customfunction.js?ver=<?php echo time(); ?>"></script>
<script src="main/dist/js/del.js?ver=<?php echo time(); ?>"></script>
<script src="main/dist/js/functions.js?ver=<?php echo date('His'); ?>"></script>
<script src="main/dist/js/view1.js?ver=<?php echo date('His'); ?>"></script>
<script src="main/dist/js/search.js"></script>
<script src="main/dist/js/jquery.bvalidator-yc.js"></script>
<!--<script src="main/dist/js/bs3form.min.js"></script>-->
<script src="main/dist/js/b3form.js"></script>
<div class="modal fade" id="customConfirmModal" tabindex="-1" role="dialog" aria-labelledby="customConfirmModalLabel" aria-hidden="true" style="z-index: 99;">
  <div class="modal-dialog modal-dialog-broswer" role="document">
    <div class="modal-content browser-model-content">
      <div class="modal-body">
        Are you sure you want to proceed?
      </div>
      <div class="modal-footer modal-footer-browser">
        <button type="button" class="btn btn-secondary browser-btn browser-btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary browser-btn browser-btn-primary" onclick="handleCustomConfirm(true)">Proceed</button>
      </div>
    </div>
  </div>
</div>
<?php
if (isset($extrajs)) {
  echo $extrajs;
} ?>
<script>
  <?php
  if (isset($onpagejs)) {
    echo $onpagejs;
  } ?>
</script>