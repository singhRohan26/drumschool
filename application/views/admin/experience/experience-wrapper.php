<div id="res_status"></div>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Experience</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($experience)) {
                $i = 1;
                foreach ($experience as $experiences) {
                    ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $experiences['experience']; ?> years</td>
                <td>
                    <?php if ($experiences['status'] == 'Active') { ?>
                        <a href="<?php echo base_url('admin/experience/change_experience_status/' . $experiences['experience_id'] . '/Inactive'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Inactive" class="btn btn-primary btn-sm change-status">Active <i class="fa fa-thumbs-up"></i></a>
                    <?php } else { ?>
                        <a href="<?php echo base_url('admin/experience/change_experience_status/' . $experiences['experience_id'] . '/Active'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Active" class="btn btn-danger btn-sm change-status">Inactive <i class="fa fa-thumbs-down"></i></a>
                    <?php } ?>
                    <a href="<?php echo base_url('admin/experience/' . $experiences['experience_id']); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success btn-sm" title="Edit Category">Edit <i class="fa fa-edit"></i></a>
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