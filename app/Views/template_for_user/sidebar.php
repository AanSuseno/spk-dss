<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
      <img src="<?= base_url("dss-ikon.svg") ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DSS Collection</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="<?= session('picture') ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= session()->get('name') ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?= ($page_master == 'dashboard') ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link  <?= ($page_master == 'dashboard') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                HOME
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('dashboard') ?>" class="nav-link <?= ($page_sub == 'dashboard') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Home</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">DSS</li>
          <?php
          $dataDss = [
            [
              'url' => 'ahp',
              'color' => '#DBC4F0'
            ],
            [
              'url' => 'saw',
              'color' => '#FF6969'
            ],
            [
              'url' => 'wp',
              'color' => '#F9B572'
            ],
            [
              'url' => 'topsis',
              'color' => '#C683D7'
            ],
            [
              'url' => 'smart',
              'color' => '#99eb96'
            ],
          ];
          $dataDss = array_reverse($dataDss);
          ?>
          <?php foreach ($dataDss as $key => $value) : ?>
          <li class="nav-item <?= ($page_master == $value['url']) ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?= ($page_master == $value['url']) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-balance-scale" style="color: <?= $value['color'] ?>"></i>
              <p class="text-uppercase">
                <?= $value['url'] ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url($value['url']) ?>" class="nav-link <?= ($page_sub == $value['url'] . '-index') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Info</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('projects/'.$value['url']) ?>" class="nav-link <?= ($page_sub == $value['url'] . '-project') ? 'active' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>My Projects</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endforeach ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>