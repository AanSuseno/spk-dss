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
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/alternatives") ?>">Step 5 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("ahp/$id_project/result") ?>">Step 6</i></a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">

                        <div class="table-responsive">
                            <table class="table table-hover" id="table-result">
                                <thead>
                                    <tr>
                                        <th class="bg-primary">Alternative</th>
                                        <?php foreach ($criteria as $key => $c) { ?>
                                            <th><?= $c['name'] ?></th>
                                        <?php } ?>
                                        <th class="bg-success">Total</th>
                                        <th class="bg-warning">Rank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = [];
                                    foreach ($alternatives as $key => $a) {
                                    $total[$a['id']] = 0;    
                                    ?>
                                        <tr>
                                            <td class="bg-primary"><?= $a['name'] ?></td>
                                            <?php foreach ($criteria as $key_c => $c) {
                                                $total[$a['id']] += $alternative_priority[$a['id']][$c['id']]['value'] * $c['priority'];
                                                echo "<td title='{$alternative_priority[$a['id']][$c['id']]['name']}'>" . number_format($alternative_priority[$a['id']][$c['id']]['value'] * $c['priority'], 2, ".", ",") . "</td>";
                                            } ?>
                                            <td class="bg-success"><?= number_format($total[$a['id']], 2, ".", ",") ?></td>
                                            <td class="bg-warning" id="rank-<?= $a['id']?>"></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php arsort($total); $total_key = array_keys($total); ?>
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