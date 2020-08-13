<div id="content-wrapper">
    <div class="container-fluid">
        <!-- DataTables Example -->
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header"><i class="fas fa-certificate"></i> Course Listing</div>
                    <div class="card-body" id="content-wrappers" data-url="<?php echo base_url('admin/get-course-wrapper'); ?>">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <?php if(empty($course)){ ?>
                        <div class="card-header"><i class="fas fa-certificate"></i> Add Course</div>
                    <?php }else{ ?>
                        <div class="card-header"><i class="fas fa-certificate"></i> Edit Course</div>
                    <?php } ?>
                    <div class="card-body">
                        <form method="post" id="common-form" action="<?php if (!empty($course)) { echo base_url('Category/do_edit_course/' . $course['course_id']); } else { echo base_url('Category/do_add_course'); } ?>">
                            <div id="error_msg"></div>
                            <div class="form-group">
                                <label>Course Name<sup>*</sup></label>
                                <input type="text" name="course_name" id="course_name" class="form-control" placeholder="Enter Course Name" value="<?php
                                          if (isset($course)) {
                                              echo $course['course_name'];
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