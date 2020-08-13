<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-bell"></i>
                <a class="notify" href="<?php echo base_url('Notification/setUserInNotification'); ?>"> Send Notification</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="check"/></th>
                                <th>ID</th>
                                <th>User's Name</th>
                                <th>User's Email</th>
                                <th>Phone Number</th>
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
                                <td><input type="checkbox" class="users_id" name="user_id[]" value="<?php echo $user['user_id']; ?>"/></td>
                                <td style="width: 20px;"><?php echo $i; ?></td>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['phone']; ?></td>
                                <td>
                                    <a href="<?php echo base_url('admin/view-user-notification/' .$user['user_id']); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success" title="View Notification">View Notifications <i class="fa fa-eye"></i></a>
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

<div class="modal" id="notificationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Send Notification</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="error_msg"></p>
                <div id="send-notification-wrapper"></div>
            </div>
        </div>
    </div>
</div>