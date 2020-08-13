<div id="content-wrapper">
    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Study Type Listing</div>
                    <div class="card-body" id="content-wrappers" data-url="<?php echo base_url('admin/get_study_wrapper'); ?>">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <?php if(empty($study)){ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Add Study Type</div>
                    <?php }else{?>
                        <div class="card-header"><i class="fas fa-table"></i> Edit Study Type</div>
                    <?php } ?>
                    <div class="card-body">
                        <form method="post" id="common-form" action="<?php if (!empty($study)) { echo base_url('Experience/do_edit_study/' . $study['study_id']); } else { echo base_url('Experience/do_add_study'); } ?>">
                            <div id="error_msg"></div>
                            <div class="form-group">
                                <label>Study Type<sup>*</sup></label>
                                <input type="text" name="study_type" id="study_type" class="form-control" placeholder="Enter Study Type" value="<?php
                                          if (isset($study)) {
                                              echo $study['name'];
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