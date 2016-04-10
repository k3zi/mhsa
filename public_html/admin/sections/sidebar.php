<?php if(!$page_id) die();

function activeFor($id) {
  global $page_id;
  return $page_id == $id ? ' class="active"' : '';
}

?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li<?=activeFor(1)?>>
        <a href="/admin/">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <li<?=activeFor(2)?>>
        <a href="/admin/users">
          <i class="fa fa-user"></i> <span>All Users</span>
        </a>
      </li>

      <li<?=activeFor(3)?>>
        <a href="/admin/players">
          <i class="fa fa-user"></i> <span>All Players</span>
        </a>
      </li>

      <li<?=activeFor(4)?>>
        <a href="/admin/alivePlayers">
          <i class="fa fa-user"></i> <span>Alive Players</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
