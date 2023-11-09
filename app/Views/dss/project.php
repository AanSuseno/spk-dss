<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="card card-default">
    <div class="card-header">
    <h3 class="card-title">
        <i class="fas fa-folder"></i>
        Projects DSS <?= $title ?>
    </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <!-- box btn create project -->
        <div class="d-flex justify-content-end my-2">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreateProject">
                <i class="fa fa-plus"></i> Create Project
            </button>
        </div>
        <!-- ! box btn create project -->
        <a  href="<?= base_url($dss.'/detail/id') ?>">
            <div class="callout callout-success">
                <h5 class="d-flex justify-content-between">
                    <span>Project name</span>
                    <button class="btn btn-secondary btn-sm rounded">
                        <i class="fa fa-archive" title="archive project"></i>
                    </button>
                </h5>
            </div>
        </a>
    </div>
    <!-- /.card-body -->
</div>

<div class="modal fade" id="modalCreateProject">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="projectName">Project Name</label>
            <input type="text" class="form-control" id="projectName" placeholder="Name">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Create</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>