<?php 
require '../controllers/funciones.php';
include('../db/config.php');
include('../session.php');
$userDetails=$userClass->userDetails($session_uid);
$fechaDefault = date("Y-m-j");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Gastos</title>
	<link rel="stylesheet" href="../css/dist/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/estilos.css">	
<script type="text/javascript">	
$(document).ready(function(){	
	$("input[name=monto]").on("change keyup",function(){
		  var num = $("input[name=monto]").val().replace(/\./g,'');
		  if(!isNaN(num)){
		  num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,"$1.");
		  num = num.split('').reverse().join('').replace(/^[\.]/,'');
		  $("input[name=monto]").val(num);
		  }
		  else{ 
		  $("input[name=monto]").val($("input[name=monto]").val().replace(/[^\d\.]*/g,''));
		  }
	  })
	/**
	 * funcion que prohibe presionar todo excepto las teclas comentadas abajito
	 * @param  {[type]} e) {                      if(!event) event [description]
	 * @return {[type]}    [description]
	 */
	  $("input[name=monto]").on("keydown",function (e) {
			 if(!event) event = event || window.event;
		return (
		(event.keyCode > 7 && event.keyCode < 10)  // delete (8) o tabulador (9)
		|| (event.keyCode > 45 && event.keyCode < 60) // numeros del teclado
		|| (event.keyCode > 95 && event.keyCode < 106) // teclado numerico
		|| event.keyCode == 17  // Ctrl
		|| event.keyCode == 116 // F5
		|| event.keyCode == 37
		|| event.keyCode == 39
		)
	  });
});
</script>	
</head>
<body class="bg-dark">	
<div class="container">
<div class="jumbotron">	
  <h1 class="display-4">Registro de Gastos</h1>
  <p class="lead">Registro de Gastos Diarios - Semanales - Mensuales</p>  
  <h1>Bienvenido <?php echo $userDetails->name; ?></h1>  
</div>
  <div class="col-sm-3 pull-right"><button type="button" class="btn btn-secondary volver" onclick="window.location.href='../dashboard.php'" >Volver al Dashboard</button></div>
<fieldset>	
	<legend id="titulo">Gasto a Registrar</legend>
	<?php 
		if ($_POST) { 
			insertarGasto();
		}
	?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">
	  <div class="form-group">
	  <label class="col-8 col-md-6" id="tipoGasto"><i class="fas fa-dollar-sign"></i> Tipo de Gasto: </label>
	  <div class="col-sm-2 col-md-4">
	      <select class="custom-select" id="selectIng" name="tipoGasto" required><?php getTipoGasto(); ?></select> 	
		</div>
		<hr>
	    <label class="col-sm-2" id="monto"><i class="far fa-money-bill-alt"></i> Monto: </label>
	    <div class="col-sm-4">
	      <input type="text" name="monto" class="form-control" required>
	    </div>
	    <hr>
	    <label class="col-sm-4" id="fecha"><i class="fas fa-calendar-alt"></i> Fecha: </label>
	    <div class="col-sm-4">
	      <input type="date" value="<?php echo $fechaDefault; ?>" name="fecha" required>
	    </div>
	    <hr>
	    <label class="col-sm-2" id="comprobante"><i class="fas fa-file-upload"></i> Comprobante: </label>
	    <div class="col-sm-4">
	      <input type="file"  name="comprobante" id="archivo">
	    </div>
	    <hr>	    
	    <hr>
	    <input type="hidden" name="id_user" id="id_user" value="<?php echo $session_uid ?>">	    
	    <label for="comment" id="observaciones"><i class="fas fa-info-circle"></i> Observaciones:</label>
  		<textarea class="form-control" id="txtObservaciones" name="observaciones" rows="3" cols="30" maxlength="100"></textarea>	    
	  </div>
	  <input class="btn btn-primary" type="submit" value="Registrar">
	  <input class="btn btn-primary" type="reset" value="Limpiar">	  
	 </form> 
</fieldset>
<br><br>
</div>	
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="../css/dist/js/bootstrap.min.js"></script>	
<script src="../css/js/src/util.js"></script>
</body>
</html>
