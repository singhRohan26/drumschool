<form method="post" id="common-form" action="<?php if (!empty($faq)) { echo base_url('admin/doUpdateFaq/' . $faq['id']); } else { echo base_url('admin/doAddFaq'); } ?>">
    <div class="modal-header">
        <?php if(!empty($faq)){ ?>
            <h5 class="modal-title" id="exampleModalLabel">Edit FAQ</h5>
        <?php } else{ ?>
            <h5 class="modal-title" id="exampleModalLabel">Add FAQ</h5>
        <?php } ?>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
    <div id="error_msg"></div>
        <div class="form-group boxs">
            <label>Question<sup>*</sup></label>
            <input type="text" name="question" id="question" class="form-control" value="<?php
              if (isset($faq)) {
                  echo $faq['question'];
              }
              ?>">
        </div>
    </div>
    <div class="modal-body">
        <div class="form-group boxs">
            <label>Answer<sup>*</sup></label>
            <?php if (!empty($faq)) { ?>
                <textarea rows="5" cols="5" name="description" id="description" class="form-control"><?php echo $faq['answer']; ?></textarea>
            <?php } else{ ?>
                <textarea rows="5" cols="5" name="description" id="description" class="form-control"></textarea>
            <?php } ?>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary">Submit</button>
    </div>
</form>