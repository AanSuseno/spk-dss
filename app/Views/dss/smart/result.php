<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Utility</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url("smart/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url("smart/$id_project/alternatives") ?>">Step 2 <i class="fa fa-arrow-right"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url("smart/$id_project/alternatives/utility") ?>">Step 3 <i class="fa fa-arrow-right"></i></a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url("smart/$id_project/alternatives/result") ?>">Step 4</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table-result">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Name</th>
                                        <?php foreach ($criteria as $key => $c) { ?>
                                            <th id="tippy-header-criteria-<?= $c['id'] ?>">C<?= $key + 1 ?></th>
                                        <?php } ?>
                                        <th rowspan="2">Final Result</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($criteria as $key => $c) { ?>
                                            <th class="tippy-me" data-tippy-content="<?= $c['cost_benefit'] ?>"><?= ($c['cost_benefit'] == 'benefit') ? 'B' : 'C' ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($alternatives as $key => $a) : ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td><?= $a['name'] ?></td>
                                            <?php
                                            $vector_s = 1;
                                            $str_vector_s = "";
                                            $total = 0;
                                            foreach ($criteria as $key_c => $c) {
                                                $utility = ($c['cost_benefit'] == 'benefit') ? 
                                                (($alternatives_weight[$c['id']][$a['id']] - $alternatives_min[$c['id']]) / ($alternatives_max[$c['id']] - $alternatives_min[$c['id']]))
                                                : (($alternatives_max[$c['id']] - $alternatives_weight[$c['id']][$a['id']]) / ($alternatives_max[$c['id']] - $alternatives_min[$c['id']]));
                                                $res = $utility * ($c['weight']/$total_criteria_weight);
                                                $total += $res;
                                            ?>
                                                <td class="tippy-me" data-tippy-content="<?= number_format($utility, 3) . '×' . number_format(($c['weight']/$total_criteria_weight), 3) ?>">
                                                    <?= number_format($res, 3) ?>
                                                </td>
                                            <?php
                                            }
                                            ?>
                                            <td>
                                                <?= number_format($total, 3) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
        $('#form-delete').attr('action', '<?= base_url("smart/$id_project/alternatives/delete") ?>/' + id)
    }

    $(document).ready(() => {
        $('#table-result').DataTable({
            dom: 'Bfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    })
</script>
<?= $this->endSection() ?>