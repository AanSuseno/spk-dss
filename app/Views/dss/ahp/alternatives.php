<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Alternatives</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/criteria_weight") ?>">Step 2 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("ahp/$id_project/alternatives") ?>">Step 3 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/sub_criteria_weight") ?>">Step 4 <i class="fa fa-arrow-right"></i></a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="d-flex justify-content-end my-2">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreateAlternative"><i class="fa fa-plus"></i> Add Alternatives</button>
                        </div>

                    </div>
                    <!-- /.tab-pane -->
                </div>
            <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- ./card -->
    </div>
    <!-- /.col -->
</div>

<!-- modal create -->
<div class="modal fade" id="modalCreateAlternative">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Alternative</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ahp/' . $id_project . '/alternative/create') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="projectName">Alternative Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="name" id="projectName" placeholder="Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ! modal create -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
</script>
<?= $this->endSection() ?>