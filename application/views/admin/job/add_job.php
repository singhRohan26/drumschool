<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <?php if(empty($job)){ ?>
                <li class="breadcrumb-item active"> Add Job</li>
            <?php }else{ ?>
                <li class="breadcrumb-item active"> Edit Job</li>
            <?php } ?>
        </ol>
        <div class="error_msg"></div>
        <div class="card mb-3">
            <?php if(empty($job)){ ?>
                <div class="card-header">Add Job</div>
            <?php }else{ ?>
                <div class="card-header">Edit Job</div>
            <?php } ?>
            <div class="card-body">
                <form method="post" id="image-common-form-new" action="<?php if (!empty($job)) { echo base_url('Job/doEditJob/' . $job['job_id']); } else { echo base_url('Job/doAddJob'); } ?>">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <input type="text" id="company_name" name="company_name" class="form-control" placeholder="Company Name" autofocus="autofocus" value="<?php
                                          if (isset($job)) {
                                              echo $job['company_name'];
                                          }
                                          ?>">
                                    <label for="company_name">Company Name</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label>Country</label>
                                        <div class="form-label-group">
                                            <select class="form-control select2" name="country" id="country" data-url="<?php echo base_url('Job/filteredStates'); ?>">
                                                <option value="">Select Country</option>
                                                <?php foreach($country as $countries){ ?>
                                                    <option value="<?php echo $countries['id']; ?>"<?php if(!empty($job['country_id'])){ if($countries['id'] == $job['country_id']){ echo 'selected'; } } ?>><?php echo $countries['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label>State</label>
                                        <div class="form-label-group">
                                            <select class="form-control select3" name="state" id="state" data-url="<?php echo base_url('Job/filteredCities'); ?>">
                                                <?php if(!empty($job['state_id'])){ foreach($states as $state){ ?>
                                                    <option value="<?php echo $state['id']; ?>" <?php if($job['state_id'] == $state['id']){ echo 'selected'; } ?>  ><?php echo $state['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label>City</label>
                                        <div class="form-label-group">
                                            <select class="form-control select4" name="city" id="city">
                                                <?php if(!empty($job['city_id'])){ foreach($cities as $city){ ?>
                                                    <option value="<?php echo $city['id']; ?>" <?php if($job['city_id'] == $city['id']){ echo 'selected'; } ?>  ><?php echo $city['name']; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <input type="text" id="location" name="location" class="form-control" placeholder="Job Location Required" autofocus="autofocus" value="<?php
                                          if (isset($job)) {
                                              echo $job['location'];
                                          }
                                          ?>">
                                    <label for="location">Address</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <input type="text" id="role" name="role" class="form-control" placeholder="Role" autofocus="autofocus" value="<?php
                                          if (isset($job)) {
                                              echo $job['role'];
                                          }
                                          ?>">
                                    <label for="role">Role</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Qualification</label>
                                <div class="form-label-group">
                                    <select class="form-control select5" name="qualification[]" id="qualification" multiple>
                                        <option value="">Select Qualification</option>
                                        <?php foreach($qualification as $qualifications){ ?>
                                            <option value="<?php echo $qualifications['course_id']; ?>"<?php  if(!empty($job_qualification)){ foreach ($job_qualification as $job_qualifications) { if($qualifications['course_id']==$job_qualifications['qualification_id']){ echo 'selected'; } }}?>><?php echo $qualifications['course_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Employee Type</label>
                                <div class="form-label-group">
                                    <select class="form-control select2" name="employee_type" id="employee_type">
                                        <option value="">Select Employee Type</option>
                                        <?php foreach($employee_type as $employee_types){ ?>
                                            <option value="<?php echo $employee_types['employee_type_id']; ?>"<?php if(!empty($job['employee_type_id'])){ if($employee_types['employee_type_id'] == $job['employee_type_id']){ echo 'selected'; } } ?>><?php echo $employee_types['employee_type']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label>Industry Type</label>
                                        <div class="form-label-group">
                                            <select class="form-control select3" name="industry_type" id="industry_type">
                                                <option value="">Select Industry Type</option>
                                                <?php foreach($industry_type as $industry_types){ ?>
                                                    <option value="<?php echo $industry_types['industry_type_id']; ?>"<?php if(!empty($job['industry_type_id'])){ if($industry_types['industry_type_id'] == $job['industry_type_id']){ echo 'selected'; } } ?>><?php echo $industry_types['industry_type']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="text" id="salary" name="salary" class="form-control" placeholder="Industry Type" autofocus="autofocus" value="<?php
                                                  if (isset($job)) {
                                                      echo $job['salary'];
                                                  }
                                                  ?>">
                                            <label for="salary">Salary</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label>Experience</label>
                                        <div class="form-label-group">
                                            <select class="form-control select4" name="experience" id="experience">
                                                <option value="">Select Experience</option>
                                                <?php foreach($experience as $experiences){ ?>
                                                    <option value="<?php echo $experiences['experience_id']; ?>"<?php if(!empty($job['experience_id'])){ if($experiences['experience_id'] == $job['experience_id']){ echo 'selected'; } } ?>><?php echo $experiences['experience']; ?> Years</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="file" id="image_url" name="image_url" class="form-control" placeholder="Company Logo" autofocus="autofocus">
                                            <label for="image_url">Company Logo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <?php if(!empty($job['description'])){ ?>
                                        <textarea name="description" maxlength="250" id="description" rows="10" cols="30"><?php echo $job['description']; ?></textarea>
                                    <?php }else{ ?>
                                        <textarea name="description" maxlength="250" id="description" rows="10" cols="30"></textarea>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-danger btn-block" href="<?php echo base_url('admin/job'); ?>">Cancel</a>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary btn-block">Save and Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>