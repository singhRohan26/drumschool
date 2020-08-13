</div>
<!-- /#wrapper -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Logout?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Are you sure want to logout</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?php echo base_url('admin/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
    <?php if (!empty($editor)) { ?>
        <script src="<?php echo base_url('public/admin/ckeditor/ckeditor.js'); ?>" ></script>
        <script> CKEDITOR.replace('description');</script>
        <script> CKEDITOR.replace('accomodation');</script>
    <?php } ?>
    <script src="<?php echo base_url('public/admin/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/admin/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('public/admin/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
    <!-- Page level plugin JavaScript-->
    <script src="<?php echo base_url('public/admin/js/sweetalert.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/admin/vendor/chart.js/Chart.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/admin/vendor/datatables/jquery.dataTables.js'); ?>"></script>
    <script src="<?php echo base_url('public/admin/vendor/datatables/dataTables.bootstrap4.js'); ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url('public/admin/js/sb-admin.min.js'); ?>"></script>
    <!-- Demo scripts for this page-->
    <script src="<?php echo base_url('public/admin/js/demo/datatables-demo.js'); ?>"></script>
    <script src="<?php echo base_url('public/admin/js/demo/chart-area-demo.js'); ?>"></script>
    <script src="<?php echo base_url('public/admin/'); ?>js/event.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $('.select2').select2();
        $('.select3').select2();
        $('.select4').select2();
        $('.select5').select2();
    </script>
</body>
</html>
