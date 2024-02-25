<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Euclidean distance & Positive and Negative ideal solutions</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/alternatives") ?>">Step 2 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/normalized") ?>">Step 3 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/normalized-weight") ?>">Step 4 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("topsis/$id_project/ideal_solutions") ?>">Step 5 <i class="fa fa-arrow-right"></i></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("topsis/$id_project/preference_score") ?>">Step 6</a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">

                        <div class="table-responsive">
                            <table class="table table-hover" id="table-result">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Alternative</th>
                                        <th>Preference (V)</th>
                                        <th>Rangking</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($alternatives as $key => $a) : ?>
                                        <tr>
                                            <td><?= $key+1 ?></td>
                                            <td> <?= $a['name'] ?></td>
                                            <td class="tippy-me" data-tippy-content="<?= $preference_str[$a['id']] ?>"><?= number_format($preference[$a['id']], 2) ?></td>
                                            <td class="tippy-me" ><?= $ranking[$a['id']] ?></td>
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

    $(document).ready(() => {
        $('#table-result').DataTable({
            dom: 'Bfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
        })
    })
</script>
<?= $this->endSection() ?>