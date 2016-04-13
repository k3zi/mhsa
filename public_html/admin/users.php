<?php
require_once('/home/mhsa/includes/admin_include.php');
$page_title = 'Users';
$page_id = 2;

include('sections/header.php');
include('sections/sidebar.php');

$users = getUnblockedUsers();
?>

<style>
td, th {
    vertical-align: middle !important;
    text-align: center;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

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
            <table id="usersTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>AISD ID</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Twitter</th>
                <th>Awaiting New Name</th>
                <th>Options</th>
              </tr>
              </thead>
              <tbody>
              <?php foreach($users as $user) { ?>
                <tr>
                  <td><?=$user['user_id']?></td>
                  <td><?=$user['name']?></td>
                  <td><?=$user['aisd_id']?></td>
                  <td>
                      <?=$user['phone']?>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#message<?=$user['user_id']?>">message user</button>

                      <div class="modal fade" id="message<?=$user['user_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                         <div class="modal-dialog" role="document">
                              <form class="modal-content" method="post" action="/admin/sendUserMessage?userID=<?=$user['user_id']?>">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Message: <?=$user['name']?></h4>
                                  </div>

                                  <div class="modal-body form-group">
                                      <textarea class="form-control" name="text" placeholder="Message here..."></textarea>
                                  </div>

                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Send</button>
                                  </div>
                              </form>
                          </div>
                        </div>
                  </td>
                  <td><?=$user['email']?></td>
                  <td><?=$user['twitter_name']?></td>
                  <td><?=($user['waiting_name'] ? 'true' : 'false')?> - <a href="/admin/reportInvalidName?userID=<?=$user['user_id']?>">Report Invalid Name</a></td>
                  <td><a href="/admin/withdrawUser?userID=<?=$user['user_id']?>"><i class="fa fa-fw fa-close"></i></a></td>
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
</div>

<?php include('sections/footer.php'); ?>

<script>
  $(function () {
    $("#usersTable").DataTable();
  });
</script>

</body>
</html>
