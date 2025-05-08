<style>
  .nav-sidebar>.nav-item.menu-open>.nav-link,
  .nav-sidebar>.nav-item:hover>.nav-link,
  .nav-sidebar>.nav-item>.nav-link:focus {
    background-color: rgba(255, 255, 255, .1) !important;
    color: #fff !important;
    background: #28a745 !important;
  }

  .btn-modal {
    background-color: #F0483E !important;
    color: #fff !important;
  }
</style>
<div class="preloader flex-column justify-content-center align-items-center">
  <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
</div>


<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="dashboard.php" class="nav-link">Home</a>
    </li>
  </ul>


  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a href="#" id="logout-btn" class="btn btn-block btn-success btn-sm text-white">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </a>
    </li>
  </ul>

</nav>



<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <a href="index3.html" class="brand-link">
    <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SecurePharma</span>
  </a>


  <div class="sidebar">


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


    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="dashboard.php" class="nav-link active">
                <i class="fa-solid fa-chart-line nav-icon"></i>
                <p>Dashboard</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="inventory.php" class="nav-link">
            <i class="fa-solid fa-cash-register nva-icon"></i>
            Inventory
            </p>
          </a>
        </li>
        <li class="nav-header">Medicines</li>

        <!-- <li class="nav-item">
          <a href="pages/widgets.html" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Register Medicines
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li> -->

        <li class="nav-item">
          <a href="register.php" class="nav-link">
            <i class="nav-icon fa-solid fa-plus"></i>
            Medicines
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="stocks.php" class="nav-link">
            <i class=" nav-icon fa-brands fa-stack-overflow"></i>
            <p>
              Stocks
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="expired.php" class="nav-link">
            <i class="fa-regular fa-calendar-xmark nav-icon"></i>
            <p>
              Expired Medicine
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="reports.php" class="nav-link">
            <i class="fa-solid fa-chart-line nav-icon"></i>
            <p>
              Sales Reports
            </p>
          </a>
        </li>



        <!-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Reports
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="pages/examples/invoice.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Invoice</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/examples/profile.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/examples/e-commerce.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>E-commerce</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/examples/projects.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Projects</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/examples/project-add.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Project Add</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/examples/project-edit.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Project Edit</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/examples/project-detail.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Project Detail</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/examples/contacts.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Contacts</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/examples/faq.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>FAQ</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/examples/contact-us.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Contact us</p>
              </a>
            </li>
          </ul>
        </li> -->



      </ul>
    </nav>

  </div>

</aside>