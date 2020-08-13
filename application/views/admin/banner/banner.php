<div id="content-wrapper">
    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Banner Listing</div>
                    <div class="card-body" id="content-wrappers" data-url="<?php echo base_url('admin/get-banner-wrapper'); ?>"> 
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header"><i class="fas fa-table"></i> Add Banner Image</div>
                    
                    <div class="card-body">
                        <form method="post" id="image-common-form-new" action="<?php echo base_url('Admin/do_add_banner'); ?>">
                            <div class="error_msg"></div>
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