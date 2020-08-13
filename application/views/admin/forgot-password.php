<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Drumschool | <?php echo $title;?></title>

    <!-- Bootstrap core CSS-->
    <link href="<?php echo base_url('public/admin/vendor/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('public/admin/vendor/fontawesome-free/css/all.min.css');?>" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('public/admin/css/sb-admin.css');?>" rel="stylesheet">

  </head>

  <body class="bg-dark">
    <div class="loader-admin"></div>
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Reset Password</div>
        <div class="card-body">
          <div class="text-center mb-4">
            <h4>Forgot your password?</h4>
            <p>Enter your email address and we will send you the link to reset your password.</p>
          </div>
          <div id="error_msg"></div>
          <?php 
              $content = array('id' => 'common-form');
              echo form_open('admin/doForgotPassword', $content);
          ?>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="email" name="email" class="form-control" placeholder="Enter email address" autofocus="autofocus">
                <label for="email">Enter email address</label>
              </div>
            </div>
            <button class="btn btn-primary btn-block">Reset Password</button>
          <?php
              echo form_close();
          ?>
          <div class="text-center">
            <!-- <a class="d-block small mt-3" href="register.html">Register an Account</a> -->
            <a class="d-block small" href="<?php echo base_url('admin');?>">Login Page</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url('public/admin/vendor/jquery/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('public/admin/vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url('public/admin/vendor/jquery-easing/jquery.easing.min.js');?>"></script>
    <script src="<?php echo base_url('public/admin/');?>js/event.js"></script>

  </body>

</html>
