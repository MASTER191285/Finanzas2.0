<?php
            
    if(isset($_POST["id"]))  
    {   
			$db = getDB();
			$query = "SELECT g.id, g.monto, g.fecha, g.observaciones, tg.descripcion FROM gastos g INNER JOIN tipo_gasto tg ON g.id_tipo_gasto=tg.id WHERE g.id = '".$_POST["id"]."'";
			$stmt = $db->prepare($query);
			//$stmt->bindParam("id", $id,PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);  			
    }
        
?>        