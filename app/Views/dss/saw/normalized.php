<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Normalized & Rangking</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link" href="<?= base_url("saw/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("saw/$id_project/alternatives") ?>">Step 2 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("saw/$id_project/normalized") ?>">Step 3</a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <?php
                        $arr_min_max = [];
                        foreach ($alternatives as $key => $a) :
                            foreach ($criteria as $key_c => $c) {
                                $arr_min_max[$c['id']][] = (float) $alternatives_weight[$a['id']][$c['id']]['weight'];
                            }
                        endforeach;
                        ?>

                        <table class="table table-hover" id="table-result">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php foreach ($criteria as $key => $c) { ?>
                                        <th id="tippy-header-criteria-<?= $c['id'] ?>">C<?= $key+1 ?></th>
                                    <?php } ?>
                                    <th rowspan="2">Total</th>
                                    <th rowspan="2" class="bg-success">Ranking</th>
                                </tr>
                                <tr>
                                    <th>Weight</th>
                                    <?php foreach ($criteria as $key => $c) { ?>
                                        <th><?= number_format(($c['weight']/$total_criteria_weight) * 100, 1, ".", ",") ?>%</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rank = [];
                                $rank_tippy_str = [];
                                foreach ($alternatives as $key => $a) : ?>
                                    <tr>
                                        <td  id="tippy-header-alternatives-<?= $a['id'] ?>">A<?= $key + 1 ?></td>
                                        <?php
                                        $rank[$a['id']] = 0;
                                        $rank_tippy_str[$a['id']] = "";
                                        foreach ($criteria as $key_c => $c) {
                                            $temp = ($c['cost_benefit'] == 'benefit') ? $alternatives_weight[$a['id']][$c['id']]['weight']/max($arr_min_max[$c['id']]) : min($arr_min_max[$c['id']])/$alternatives_weight[$a['id']][$c['id']]['weight'];
                                            $rank[$a['id']] += $temp * ($c['weight'])/$total_criteria_weight;
                                            $rank_tippy_str[$a['id']] .=  "(" . number_format(($c['weight']/$total_criteria_weight) * 100, 2, ".", ",") . "%)×(" . number_format($temp, 2, ".", ",") . ") + ";
                                        ?>
                                            <td
                                             class="tippy-me"
                                             data-tippy-content="<?= ($c['cost_benefit'] == 'benefit') ?
                                              $alternatives_weight[$a['id']][$c['id']]['weight'] . '/' . max($arr_min_max[$c['id']]) :
                                              min($arr_min_max[$c['id']]) . '/' . $alternatives_weight[$a['id']][$c['id']]['weight'] ?>">
                                                <?= ($c['cost_benefit'] == 'benefit') ?
                                                number_format($alternatives_weight[$a['id']][$c['id']]['weight']/max($arr_min_max[$c['id']]), 2, ".", ",") :
                                                number_format(min($arr_min_max[$c['id']])/$alternatives_weight[$a['id']][$c['id']]['weight'], 2, ".", ",") ?>
                                            </td>
                                        <?php } ?>
                                        <td
                                         class="tippy-me"
                                         data-tippy-content="<?= rtrim($rank_tippy_str[$a['id']], ' +'); ?>"
                                        >
                                            <?= number_format($rank[$a['id']], 2, ".", ",") ?>
                                        </td>
                                        <td id="rank-<?= $a['id'] ?>" class="bg-success"></td>
                                    </tr>
                                <?php endforeach;?>
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
    <?php arsort($rank); $total_key = array_keys($rank); ?>
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
    <?php foreach ($alternatives as $key => $c) { ?>
        tippy('#tippy-header-alternatives-<?= $c['id'] ?>', {
            interactive: true,
            content: "<?= $c['name'] ?>",
            arrow: true,
            placement: 'top-start',
        });
    <?php } ?>

    function deleteAlternativeModal(id) {
        $('#form-delete').attr('action', '<?= base_url("saw/$id_project/alternatives/delete") ?>/'+id)
    }

    $(document).ready(() => {
        <?php
            foreach ($total_key as $key => $t) {
                $rank = $key + 1;
                echo "\$('#rank-{$t}').text('{$rank}');";
            }
        ?>

        $('#table-result').DataTable({
            dom: 'Bfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        })
    })
</script>
<?= $this->endSection() ?>