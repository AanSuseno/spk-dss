<?php
$total_eigenvalue = 0;
?>
<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Pairwise Comparison of Criteria Importance Level</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("ahp/$id_project/criteria_weight") ?>">Step 2 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/sub_criteria") ?>">Step 3 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/sub_criteria_weight") ?>">Step 4 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/alternatives") ?>">Step 5 <i class="fa fa-arrow-right"></i></a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="d-flex justify-content-end my-2">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalUpdateWeight"><i class="fa fa-edit"></i> Update Weight</button>
                        </div>

                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Criteria</th>
                                    <?php foreach ($criteria as $key => $c) : ?>
                                        <?php $criteria_weight_total[$c['id']] = 0; ?>
                                        <th><?= $c ['name'] ?></th>
                                    <?php endforeach ?>
                                </tr>
                                <?php foreach ($criteria as $key => $cx) : ?>
                                    <tr>
                                        <th><?= $cx['name'] ?></th>
                                        <?php foreach ($criteria as $key2 => $cy) : ?>
                                            <?php $criteria_weight_total[$cy['id']] += $criteria_weight_arr[$cx['id']][$cy['id']]; ?>
                                            <td class="<?= ($cy['id'] == $cx['id']) ? 'bg-success' : '' ?>">
                                                <?= number_format($criteria_weight_arr[$cx['id']][$cy['id']], 2, ".", ",") ?>
                                            </td>
                                        <?php endforeach ?>
                                    </tr>
                                <?php endforeach ?>
                                <tr>
                                    <th>Total</th>
                                    <?php foreach ($criteria_weight_total as $key => $ct) { ?>
                                        <th><?= number_format($ct, 2, ".", ",") ?></th>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>

                        <hr>
                        <h3>Pairwise Comparison Normalization</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Criteria</th>
                                    <?php foreach ($criteria as $key => $c) : ?>
                                        <?php
                                            $criteria_weight_nomralized_total[$c['id']] = 0;
                                        ?>
                                        <th><?= $c ['name'] ?></th>
                                    <?php endforeach ?>
                                    <th class="bg-success">Total</th>
                                    <th class="bg-secondary">Priority</th>
                                    <th class="bg-warning">Eigen Value</th>
                                </tr>
                                <?php foreach ($criteria as $key => $cx) : ?>
                                    <tr>
                                        <th><?= $cx['name'] ?></th>
                                        <?php foreach ($criteria as $key2 => $cy) : ?>
                                            <?php
                                                $temp = $criteria_weight_arr[$cx['id']][$cy['id']]/$criteria_weight_total[$cy['id']];
                                                $criteria_weight_nomralized_total[$cx['id']] += $temp;
                                            ?>
                                            <td>
                                                <?= number_format($temp, 2, ".", ",") ?>
                                            </td>
                                        <?php endforeach ?>
                                        <th class="bg-success"><?= number_format($criteria_weight_nomralized_total[$cx['id']], 2, ".", ",") ?></th>
                                        <th class="bg-secondary"><?= number_format($criteria_weight_nomralized_total[$cx['id']]/count($criteria), 2, ".", ",") ?></th>
                                        <th class="bg-warning"><?= number_format(($criteria_weight_nomralized_total[$cx['id']]/count($criteria))*$criteria_weight_total[$cx['id']], 2, ".", ",") ?></th>
                                        <?php
                                            $total_eigenvalue += ($criteria_weight_nomralized_total[$cx['id']]/count($criteria))*$criteria_weight_total[$cx['id']];
                                        ?>
                                    </tr>
                                <?php endforeach ?>
                            </table>
                        </div>

                        <hr>
                        <h3>Decision Making Consistency</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="bg-primary">Consistency Index (CI)</th>
                                    <th>
                                        <?php
                                            $ci = ($total_eigenvalue-count($criteria))/(count($criteria)-1);
                                            echo number_format($ci, 2, ".", ",");
                                        ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="bg-primary">Ramdom Index (RI)</th>
                                    <th>
                                        <?php
                                            echo number_format($random_index, 2, ".", ",");
                                        ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="bg-primary">Consistency Ratio (CR)</th>
                                    <th>
                                        <?php
                                            $cr = $ci/$random_index;
                                            echo number_format($cr, 2, ".", ",");
                                            if ($cr < 0.1) {
                                                echo " [Consistent]";
                                            } else echo " [Inconsistent]";
                                        ?>
                                    </th>
                                </tr>
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
<div class="modal fade" id="modalUpdateWeight">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Importance Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ahp/' . $id_project . '/criteria_weight/update') ?>" method="post">
                <div class="modal-body">
                    <center class="box-note"></center>
                    <hr>
                    <table class="table table-borderless">
                        <?php
                        for ($i = 0; $i < count($criteria); $i++) :
                            for ($j = $i; $j < count($criteria); $j++) :
                                if ($j == $i) continue;
                            ?>
                                <tr>
                                    <td><?= $criteria[$i]['name'] ?></td>
                                    <td>
                                        <input type="hidden" name="criteria[]" value="<?= $criteria[$i]['id'] ?>-<?= $criteria[$j]['id'] ?>">
                                        <input
                                         type="range"
                                         class="custom-range"
                                         min="-7"
                                         max="9"
                                         value="<?= ($criteria_weight_arr[$criteria[$j]['id']][$criteria[$i]['id']] >= 1) ?
                                          $criteria_weight_arr[$criteria[$j]['id']][$criteria[$i]['id']] :
                                          ($criteria_weight_arr[$criteria[$i]['id']][$criteria[$j]['id']] - 2) * -1 ?>"
                                         id="range-<?= $criteria[$i]['id'] ?>-<?= $criteria[$j]['id'] ?>"
                                         name="range[]"
                                         onchange="changeRange('<?= $criteria[$i]['id'] ?>-<?= $criteria[$j]['id'] ?>', '<?= $criteria[$i]['name'] ?>', '<?= $criteria[$j]['name'] ?>')"
                                         onfocus="changeRange('<?= $criteria[$i]['id'] ?>-<?= $criteria[$j]['id'] ?>', '<?= $criteria[$i]['name'] ?>', '<?= $criteria[$j]['name'] ?>')"
                                         >
                                    </td>
                                    <td><?= $criteria[$j]['name'] ?></td>
                                </tr>
                            <?php            
                            endfor;
                        endfor;
                        ?>
                    </table>
                    <hr>
                    <center class="box-note"></center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ! modal create -->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    const Saaty_9_point_scale = {
        1: 'CriteriaA is equally as important as CriteriaB.',
        2: 'CriteriaA is slightly more important than CriteriaB.',
        3: 'CriteriaA is more important than CriteriaB, but not significantly.',
        4: 'CriteriaA is clearly more important than CriteriaB.',
        5: 'CriteriaA is significantly more important than CriteriaB.',
        6: 'CriteriaA is absolutely more important than CriteriaB.',
        7: 'CriteriaA is absolutely more important, with a demonstrated level of importance, than CriteriaB.',
        8: 'CriteriaA is overwhelmingly more important than CriteriaB.',
        9: 'CriteriaA is extremely more important than CriteriaB.'
    }

    function changeRange(id, criteria_1, criteria_2) {
        var val_range = $('#range-'+id).val()
        var str = ''

        if (val_range < 1) {
            val_range = Math.abs(val_range)+2
            str = Saaty_9_point_scale[val_range].replace('CriteriaA', criteria_1)
            str = str.replace('CriteriaB', criteria_2)
        } else {
            str = Saaty_9_point_scale[val_range].replace('CriteriaA', criteria_2)
            str = str.replace('CriteriaB', criteria_1)
        }
        $('.box-note').text('Scale: ' + val_range + ' | ' + str)
    }
</script>
<?= $this->endSection() ?>