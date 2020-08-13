<div id="content-wrapper">
    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Employee Type Listing</div>
                    <div class="card-body" id="content-wrappers" data-url="<?php echo base_url('admin/get-employee-wrapper'); ?>">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <?php if(empty($employee)){ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Add Employee Type</div>
                    <?php }else{ ?>
                        <div class="card-header"><i class="fas fa-table"></i> Edit Employee Type</div>
                    <?php } ?>
                    <div class="card-body">
                        <form method="post" id="common-form" action="<?php if (!empty($employee)) { echo base_url('Experience/do_edit_employee/' . $employee['employee_type_id']); } else { echo base_url('Experience/do_add_employee'); } ?>">
                            <div id="error_msg"></div>
                            <div class="form-group">
                                <label>Employee Type<sup>*</sup></label>
                                <input type="text" name="employee_type" id="employee_type" class="form-control" placeholder="Enter Employee Type" value="<?php
                                          if (isset($employee)) {
                                              echo $employee['employee_type'];
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