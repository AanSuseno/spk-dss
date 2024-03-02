<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Criteria</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("saw/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("saw/$id_project/alternatives") ?>">Step 2 <i class="fa fa-arrow-right"></i></a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="d-flex justify-content-end my-2">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreateCriteria"><i class="fa fa-plus"></i> Add Criteria</button>
                        </div>

                        <table class="table table-hover" id="table-result">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Benefit/Cost</th>
                                    <th>Weight</th>
                                    <th>Weight (%)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($criteria as $key => $c) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $c['name'] ?></td>
                                        <td><?= $c['cost_benefit'] ?></td>
                                        <td><?= number_format($c['weight']) ?></td>
                                        <td><?= number_format(($c['weight']/$total_criteria_weight) * 100, 2, ".", ",") ?>%</td>
                                        <td>
                                            <button
                                             class="btn btn-danger btn-sm"
                                             data-toggle="modal"
                                             data-target="#modalDeleteCriteria"
                                             onclick="deleteCriteriaModal(<?= $c['id'] ?>)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <button
                                             data-tippy-content="Sub Criteria of <?= $c['name'] ?>"
                                             class="btn btn-secondary btn-sm tippy-me"
                                             onclick="subCriteriaModal(<?= $c['id'] ?>, '<?= $c['name'] ?>')">
                                                <i class="fa fa-list"></i> Sub Criteria
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
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
            <form action="<?= base_url('saw/' . $id_project . '/criteria/create') ?>" method="post">
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

<!-- modal sub criteria -->
<div class="modal fade" id="modalSubCriteria">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sub Criteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: 60vh">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Weight</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-sub-criteria">
                    </tbody>
                </table>
                <hr>
                <h4>Create New Sub Criteria for <span id="criteria-name"></span></h4>
                <form action="" method="post" id="form-create-sub-criteria">
                    <table class="table table-borderless">
                        <tr>
                            <td>Name</td>
                            <td>
                                <input type="text" required autocomplete="off" name="name" id="" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Weight</td>
                            <td><input type="number" required name="weight" id="" class="form-control"></td>
                        </tr>
                    </table>
                    <button class="btn btn-primary btn-sm mt-2 col-12">Add</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- ! modal sub criteria -->

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
        $('#form-delete').attr('action', '<?= base_url("saw/$id_project/criteria/delete") ?>/'+id)
    }

    function subCriteriaModal(id_criteria, criteria_name) {
        $('#modalSubCriteria').modal()
        $('#criteria-name').text(criteria_name)
        $('#form-create-sub-criteria').attr('action', '<?= base_url("saw/$id_project/sub_criteria/create/") ?>'+id_criteria)

        $.ajax({
            url: '<?= base_url("saw/$id_project/sub_criteria/") ?>'+id_criteria, // Specify the URL of the API or JSON file
            type: 'GET', // Use the GET method
            dataType: 'json', // Expect JSON data
            success: function(data) {
                var str_table = ''
                var sub_criteria = data.sub_criteria

                sub_criteria.forEach((i, idx) => {
                    str_table += `
                        <tr>
                            <td>${idx+1}</td>
                            <td>${i.name}</td>
                            <td>${i.weight}</td>
                            <td>
                                <a href="<?= base_url("saw/$id_project/sub_criteria/delete/") ?>${i.id}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    `
                })

                $('#table-sub-criteria').html(str_table)
            },
            error: function(error) {
                // Handle errors
                console.error('Error:' + error);
            }
        });
    }

    $(document).ready(() => {
        $('#table-result').DataTable({
            dom: 'Bfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        })
    })
</script>
<?= $this->endSection() ?>