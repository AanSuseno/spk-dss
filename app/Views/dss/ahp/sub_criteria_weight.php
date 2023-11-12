<?= $this->extend('template_for_user/index') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <!-- Custom Tabs -->
        <div class="card">
            <div class="card-header d-flex p-0">
            <h3 class="card-title p-3">Pairwise Comparison of Sub Criteria Importance Level</h3>
            <ul class="nav nav-pills ml-auto p-2">
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/criteria") ?>">Step 1 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/criteria_weight") ?>">Step 2 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url("ahp/$id_project/sub_criteria") ?>">Step 3 <i class="fa fa-arrow-right"></i></a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url("ahp/$id_project/sub_criteria_weight") ?>">Step 4 <i class="fa fa-arrow-right"></i></a></li>
            </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active">

                        <select name="" id="select-criteria" onchange="changeCriteria()" class="form-control">
                            <?php foreach ($criteria as $key => $c) { ?>
                                <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                            <?php } ?>
                        </select>

                        <div class="d-flex justify-content-end my-2">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalUpdate"><i class="fa fa-edit"></i> Update Importance Level</button>
                        </div>

                        <div id="box-sub-criteria-table">
                        </div>
                        <hr>
                        <h3>Normalized</h3>
                        <div class="table-responsive" id="box-sub-criteria-table-normalized">
                        </div>

                        <hr>
                        <h3>Decision Making Consistency</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th class="bg-primary">Consistency Index (CI)</th>
                                    <th id="dmc-ci">
                                    </th>
                                </tr>
                                <tr>
                                    <th class="bg-primary">Ramdom Index (RI)</th>
                                    <th id="dmc-ri">
                                    </th>
                                </tr>
                                <tr>
                                    <th class="bg-primary">Consistency Ratio (CR)</th>
                                    <th id="dmc-cr">
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
<div class="modal fade" id="modalUpdate">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Importance Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form-update-table" method="post">
                <div class="modal-body">
                    <center class="box-note"></center>
                    <hr>
                    <table class="table table-borderless" id="table-for-update">
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
    
    function changeCriteria(id_criteria = -1) {
        var id = (id_criteria == -1) ? $('#select-criteria').val() : id_criteria
        var str = `<div class="table-responsive"><table class="table"><tr><th>Sub Criteria</th>`
        var str_normalized = `<div class="table-responsive"><table class="table"><tr><th>Sub Criteria</th>`
        $('#form-update-table').attr('action', '<?= base_url("ahp/$id_project/sub_criteria_weight/update/") ?>')

        $.ajax({
            url: '<?= base_url("ahp/$id_project/sub_criteria_weight/") ?>'+id, // Specify the URL of the API or JSON file
            type: 'GET', // Use the GET method
            dataType: 'json', // Expect JSON data
            success: function(data) {
                var sub_c = data.sub_criteria
                var weight = data.weight
                var for_update = ``
                var total_ = []
                var total_normalized = []

                // set table header
                sub_c.forEach((i) => {
                    total_[i.id] = 0.0
                    str += `<th>${i.name}</th>`
                })
                str += `</tr>`

                // set table
                sub_c.forEach((y) => {
                    str += `<tr><th>${y.name}</th>`
                    sub_c.forEach((x) => {
                        // console.log(total_[x])
                        var w = parseFloat(weight[y.id][x.id])
                        total_[x.id] += w
                        str += `<td>${Intl.NumberFormat('en-US').format(w)}</td>`
                    })
                    str += `</tr>`
                })

                // set total
                str += '<tr style="border-top: 2px solid"><th>Total</th>'
                sub_c.forEach((y) => {
                    str += `<th>${Intl.NumberFormat('en-US').format(total_[y.id])}</th>`
                })
                str += '</tr></table></div>'

                // set table header normalized
                sub_c.forEach((i) => {
                    total_normalized[i.id] = 0.0
                    str_normalized += `<th>${i.name}</th>`
                })
                str_normalized += `<th class="bg-success">Total</th><th class="bg-secondary">Priority</th><th class="bg-warning">Eigen Value</th></tr>`

                // set table normalized
                var total_total_normalized = 0
                var total_priority = 0
                var total_eigen_value = 0
                sub_c.forEach((y) => {
                    str_normalized += `<tr><th>${y.name}</th>`
                    sub_c.forEach((x) => {
                        var temp = parseFloat(weight[y.id][x.id])/total_[x.id]
                        total_normalized[y.id] += temp
                        str_normalized += `<td>${Intl.NumberFormat('en-US').format(temp)}</td>`
                    })
                    str_normalized += `<th class="bg-success">${Intl.NumberFormat('en-US').format(total_normalized[y.id])}</th>`
                    total_total_normalized += total_normalized[y.id]
                    str_normalized += `<th class="bg-secondary">${Intl.NumberFormat('en-US').format(total_normalized[y.id]/sub_c.length)}</th>`
                    total_priority += total_normalized[y.id]/sub_c.length
                    str_normalized += `<th class="bg-warning">${Intl.NumberFormat('en-US').format((total_normalized[y.id]/sub_c.length)*total_[y.id])}</th></tr>`
                    total_eigen_value += (total_normalized[y.id]/sub_c.length)*total_[y.id]
                })

                // set total normalized
                str_normalized += `
                <tr style="border-top: 2px solid">
                    <th colspan="${sub_c.length+1}">Total</th>
                    <th class="bg-success">${Intl.NumberFormat('en-US').format(total_total_normalized)}</th>
                    <th class="bg-secondary">${Intl.NumberFormat('en-US').format(total_priority)}</th>
                    <th class="bg-warning">${Intl.NumberFormat('en-US').format(total_eigen_value)}</th>
                </tr>`

                // for input range update
                for (let i = 0; i < sub_c.length; i++) {
                    for (let j = i; j < sub_c.length; j++) {
                        if (i == j) continue;
                        for_update += `
                            <tr>
                                <td>${sub_c[i].name}</td>
                                <td>
                                <input type="hidden" name="criteria[]" value="${sub_c[i].id}-${sub_c[j].id}">
                                <input
                                    type="range"
                                    class="custom-range"
                                    min="-7"
                                    max="9"
                                    value="${(weight[sub_c[j].id][sub_c[i].id] >= 1) ? weight[sub_c[j].id][sub_c[i].id] : (weight[sub_c[i].id][sub_c[j].id] - 2) * -1}"
                                    id="range-${sub_c[i].id}-${sub_c[j].id}"
                                    name="range[]"
                                    onchange="changeRange('${sub_c[i].id}-${sub_c[j].id}', '${sub_c[i].name}', '${sub_c[j].name}')"
                                    onfocus="changeRange('${sub_c[i].id}-${sub_c[j].id}', '${sub_c[i].name}', '${sub_c[j].name}')"
                                    >
                                </td>
                                <td>${sub_c[j].name}</td>
                            </tr>
                        `
                    }
                }

                ci = (total_eigen_value-sub_c.length)/(total_total_normalized-1)
                cr = ci/parseFloat(data.ri)

                $('#table-for-update').html(for_update)
                $('#box-sub-criteria-table').html(str)
                $('#box-sub-criteria-table-normalized').html(str_normalized)
                $('#dmc-ri').text(Intl.NumberFormat('en-US').format(parseFloat(data.ri)))
                $('#dmc-ci').text(Intl.NumberFormat('en-US').format(ci))
                $('#dmc-cr').text(Intl.NumberFormat('en-US').format(cr) + ((cr < 0.1) ? ' [Consistent]' : ' [Inconsistent]'))
            },
            error: function(error) {
                // Handle errors
                console.error('Error:' + error);
            }
        });
    }

    $(document).ready(() => {
        changeCriteria(<?= $criteria[0]['id'] ?>)
    })
</script>
<?= $this->endSection() ?>