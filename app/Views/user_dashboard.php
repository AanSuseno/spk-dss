<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Note</h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <p>
                    To avoid errors, please follow the steps carefully.
                    If there is an issue in the previous step, you can delete the project and create it again.
                    This application is still in development, and you can contribute on <a href="https://github.com/AanSuseno/spk-dss" target="_blank">GitHub</a> to improve it.
                </p>
            <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- ./card -->
        </div>
        <!-- /.col -->
    </div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
</script>
<?= $this->endSection() ?>