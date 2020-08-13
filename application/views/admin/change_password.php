<div class="container">
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">Change Password</div>
        <div class="card-body">
            <div id="error_msg"></div>
            <?php
            $content = array('id' => 'common-form');
            echo form_open('admin/doChangePass', $content);
            ?>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-label-group">
                            <input type="password" id="opass" name="opass" class="form-control" placeholder="Old Password" autofocus="autofocus">
                            <label for="opass">Old Password</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input type="password" id="npass" name="npass" class="form-control" placeholder="New Password">
                    <label for="npass">New Password</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-label-group">
                            <input type="password" id="cpass" name="cpass" class="form-control" placeholder="Confrim Password">
                            <label for="cpass">Confrim Password</label>
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