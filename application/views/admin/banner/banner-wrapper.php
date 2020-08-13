<div id="res_status"></div>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Id</th>
                <th>Banner Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($banner)) {
                $i = 1;
                foreach ($banner as $banners) {
                    ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><img height="100" width="100" src="<?php echo base_url('uploads/banner/' . $banners['image_url']); ?>"/></td>
                <td>
                    <a data-placement="top" title="Delete Banner" class="delete-item" href="<?php echo base_url('Admin/doDeleteBanner/'.$banners['banner_id']); ?>"><i class="fas fa-trash"></i></a>
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