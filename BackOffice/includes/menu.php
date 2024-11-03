<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="m-0" href="#">
        <img src="images/logos/LogoBB_02.png" class="h-100" alt="<?php echo MARCA ?>" title="<?php echo MARCA ?>" style="max-width: 100%;">
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php echo strtolower($title) == "dashboard" ? ' active bg-gradient-success' : '' ?> " href="dashboard.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-chart-pie-35 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Administración</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (strtolower($archivoActual) == "usuarios" || strtolower($archivoActual) == "usuarios_editar") ? ' active bg-gradient-success' : '' ?>" href="usuarios.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Usuarios</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $archivoActual == "pagos" || $archivoActual == "pagos_editar" ? ' active bg-gradient-success' : '' ?>" href="pagos.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-credit-card text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Cobros/Pagos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $archivoActual == "deudas" || $archivoActual == "deudas_editar" ? ' active bg-gradient-success' : '' ?>" href="deudas.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-shop text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Deudas</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Capacitación</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $archivoActual == "cursos" || $archivoActual == "cursos_editar" ? ' active bg-gradient-success' : '' ?>" href="cursos.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-book-bookmark text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Cursos</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">TRavel</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $archivoActual == "viajes" || $archivoActual == "viajes_editar" ? ' active bg-gradient-success' : '' ?>" href="viajes.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-favourite-28 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Viajes</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Info estática</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $archivoActual == "pagos_rubros" || $archivoActual == "pagos_rubros_editar" ? ' active bg-gradient-success' : '' ?>" href="pagos_rubros.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Rubros</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $archivoActual == "pagos_subrubros" || $archivoActual == "pagos_subrubros_editar" ? ' active bg-gradient-success' : '' ?>" href="pagos_subrubros.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Subrubros</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $archivoActual == "deudaTipo_listado" || $archivoActual == "deudaTipo_listado_editar" ? ' active bg-gradient-success' : '' ?>" href="deudaTipo_listado.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Tipos deuda</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
      <div class="card card-plain shadow-none" id="sidenavCard">
        <!-- <img class="w-50 mx-auto" src="../assets/img/illustrations/icon-documentation.svg" alt="sidebar_illustration"> -->
        <div class="card-body text-center p-3 w-100 pt-0">
          <div class="docs-info">
            <h6 class="mb-0"></h6>
            <p class="text-xs font-weight-bold mb-0"></p>
          </div>
        </div>
      </div>
      <a href="logout.php" class="btn btn-secondary active w-100 mb-3">Salir</a>
    </div>
  </aside>