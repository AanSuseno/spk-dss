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
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/normalized") ?>">Step 3 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("topsis/$id_project/normalized-weight") ?>">Step 4 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/ideal_solutions") ?>">Step 5</i></a></li>
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
                                </thead>
                                <tbody>
                                    <?php
                                    $arr_normalized_weight = [];
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
                                                 <?= $c['weight'] . '×' . number_format($normalized[$a['id']][$c['id']], 2, '.', ',') ?>
                                                ">
                                                    <?= number_format($c['weight']*$normalized[$a['id']][$c['id']], 2, '.', ',') ?>
                                                </td>
                                            <?php
                                                $arr_normalized_weight[$c['id']][] =$c['weight']*$normalized[$a['id']][$c['id']];
                                            }
                                            ?>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>MAX</th>
                                        <td> </td>
                                        <?php for ($i = 0; $i < count($criteria); $i++) { ?>
                                            <th>
                                                <?php
                                                    if ($criteria[$i]['cost_benefit'] == 'benefit') {
                                                        echo number_format(max($arr_normalized_weight[$criteria[$i]['id']]), 2, '.', ',');
                                                    } else {
                                                        echo number_format(min($arr_normalized_weight[$criteria[$i]['id']]), 2, '.', ',');
                                                    }
                                                ?>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <th>MIN</th>
                                        <td> </td>
                                        <?php for ($i = 0; $i < count($criteria); $i++) { ?>
                                            <th>
                                                <?php
                                                    if ($criteria[$i]['cost_benefit'] == 'cost') {
                                                        echo number_format(max($arr_normalized_weight[$criteria[$i]['id']]), 2, '.', ',');
                                                    } else {
                                                        echo number_format(min($arr_normalized_weight[$criteria[$i]['id']]), 2, '.', ',');
                                                    }
                                                ?>
                                            </th>
                                        <?php } ?>
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

    $(document).ready(() => {
        $('#table-result').DataTable({
            dom: 'Bfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        })
    })
</script>
<?= $this->endSection() ?>