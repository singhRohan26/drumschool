<form method="post" id="common-form" action="<?php echo base_url('admin/doUpdateSettings/'.$settings['id']); ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Settings</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
    <div id="error_msg"></div>
        <div class="form-group boxs">
            <label>Title<sup>*</sup></label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo $settings['title']; ?>">
        </div>
    </div>
    <div class="modal-body">
        <div class="form-group boxs">
            <label>Description<sup>*</sup></label>
            <textarea rows="5" cols="5" name="description" id="description" class="form-control"><?php echo $settings['description']; ?></textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary">Submit</button>
    </div>
</form>