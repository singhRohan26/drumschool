<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">View University</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label><b>University Name: </b></label> <?php echo $university['university_name']; ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label><b>Image: </b></label><br>
                <?php foreach($university_images as $university_image){ 
                    $image = explode('.', $university_image['media']);
                    $arr = array('mp4', '3gp', 'mov', 'wmv', 'webm');
                    if(in_array($image[1], $arr)){ ?>
                        <video width="320" height="240" controls><source src="<?php echo base_url('uploads/university/' . $university_image['media']); ?>"></video>
                <?php }else{ ?>
                    <img height="100" width="100" src="<?php echo base_url('uploads/university/' . $university_image['media']); ?>"/>
                <?php } }?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><b>Country: </b></label> <?php echo $university['cname']; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><b>State: </b></label> <?php echo $university['sname']; ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label><b>About: </b></label> <?php echo $university['about']; ?>
    </div>
    <div class="form-group">
        <label><b>Accomodation: </b></label> <?php echo $university['accomodation']; ?>
    </div>
</div>
