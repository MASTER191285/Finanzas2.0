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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-sccale=1, user-scalable=no">
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

      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>Yuri López V. &copy; 2017-2019</p>
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
                    $query = "SELECT sum(g.monto) AS TOTALES, tg.descripcion AS DESCRIPCION FROM gastos g INNER JOIN tipo_gasto tg ON g.id_tipo_gasto=tg.id  WHERE g.id_usuario=:id_usuario AND g.fecha BETWEEN :fechaini AND CURDATE() GROUP BY tg.descripcion";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam("fechaini", $first_day, PDO::PARAM_STR, 10);
                    $stmt->bindParam("id_usuario", $parametro,PDO::PARAM_INT);          
                    $stmt->execute(); 
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                      ['<?php echo $row['DESCRIPCION']?>'],
                    <?php 
                    }
                  ?>                
              ],
              borderWidth: [1, 1, 1],
              backgroundColor: ["#0074D9", "#2ECC40", "#FF4136", "#9F40FF", "#FFEAA3", "#B10DC9", "#e8c4ff", "#76ff9e", "#ff1153", "#a57600", "#30ffee", "#caff00", "#480068", "#c13c00", "#28006d", "#707300", "#001a6a", "#2cff08"],
              datasets: [
                  {
                      data: [
                        <?php
                          getcwd();       
                          $db = getDB();
                          $query = "SELECT ROUND(sum(g.monto) * 100.0 / (select monto from ingresos where id_tipo_ingreso = 1 and id_usuario=:id_usuario and fecha BETWEEN :fechaini AND CURDATE()),1) as PORCENTAJE
                          ,tg.descripcion AS DESCRIPCION FROM gastos g INNER JOIN tipo_gasto tg ON g.id_tipo_gasto=tg.id WHERE g.id_usuario=:id_usuario AND g.fecha BETWEEN :fechaini AND CURDATE() GROUP BY tg.descripcion ORDER BY tg.descripcion";
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
                      backgroundColor: ["#0074D9", "#2ECC40", "#FF4136", "#9F40FF", "#FFEAA3", "#B10DC9", "#e8c4ff", "#76ff9e", "#ff1153", "#a57600", "#30ffee", "#caff00", "#480068", "#c13c00", "#28006d", "#707300", "#001a6a", "#2cff08"],
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