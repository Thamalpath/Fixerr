<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./dashboard.php" class="brand-link">
      <img src="dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DASHBOARD</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-4">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Category Option -->
          <li class="nav-item">
            <a href="" class="nav-link">
                <i class="nav-icon fas fa-th-large"></i>
                <p>
                    Category
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="./category.php" class="nav-link">
                        <i class="fas fa-list nav-icon"></i>
                        <p>All Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./category-add.php" class="nav-link">
                        <i class="fas fa-plus-circle nav-icon"></i>
                        <p>Add Category</p>
                    </a>
                </li>
            </ul>
        </li>
        <br>
        <!-- Sub Category Option -->
        <li class="nav-item">
            <a href="" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Sub Category
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                    <a href="./sub-category.php" class="nav-link">
                        <i class="fas fa-list nav-icon"></i>
                        <p>All Sub Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./sub-category-add.php" class="nav-link">
                        <i class="fas fa-plus-circle nav-icon"></i>
                        <p>Add Sub Category</p>
                    </a>
                </li>
            </ul>
        </li>
        <br>
        <!-- Orders Option -->
        <li class="nav-item">
              <a href="./professional.php" class="nav-link">
                  <i class="nav-icon fas fa-user-tie"></i>
                  <p>Professional</p>
              </a>
          </li>
          <br>
          <!-- Users Option -->
          <li class="nav-item">
              <a href="./customer.php" class="nav-link">
                  <i class="nav-icon fas fa-user"></i>
                  <p>Customer</p>
              </a>
          </li>
          <br>
          <!-- Service Option -->
          <li class="nav-item">
              <a href="./service.php" class="nav-link">
                  <i class="nav-icon fas fa-tools"></i>
                  <p>Service</p>
              </a>
          </li>
          <br>
          <!-- Message Option -->
          <li class="nav-item">
              <a href="./message.php" class="nav-link">
                  <i class="nav-icon fas fa-envelope"></i>
                  <p>Message</p>
              </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>