<?php
require '../controllers/funciones.php';
include('../db/config.php');
include('../session.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Listado de Gastos</title>
	<link rel="stylesheet" href="../css/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/estilos.css">	
</head>
<body class="bg-dark">
    <?php $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID no existe.'); ?>
<div class="container">
<div class="jumbotron">	
  <h1 class="display-4">Actualización de Gastos</h1>
  <p class="lead">Actualización del Gasto N# <?php echo $id; ?></p>  
  <!-- <h1>Bienvenido <?php echo $userDetails->name; ?></h1>   -->
</div>
  <div class="col-sm-3 pull-right"><button type="button" class="btn btn-dark" onclick="window.location.href='../dashboard.php'" >Volver al Dashboard</button></div>
<fieldset>	
	<legend id="titulo">Gasto a Modificar</legend>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">        
            <?php gastoaActualizar($id); ?>    
            <?php ActualizarGasto($id); ?>
            <label class="col-8 col-md-6" id="tipoGasto"><i class="fas fa-dollar-sign"></i> Tipo de Gasto: </label>
            <div class="col-sm-4 col-md-6">
            <select class="custom-select" id="selectIng" name="tipoGasto" required><?php getTipoGasto(); ?></select> 	
            </div>
            <hr>
            <input type='submit' value='Actualizar Gasto' class='btn btn-primary' />
            <a href='listarGastos.php' class='btn btn-info'>Volver al Listado</a>
    </div>
</fieldset>
<br><br>
</form>
</div>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="../css/dist/js/bootstrap.min.js"></script>	
<script src="../css/js/src/util.js"></script>

</body>
</html>