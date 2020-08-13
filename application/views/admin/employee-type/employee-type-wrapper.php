<div id="res_status"></div>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Employee Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($employee)) {
                $i = 1;
                foreach ($employee as $employees) {
                    ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $employees['employee_type']; ?></td>
                <td>
                    <?php if ($employees['status'] == 'Active') { ?>
                        <a href="<?php echo base_url('admin/employee/change_employee_status/' . $employees['employee_type_id'] . '/Inactive'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Inactive" class="btn btn-primary btn-sm change-status">Active <i class="fa fa-thumbs-up"></i></a>
                    <?php } else { ?>
                        <a href="<?php echo base_url('admin/employee/change_employee_status/' . $employees['employee_type_id'] . '/Active'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Active" class="btn btn-danger btn-sm change-status">Inactive <i class="fa fa-thumbs-down"></i></a>
                    <?php } ?>
                    <a href="<?php echo base_url('admin/employee/' . $employees['employee_type_id']); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success btn-sm" title="Edit Employee Type">Edit <i class="fa fa-edit"></i></a>
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