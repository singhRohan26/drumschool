<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <?php if(empty($university)){ ?>
                <li class="breadcrumb-item active">Add University</li>
            <?php }else{ ?>
                <li class="breadcrumb-item active">Edit University</li>
            <?php } ?>
        </ol>
        <div class="error_msg"></div>
        <!-- DataTables Example -->
        <div class="card mb-3">
            <?php if(empty($university)){ ?>
                <div class="card-header">Add University</div>
            <?php }else{ ?>
                <div class="card-header">Edit University</div>
            <?php } ?>
            <div class="card-body">
                <form method="post" id="image-common-form-new" action="<?php if (!empty($university)) { echo base_url('University/doUpdateUniversity/' . $university['university_id']); } else { echo base_url('University/doAddUniversity'); } ?>">
                    <div class="form-group">
                        <?php if(isset($university)){ $university_type = $university['university_type'];}?>
                        <span class="m-r-15"><input type="radio" name="university_type" value="top" <?php if(isset($university_type)){ if($university_type =='top'){?> checked <?php } }?>>Top</span>
                        <span><input type="radio" name="university_type" value="recommended" <?php if(isset($university_type)){ if($university_type =='recommended'){?> checked <?php } }?>>Recommended</span>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-label-group">
                                    <input type="text" id="university_name" name="university_name" class="form-control" placeholder="University Name" autofocus="autofocus" value="<?php
                                          if (isset($university)) {
                                              echo $university['university_name'];
                                          }
                                          ?>">
                                    <label for="university_name">University Name</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="file" id="image_url1" name="image_url1" class="form-control" placeholder="University Image" autofocus="autofocus">
                                            <label for="image_url1">University Image 1</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="file" id="image_url2" name="image_url2" class="form-control" placeholder="University Image" autofocus="autofocus">
                                            <label for="image_url2">University Image 2</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="file" id="image_url3" name="image_url3" class="form-control" placeholder="University Video" autofocus="autofocus">
                                            <label for="image_url3">University Video</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <select class="form-control select2" name="country" id="country" data-url="<?php echo base_url('University/filteredStates'); ?>">
                                                <option value="">Select Country</option>
                                                <?php foreach($country as $countries){ ?>
                                                    <option value="<?php echo $countries['id']; ?>"<?php if(!empty($university['country_id'])){ if($countries['id'] == $university['country_id']){ echo 'selected'; } } ?>><?php echo $countries['name']; ?></option>
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
                                        <div class="form-label-group">
                                            <select class="form-control select3" name="state" id="state"  data-url="<?php echo base_url('University/filteredCities'); ?>">
                                                <?php if(!empty($university['state_id'])){ foreach($states as $state){ ?>
                                                    <option value="<?php echo $state['id']; ?>" <?php if($university['state_id'] == $state['id']){ echo 'selected'; } ?>  ><?php echo $state['name']; ?></option>
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
                                        <div class="form-label-group">
                                            <select class="form-control select4" name="city" id="city">
                                                <?php if(!empty($university['city_id'])){ foreach($cities as $city){ ?>
                                                    <option value="<?php echo $city['id']; ?>" <?php if($university['city_id'] == $city['id']){ echo 'selected'; } ?>  ><?php echo $city['name']; ?></option>
                                                <?php } } ?>
                                            </select>
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
                                        <div class="form-label-group">
                                            <?php if(!empty($university['accomodation'])){ ?>
                                                <textarea name="accomodation" maxlength="250" id="accomodation" rows="10" cols="30"><?php echo $university['accomodation']; ?></textarea>
                                            <?php }else{ ?>
                                                <textarea name="accomodation" maxlength="250" id="accomodation" rows="10" cols="30"></textarea>
                                            <?php } ?>
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
                                            <?php if(!empty($university['about'])){ ?>
                                                <textarea name="description" maxlength="250" id="description" rows="10" cols="30"><?php echo $university['about']; ?></textarea>
                                            <?php }else{ ?>
                                                <textarea name="description" maxlength="250" id="description" rows="10" cols="30"></textarea>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0);" id="addsection"><i class="fa fa-plus pull-right" aria-hidden="true"></i></a>
                    <div class="sectionMore">
                        <div class="row newsection_chk" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-label-group">
                                                <select class="form-control select1231" name="course" id="course">
                                                    <option value="">Select Course</option>
                                                    <?php foreach($course as $courses){ ?>
                                                        <option value="<?php echo $courses['course_id']; ?>"><?php echo $courses['course_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="err_chk[]" value="">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-label-group">
                                                <input type="text" name="fee" id="fee" class="form-control" placeholder="Enter Fee" autofocus="autofocus">
                                                <label for="fee">Fee</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            if(!empty($count_university_course)){
                                $sr = 2;
                                foreach ($university_course as $count_university) {
                        ?>

                        <div class="row newsection">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-label-group">
                                                <select class="form-control select<?php echo $sr;?>" name="course<?php echo $sr;?>" id="course<?php echo $sr;?>">
                                                    <option value="">Select Course</option>
                                                    <?php foreach($course as $courses){ ?>
                                                        <option <?php if($courses['course_id'] == $count_university['course']){ echo "selected";}?> value="<?php echo $courses['course_id']; ?>"><?php echo $courses['course_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="err_chk[]" value="<?php echo $sr;?>">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-label-group">
                                                <input type="text" name="fee<?php echo $sr;?>" id="fee<?php echo $sr;?>" class="form-control" placeholder="Enter Fee" value="<?php echo $count_university['fee'];?>" autofocus="autofocus">
                                                <label for="fee2">Fee</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                if($sr != 2){
                            ?>
                            <a href="javascript:void(0);" class="remove">
                                <i class="fa fa-minus-square pull-right" data-active="<?php echo $sr;?>" aria-hidden="true"></i>
                            </a>
                            <?php
                                }
                            ?>
                        </div>
                                <?php
                                $sr++; }
                            } else{
                        ?>
                        <div class="row newsection">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-label-group">
                                                <select class="form-control select2" name="course2" id="course2">
                                                    <option value="">Select Course</option>
                                                    <?php foreach($course as $courses){ ?>
                                                        <option value="<?php echo $courses['course_id']; ?>"><?php echo $courses['course_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="err_chk[]" value="2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-label-group">
                                                <input type="text" name="fee2" id="fee2" class="form-control" placeholder="Enter Fee" autofocus="autofocus">
                                                <label for="fee2">Fee</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-danger btn-block" href="<?php echo base_url('admin/university'); ?>">Cancel</a>                        
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