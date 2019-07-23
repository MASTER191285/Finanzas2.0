<?php
require '../controllers/funciones.php';
include('../db/config.php');
include('../session.php');
$userDetails=$userClass->userDetails($session_uid);
$mesActual = $meses[date('n')-1];

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Listado de Gastos</title>
	<link rel="stylesheet" href="../css/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/estilos.css">	
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../js/jalert/src/jAlert.css">     
  <script type="text/javascript" src="../js/jalert/src/jAlert.js"></script>
  <script type="text/javascript" src="../js/jalert/src/jAlert-functions.js"></script>
</head>
<body class="bg-dark">
<div class="container">
<div class="jumbotron">
  <h1 class="display-4">Listado</h1>
  <p class="lead">Listado de Gastos del Mes de <?php echo $mesActual; ?></p>  
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
    <?php $first_day = date('Y-m-01');  ?>
    <?php listarGastosMes($first_day, $uid); ?>
    <!-- The Modal -->
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
  <!-- modal de Eliminar-->
 <div id="modalEliminar" class="modal">
    <div class="modal-content">
    <h3>¿Esta seguro de eliminar al Gasto Seleccionado?</h3>
    </div>
    <div class="modal-footer row">
    <button class="btn modal-action modal-close waves-effect waves-orange orange accent-4 col s2" id="modalCancel" >Cancelar</button>
      <button class="btn modal-action modal-close waves-effect waves-orange orange accent-4 col s2" id="modalOK">Aceptar</button>
    </div>
  </div>
  <!-- Modal de Gasto Eliminaro-->
  <div id="modalGastoEliminado" class="modal">
    <div class="modal-content">
    <h3>¡ EXITO !</h3>
      SE HA ELIMINADO
    </div>
    <div class="modal-footer">
      <button class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</button>
    </div>
  </div>
  <!-- Modal de Cliente No Eliminado-->
  <div id="modalGastoNOEliminado" class="modal">
    <div class="modal-content">
    <h3>¡ ERROR !</h3>
      No se ha logrado eliminar al Gasto
    </div>
    <div class="modal-footer">
      <button class=" modal-action modal-close waves-effect waves-green btn-flat">Aceptar</button>
    </div>
</table>
</fieldset>
<br><br>
</div>	
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

    $(".eliminar").on("click",function(){
        var id = this.value;
        $("#modalOK").click(function(){
         $.ajax({
                    url: "../controllers/funciones.php",
                   type: "post",
                    data: {action: "eliminarGasto",valor:id},
                   success: function(data){
                    if (data==true) {
                        $('#modalGastoEliminado').openModal({complete: function(){location.reload();}});
                    }else{
                        $('#modalGastoNOEliminado').openModal();
                    }
                }
            });
        })
    }).leanModal();

});
</script>
</body>
</html>
