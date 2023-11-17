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
        <!-- loop projects -->
        <?php foreach ($projects as $key => $p) : ?>
            <div class="callout callout-success">
                <h5 class="d-flex justify-content-between">
                    <a  href="<?= base_url($dss.'/detail/'.$p['id']) ?>">
                        <span class="text-dark"><?= $p['name'] ?></span>
                    </a>
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDeleteProject" onclick="deleteProjectModal(<?= $p['id'] ?>)">
                        <i class="fa fa-times" title="delete project"></i>
                    </button>
                </h5>
            </div>
        <?php endforeach ?>
        <!-- ! loop projects -->
    </div>
    <!-- /.card-body -->
</div>

<!-- modal create -->
<div class="modal fade" id="modalCreateProject">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('projects/create/'.$dss) ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="projectName">Project Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="name" id="projectName" placeholder="Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ! modal create -->

<!-- modal delete -->
<div class="modal fade" id="modalDeleteProject">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('projects/delete/ahp') ?>" id="form-delete" method="post">
                <div class="modal-body">
                    <p>Are you sure you want to permanently delete this project?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes, delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ! modal delete -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    function deleteProjectModal(id) {
        $('#form-delete').attr('action', '<?= base_url('projects/delete/ahp') ?>/'+id)
    }
</script>
<?= $this->endSection() ?>