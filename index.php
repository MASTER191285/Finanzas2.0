<?php 
include("db/config.php");
include('model/userClass.php');
require 'login.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" href="css/estilos.css">
	<script src="css/dist/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<title>Inicio de Sesión</title>
</head>
<body class="bg-dark">
	<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center text-white mb-4">Inicio de Sesión</h2>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0">Credenciales</h3>
                        </div>
                        <div class="card-body" id="login">
                            <form class="form" role="form" autocomplete="off" name="login" id="formLogin" method="POST">
							<label for="usuario"><i class="fas fa-user"></i> Nombre de Usuario</label>
							<input type="text" class="form-control form-control-lg rounded-0" name="usernameEmail" autocomplete="off"required="">
							<div class="invalid-feedback">Campo Obligatorio.</div>   
							<hr>                             
							<label for="contraseña"><i class="fas fa-key"></i> Contraseña</label>
							<input type="password" name="password" class="form-control form-control-lg rounded-0"  required="" autocomplete="new-password">
							<div class="invalid-feedback">Contraseña Requerida!</div>                                
                            <div class="errorMsg"><?php echo $errorMsgLogin; ?></div>
                            <button type="submit" class="btn btn-dark btn-lg float-right" id="btnLogin" name="loginSubmit" value="Login">Ingresar</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->
                </div>
            </div>
            <!--/row-->
        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->
<script type="text/javascript">
	 $("#btnLogin").click(function(event) {    
    var form = $("#formLogin")

    if (form[0].checkValidity() === false) {
      event.preventDefault()
      event.stopPropagation()
    }    
    form.addClass('was-validated');
  });

</script>
</body>
</html>

