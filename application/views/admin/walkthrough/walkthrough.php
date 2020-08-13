<div id="content-wrapper">
    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Walkthrough Listing</div>
                    <div class="card-body" id="content-wrappers" data-url="<?php echo base_url('Admin/get_walkthrough_wrapper'); ?>"> 
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <?php if(empty($walkthrough)){ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Add Walkthrough</div>
                    <?php }else{ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Edit Walkthrough</div>
                    <?php } ?>
                    
                    <div class="card-body">
                        <form method="post" id="image-common-form-new" action="<?php if (!empty($walkthrough)) { echo base_url('Admin/do_edit_walkthrough/' . $walkthrough['walkthrough_id']); } else { echo base_url('Admin/do_add_walkthrough'); } ?>">
                            <div class="error_msg"></div>
                            <div class="form-group">
                                <label>Title<sup>*</sup></label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Walkthrough Title" value="<?php if (isset($walkthrough)) { echo $walkthrough['title']; } ?>">
                            </div>
                            <div class="form-group">
                                <label>Text<sup>*</sup></label>
                                <?php if(!empty($walkthrough['text'])){ ?>
                                    <textarea name="description" maxlength="250" id="description" rows="10" cols="30"><?php echo $walkthrough['text']; ?></textarea>
                                <?php }else{ ?>
                                    <textarea name="description" maxlength="250" id="description" rows="10" cols="30"></textarea>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label>Banner Image<sup>*</sup></label>
                                <input type="file" name="image_url" id="image_url" class="form-control" placeholder="Upload Banner Image">
                            </div>
                            <button class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>