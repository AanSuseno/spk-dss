<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Criteria</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url("smart/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url("smart/$id_project/alternatives") ?>">Step 2</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="d-flex justify-content-end my-2">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreateCriteria"><i class="fa fa-plus"></i> Add Criteria</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="table-result">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Benefit/Cost</th>
                                        <th>Weight</th>
                                        <th>Normalized</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_str = "";
                                    foreach ($criteria as $key => $c) :
                                        $total_str .= $c['weight'] . " + ";
                                    ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $c['name'] ?></td>
                                            <td><?= $c['cost_benefit'] ?></td>
                                            <td><?= number_format($c['weight']) ?></td>
                                            <td
                                             class="tippy-me"
                                             data-tippy-content="<?= $c['weight'] ?>/<?= $total_criteria_weight ?>"><?= number_format($c['weight']/$total_criteria_weight, 3) ?></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDeleteCriteria" onclick="deleteCriteriaModal(<?= $c['id'] ?>)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th><?= $total_criteria_weight ?></th>  
                                        <th>1</th>  
                                        <th> </th>  
                                    </tr>
                                </tfoot>
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
<div class="modal fade" id="modalCreateCriteria">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Criteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('smart/' . $id_project . '/criteria/create') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="projectName">Criteria Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="name" id="projectName" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label>Cost/Benefit</label>
                        <select name="cost_benefit" id="" class="form-control">
                            <option value="c">Cost</option>
                            <option value="b">Benefit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Weight</label>
                        <input type="number" name="weight" class="form-control">
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
<div class="modal fade" id="modalDeleteCriteria">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Criterion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form-delete" method="post">
                <div class="modal-body">
                    <p>Are you sure you want to permanently delete this criterion?</p>
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
    function deleteCriteriaModal(id) {
        $('#form-delete').attr('action', '<?= base_url("smart/$id_project/criteria/delete") ?>/' + id)
    }

    $(document).ready(() => {
        $('#table-result').DataTable({
            dom: 'Bfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        })
    })
</script>
<?= $this->endSection() ?>