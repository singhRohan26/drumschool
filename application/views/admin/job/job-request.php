<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fab fa-500px"></i> Job Request Management
            </div>
            <div class="card-body">
                <div id="res_status"></div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Company Name</th>
                                <th>Employee Type</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($jobrequest)) {
                                    $i = 1;
                                    foreach ($jobrequest as $jobrequests) {
                                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $jobrequests['company_name']; ?></td>
                                <td><?php echo $jobrequests['employee_type']; ?></td>
                                <td><?php echo $jobrequests['cname']; ?></td>
                                <td><?php echo $jobrequests['sname']; ?></td>
                                <td>
                                    <a data-placement="top" title="View Job" href="javascript:void(0)" data-toggle="modal" data-url="<?php echo base_url('Job/viewJobWrapper/'.$jobrequests['job_id']); ?>" class="view_job btn btn-info btn-sm"><i class="fas fa-eye"></i> View</a>
                                    <?php if ($jobrequests['status'] == 'Active') { ?>
                                        <a href="<?php echo base_url('admin/job/change_job_status/' . $jobrequests['job_id'] . '/Inactive'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Inactive" class="btn btn-primary btn-sm change-status">Active <i class="fa fa-thumbs-up"></i></a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url('admin/job/change_job_status/' . $jobrequests['job_id'] . '/Active'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Active" class="btn btn-warning btn-sm change-status">Inactive <i class="fa fa-thumbs-down"></i></a>
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