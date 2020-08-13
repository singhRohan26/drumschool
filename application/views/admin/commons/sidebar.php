<div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item <?php if($title=='Dashboard'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- <li class="nav-item <?php if($title=='Category Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/category'); ?>">
                <i class="fa fa-list-alt"></i>
                <span>Job Category Management</span>
            </a>
        </li> -->
        <li class="nav-item <?php if($title=='Experience Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/experience'); ?>">
                <i class="fa fa-history"></i>
                <span>Experience Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Industry Type Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/industry'); ?>">
                <i class="fa fa-industry"></i>
                <span>Industry Type Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Study Type Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/study'); ?>">
                <i class="fa fa-industry"></i>
                <span>Study Type Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Employee Type Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/employee'); ?>">
                <i class="fa fa-industry"></i>
                <span>Employee Type Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Course Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/course'); ?>">
                <i class="fas fa-certificate"></i>
                <span>Courses Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Account Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/account'); ?>">
                <i class="fas fa-rupee-sign"></i>
                <span>Account Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='University Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/university'); ?>">
                <i class="fas fa-university"></i>
                <span>University Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Job Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/job'); ?>">
                <i class="fas fa-briefcase"></i>
                <span>Job Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Request Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/job_request'); ?>">
                <i class="fab fa-500px"></i>
                <span>Job Request Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Library Management'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/library'); ?>">
                <i class="fas fa-book-open"></i>
                <span>CV Library Management</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Notification'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/notification'); ?>">
                <i class="fas fa-bell"></i>
                <span>Notification</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Banner'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/banner'); ?>">
                <i class="fas fa-image"></i>
                <span>Banner</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Walkthrough'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/walkthrough'); ?>">
                <i class="fas fa-bolt"></i>
                <span>Walkthrough</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=='Site Settings'){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/settings'); ?>">
                <i class="fas fa-cogs"></i>
                <span>Settings</span>
            </a>
        </li>
        <li class="nav-item <?php if($title=="FAQ's"){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo base_url('admin/faq'); ?>">
                <i class="far fa-question-circle"></i>
                <span>FAQ's</span>
            </a>
        </li>
    </ul>