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
	<title>Listado de Gastos</title>
	<link rel="stylesheet" href="../css/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/estilos.css">	
</head>
<body class="bg-dark">
<div class="container">
<div class="jumbotron">
  <h1 class="display-4">Listado</h1>
  <p class="lead">Listado de Gastos del Mes Actual</p>  
  <h1>Bienvenido <?php echo $userDetails->name; ?></h1>  
</div>
<div class="col-sm-3 pull-right"><button type="button" class="btn btn-info" onclick="window.location.href='../dashboard.php'" >Volver al Dashboard</button></div>
<fieldset>	
<table class="table table-striped table-dark">
    <tr>
        <th scope="col">Monto</th>
        <th scope="col">Fecha</th>
        <th scope="col">Comprobante</th>
        <th scope="col">Observaciones</th>
        <th scope="col">Tipo de Gasto</th>
        <th scope="col">Opciones</th>
    </tr>
    <?php $uid = $userDetails->uid; ?>
    <?php listarGastosMes($uid); ?>
    <!-- The Modal -->
    <!-- <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">              
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <img src="" class="imagepreview" style="width: 100%;" >
        </div>
      </div>
    </div>
  </div> -->
  <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" data-dismiss="modal">
    <div class="modal-content"  >              
      <div class="modal-body">
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
      <div class="modal-footer">
          <div class="col-xs-12">
               <p class="text-left">Comprobante Asociado al Gasto</p>
          </div>
      </div>                
    </div>
  </div>
</div>
  <!-- Fin Modal -->
</table>
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
<script>
// Get the modal
$(function() {   
		$('.pop').on('click', function() {
      //console.log('entro');
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
    });
    
    //Eliminar
    $("#eliminar").on("click" ,function(){
            //console.log('ingreso');
            var padre = $(this).children("i").parent()[0];
            padre = $(padre).attr("value");
            console.log(padre);
            $.jAlert({
              'size': 'md',
              'type': 'confirm',
              'confirmQuestion':'¿Esta seguro?',
              'showAnimation': 'fadeInUp',
              'hideAnimation': 'fadeOutDown',
              'onConfirm': function(e, btn){ e.preventDefault(); window.location = '../controllers/funciones.php?id=' + padre; return false; },
              'onDeny': function(alert){ console.log("falso"); return false; }
          });

        });
});
</script>
</body>
</html>
