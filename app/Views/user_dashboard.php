<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Note 🗒️</h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <p>
                    To avoid errors, please follow the steps carefully.
                    If there is an issue in the previous step, you can delete the project and create it again.
                    This application is still in development, and you can contribute on <a href="https://github.com/AanSuseno/spk-dss" target="_blank">GitHub</a> to improve it.
                </p>
            <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- ./card -->
    </div>
    <!-- /.col -->
</div>

<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Dashboard <i class="fa fa-tachometer-alt"></i></h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                        <!-- Project -->
                        <div class="card card-<?= (($total_project/$max_project) > 0.75) ? 'danger' : 'info' ?>">
                            <div class="card-header">
                                <h3 class="card-title">My Projects</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="chartProjects" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <!-- Criteria -->
                        <div class="card card-<?= (($total_criteria/$max_criteria) > 0.75) ? 'danger' : 'info' ?>">
                            <div class="card-header">
                                <h3 class="card-title">My Criteria</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="chartCriteria" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <!-- Sub Criteria -->
                        <div class="card card-<?= (($total_sub_criteria/$max_sub_criteria) > 0.75) ? 'danger' : 'info' ?>">
                            <div class="card-header">
                                <h3 class="card-title">My Sub Criteria</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="chartSubCriteria" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <!-- Alternatives -->
                        <div class="card card-<?= (($total_alternatives/$max_alternatives) > 0.75) ? 'danger' : 'info' ?>">
                            <div class="card-header">
                                <h3 class="card-title">My Alternatives</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="chartAlternatives" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
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
        var bgColor = ['#DBC4F0', '#FF6969', '#F9B572', '#C683D7', '#99eb96', '#ddd']

        // chart for projects
        new Chart($('#chartProjects').get(0).getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: [
                    <?php foreach ($total_projects as $key => $t) { ?>
                        '<?= $key ?>',
                    <?php } ?>
                    'Free Slots'
                ],
                datasets: [
                    {
                    data: [
                        <?php foreach ($total_projects as $key => $t) { ?>
                            <?= $t ?>,
                        <?php } ?>
                        <?= $max_project-$total_project ?>
                    ],
                    backgroundColor : bgColor,
                    }
                ]
            },
            options: {
                maintainAspectRatio : false,
                responsive : true,
            }
        })

        // chart for criteria
        new Chart($('#chartCriteria').get(0).getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: [
                    <?php foreach ($arr_total_criteria as $key => $t) { ?>
                        '<?= $key ?>',
                    <?php } ?>
                    'Free Slots'
                ],
                datasets: [
                    {
                    data: [
                        <?php foreach ($arr_total_criteria as $key => $t) { ?>
                            <?= $t ?>,
                        <?php } ?>
                        <?= $max_criteria-$total_criteria ?>
                    ],
                    backgroundColor : bgColor,
                    }
                ]
            },
            options: {
                maintainAspectRatio : false,
                responsive : true,
            }
        })

        // chart for sub criteria
        new Chart($('#chartSubCriteria').get(0).getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: [
                    <?php foreach ($arr_total_sub_criteria as $key => $t) { ?>
                        '<?= $key ?>',
                    <?php } ?>
                    'Free Slots'
                ],
                datasets: [
                    {
                    data: [
                        <?php foreach ($arr_total_sub_criteria as $key => $t) { ?>
                            <?= $t ?>,
                        <?php } ?>
                        <?= $max_sub_criteria-$total_sub_criteria ?>
                    ],
                    backgroundColor : bgColor,
                    }
                ]
            },
            options: {
                maintainAspectRatio : false,
                responsive : true,
            }
        })

        // chart for alternatives
        new Chart($('#chartAlternatives').get(0).getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: [
                    <?php foreach ($arr_total_alternatives as $key => $t) { ?>
                        '<?= $key ?>',
                    <?php } ?>
                    'Free Slots'
                ],
                datasets: [
                    {
                    data: [
                        <?php foreach ($arr_total_alternatives as $key => $t) { ?>
                            <?= $t ?>,
                        <?php } ?>
                        <?= $max_alternatives-$total_alternatives ?>
                    ],
                    backgroundColor : bgColor,
                    }
                ]
            },
            options: {
                maintainAspectRatio : false,
                responsive : true,
            }
        })
    })
</script>
<?= $this->endSection() ?>