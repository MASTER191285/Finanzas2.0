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
  <link rel="stylesheet" href="../js/datatables/dataTables.bootstrap.css"/>
  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
  <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/estilos.css">	
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
  <!-- Google fonts - Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <script type="text/javascript" src="../js/bootbox/bootbox.min.js"></script>
</head>
<body>
<div class="container">
  <div class="jumbotron">
    <h1 class="display-4">Listado</h1>
    <p class="lead">Listado de Gastos del Mes de <?php echo $mesActual; ?></p>  
    <h1>Bienvenido <?php echo $userDetails->name; ?></h1>  
  </div>
    <div class="col-sm-3 pull-right"><button type="button" class="btn btn-info volver" onclick="window.location.href='../dashboard.php'" >Volver al Dashboard</button>
    </div>
<!-- <fieldset>	 -->
  <div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-body">
    <table class="table table-bordered" id="listadoGastos">
      <thead>
        <tr>
            <th scope="col">Monto</th>
            <th scope="col">Fecha</th>
            <th scope="col">Comprobante</th>
            <th scope="col">Observaciones</th>
            <th scope="col">Tipo de Gasto</th>
            <th scope="col">Opciones</th>
        </tr>
      </thead>
        <?php $uid = $userDetails->uid; ?>
        <?php $first_day = date('Y-m-01');  ?>
        <tbody> 
          <?php listarGastosMes($first_day, $uid); ?>
      </tbody>
    </table> 
    </div>   
  </div>
</div>
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
  
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="../css/dist/js/bootstrap.min.js"></script>	
<script src="..js/datatables/jquery.dataTables.js"></script>
<script src="..js/datatables/dataTables.bootstrap.js"></script>
<script src="../css/js/src/util.js"></script>
<script>
// Get the modal
$(function() {   
    /*Script PopUP Imagen*/
		$('.pop').on('click', function() {
      //console.log('entro');
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
    });
    /*Fin Script PopUP Imagen*/

    /*Script Eliminar*/
    $(".eliminar").on("click",function(e){      
      e.preventDefault();
      var id = $(this).attr('data-id');      
      var parent = $(this).parent("td").parent("tr");
      //bootbox.confirm("Are you sure?", function(result) {
      bootbox.dialog({
        message: "¿Seguro que desea eliminar?",
        title: "Eliminar Gasto",
          buttons: {
            danger: {
              label: "Si",
              className: "btn-danger",
              callback: function() {
                $.ajax({                  
                    type: 'POST',
                    url: '../controllers/funciones.php',
                    data: {action: "eliminarGasto",valor:id},
                })
                .done(function(response){
                    bootbox.alert(response);
                    parent.fadeOut('slow');                                       
                })
                .fail(function(){
                    bootbox.alert('Error al eliminar ....');
                })
              }
            },
            success: {
              label: "No",
              className: "btn-success",
              callback: function() {
                // cancel button, close dialog box
                  $('.bootbox').modal('hide');
              }
            }
          }
        });
    });
    /*Fin Script Eliminar*/
    
    /*Script Listado*/
    $('#listadoGastos').DataTable({
        "language":  {
          "sProcessing":     "Procesando...",
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
          "sUrl":            "",
          "sInfoThousands":  ",",
          "sLoadingRecords": "Cargando...",
          "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
          },
          "oAria": {
						"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					}
        }
      }); 
    /*Fin Script Listado*/
});
</script>
</body>
</html>
