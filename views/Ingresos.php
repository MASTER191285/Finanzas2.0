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
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-sccale=1, user-scalable=no">
	<title>Ingresos</title>
	<link rel="stylesheet" href="../css/dist/css/bootstrap.min.css">
	<!-- Font Awesome CSS-->
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/estilos.css">	
	  <!-- jQuery library -->
	<script src="../js/jquery/jquery.min.js"></script> 
  	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script> 

<script type="text/javascript">
$(function() {  
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
	      <input type="text" class="form-control"  required="" class="ingreso" name="monto">
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
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="../css/dist/js/bootstrap.min.js"></script>	
<script src="../css/js/src/util.js"></script>
</body>
</html>
