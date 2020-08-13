<div id="res_status"></div>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($category)) {
                $i = 1;
                foreach ($category as $categories) {
                    ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $categories['category_name']; ?></td>
                <td>
                    <?php if ($categories['status'] == 'Active') { ?>
                        <a href="<?php echo base_url('admin/category/change_category_status/' . $categories['job_category_id'] . '/Inactive'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Inactive" class="btn btn-primary btn-sm change-status">Active <i class="fa fa-thumbs-up"></i></a>
                    <?php } else { ?>
                        <a href="<?php echo base_url('admin/category/change_category_status/' . $categories['job_category_id'] . '/Active'); ?>" data-toggle="tooltip" data-placement="top" title="Change Status to Active" class="btn btn-danger btn-sm change-status">Inactive <i class="fa fa-thumbs-down"></i></a>
                    <?php } ?>
                    <a href="<?php echo base_url('admin/category/' . $categories['job_category_id']); ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success btn-sm" title="Edit Category">Edit <i class="fa fa-edit"></i></a>
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