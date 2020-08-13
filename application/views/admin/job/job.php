<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-briefcase"></i>
                <a href="<?php echo base_url('admin/add-job'); ?>"> Add Job</a>
            </div>
            <div class="card-body">
            <div id="res_status"></div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Company Logo</th>
                                <th>Company Name</th>
                                <th>Employee Type</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($job)) {
                                    $i = 1;
                                    foreach ($job as $jobs) {
                                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><img height="100" width="100" src="<?php echo base_url('uploads/company-logo/' . $jobs['image_url']); ?>"/></td>
                                <td><?php echo $jobs['company_name']; ?></td>
                                <td><?php echo $jobs['employee_type']; ?></td>
                                <td><?php echo $jobs['cname']; ?></td>
                                <td><?php echo $jobs['sname']; ?></td>
                                <td>
                                    <?php if(empty($jobs['user_id'])){ ?>
                                        <a data-placement="top" title="View Job" href="javascript:void(0)" data-toggle="modal" data-url="<?php echo base_url('Job/viewJobWrapper/'.$jobs['job_id']); ?>" class="view_job btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                        <a data-placement="top" title="Edit Job" class="btn btn-success btn-sm" href="<?php echo base_url('admin/edit-job/'.$jobs['job_id']); ?>"><i class="fas fa-edit"></i> Edit</a>
                                        <a data-placement="top" title="Delete Job" class="btn btn-danger btn-sm delete-item" href="<?php echo base_url('Job/doDeleteJob/'.$jobs['job_id']); ?>"><i class="fas fa-trash"></i> Delete</a>
                                        <?php if ($jobs['status'] == 'Active') { ?>
                                            <a href="<?php echo base_url('admin/job/change_job_status/' . $jobs['job_id'] . '/Inactive'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Inactive" class="btn btn-primary btn-sm change-status">Active <i class="fa fa-thumbs-up"></i></a>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url('admin/job/change_job_status/' . $jobs['job_id'] . '/Active'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Active" class="btn btn-warning btn-sm change-status">Inactive <i class="fa fa-thumbs-down"></i></a>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <a data-placement="top" title="View Job" href="javascript:void(0)" data-toggle="modal" data-url="<?php echo base_url('Job/viewJobWrapper/'.$jobs['job_id']); ?>" class="view_job btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                        <?php if ($jobs['status'] == 'Active') { ?>
                                            <a href="<?php echo base_url('admin/job/change_job_status/' . $jobs['job_id'] . '/Inactive'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Inactive" class="btn btn-primary btn-sm change-status">Active <i class="fa fa-thumbs-up"></i></a>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url('admin/job/change_job_status/' . $jobs['job_id'] . '/Active'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Active" class="btn btn-warning btn-sm change-status">Inactive <i class="fa fa-thumbs-down"></i></a>
                                        <?php } ?>
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