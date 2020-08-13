<div id="content-wrapper">
    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Category Listing</div>
                    <div class="card-body" id="content-wrappers" data-url="<?php echo base_url('admin/get-category-wrapper'); ?>">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <?php if(empty($category)){ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Add Category</div>
                    <?php }else{ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Edit Category</div>
                    <?php } ?>
                    <div class="card-body">
                        <form method="post" id="common-form" action="<?php if (!empty($category)) { echo base_url('Category/do_edit_category/' . $category['job_category_id']); } else { echo base_url('Category/do_add_category'); } ?>">
                            <div id="error_msg"></div>
                            <div class="form-group">
                                <label>Category Name<sup>*</sup></label>
                                <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Enter Category Name" value="<?php
                                          if (isset($category)) {
                                              echo $category['category_name'];
                                          }
                                          ?>">
                            </div>
                            <button class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>