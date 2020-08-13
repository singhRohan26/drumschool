<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Admin Profile</li>
        </ol>
        <div class="error_msg"></div>
        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header">Admin Profile</div>
            <div class="card-body">
                <?php
                $content = array('id' => 'image-common-form-new');
                echo form_open('admin/doUpdateProfile', $content);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-label-group">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Admin Name" autofocus="autofocus" value="<?php
                                              if (isset($admin)) {
                                                  echo $admin['name'];
                                              }
                                              ?>">
                                        <label for="name">Admin Name</label>
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
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Admin Email" autofocus="autofocus" readonly="" value="<?php
                                              if (isset($admin)) {
                                                  echo $admin['email'];
                                              }
                                              ?>">
                                        <label for="email">Admin Email</label>
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
                                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Admin Phone" autofocus="autofocus" value="<?php
                                              if (isset($admin)) {
                                                  echo $admin['phone'];
                                              }
                                              ?>">
                                        <label for="phone">Admin Phone</label>
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
                                        <input type="text" id="address" name="address" class="form-control" placeholder="Admin Address" autofocus="autofocus" value="<?php
                                              if (isset($admin)) {
                                                  echo $admin['address'];
                                              }
                                              ?>">
                                        <label for="address">Admin Address</label>
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
                                        <input type="text" id="region" name="region" class="form-control" placeholder="Admin Region" autofocus="autofocus" value="<?php
                                              if (isset($admin)) {
                                                  echo $admin['region'];
                                              }
                                              ?>">
                                        <label for="region">Admin Region</label>
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
                                        <input type="file" id="image_url" name="image_url" class="form-control" placeholder="Admin Image" autofocus="autofocus">
                                        <label for="image_url">Admin Image</label>
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
                                <textarea name="description" maxlength="250" id="description" rows="10" cols="30" value="<?php
                                    if (isset($admin)) {
                                        echo $admin['description'];
                                    }
                                ?>"><?php echo $admin['description']; ?></textarea>
                                <!-- <label for="description">Admin Description</label> -->
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btn-block">Submit</button>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>