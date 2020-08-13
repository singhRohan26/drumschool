<div id="res_status"></div>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Title</th>
                <th>Text</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($walkthrough)) {
                $i = 1;
                foreach ($walkthrough as $walkthroughs) {
                    ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><img height="100" width="100" src="<?php echo base_url('uploads/walkthrough/' . $walkthroughs['image_url']); ?>"/></td>
                <td><?php echo $walkthroughs['title']; ?></td>
                <td><?php echo substr($walkthroughs['text'],0,250); ?>...</td>
                <td>
                    <a data-placement="top" title="Edit Walkthrough" href="<?php echo base_url('admin/walkthrough/'.$walkthroughs['walkthrough_id']); ?>"><i class="fas fa-edit"></i> |</a>
                    <a data-placement="top" title="Delete Walkthrough" class="delete-item" href="<?php echo base_url('Admin/doDeleteWalkthrough/'.$walkthroughs['walkthrough_id']); ?>"><i class="fas fa-trash"></i></a>
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