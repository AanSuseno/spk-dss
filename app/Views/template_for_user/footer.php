  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>dist/js/adminlte.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/chart.js/Chart.min.js"></script>
<!-- DataTables  & Plugins -->
<!-- DataTables  & Plugins -->
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url("assets/AdminLTE-3.2.0/") ?>plugins/chart.js/Chart.min.js"></script>

<script>
  $(document).ready(() => {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    <?php if (session()->getFlashdata('msg') !== null) : ?>
      Toast.fire({
          icon: '<?= session()->getFlashdata('msg-type') ?>',
          title: '<?= session()->getFlashdata('msg') ?>',
      })
    <?php endif ?>
  })

  tippy('.tippy-me', {
      interactive: true,
      arrow: true,
      placement: 'top-start',
  });
</script>

<!-- script per page -->
<?= $this->renderSection('js') ?>
</body>
</html>