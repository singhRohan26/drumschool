<div id="res_status"></div>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Study Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($study)) {
                $i = 1;
                foreach ($study as $studies) {
                    ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $studies['name']; ?></td>
                <td>
                    <?php if ($studies['status'] == 'Active') { ?>
                        <a href="<?php echo base_url('admin/study/change_study_status/' . $studies['study_id'] . '/Inactive'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Inactive" class="btn btn-primary btn-sm change-status">Active <i class="fa fa-thumbs-up"></i></a>
                    <?php } else { ?>
                        <a href="<?php echo base_url('admin/study/change_study_status/' . $studies['study_id'] . '/Active'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Active" class="btn btn-danger btn-sm change-status">Inactive <i class="fa fa-thumbs-down"></i></a>
                    <?php } ?>
                    <a href="<?php echo base_url('admin/study/'. $studies['study_id']); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success btn-sm" title="Edit Industry Type">Edit <i class="fa fa-edit"></i></a>
                </td>
            </tr>
            <?php
                    $i++;
                }
            }
            ?>
        </tbody>
    </table>
</div>