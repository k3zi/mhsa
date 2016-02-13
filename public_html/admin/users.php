<?php
require_once('/home/mhsa/includes/admin_include.php');
$page_title = 'Users';
$page_id = 2;

include('sections/header.php');
include('sections/sidebar.php');

$users = DB::query('SELECT * FROM users');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">All Users</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Twitter</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($users as $user) { ?>
                  <tr>
                    <td><?=$users['user_id']?></td>
                    <td><?=$users['name']?></td>
                    <td><?=$users['phone']?></td>
                    <td><?=$users['email']?></td>
                    <td><?=$users['twitter_name']?></td>
                  </tr>
                  <?php } ?>
                </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
      </section>

<?php include('sections/footer.php'); ?>
