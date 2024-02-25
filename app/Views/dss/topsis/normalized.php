<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Normalized decision matrix</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/alternatives") ?>">Step 2 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("topsis/$id_project/normalized") ?>">Step 3 <i class="fa fa-arrow-right"></i></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/normalized-weight") ?>">Step 4</i></a></li>
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
                                            <th id="tippy-header-criteria-<?= $c['id'] ?>">C<?= $key+1 ?></th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php foreach ($criteria as $key => $c) { ?>
                                            <th class="tippy-me" data-tippy-content="<?= $c['cost_benefit'] ?>"><?= ($c['cost_benefit'] == 'benefit') ? 'B' : 'C' ?></th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <th colspan="2">
                                            <img src="data:image/png;base64,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" alt="">
                                        </th>
                                        <?php foreach ($arr_sum_weight_squared as $key => $value) { ?>
                                            <th
                                             class="tippy-me"
                                             data-tippy-content="<?= rtrim($arr_sum_weight_squared_text[$key], ' + ') . ')'; ?>"
                                             >
                                                <?= number_format(sqrt($value), 2,',','.') ?>
                                            </th>
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
                                                $arr_min_max[$c['id']][] = $alternatives_weight[$a['id']][$c['id']]['weight'];
                                                $exponent = ($c['cost_benefit'] == 'benefit') ? $c['weight']/$total_criteria_weight : -1 * ($c['weight']/$total_criteria_weight);
                                                $vector_s *= $alternatives_weight[$a['id']][$c['id']]['weight'] ** $exponent;
                                                $str_vector_s .= "(" . $alternatives_weight[$a['id']][$c['id']]['weight'] . "^" . number_format($exponent, 2, ".", ",") . ")";
                                            ?>
                                                <td
                                                class="tippy-me"
                                                data-tippy-content="
                                                 [<?= $sub_criteria[$c['id']][$alternatives_weight[$a['id']][$c['id']]['id']]['name'] ?>]
                                                 <?= $alternatives_weight[$a['id']][$c['id']]['weight'] . '/' . number_format(sqrt($arr_sum_weight_squared[$c['id']]), 2, '.', ',') ?>
                                                ">
                                                    <?= number_format($alternatives_weight[$a['id']][$c['id']]['weight']/sqrt($arr_sum_weight_squared[$c['id']]), 2, '.', ',') ?>
                                                </td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                    <?php endforeach;?>
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
        $('#form-delete').attr('action', '<?= base_url("topsis/$id_project/alternatives/delete") ?>/'+id)
    }

    $(document).ready(() => {
        $('#table-result').DataTable({
            dom: 'Bfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        })
    })
</script>
<?= $this->endSection() ?>