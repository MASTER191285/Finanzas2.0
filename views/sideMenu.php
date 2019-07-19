    
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><img src="img/yo.jpg" alt="person" class="img-fluid rounded-circle">
            <h2 class="h5"><?php echo $userDetails->name; ?></h2><span>Web Developer</span>
            <h2></h2>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>

        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Menú</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="dashboard.php"> <i class="icon-home"></i>Inicio</a></li>            
            <li><a href="charts.html"> <i class="fa fa-bar-chart"></i>Gráficos</a></li>
            <li><a href="views/ingresos.php"> <i class="icon-grid"></i>Insertar Ingresos</a></li>
            <li><a href="views/gastos.php"> <i class="icon-grid"></i>Insertar Gastos</a></li>
            <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Mantenedores</a>
              <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li><a href="views/listarGastos.php">Listado de Gastos</a></li>
                <li><a href="#">Modificar Gastos</a></li>
                <li><a href="#">Modificar Ingresos</a></li>
              </ul>
            </li>
            <!--<li><a href="login.html"> <i class="icon-interface-windows"></i>Login page                             </a></li>
            <li> <a href="#"> <i class="icon-mail"></i>Demo
                <div class="badge badge-warning">6 New</div></a></li>-->
          </ul>
        </div>

        <!--<div class="admin-menu">
          <h5 class="sidenav-heading">Second menu</h5>
          <ul id="side-admin-menu" class="side-menu list-unstyled"> 
            <li> <a href="#"> <i class="icon-screen"> </i>Demo</a></li>
            <li> <a href="#"> <i class="icon-flask"> </i>Demo
                <div class="badge badge-info">Special</div></a></li>
            <li> <a href=""> <i class="icon-flask"> </i>Demo</a></li>
            <li> <a href=""> <i class="icon-picture"> </i>Demo</a></li>
          </ul>
        </div>-->
      </div>      
    </nav>