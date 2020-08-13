<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-cogs"></i> Site Settings
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($settings)) {
                                    $i = 1;
                                    foreach ($settings as $setting) {
                                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $setting['title']; ?></td>
                                <td title="<?php echo strip_tags($setting['description']); ?>"><?php echo substr($setting['description'], 0, 400); ?>....</td>
                                <td><a data-placement="top" title="Edit Settings" data-url="<?php echo base_url('admin/settingWrapper/'. $setting['id']);?>" href="javascript:void(0)" class="edit_settings" data-toggle="modal"><i class="fas fa-edit"></i></a></td>
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

<div class="modal fade" id="settings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="set_wrap">
            
        </div>
    </div>
</div>