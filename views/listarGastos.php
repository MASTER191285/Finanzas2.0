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
<fieldset>	
<table class="table table-striped table-dark">
    <tr>
        <th scope="col">Monto</th>
        <th scope="col">Fecha</th>
        <th scope="col">Comprobante</th>
        <th scope="col">Observaciones</th>
        <th scope="col">Tipo de Gasto</th>
    </tr>
    <?php listarGastosMes(); ?>
    <!-- The Modal -->
    <div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
    </div>
</table>
</fieldset>
<br><br>
</div>	
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("comprobante");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  debugger;
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="../css/dist/js/bootstrap.min.js"></script>	
<script src="../css/js/src/util.js"></script>

</body>
</html>
