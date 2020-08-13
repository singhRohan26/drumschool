<div id="content-wrapper">
    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Industry Type Listing</div>
                    <div class="card-body" id="content-wrappers" data-url="<?php echo base_url('admin/get-industry-wrapper'); ?>">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <?php if(empty($industry)){ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Add Industry Type</div>
                    <?php }else{ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Edit Industry Type</div>
                    <?php } ?>
                    <div class="card-body">
                        <form method="post" id="common-form" action="<?php if (!empty($industry)) { echo base_url('Experience/do_edit_industry/' . $industry['industry_type_id']); } else { echo base_url('Experience/do_add_industry'); } ?>">
                            <div id="error_msg"></div>
                            <div class="form-group">
                                <label>Industry Type<sup>*</sup></label>
                                <input type="text" name="industry_type" id="industry_type" class="form-control" placeholder="Enter Industry Type" value="<?php
                                          if (isset($industry)) {
                                              echo $industry['industry_type'];
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