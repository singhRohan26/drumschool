<div id="content-wrapper">
    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Experience Listing</div>
                    <div class="card-body" id="content-wrappers" data-url="<?php echo base_url('admin/get-experience-wrapper'); ?>">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <?php if(empty($experience)){ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Add Experience</div>
                    <?php }else{ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Edit Experience</div>
                    <?php } ?>
                    <div class="card-body">
                        <form method="post" id="common-form" action="<?php if (!empty($experience)) { echo base_url('Experience/do_edit_experience/' . $experience['experience_id']); } else { echo base_url('Experience/do_add_experience'); } ?>">
                            <div id="error_msg"></div>
                            <div class="form-group">
                                <label>Experience<sup>*</sup><small>(In Years)</small></label>
                                <input type="text" name="experience" id="experience" class="form-control" placeholder="Enter Experience" value="<?php
                                          if (isset($experience)) {
                                              echo $experience['experience'];
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