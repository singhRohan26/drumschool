<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-book-open"></i> Library Management
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>User's Name</th>
                                <th>User's Email</th>
                                <th>Job Profile</th>
                                <th>Company Name</th>
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
                                <td style="width: 20px;"><?php echo $i; ?></td>
                                <td><?php echo $user['name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['role']; ?></td>
                                <td><?php echo $user['company_name']; ?></td>
                                <td><?php echo $user['cname']; ?></td>
                                <td>
                                    <a href="<?php echo base_url('admin/library/view/' .$user['job_apply_id']); ?>" data-toggle="tooltip" data-placement="top" class="" title="View Job Profile"><i class="fa fa-eye"></i></a>
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