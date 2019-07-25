<?php 
require '../controllers/funciones.php';
include('../db/config.php');
include('../session.php');
$userDetails=$userClass->userDetails($session_uid);
$mesActual = $meses[date('n')-1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ingresos</title>
	<link rel="stylesheet" href="../css/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/estilos.css">	
	  <!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
  	<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script> 
</head>
<body class="bg-dark">
<div class="container">
    <div class="jumbotron">
    <h1 class="display-4">Registro de Balance Mensual</h1>
    <p class="lead">Correspondiente al Mes de <?php echo $mesActual; ?></p>  
    <h1>Bienvenido <?php echo $userDetails->name; ?></h1>
    </div>
    <div class="col-sm-3 pull-right"><button type="button" class="btn btn-secondary volver" onclick="window.location.href='../dashboard.php'" >Volver al Dashboard</button></div>
    <fieldset>	
	<!-- <legend id="titulo">Ingreso a Registrar</legend> -->
        <?php 
            if ($_POST) { 
                insertarIngreso();
            }
        ?>
    <div class="row mt-3">    
        <div class="col">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="form-group row">
                <div class="col-12 col-md-6 mb-3">
                    <h4>Entradas: </h4>                
                    <div class="col-12 col-md-6 mb-3">
                        <label class="" id="monto"><i class="fas fa-dollar-sign"></i> Sueldo: </label>
                        <input type="number" required="" class="sueldo" name="sueldo">
                    </div>
                    <h4>Gastos Principales: </h4>
                    <label class="" id="montoInternet"><i class="fas fa-dollar-sign"></i> Internet: </label>
                    <div class="col-2 col-md-4 col-lg-6">
                        <input type="number" required="" class="internet" name="internet">
                    </div>
                </div>
                <hr>
                <!-- <label class="col-sm-2" id="otro"><i class="far fa-money-bill-alt"></i> Monto: </label>
                <div class="col-sm-4">
                    <input type="number" required="" class="ingreso" name="monto">
                </div>
                <hr>
                <label class="col-sm-2" id="fecha"><i class="fas fa-calendar-alt"></i> Fecha: </label>
                <div class="col-sm-4">
                    <input type="date" required="" name="fecha">
                </div>
                <hr> -->
                <input type="hidden" name="id_user" id="id_user" value="<?php echo $session_uid ?>">
                <input class="btn btn-primary" type="submit" value="Registrar">
                <input class="btn btn-primary" type="reset" value="Limpiar">
                <!-- <button type="button" class="btn btn-danger" onclick="window.location.href='<?php echo BASE_URL; ?>logout.php'">Cerrar Sesión</button>	   -->
            </form> 
        </div>    
    </fieldset>
    </div>
<br><br>
</div>	
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="../css/dist/js/bootstrap.min.js"></script>	
<script src="../css/js/src/util.js"></script>
<script type="text/javascript">	
// $('#selectIng').on('change', function() {
// 		console.log($(this).val());
// 		if ($(this).val() == 1) {
// 			var total = document.getElementsByClassName("ingreso");
// 			console.log(total);
// 			total.value = 250000;
// 		}     
// });
/*var id = document.querySelector("#id_user").value;
console.log(id);*/
</script>
</body>
</html>
