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
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/sub_criteria") ?>">Step 3 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/sub_criteria_weight") ?>">Step 4 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("ahp/$id_project/alternatives") ?>">Step 5 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/result") ?>">Step 6</i></a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="d-flex justify-content-end my-2">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreateAlternative"><i class="fa fa-plus"></i> Add Alternatives</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alternatives as $key => $a) { ?>
                                        <tr>
                                            <td><?= $key +1 ?></td>
                                            <td><?= $a['name'] ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" onclick="editAlternative(<?= $a['id'] ?>, '<?= $a['name'] ?>')">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDeleteAlternative" onclick="deleteAlternative(<?= $a['id'] ?>)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Alternative</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ahp/' . $id_project . '/alternatives/create') ?>" method="post">
                <div class="modal-body" style="overflow-y: auto; max-height: 60vh">
                    <div class="form-group">
                        <label for="projectName">Alternative Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="name" id="projectName" placeholder="Name">
                    </div>

                    <?php foreach ($criteria as $key => $c) { ?>
                        <hr>
                        <label for=""><?= $c['name'] ?></label>
                        <?php foreach ($sub_criteria[$c['id']] as $key_sc => $sc) { ?>
                            <div class="form-check">
                                <input class="form-check-input" required="required" type="radio" value="<?= $sc['id'] ?>" name="crit_<?= $c['id'] ?>" id="crit_<?= $sc['id'] ?>">
                                <label class="form-check-label" for="crit_<?= $sc['id'] ?>">
                                    <?= $sc['name'] ?>
                                </label>
                            </div>
                        <?php } ?>
                    <?php } ?>

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

<!-- modal edit -->
<div class="modal fade" id="modalEditAlternative">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Alternative</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form-update" method="post">
                <div class="modal-body" style="overflow-y: auto; max-height: 60vh">
                    <div class="form-group">
                        <label for="projectName">Alternative Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="name" id="alternative-name" placeholder="Name">
                    </div>

                    <?php foreach ($criteria as $key => $c) { ?>
                        <hr>
                        <label for=""><?= $c['name'] ?></label>
                        <?php foreach ($sub_criteria[$c['id']] as $key_sc => $sc) { ?>
                            <div class="form-check">
                                <input class="form-check-input" required="required" type="radio" value="<?= $sc['id'] ?>" name="crit_<?= $c['id'] ?>" id="crit_edit_<?= $sc['id'] ?>">
                                <label class="form-check-label" for="crit_edit_<?= $sc['id'] ?>">
                                    <?= $sc['name'] ?>
                                </label>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ! modal edit -->

<!-- modal delete -->
<div class="modal fade" id="modalDeleteAlternative">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Alternative</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form-delete" method="post">
                <div class="modal-body">
                    <p>Are you sure you want to permanently delete this alternative?</p>
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
    function deleteAlternative(id) {
        $('#form-delete').attr('action', '<?= base_url("ahp/$id_project/alternatives/delete/") ?>'+id)
    }

    function editAlternative(id, name) {
        $('#modalEditAlternative').modal('show')
        $('#alternative-name').val(name)
        $('#form-update').attr('action', '<?= base_url('ahp/' . $id_project . '/alternatives/update') ?>/'+id)
        
        $.ajax({
            url: '<?= base_url("ahp/$id_project/alternatives/sub_c/") ?>'+id, // Specify the URL of the API or JSON file
            type: 'GET', // Use the GET method
            dataType: 'json', // Expect JSON data
            success: function(data) {
                Object.keys(data.alternative_sub_criteria).forEach((i) => {
                    $('#crit_edit_'+data.alternative_sub_criteria[i]).prop('checked', true)
                })
            },
            error: function(error) {
                // Handle errors
                console.error('Error:' + error);
            }
        });
    }
</script>
<?= $this->endSection() ?>