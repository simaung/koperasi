<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <?php echo ucfirst($this->authData['nama']) . ' - ' . $this->authData['level']; ?>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="<?php echo base_url('auth/logout'); ?>" class="dropdown-item">
          Logout
        </a>
        <div class="dropdown-divider"></div>
      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->