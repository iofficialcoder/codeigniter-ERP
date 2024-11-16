<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Admin Panel</small>
  </h1>
</section>

<!-- Main content -->
<section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $countEmployees; ?></h3>

              <p>Total Employees</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-people"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $countTasks; ?>/<?php echo $countTasksAssigned; ?></h3>

              <p>Total Task/Assigned</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-albums"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $countTasksDone; ?></h3>

              <p>Task Done</p>
            </div>
            <div class="icon">
              <i class="ion ion-checkmark-circled"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $countTasksPending;?></h3>

              <p>Task Pending</p>
            </div>
            <div class="icon">
              <i class="ion ion-load-a"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
      </div>
</section>

<!-- /.content -->
