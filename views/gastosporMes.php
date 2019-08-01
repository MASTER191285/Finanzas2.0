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
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-sccale=1, user-scalable=yes">
	<title>Búsqueda de Gastos por Mes</title>
  <link rel="stylesheet" href="../css/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../js/datatables/dataTables.bootstrap.css"/>
    <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/estilos.css">	
  <!-- jQuery library -->  
  <script src="../js/jquery/jquery.min.js"></script>          
  <!-- Google fonts - Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <script type="text/javascript" src="../js/bootbox/bootbox.min.js"></script>
</head>
<body class="bg-dark">
<div class="container">
  <div class="jumbotron">
    <h1 class="display-4">Listado</h1>     
    <h1>Bienvenido <?php echo $userDetails->name; ?></h1>  
  </div>
    <div class="col-sm-3 pull-right"><button type="button" class="btn btn-info volver" onclick="window.location.href='../dashboard.php'" >Volver al Dashboard</button>
    </div>
    <div class="form-group">
	  <label class="col-8 col-md-6" id="tipoIngreso"><i class="fas fa-dollar-sign"></i> Mes a Consultar: </label>
	    <div class="col-sm-2 col-md-4">
	      <select class="custom-select" id="selectIng" name="tipoIngreso" required>
                <option value='' disabled selected>SELECCIONE MES</option>
                <option value='1'>Enero</option>
                <option value='2'>Febrero</option>
                <option value='3'>Marzo</option>
                <option value='4'>Abril</option>
                <option value='5'>Mayo</option>
                <option value='6'>Junio</option>
                <option value='7'>Julio</option>
                <option value='8'>Agosto</option>
                <option value='9'>Septiembre</option>
                <option value='10'>Octubre</option>
                <option value='11'>Noviembre</option>
                <option value='12'>Diciembre</option>
          </select> 	
		</div>
    <hr>
    <table class="table table-bordered" id="listadoGastos">
      <thead>
        <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Monto</th>                        
            <th scope="col">Observaciones</th>
            <th scope="col">Tipo de Gasto</th>            
        </tr>
      </thead>
        <?php $uid = $userDetails->uid; ?>
        <tbody id="cuerpoGastos">           
        </tbody>
    </table> 
    <input type="button" id="exportar" class="btn btn-info" value="Exportar a PDF">
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
<!-- <script src="..js/datatables/jquery.dataTables.js"></script>
<script src="..js/datatables/dataTables.bootstrap.js"></script> -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>   
<script src="../css/js/src/util.js"></script>
<script>
// Get the modal
$(function() {
  
  $("#exportar").attr("disabled", true);

    /*Script PopUP Imagen*/
	$('.fotito').on('click', function() {
      //console.log('entro');
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
    });
    /*Fin Script PopUP Imagen*/

    /*Script Mes*/
    $("#selectIng").on("change",function(e){      
      e.preventDefault();      
      var idMes = $(this).val();
      var idU = "<?php echo $uid; ?>";      
      $.ajax({                  
                type: 'POST',
                url: '../controllers/funciones.php',
                data: {action: "buscaGasto",valor:idMes, id: idU},
                success: function(data){
                    $("#cuerpoGastos").hide(500);
                    $("#cuerpoGastos").html(data);
                    $("#cuerpoGastos").show(500);
                    $("#exportar").attr("disabled", false);
                }
            });
    });
    /*Fin Script Mes*/

    /*Script Exportar*/
    $("#exportar").click(function(){
        var idMes = $("#selectIng").val();
        var idU = "<?php echo $uid; ?>";   
        window.open("../controllers/verPDF.php?action=verPDF&idMes="+idMes+"&id="+idU);        
    });

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
                    data: {action: "eliminarGasto", valor:id},
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
    

});
</script>
</body>
</html>
