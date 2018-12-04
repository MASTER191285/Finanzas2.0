<?php
	$servername = "localhost";
    $username = "root";
  	$password = "";
  	$dbname = "finanzas";
    
	try {

    $conn = new PDO("mysql:host={$servername};dbname={$dbname}", $username, $password);

	}
	catch(PDOException $exception){

    echo "Error de Conexion: " . $exception->getMessage();
    
	}
?>