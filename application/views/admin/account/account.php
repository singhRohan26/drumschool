<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-rupee-sign"></i> Account Management
            </div>
            <div class="card-body">
                <div id="res_status"></div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>User's Name</th>
                                <th>Email ID</th>
                                <th>Phone Number</th>
                                <th>Country</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($users)) {
                                    $i = 1;
                                    foreach ($users as $user) {
                                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['phone']; ?></td>
                                <td><?php echo $user['cname']; ?></td>
                                <td>
                                    <?php if ($user['payment_status'] == 'Active') { ?>
                                        <a href="<?php echo base_url('admin/account/change_account_status/' . $user['user_id'] . '/Inactive'); ?>" data-toggle="tooltip" data-placement="top" title="Change Payment Status to Inactive" class="btn btn-primary btn-sm change-status">Active <i class="fa fa-thumbs-up"></i></a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('admin/account/change_account_status/' . $user['user_id'] . '/Active'); ?>" data-toggle="tooltip" data-placement="top" title="Change Payment Status to Active" class="btn btn-danger btn-sm change-status">Inactive <i class="fa fa-thumbs-down"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                                $i++;
                            }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewjob" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="viewjob_wrapper">
            
        </div>
    </div>
</div>