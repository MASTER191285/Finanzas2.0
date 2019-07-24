<?php 
require '../controllers/funciones.php';
include('../db/config.php');
include('../session.php');
$userDetails=$userClass->userDetails($session_uid);
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
  <h1 class="display-4">Registro de Ingresos</h1>
  <p class="lead">Registro de Ingresos Diarios - Semanales - Mensuales</p>  
  <h1>Bienvenido <?php echo $userDetails->name; ?></h1>
</div>
<div class="col-sm-3 pull-right"><button type="button" class="btn btn-secondary volver" onclick="window.location.href='../dashboard.php'" >Volver al Dashboard</button></div>
<fieldset>	
	<legend id="titulo">Ingreso a Registrar</legend>
	<?php 
		if ($_POST) { 
			insertarIngreso();
		}
	?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	  <div class="form-group">
	  <label class="col-8 col-md-6" id="tipoIngreso"><i class="fas fa-dollar-sign"></i> Tipo de Ingreso: </label>
	    <div class="col-sm-2 col-md-4">
	      <select class="custom-select" id="selectIng" name="tipoIngreso" required><?php getTipoIngreso(); ?></select> 	
		</div>
		<hr>
	    <label class="col-sm-2" id="monto"><i class="far fa-money-bill-alt"></i> Monto: </label>
	    <div class="col-sm-4">
	      <input type="number" required="" class="ingreso" name="monto">
	    </div>
	    <hr>
	    <label class="col-sm-2" id="fecha"><i class="fas fa-calendar-alt"></i> Fecha: </label>
	    <div class="col-sm-4">
	      <input type="date" required="" name="fecha">
	    </div>
	    <hr>
	    <hr>
	    <input type="hidden" name="id_user" id="id_user" value="<?php echo $session_uid ?>">
	    <label for="comment" id="observaciones">Observaciones:</label>
  		<textarea class="form-control" id="txtObservaciones" name="observaciones" rows="3" cols="10" maxlength="100"></textarea>	    
	  </div>
	  <input class="btn btn-primary" type="submit" value="Registrar">
	  <input class="btn btn-primary" type="reset" value="Limpiar">
	  <!-- <button type="button" class="btn btn-danger" onclick="window.location.href='<?php echo BASE_URL; ?>logout.php'">Cerrar Sesión</button>	   -->
	 </form> 
</fieldset>
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
