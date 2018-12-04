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
	<title>Gastos</title>
	<link rel="stylesheet" href="../css/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/estilos.css">	
</head>
<body class="bg-dark">	
<div class="container">
<div class="jumbotron">	
  <h1 class="display-4">Registro de Gastos</h1>
  <p class="lead">Registro de Gastos Diarios - Semanales - Mensuales</p>  
  <h1>Bienvenido <?php echo $userDetails->name; ?></h1>  
</div>
  <div class="col-sm-3 pull-right"><button type="button" class="btn btn-dark" onclick="window.location.href='../dashboard.php'" >Volver al Dashboard</button></div>
<fieldset>	
	<legend id="titulo">Gasto a Registrar</legend>
	<?php 
		if ($_POST) { 
			insertarGasto();
		}
	?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
	  <div class="form-group">
	    <label class="col-sm-2" id="monto"><i class="far fa-money-bill-alt"></i> Monto: </label>
	    <div class="col-sm-4">
	      <input type="number" name="monto" required>
	    </div>
	    <hr>
	    <label class="col-sm-4" id="fecha"><i class="fas fa-calendar-alt"></i> Fecha: </label>
	    <div class="col-sm-4">
	      <input type="date" required="" name="fecha" required>
	    </div>
	    <hr>
	    <label class="col-sm-2" id="comprobante"><i class="fas fa-file-upload"></i> Comprobante: </label>
	    <div class="col-sm-4">
	      <input type="file"  name="comprobante" id="archivo">
	    </div>
	    <hr>	    
	    <label class="col-8 col-md-6" id="tipoGasto"><i class="fas fa-dollar-sign"></i> Tipo de Gasto: </label>
	    <div class="col-sm-4 col-md-6">
	      <select class="custom-select" id="selectIng" name="tipoGasto" required><?php getTipoGasto(); ?></select> 	
	    </div>
	    <hr>
	    <input type="hidden" name="id_user" id="id_user" value="<?php echo $session_uid ?>">	    
	    <label for="comment" id="observaciones">Observaciones:</label>
  		<textarea class="form-control" id="txtObservaciones" name="observaciones" rows="3" cols="30" maxlength="100"></textarea>	    
	  </div>
	  <input class="btn btn-primary" type="submit" value="Registrar">
	  <input class="btn btn-primary" type="reset" value="Limpiar">	  
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
	/*$(document).on('change',"#selectIng", function() {
		if ($(this).val() == 4) {
			document.querySelector("#txtObservaciones").attributes["required"] = true;
		}     
});*/
</script>
</body>
</html>
