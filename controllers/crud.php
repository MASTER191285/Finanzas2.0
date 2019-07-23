<?php
include('../db/config.php');
/*Logica Delete*/		
getcwd();
$db->getDB();
$id = $_POST['delete_id'];
$query = "DELETE FROM gastos WHERE id=:id";
$stmt = $db->prepare($query);
$stmt->bindParam("id", $id,PDO::PARAM_INT);
$stmt->execute();
/*Fin Logica Delete*/
?>
