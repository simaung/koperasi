<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo base_url('home'); ?>" class="brand-link">
    <img src="<?= base_url('assets'); ?>/img/logo_kop.gif" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Koperasi</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url('assets'); ?>/vendor/AdminLTE-3.0.5/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div> -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item <?php echo ($menu == 'master') ? 'menu-open' : ''; ?>">
          <a href=" #" class="nav-link <?php echo ($menu == 'master') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Master Data
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('anggota'); ?>" class="nav-link <?php echo ($this->path == 'anggota') ? 'active' : ''; ?>">
                <i class=" fa fa-users nav-icon"></i>
                <p>Master Anggota</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('petugas'); ?>" class="nav-link <?php echo ($this->path == 'petugas') ? 'active' : ''; ?>">
                <i class="fa fa-user nav-icon"></i>
                <p>Master Petugas</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo ($menu == 'transaksi') ? 'menu-open' : ''; ?>">
          <a href=" #" class="nav-link <?php echo ($menu == 'transaksi') ? 'active' : ''; ?>">
            <i class="nav-icon fa fa-calculator"></i>
            <p>
              Transaksi
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url('simpanan'); ?>" class="nav-link <?php echo ($this->path == 'simpanan') ? 'active' : ''; ?>">
                <i class="far fa-save nav-icon"></i>
                <p>Tambah Simpanan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('pengambilan'); ?>" class="nav-link <?php echo ($this->path == 'pengambilan') ? 'active' : ''; ?>">
                <i class="fas fa-dollar-sign nav-icon"></i>
                <p>Ambil Simpanan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('pinjaman'); ?>" class="nav-link <?php echo ($this->path == 'pinjaman') ? 'active' : ''; ?>">
                <!-- <i class="far fa-circle nav-icon"></i> -->
                <i class="fas fa-dollar-sign nav-icon"></i>
                <p>Pinjaman</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url('kas'); ?>" class="nav-link <?php echo ($this->path == 'kas') ? 'active' : ''; ?>">
                <i class="fas fa-cash-register nav-icon"></i>
                <p>Kas</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item <?php echo ($menu == 'laporan') ? 'menu-open' : ''; ?>">
          <a href="<?php echo base_url('laporan'); ?>" class="nav-link <?php echo ($menu == 'laporan') ? 'active' : ''; ?>">
            <i class="far fa-file-pdf nav-icon"></i>
            <p>
              Laporan
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>