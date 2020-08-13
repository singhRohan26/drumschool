<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">View Job</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>Company Logo: </label>
        <img height="100" width="100" src="<?php echo base_url('uploads/company-logo/' . $job['image_url']); ?>"/>
    </div>
    <div class="form-group">
        <label>Company Name: </label><?php echo $job['company_name']; ?>
    </div>
    <div class="form-group">
        <label>Country: </label><?php echo $job['cname']; ?>
    </div>
    <div class="form-group">
        <label>State: </label><?php echo $job['sname']; ?>
    </div>
    <div class="form-group">
        <label>Qualification Required: </label>
        <?php $noti = ""; foreach($job_qualification as $job_qualifications){ ?>
            <?php  $noti .= $job_qualifications['course_name'] . ','; ?>
        <?php } echo substr($noti, 0, -1); ?>
    </div>
    <div class="form-group">
        <label>Role: </label><?php echo $job['role']; ?>
    </div>
    <div class="form-group">
        <label>Employee Type: </label><?php echo $job['employee_type']; ?>
    </div>
    <div class="form-group">
        <label>Industry Type: </label><?php echo $job['industry_type']; ?>
    </div>
</div>
