<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="<?php echo base_url('public/images/school.png'); ?>">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Drumschool | <?php echo $title; ?></title>
        <!-- Bootstrap core CSS-->
        <link href="<?php echo base_url('public/admin/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="<?php echo base_url('public/admin/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
        <!-- Page level plugin CSS-->
        <link href="<?php echo base_url('public/admin/vendor/datatables/dataTables.bootstrap4.css'); ?>" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <!-- Custom styles for this template-->
        <link href="<?php echo base_url('public/admin/css/sb-admin.css'); ?>" rel="stylesheet">
    </head>
    <body id="page-top">
        <div class="loader-admin"></div>
        <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
            <a class="navbar-brand mr-1" href="<?php echo base_url('admin'); ?>">Drumschool</a>
            <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
                <i class="fas fa-bars"></i>
            </button>
            <!-- Navbar Search -->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <!-- <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div> -->
                </div>
            </form>
            <!-- Navbar -->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown no-arrow">
                    <?php if(!empty($admin['name'])){ ?>
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $admin['name']; ?>
                        </a>
                    <?php }else{ ?>
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle fa-fw"></i>
                        </a>
                    <?php } ?>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('admin/profile'); ?>">Admin Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url('admin/change-password'); ?>">Change Passsword</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item logout" href="<?php echo base_url('admin/logout'); ?>">Logout</a>
                    </div>
                </li>
            </ul>

        </nav>