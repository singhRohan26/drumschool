<section class="privacy main topScrl">
    <div class="container" >
        <div class="col-sm-6 nopadding col-sm-offset-3">
            <div class="reg_ryt boxs">
                <p class="error_msg"></p>
                <form method="post" name="common-form" id="update-forgot-password" action="<?php echo base_url('Api/update_forgot_password'); ?>">
                    <div class="formbox boxs">
                        <h2>Update password</h2>
                        <div class="regis boxs">
                            <div class="form-group">
                                <label for="password">New Password <sup>*</sup></label>
                                <input type="password" name="new_password"  class="form-control" id="new_password" placeholder="********">
                            </div>
                            <div class="form-group">
                                <label for="password">Confirm Password <sup>*</sup></label>
                                <input type="password" name="conf_password" class="form-control" id="conf_password" placeholder="********">
                            </div>
                            <input type="hidden" name="userid" value="<?php echo $user_id;?>" />
                            <div class="modalbtn boxs">
                                <button type="submit" class="regbtn slidehover"  name="loginbtn">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url('public/admin/'); ?>js/event.js"></script>