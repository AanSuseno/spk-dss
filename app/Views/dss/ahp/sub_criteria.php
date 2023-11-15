<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Sub Criteria</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/criteria_weight") ?>">Step 2 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("ahp/$id_project/sub_criteria") ?>">Step 3 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/sub_criteria_weight") ?>">Step 4 <i class="fa fa-arrow-right"></i></a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">

                        <select name="" id="select-criteria" onchange="changeCriteria()" class="form-control">
                            <?php foreach ($criteria as $key => $c) { ?>
                                <option value="tab_c<?= $c['id'] ?>"><?= $c['name'] ?></option>
                            <?php } ?>
                        </select>

                        <?php foreach ($criteria as $key => $c) { ?>
                            <div id="tab_c<?= $c['id'] ?>" class="tab_c" style="<?= ($key != 0) ? 'display: none' : '' ?>">
                                <h3 class="mt-3"><?= $c['name'] ?></h3>
                                <div class="d-flex justify-content-end my-2">
                                    <button
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#modalCreateSubCriteria"
                                    onclick="addSubCrit(<?= $c['id'] ?>, '<?= $c['name'] ?>')"
                                    >
                                    <i class="fa fa-plus"></i> Add <?= $c['name'] ?> Sub Criteria
                                    </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php foreach ($sub_criteria[$c['id']] as $key_sc => $sc) : ?>
                                            <tr>
                                                <td><?= $key_sc+1 ?></td>
                                                <td><?= $sc['name'] ?></td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDeleteSubCriteria" onclick="deleteSC(<?= $sc['id'] ?>)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>

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
<div class="modal fade" id="modalCreateSubCriteria">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Sub Criteria for <span id="criteria-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form-create" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="projectName">Sub Criteria Name</label>
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

<!-- modal delete -->
<div class="modal fade" id="modalDeleteSubCriteria">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Sub Criterion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form-delete" method="post">
                <div class="modal-body">
                    <p>Are you sure you want to permanently delete this sub criterion?</p>
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
    function addSubCrit(id, name) {
        $('#form-create').attr('action', '<?= base_url('ahp/' . $id_project . '/sub_criteria/create/') ?>'+id)
        $('#criteria-name').text(name)
    }

    function changeCriteria() {
        $('.tab_c').hide()
        var id = $('#select-criteria').val()
        $('#'+id).show()
    }

    function deleteSC(id) {
        $('#form-delete').attr('action', '<?= base_url("ahp/$id_project/sub_criteria/delete") ?>/'+id)
    }
</script>
<?= $this->endSection() ?>