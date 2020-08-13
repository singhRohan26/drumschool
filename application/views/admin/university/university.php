<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-university"></i>
                <a href="<?php echo base_url('admin/add-university'); ?>">Add University</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>University Name</th>
                                <th>University Image</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($university)) {
                                    $i = 1;
                                    foreach ($university as $universities) {
                                        ?>
                            <tr>
                                <td style="width: 20px"><?php echo $i; ?></td>
                                <td><?php echo $universities['university_name']; ?></td>
                                <td><img height="100" width="100" src="<?php echo base_url('uploads/university/' . $universities['image_url']); ?>"/></td>
                                <td><?php echo $universities['cname']; ?></td>
                                <td><?php echo $universities['sname']; ?></td>
                                <!-- <td><?php echo $universities['course']; ?></td> -->
                                <td>
                                    <a data-placement="top" title="View University" href="javascript:void(0)" data-toggle="modal" data-url="<?php echo base_url('University/viewUniversityWrapper/'.$universities['university_id']); ?>" class="view_job"><i class="fas fa-eye"></i> |</a>
                                    <a data-placement="top" title="Edit University" href="<?php echo base_url('admin/edit-university/'.$universities['university_id']); ?>"><i class="fas fa-edit"></i> |</a>
                                    <a data-placement="top" title="Delete University" class="delete-item" href="<?php echo base_url('University/doDeleteUniversity/'.$universities['university_id']); ?>"><i class="fas fa-trash"></i></a>
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