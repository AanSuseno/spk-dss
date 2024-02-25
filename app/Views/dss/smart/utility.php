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
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url("smart/$id_project/alternatives/utility") ?>">Step 3 <i class="fa fa-arrow-right"></i></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url("smart/$id_project/alternatives/result") ?>">Step 4</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <img style="max-width: 100%; width: 200px; margin-bottom: 10px"
                         src="data:image/png;base64,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">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table-result">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Name</th>
                                        <?php foreach ($criteria as $key => $c) { ?>
                                            <th id="tippy-header-criteria-<?= $c['id'] ?>">C<?= $key + 1 ?></th>
                                        <?php } ?>
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
                                            foreach ($criteria as $key_c => $c) {
                                                $utility = ($c['cost_benefit'] == 'benefit') ? 
                                                (($alternatives_weight[$c['id']][$a['id']] - $alternatives_min[$c['id']]) / ($alternatives_max[$c['id']] - $alternatives_min[$c['id']]))
                                                : (($alternatives_max[$c['id']] - $alternatives_weight[$c['id']][$a['id']]) / ($alternatives_max[$c['id']] - $alternatives_min[$c['id']]));
                                                $utility_str = ($c['cost_benefit'] == 'benefit') ? 
                                                "(" . $alternatives_weight[$c['id']][$a['id']] . "-" . $alternatives_min[$c['id']] . ")/(" . $alternatives_max[$c['id']] . "-" . $alternatives_min[$c['id']] . ")"
                                                : "(" . $alternatives_max[$c['id']] . "-" . $alternatives_weight[$c['id']][$a['id']] . ")/(" . $alternatives_max[$c['id']] . "-" . $alternatives_min[$c['id']] . ")";
                                            ?>
                                                <td class="tippy-me" data-tippy-content="<?= $utility_str ?>">
                                                    <?= number_format($utility, 3) ?>
                                                </td>
                                            <?php
                                            }
                                            ?>
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
        })
    })
</script>
<?= $this->endSection() ?>