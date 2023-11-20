<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Alternatives, Vector, and Ranking</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link" href="<?= base_url("wp/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("wp/$id_project/alternatives") ?>">Step 2</i></a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="d-flex justify-content-end my-2">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreateAlternative"><i class="fa fa-plus"></i> Add Alternative</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="table-result">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Name</th>
                                        <?php foreach ($criteria as $key => $c) { ?>
                                            <th id="tippy-header-criteria-<?= $c['id'] ?>">C<?= $key+1 ?></th>
                                        <?php } ?>
                                        <th rowspan="2">Vector S</th>
                                        <th rowspan="2">Vector V</th>
                                        <th rowspan="2" class="bg-success">Ranking</th>
                                        <th rowspan="2">Action</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($criteria as $key => $c) { ?>
                                            <th class="tippy-me" data-tippy-content="<?= $c['cost_benefit'] ?>"><?= ($c['cost_benefit'] == 'benefit') ? 'B' : 'C' ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $arr_min_max = [];
                                    $total_vector_s = 0;
                                    $arr_vector_s = [];
                                    $str_total_vector_s = "";
                                    foreach ($alternatives as $key => $a) : ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $a['name'] ?></td>
                                            <?php
                                            $vector_s = 1;
                                            $str_vector_s = "";
                                            foreach ($criteria as $key_c => $c) {
                                            $arr_min_max[$c['id']][] = $alternatives_weight[$a['id']][$c['id']]['weight'];
                                            $exponent = ($c['cost_benefit'] == 'benefit') ? $c['weight']/$total_criteria_weight : -1 * ($c['weight']/$total_criteria_weight);
                                            $vector_s *= $alternatives_weight[$a['id']][$c['id']]['weight'] ** $exponent;
                                            $str_vector_s .= "(" . $alternatives_weight[$a['id']][$c['id']]['weight'] . "^" . number_format($exponent, 2, ".", ",") . ")";
                                            ?>
                                                <td
                                                class="tippy-me"
                                                data-tippy-content="<?= $sub_criteria[$c['id']][$alternatives_weight[$a['id']][$c['id']]['id']]['name'] ?>">
                                                    <?= number_format($alternatives_weight[$a['id']][$c['id']]['weight']) ?>
                                                </td>
                                            <?php
                                            }
                                            $total_vector_s += $vector_s;
                                            $arr_vector_s[$a['id']] = $vector_s;
                                            $str_total_vector_s .= number_format($vector_s, 2, ".", ",") . " + ";
                                            ?>
                                            <td class="tippy-me" data-tippy-content="<?= $str_vector_s ?>"><?= number_format($vector_s, 2, ".", ",") ?></td>
                                            <td id="vector_v-<?= $a['id'] ?>"></td>
                                            <td id="rank-<?= $a['id'] ?>" class="bg-success"></td>
                                            <td>
                                                <button
                                                class="btn btn-danger btn-sm"
                                                data-toggle="modal"
                                                data-target="#modalDeleteAlternative"
                                                onclick="deleteAlternativeModal(<?= $a['id'] ?>)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th colspan="<?= count($criteria) ?>"></th>
                                        <th class="tippy-me" data-tippy-content="<?= rtrim($str_total_vector_s, ' + '); ?>"><?= number_format($total_vector_s, 2, ".", ",") ?></th>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php arsort($arr_vector_s); $total_key = array_keys($arr_vector_s); ?>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Alternative</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('wp/' . $id_project . '/alternatives/create') ?>" method="post">
                <div class="modal-body" style="overflow-y: auto; max-height: 60vh">
                    <div class="form-group">
                        <label for="projectName">Alternative Name</label>
                        <input type="text" class="form-control" required autocomplete="off" name="name" id="projectName" placeholder="Name">
                    </div>
                    <?php foreach ($criteria as $key => $c) { ?>
                        <hr>
                        <input type="hidden" name="criteria[]" value="<?= $c['id'] ?>">
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
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ! modal create -->

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

    // tippy
    <?php foreach ($criteria as $key => $c) { ?>
        tippy('#tippy-header-criteria-<?= $c['id'] ?>', {
            interactive: true,
            content: "<?= $c['name'] ?>",
            arrow: true,
            placement: 'top-start',
        });
    <?php } ?>

    function deleteAlternativeModal(id) {
        $('#form-delete').attr('action', '<?= base_url("wp/$id_project/alternatives/delete") ?>/'+id)
    }

    $(document).ready(() => {
        <?php foreach ($arr_vector_s as $key => $vector_s) { ?>
            $('#vector_v-<?= $key ?>').text('<?= number_format($vector_s/$total_vector_s, 2, ".", ",") ?>')
        <?php } ?>

        <?php
            foreach ($total_key as $key => $t) {
                $rank = $key + 1;
                echo "\$('#rank-{$t}').text('{$rank}');";
            }
        ?>

        $('#table-result').DataTable()
    })
</script>
<?= $this->endSection() ?>