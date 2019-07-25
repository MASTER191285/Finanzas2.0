<?php
      require 'controllers/funciones.php';
      include('db/config.php');
      include('session.php');
      setlocale(LC_ALL,"es_ES");      
      $fecha = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1];
      $first_day = date('Y-m-01');                  
      $userDetails=$userClass->userDetails($session_uid);      
      /*Procedimientos Almacenados*/
      try {
            $db = getDB();
            $parametro = $session_uid;
            // execute the stored procedure
            $sql = 'CALL GET_TOTALESV2('.$parametro.')';
            // call the stored procedure
            $q = $db->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {
            die("Error occurred:" . $e->getMessage());
        }

        /**/
       try {
            $db = getDB();
            $parametro = $session_uid;
            // execute the stored procedure
            $sql = 'CALL INFO_DIARIA('.$parametro.')';
            // call the stored procedure
            $q2 = $db->query($sql);
            $q2->setFetchMode(PDO::FETCH_ASSOC);            
          } catch (PDOException $e) {
            die("Error occurred:" . $e->getMessage());
        }                    
      /*Fin Procedimientos Almacenados*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard Finanzas</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <?php include("views/cabeceras.php");?>
  </head>

  <body>
    <!-- Side Navbar -->    
    <?php include("views/sideMenu.php"); ?>
    <div class="page">
      <!-- navbar-->
    <?php include("views/header.php"); ?>
      <!-- Counts Section -->
      <section class="dashboard-counts section-padding">
        <div class="container-fluid">
          <div class="row">
            <!-- Count item widget-->
            <?php while ($r = $q->fetch()): ?>
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-padnote"></i></div>
                <div class="name"><strong class="text-uppercase">Total Ingresos</strong><span>Mes Actual</span>
                  <div class="count-number"><?php echo '$' . number_format($r['INGRESOS'], 0,",",".") ?></div>
                </div>
              </div>
            </div>                
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-user"></i></div>
                <div class="name"><strong class="text-uppercase">Total Gastos</strong><span>Mes Actual</span>
                  <div class="count-number"><?php echo '$' . number_format($r['GASTOS'], 0,",",".") ?></div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-check"></i></div>
                <div class="name"><strong class="text-uppercase">Total General</strong><span>Mes Actual</span>
                  <div class="count-number"><?php echo '$' . number_format($r['TOTAL'], 0,",",".") ?></div>
                </div>
              </div>
            </div>
            <?php endwhile; ?>

            <!-- Count item widget-->
          </div>
          <hr>
          <div class="row">
            <!-- Count item widget-->
            <?php while ($r2 = $q2->fetch()): ?>
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-padnote"></i></div>
                <div class="name"><strong class="text-uppercase">Alimentación</strong><span>Mes Actual</span>
                  <div class="count-number"><?php echo '$' . number_format($r2['GASTOS_ALIMENTACION'], 0,",",".") ?></div>
                </div>
              </div>
            </div>                
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-user"></i></div>
                <div class="name"><strong class="text-uppercase">Distracciones</strong><span>Mes Actual</span>
                  <div class="count-number"><?php echo '$' . number_format($r2['GASTOS_DISTRACCIONES'], 0,",",".") ?></div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-check"></i></div>
                <div class="name"><strong class="text-uppercase">Gastos Hormiga</strong><span>Mes Actual</span>
                  <div class="count-number"><?php echo '$' . number_format($r2['GASTOS_HORMIGA'], 0,",",".") ?></div>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
            <!-- Count item widget-->
          </div>
        </div>        
      </section>
      <!-- Header Section-->
      <section class="dashboard-header section-padding">
        <div class="container-fluid">
          <div class="row d-flex align-items-md-stretch">
            <!-- To Do List-->
            <div class="col-lg-6 col-md-6">
              <div class="card to-do">
                <h2 class="display h4">Últimos gastos registrados hoy, <?php echo $fecha; ?> </h2>
                <p>Total Gastado Hoy: <?php totalDiario($parametro); ?></p>
                <div class="table-responsive">
                  <div class="listaditoGastos">
                    <table class="table table-bordered">
                      <tr>
                        <th width="10%">Monto </th>
                        <th width="30%">Observaciones</th>
                        <th width="20%">Tipo de Gasto</th>
                      </tr>
                      <?php detalleDiario($parametro); ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>            
            <!-- Pie Chart-->
            <div class="col-lg-6 col-md-6">
              <div class="card project-progress">
                <h2 class="display h4">Gráfico de Gastos</h2>
                <p> Porcentaje Según Tipo.</p>
                <div class="pie-chart">
                  <canvas id="pieChart" width="300" height="300"> </canvas>
                </div>
              </div>
            </div>
      </section>
      <!-- Statistics Section-->
      <section class="statistics">
        <div class="container-fluid">
          <div class="row d-flex">
            <div class="col-lg-4">
              <!-- Income-->
              <div class="card income text-center">
                <div class="icon"><i class="icon-line-chart"></i></div>
                <div class="number">126,418</div><strong class="text-primary">All Income</strong>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit sed do.</p>
              </div>
            </div>
            <div class="col-lg-4">
              <!-- Monthly Usage-->
              <div class="card data-usage">
                <h2 class="display h4">Monthly Usage</h2>
                <div class="row d-flex align-items-center">
                  <div class="col-sm-6">
                    <div id="progress-circle" class="d-flex align-items-center justify-content-center"></div>
                  </div>
                  <div class="col-sm-6"><strong class="text-primary">80.56 Gb</strong><small>Current Plan</small><span>100 Gb Monthly</span></div>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
              </div>
            </div>
            <div class="col-lg-4">
              <!-- User Actibity-->
              <div class="card user-activity">
                <h2 class="display h4">User Activity</h2>
                <div class="number">210</div>
                <h3 class="h4 display">Social Users</h3>
                <div class="progress">
                  <div role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar bg-primary"></div>
                </div>
                <div class="page-statistics d-flex justify-content-between">
                  <div class="page-statistics-left"><span>Pages Visits</span><strong>230</strong></div>
                  <div class="page-statistics-right"><span>New Visits</span><strong>73.4%</strong></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Updates Section -->
      <section class="mt-30px mb-30px">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-4 col-md-12">
              <!-- Recent Updates Widget          -->
              <div id="new-updates" class="card updates recent-updated">
                <div id="updates-header" class="card-header d-flex justify-content-between align-items-center">
                  <h2 class="h5 display"><a data-toggle="collapse" data-parent="#new-updates" href="#updates-box" aria-expanded="true" aria-controls="updates-box">News Updates</a></h2><a data-toggle="collapse" data-parent="#new-updates" href="#updates-box" aria-expanded="true" aria-controls="updates-box"><i class="fa fa-angle-down"></i></a>
                </div>
                <div id="updates-box" role="tabpanel" class="collapse show">
                  <ul class="news list-unstyled">
                    <!-- Item-->
                    <li class="d-flex justify-content-between"> 
                      <div class="left-col d-flex">
                        <div class="icon"><i class="icon-rss-feed"></i></div>
                        <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                        </div>
                      </div>
                      <div class="right-col text-right">
                        <div class="update-date">24<span class="month">Jan</span></div>
                      </div>
                    </li>
                    <!-- Item-->
                    <li class="d-flex justify-content-between"> 
                      <div class="left-col d-flex">
                        <div class="icon"><i class="icon-rss-feed"></i></div>
                        <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                        </div>
                      </div>
                      <div class="right-col text-right">
                        <div class="update-date">24<span class="month">Jan</span></div>
                      </div>
                    </li>
                    <!-- Item-->
                    <li class="d-flex justify-content-between"> 
                      <div class="left-col d-flex">
                        <div class="icon"><i class="icon-rss-feed"></i></div>
                        <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                        </div>
                      </div>
                      <div class="right-col text-right">
                        <div class="update-date">24<span class="month">Jan</span></div>
                      </div>
                    </li>
                    <!-- Item-->
                    <li class="d-flex justify-content-between"> 
                      <div class="left-col d-flex">
                        <div class="icon"><i class="icon-rss-feed"></i></div>
                        <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                        </div>
                      </div>
                      <div class="right-col text-right">
                        <div class="update-date">24<span class="month">Jan</span></div>
                      </div>
                    </li>
                    <!-- Item-->
                    <li class="d-flex justify-content-between"> 
                      <div class="left-col d-flex">
                        <div class="icon"><i class="icon-rss-feed"></i></div>
                        <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                        </div>
                      </div>
                      <div class="right-col text-right">
                        <div class="update-date">24<span class="month">Jan</span></div>
                      </div>
                    </li>
                    <!-- Item-->
                    <li class="d-flex justify-content-between"> 
                      <div class="left-col d-flex">
                        <div class="icon"><i class="icon-rss-feed"></i></div>
                        <div class="title"><strong>Lorem ipsum dolor sit amet.</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                        </div>
                      </div>
                      <div class="right-col text-right">
                        <div class="update-date">24<span class="month">Jan</span></div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- Recent Updates Widget End-->
            </div>
            <div class="col-lg-4 col-md-6">
              <!-- Daily Feed Widget-->
              <div id="daily-feeds" class="card updates daily-feeds">
                <div id="feeds-header" class="card-header d-flex justify-content-between align-items-center">
                  <h2 class="h5 display"><a data-toggle="collapse" data-parent="#daily-feeds" href="#feeds-box" aria-expanded="true" aria-controls="feeds-box">Your daily Feeds </a></h2>
                  <div class="right-column">
                    <div class="badge badge-primary">10 messages</div><a data-toggle="collapse" data-parent="#daily-feeds" href="#feeds-box" aria-expanded="true" aria-controls="feeds-box"><i class="fa fa-angle-down"></i></a>
                  </div>
                </div>
                <div id="feeds-box" role="tabpanel" class="collapse show">
                  <div class="feed-box">
                    <ul class="feed-elements list-unstyled">
                      <!-- List-->
                      <li class="clearfix">
                        <div class="feed d-flex justify-content-between">
                          <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-5.jpg" alt="person" class="img-fluid rounded-circle"></a>
                            <div class="content"><strong>Aria Smith</strong><small>Posted a new blog </small>
                              <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                            </div>
                          </div>
                          <div class="date"><small>5min ago</small></div>
                        </div>
                      </li>
                      <!-- List-->
                      <li class="clearfix">
                        <div class="feed d-flex justify-content-between">
                          <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-2.jpg" alt="person" class="img-fluid rounded-circle"></a>
                            <div class="content"><strong>Frank Williams</strong><small>Posted a new blog </small>
                              <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                              <div class="CTAs"><a href="#" class="btn btn-xs btn-dark"><i class="fa fa-thumbs-up"> </i>Like</a><a href="#" class="btn btn-xs btn-dark"><i class="fa fa-heart"> </i>Love</a></div>
                            </div>
                          </div>
                          <div class="date"><small>5min ago</small></div>
                        </div>
                      </li>
                      <!-- List-->
                      <li class="clearfix">
                        <div class="feed d-flex justify-content-between">
                          <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-3.jpg" alt="person" class="img-fluid rounded-circle"></a>
                            <div class="content"><strong>Ashley Wood</strong><small>Posted a new blog </small>
                              <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                            </div>
                          </div>
                          <div class="date"><small>5min ago</small></div>
                        </div>
                      </li>
                      <!-- List-->
                      <li class="clearfix">
                        <div class="feed d-flex justify-content-between">
                          <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-1.jpg" alt="person" class="img-fluid rounded-circle"></a>
                            <div class="content"><strong>Jason Doe</strong><small>Posted a new blog </small>
                              <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                            </div>
                          </div>
                          <div class="date"><small>5min ago</small></div>
                        </div>
                        <div class="message-card"> <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</small></div>
                        <div class="CTAs pull-right"><a href="#" class="btn btn-xs btn-dark"><i class="fa fa-thumbs-up"> </i>Like</a></div>
                      </li>
                      <!-- List-->
                      <li class="clearfix">
                        <div class="feed d-flex justify-content-between">
                          <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img src="img/avatar-6.jpg" alt="person" class="img-fluid rounded-circle"></a>
                            <div class="content"><strong>Sam Martinez</strong><small>Posted a new blog </small>
                              <div class="full-date"><small>Today 5:60 pm - 12.06.2014</small></div>
                            </div>
                          </div>
                          <div class="date"><small>5min ago</small></div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- Daily Feed Widget End-->
            </div>
            <div class="col-lg-4 col-md-6">
              <!-- Recent Activities Widget      -->
              <div id="recent-activities-wrapper" class="card updates activities">
                <div id="activites-header" class="card-header d-flex justify-content-between align-items-center">
                  <h2 class="h5 display"><a data-toggle="collapse" data-parent="#recent-activities-wrapper" href="#activities-box" aria-expanded="true" aria-controls="activities-box">Recent Activities</a></h2><a data-toggle="collapse" data-parent="#recent-activities-wrapper" href="#activities-box" aria-expanded="true" aria-controls="activities-box"><i class="fa fa-angle-down"></i></a>
                </div>
                <div id="activities-box" role="tabpanel" class="collapse show">
                  <ul class="activities list-unstyled">
                    <!-- Item-->
                    <li>
                      <div class="row">
                        <div class="col-4 date-holder text-right">
                          <div class="icon"><i class="icon-clock"></i></div>
                          <div class="date"> <span>6:00 am</span><span class="text-info">6 hours ago</span></div>
                        </div>
                        <div class="col-8 content"><strong>Meeting</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.                </p>
                        </div>
                      </div>
                    </li>
                    <!-- Item-->
                    <li>
                      <div class="row">
                        <div class="col-4 date-holder text-right">
                          <div class="icon"><i class="icon-clock"></i></div>
                          <div class="date"> <span>6:00 am</span><span class="text-info">6 hours ago</span></div>
                        </div>
                        <div class="col-8 content"><strong>Meeting</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.                </p>
                        </div>
                      </div>
                    </li>
                    <!-- Item-->
                    <li>
                      <div class="row">
                        <div class="col-4 date-holder text-right">
                          <div class="icon"><i class="icon-clock"></i></div>
                          <div class="date"> <span>6:00 am</span><span class="text-info">6 hours ago</span></div>
                        </div>
                        <div class="col-8 content"><strong>Meeting</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.                </p>
                        </div>
                      </div>
                    </li>
                    <!-- Item-->
                    <li>
                      <div class="row">
                        <div class="col-4 date-holder text-right">
                          <div class="icon"><i class="icon-clock"></i></div>
                          <div class="date"> <span>6:00 am</span><span class="text-info">6 hours ago</span></div>
                        </div>
                        <div class="col-8 content"><strong>Meeting</strong>
                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.                </p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>Your company &copy; 2017-2019</p>
            </div>
            <div class="col-sm-6 text-right">
              <p>Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a></p>
              <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions and it helps me to run Bootstrapious. Thank you for understanding :)-->
            </div>
          </div>
        </div>
      </footer>
    </div>
        <!-- JavaScript files-->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/popper.js/umd/popper.min.js"> </script>
    <script src="css/dist/js/bootstrap.min.js"></script>
    <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="js/jquery.cookie/jquery.cookie.js"> </script>
    <script src="js/chart.js/Chart.min.js"></script>
    <script src="js/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- <script src="js/charts-home.js"></script> -->
    <script>
    $(document).ready(function () {
      /*Logica del Grafico Circular*/
      var brandPrimary = '#33b35a';
      var PIECHART = $('#pieChart');
      var myPieChart = new Chart(PIECHART, {
          type: 'doughnut',
          data: {
              labels: [
                <?php
                    getcwd();       
                    $db = getDB();
                    $query = "SELECT sum(g.monto) AS TOTALES, tg.descripcion AS DESCRIPCION FROM gastos g INNER JOIN tipo_gasto tg ON g.id_tipo_gasto=tg.id  WHERE g.id_usuario = 1 AND g.fecha BETWEEN '2019-07-01' AND CURDATE() GROUP BY tg.descripcion";
                    $stmt = $db->prepare($query);                
                    $stmt->execute(); 
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                      ['<?php echo $row['DESCRIPCION']?>'],
                    <?php 
                    }
                  ?>                  
              ],
              datasets: [
                  {
                      data: [
                        <?php
                          getcwd();       
                          $db = getDB();
                          $query = "SELECT ROUND(sum(g.monto) * 100.0 / (select monto from ingresos where id_tipo_ingreso = 1 and id_usuario=:id_usuario and fecha BETWEEN :fechaini AND CURDATE()),1) as PORCENTAJE
                          ,tg.descripcion AS DESCRIPCION FROM gastos g INNER JOIN tipo_gasto tg ON g.id_tipo_gasto=tg.id WHERE g.id_usuario=:id_usuario AND g.fecha BETWEEN :fechaini AND CURDATE() GROUP BY tg.descripcion";
                          $stmt = $db->prepare($query);
                          $stmt->bindParam("fechaini", $first_day, PDO::PARAM_STR, 10);
                          $stmt->bindParam("id_usuario", $parametro,PDO::PARAM_INT);                                  
                          $stmt->execute(); 
                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          ?>
                            ['<?php echo $row['PORCENTAJE']?>'],
                          <?php 
                          }
                        ?>
                      ],
                      borderWidth: [1, 1, 1],
                      backgroundColor: ["#0074D9", "#2ECC40", "#FF4136", "#9F40FF", "#FFEAA3", "#B10DC9"],
                      hoverBackgroundColor: [
                          brandPrimary,
                          "rgba(75,192,192,1)",
                          "#FFCE56"
                      ]
                  }]
          }
      });
      /*Fin Logica del Grafico Circular*/
    });
    </script>
    <!-- Main File-->
    <script src="js/front.js"></script>
  </body>
</html>