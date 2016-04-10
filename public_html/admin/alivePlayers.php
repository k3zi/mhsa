<?php
require_once('/home/mhsa/includes/admin_include.php');
$page_title = 'Alive Players';
$page_id = 4;

include('sections/header.php');
include('sections/sidebar.php');

$users = DB::query('SELECT users.*, targetUsers.name as target, COUNT(k.kill_id) AS num_kills FROM users '.SYSTEM_SQL_STATS_JOIN.' LEFT JOIN users targetUsers ON users.target_id = targetUsers.user_id '.SYSTEM_SQL_IS_ALIVE.' AND '.SYSTEM_SQL_VALID_USER.' GROUP BY users.phone');
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
            <h3 class="box-title">Players</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="usersTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Target</th>
                <th>Status</th>
                <th>Kills</th>
                <th>Phone</th>
                <th>Commands</th>
              </tr>
              </thead>
              <tbody>
              <?php foreach($users as $user) { ?>
                <tr>
                  <td><?=$user['user_id']?></td>
                  <td><?=$user['name']?></td>
                  <td><?=$user['target']?></td>
                  <td><?=formatUserStatus($user)?></td>
                  <td><?=$user['num_kills']?></td>
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
                  <td>
                      <a class="btn btn-primary" href="/admin/userTextedDidEliminate?userID=<?=$user['user_id']?>">eliminated</a>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <a class="btn btn-primary" href="/admin/userTextedWasAssassinated?userID=<?=$user['user_id']?>">rip</a>
                      <hr>
                      <a class="btn btn-primary" href="/admin/userTextDidSuicide?userID=<?=$user['user_id']?>">suicide</a>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <a class="btn btn-primary" href="/admin/userForceWithdraw?userID=<?=$user['user_id']?>">withdraw</a>
                  </td>
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
