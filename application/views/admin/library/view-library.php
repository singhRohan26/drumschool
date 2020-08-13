<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-book-open"></i> View Library
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr><b>User's Name:</b></tr> <?php echo $view_job_library['name']; ?><br>
                        <tr><b>User's E-mail Id:</b></tr> <?php echo $view_job_library['email']; ?><br>
                        <tr><b>User's Phone Number:</b></tr> <?php echo $view_job_library['phone']; ?><br>
                        <tr><b>User's Qualification:</b></tr> <?php echo $view_job_library['qualification']; ?><br>


                        <tr><b>Company Name:</b></tr> <?php echo $view_job_library['company_name']; ?><br>
                        <tr><b>Company Country Name:</b></tr> <?php echo $view_job_library['cname']; ?><br>
                        <tr><b>Company State Name:</b></tr> <?php echo $view_job_library['sname']; ?><br>
                        <tr><b>Company City Name:</b></tr> <?php echo $view_job_library['citname']; ?><br>
                        <tr><b>Job Location:</b></tr> <?php echo $view_job_library['location']; ?><br>
                        <tr><b>Experience Required:</b></tr> <?php echo $view_job_library['experience'].' '.'Years'; ?><br>
                        <tr><b>Job Role:</b></tr> <?php echo $view_job_library['role']; ?><br>
                        <?php if(!empty($view_job_library['salary'])){ ?>
                            <tr><b>Salary:</b></tr> <?php echo $view_job_library['salary']; ?><br>
                        <?php } else{ ?>
                            <tr><b>Salary:</b></tr> Not Disclosed<br>
                        <?php } ?>
                        <tr><b>Employee Type:</b></tr> <?php echo $view_job_library['employee_type']; ?><br>
                        <tr><b>Industry Type:</b></tr> <?php echo $view_job_library['industry_type']; ?><br>
                        <tr><b>Job Description:</b></tr> <?php echo $view_job_library['description']; ?><br>
                        <tr><b>Company Logo:</b></tr> <a href="<?php echo base_url('uploads/company-logo/' . $view_job_library['image_url']); ?>" download><img height="100" width="200" src="<?php echo base_url('uploads/company-logo/' . $view_job_library['image_url']); ?>"/></a><br>
                        <tr><b>Candidate Resume:</b></tr><?php echo $view_job_library['resume_file']; ?><a href="<?php echo base_url('uploads/resume/'.$view_job_library['resume_file']) ?>" download> Download>></a>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>