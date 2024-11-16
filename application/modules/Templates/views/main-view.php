<?php $this->load->view('header.php'); ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url('assets/dist/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata('user_name'); ?></p>
                -<?php echo $this->session->userdata('user_role'); ?>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">

            </div>
        </form>
        <!-- /.search form -->

        <?php if($this->session->userdata('user_role') == 'Administrator'): ?>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">MAIN NAVIGATION</li>

            <li><a href="<?php echo base_url('Dashboard'); ?>"><i class="fa fa-dashboard"></i>
                    <span>Dashboard</span></a></li>

            <!-- <li class="header">LABELS</li> -->

        </ul>

        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Employee Section</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="<?php echo base_url('User/addUserPage'); ?>"><i class="fa fa-circle-o"></i>
                            Add Employee </a></li>
                    <li class=""><a href="<?php echo base_url('User/viewUserPage'); ?>"><i class="fa fa-circle-o"></i>
                            View All Employee </a></li>
                    <li class=""><a href="<?php echo base_url('User/makeUserSeniorPage'); ?>"><i
                                class="fa fa-circle-o"></i> Make Employee's Senior </a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Item Master</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="<?php echo base_url('ItemMaster/addUserPage'); ?>"><i
                                class="fa fa-circle-o"></i>
                            Add Employee </a></li>
                    <li class=""><a href="<?php echo base_url('ItemMaster/viewItems'); ?>"><i
                                class="fa fa-circle-o"></i>
                            View All Items </a></li>
                    <!-- <li class=""><a href="<?php echo base_url('User/makeUserSeniorPage'); ?>"><i
                                class="fa fa-circle-o"></i> Make Employee's Senior </a></li> -->
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Cusomer Bill</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="<?php echo base_url('CustomerBill/addBillPage'); ?>"><i
                                class="fa fa-circle-o"></i>
                            Add Bill </a></li>
                    <li class=""><a href="<?php echo base_url('CustomerBill/viewBills'); ?>"><i
                                class="fa fa-circle-o"></i>
                            View All Bills </a></li>
                    <!-- <li class=""><a href="<?php echo base_url('User/makeUserSeniorPage'); ?>"><i
                                class="fa fa-circle-o"></i> Make Employee's Senior </a></li> -->
                </ul>
            </li>
            <!-- <li class="header">LABELS</li> -->

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file"></i> <span>To Do Tasks</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="<?php echo base_url('ToDo/addToDoPage'); ?>"><i class="fa fa-circle-o"></i>
                            Create ToDo Tasks</a></li>
                    <li class=""><a href="<?php echo base_url('ToDo/viewMyToDo'); ?>"><i class="fa fa-circle-o"></i>
                            View My ToDo Tasks </a></li>
                    <li class=""><a href="<?php echo base_url('ToDo/addToDoJuniorPage'); ?>"><i
                                class="fa fa-circle-o"></i> Assign Tasks </a></li>
                    <li class=""><a href="<?php echo base_url('ToDo/viewMyJuniorToDo'); ?>"><i
                                class="fa fa-circle-o"></i> View Employee's Tasks </a></li>
                </ul>
            </li>

        </ul>
        <?php endif; ?>

        <?php if($this->session->userdata('user_role') != 'Administrator'): ?>

        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">MAIN NAVIGATION</li>

            <li><a href="<?php echo base_url('Dashboard'); ?>"><i class="fa fa-dashboard"></i>
                    <span>Dashboard</span></a></li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file"></i> <span>To Do</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class=""><a href="<?php echo base_url('ToDo/addToDoPage'); ?>"><i class="fa fa-circle-o"></i>
                            Create ToDo Task </a></li>
                    <li class=""><a href="<?php echo base_url('ToDo/viewMyToDo'); ?>"><i class="fa fa-circle-o"></i>
                            View My ToDo Tasks </a></li>
                </ul>
            </li>

        </ul>

        <?php endif; ?>


    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php $this->load->view($content_view); ?>
</div>
<!-- /.content-wrapper -->
<?php $this->load->view('footer.php'); ?>