<?php 
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");		
		#region AlimentaCombos
		function getTipoIngreso(){

			try {
				getcwd();				
				$db = getDB();
				$query = "SELECT id, descripcion FROM tipo_ingreso";
				$stmt = $db->prepare($query);

				$stmt->execute();   				
				//var_dump($stmt);
				echo "<option value='' disabled selected>SELECCIONE TIPO INGRESO</option>";			
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);							
					echo'<OPTION VALUE="'.$row['id'].'">'.strtoupper($row['descripcion']).'</OPTION>';  
				}    				
			}catch (Exception $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}
		
		}

		function getTipoGasto(){

			try {
				getcwd();				
				$db = getDB();
				$query = "SELECT id, descripcion FROM tipo_gasto";
				$stmt = $db->prepare($query);

				$stmt->execute();				
				echo "<option value='' disabled selected>SELECCIONE TIPO GASTO</option>";			
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);							
					echo'<OPTION VALUE="'.$row['id'].'">'.strtoupper($row['descripcion']).'</OPTION>';  
				}    				
			}catch (Exception $e) {
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}
		
		}
		#endRegion		


		function insertarIngreso(){			

     		try{    
     			getcwd();  	
     			$db = getDB();
     			$mensaje = "";     			
				$monto=htmlspecialchars(strip_tags($_POST['monto']));
		        $fecha=htmlspecialchars(strip_tags($_POST['fecha']));
		        $tipoIngreso=htmlspecialchars(strip_tags($_POST['tipoIngreso']));
		        if (strlen(htmlspecialchars(strip_tags($_POST['observaciones']))) == 0) {
		        	$observaciones = "Sin Observaciones";
		        }else{
		        	$observaciones=htmlspecialchars(strip_tags($_POST['observaciones']));
		        }		        
		        $id_usuario=htmlspecialchars(strip_tags($_POST['id_user']));

		        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		        $query = "INSERT INTO ingresos (monto,fecha, id_tipo_ingreso, observaciones, id_usuario) values(?, ?, ?, ?, ?)";
		        $inserccion = $db->prepare($query);
				$inserccion->execute(
				array(
					$monto
					,date($fecha)
					,$tipoIngreso
					,$observaciones
					,$id_usuario
				));            
                 
		        if($inserccion){		            
		            $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
		            $mensaje.= "<strong>Exito!</strong> Registro Insertado.";
		            $mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
		            $mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
		            echo $mensaje;
		        }else{
					$mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
		            $mensaje.= "<strong>Error!</strong> Error al grabar.";
		            $mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
		            $mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
		            echo $mensaje;
		        }
         
    		}     	
    		catch(PDOException $exception){
        	die('ERROR: ' . $exception->getMessage());
    		}
    	}

		function insertarGasto(){			

     		try{    
     			getcwd();  	
     			$db = getDB();
     			$mensaje = "";
				$monto=htmlspecialchars(strip_tags($_POST['monto']));
		        $fecha=htmlspecialchars(strip_tags($_POST['fecha']));
		        $tipoGasto=htmlspecialchars(strip_tags($_POST['tipoGasto']));		        
		        if (strlen(htmlspecialchars(strip_tags($_POST['observaciones']))) == 0) {
		        	$observaciones = "Sin Observaciones";
		        }else{
		        	$observaciones=htmlspecialchars(strip_tags($_POST['observaciones']));
		        }
		        $id_usuario=htmlspecialchars(strip_tags($_POST['id_user']));

		        /*Lógica de subida de archivo*/
		        $directorio = "../uploads/";
				$archivo = basename($_FILES["comprobante"]["name"]);
				$destino = $directorio . $archivo;
				$tipoArchivo = pathinfo($destino,PATHINFO_EXTENSION);
				// Extensiones permitidas
				$extPermitida = array('jpg','png','jpeg','pdf');
				
				if (empty($_FILES["comprobante"]["name"])) {
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					        $query = "INSERT INTO gastos (monto,fecha, id_tipo_gasto, observaciones, id_usuario) values(?, ?, ?, ?, ?)";
					        $inserccion = $db->prepare($query);

							$inserccion->execute(
								array(
									$monto
									,date($fecha)
									,$tipoGasto
									,$observaciones
									,$id_usuario									
							));

					        if($inserccion){		            
					            $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
					            $mensaje.= "<strong>Exito!</strong> Registro Insertado.";
					            $mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
					            $mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
					            echo $mensaje;

					        }else{
								$mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
					            $mensaje.= "<strong>Error!</strong> Error al grabar.";
					            $mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
					            $mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
					            echo $mensaje;
					        }
					}else{
						if(in_array($tipoArchivo, $extPermitida)){
				        	// Subir archivo
				        	if(move_uploaded_file($_FILES["comprobante"]["tmp_name"], $destino)){				            
					        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					        $query = "INSERT INTO gastos (monto,fecha, id_tipo_gasto, observaciones, id_usuario, comprobante) values(?, ?, ?, ?, ?, ?)";
					        $inserccion = $db->prepare($query);

							$inserccion->execute(
								array(
									$monto
									,date($fecha)
									,$tipoGasto
									,$observaciones
									,$id_usuario
									,$archivo
							));

					        if($inserccion){		            
					            $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
					            $mensaje.= "<strong>Exito!</strong> Registro Insertado.";
					            $mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
					            $mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
					            echo $mensaje;

					        }else{
								$mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
					            $mensaje.= "<strong>Error!</strong> Error al grabar.";
					            $mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
					            $mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
					            echo $mensaje;
					        }

				        	}else{
								$mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
					            $mensaje.= "<strong>Error!</strong> Error al Subir el Archivo.";
					            $mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
					            $mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
					            echo $mensaje;
				        		}
				    		}else{
								$mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
					            $mensaje.= "<strong>Error!</strong> Extensión de archivo no permitida.";
					            $mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
					            $mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
					            echo $mensaje;
			            
				   			 }		
				}		
    		}     	
    		catch(PDOException $exception){
        	die('ERROR: ' . $exception->getMessage());
    		}
		}
		
		function listarGastosMes($fecha, $uid){
			
			try {
				getcwd();								
				$db = getDB();
				$query = 'SELECT g.id, g.monto ,g.fecha ,g.comprobante ,g.observaciones  ,tg.descripcion FROM  gastos g INNER JOIN tipo_gasto tg ON g.id_tipo_gasto=tg.id WHERE fecha BETWEEN :fechaini AND CURDATE() AND id_usuario=:id_usuario ORDER BY g.fecha';
				$stmt = $db->prepare($query);
				$stmt->bindParam("fechaini", $fecha, PDO::PARAM_STR, 10);
				$stmt->bindParam("id_usuario", $uid,PDO::PARAM_INT);
				$stmt->execute();
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					echo '<tr>';
					//echo '<td>'. money_format('%i', $row['monto']).'</td>';
					echo '<td>'. number_format($row['monto'], 0,",",".").'</td>';
					echo '<td>'. $row['fecha'].'</td>';					
					//echo "<td>"."<img width='100px' alt='sin imagen' id='comprobante' src='../uploads/" .  $row['comprobante'] . "'/>"."</td>";
					echo "<td>"."<a href='#'' class='pop'>"."<img width='100px' alt='Sin Imagen' id='comprobante' src='../uploads/" .  $row['comprobante'] . "'/>"."</a>"."</td>";
					echo '<td>'. $row['observaciones'].'</td>';
					echo '<td>'. $row['descripcion'].'</td>';
					echo '<td>';					
					// echo "<button value='$row[id]' id='$row[id]' class='btn btn-info btn-xs edit_data'>Editar </button>";
					echo "<a href='actualizarGasto.php?id={$id}' class='btn btn-info btn-xs edit_data'>Editar </a>";
					echo '<a href="#" value="id" id="eliminar" <i class="fas fa-trash-alt"> Eliminar</i></a>';
					echo '</td>';
					echo '</tr>';
				}
			} catch (PDOException $exception) {
				die('ERROR: ' . $exception->getMessage());
			}
			
		}

		function gastoaActualizar($id){
			
			try {
				getcwd();								
				$db = getDB();
				$query = "SELECT g.id, g.monto as monto, g.fecha as fecha, g.observaciones as observaciones, tg.descripcion as descripcion FROM gastos g INNER JOIN tipo_gasto tg ON g.id_tipo_gasto=tg.id WHERE g.id=:id";
				$stmt = $db->prepare($query);
				$stmt->bindParam("id", $id,PDO::PARAM_INT);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);				
				$monto = $row['monto'];
				$fecha = $row['fecha'];
				$observaciones = $row['observaciones'];
				$descripcion = $row['descripcion'];
				echo "				
				<label class='col-sm-2' id='monto'><i class='far fa-money-bill-alt'></i> Monto: </label>
				<div class='col-sm-4'>
				  <input type='number' name='monto' value=$monto class='form-control' >
				</div>
				<hr>		
				<label class='col-sm-4' id='fecha'><i class='fas fa-calendar-alt'></i> Fecha: </label>
				<div class='col-sm-4'>
				  <input type='date' required='' name='fecha' value=$fecha>
				</div>
				<hr>      
				<label for='observaciones' id='observaciones'>Observaciones:</label>
				<textarea class='form-control' id='observaciones' name='observaciones' rows='3' cols='30' maxlength='100'>$observaciones</textarea>
				<hr>
				";
			} catch (PDOException $exception) {
				die('ERROR: ' . $exception->getMessage());
			}
		}

		function ActualizarGasto($id){

			try {
				getcwd();
				$db = getDB();
				$mensaje = "";
				if ($_POST) {
					$query = "UPDATE gastos SET 
					monto=:monto,
					fecha=:fecha,
					observaciones=:observaciones,
					id_tipo_gasto=:tipoGasto
					WHERE id=:id";
					$stmt = $db->prepare($query);
					$monto=htmlspecialchars(strip_tags($_POST['monto']));
					$fecha=$_POST['fecha'];
					$observaciones=$_POST['observaciones'];
					$tipoGasto=htmlspecialchars(strip_tags($_POST['tipoGasto']));
					$stmt->bindParam("id", $id,PDO::PARAM_INT);
					$stmt->bindParam(":monto", $monto);
					$stmt->bindParam(":fecha", $fecha);
					$stmt->bindParam(":observaciones", $observaciones);
					$stmt->bindParam(":tipoGasto", $tipoGasto);					
					if($stmt->execute()){
						$mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
						$mensaje.= "<strong>Exito!</strong> Gasto Modificado.";
						$mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
						$mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
						echo $mensaje;
					}else{
						$mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
						$mensaje.= "<strong>Error!</strong> Error al Modificar.";
						$mensaje.= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
						$mensaje.= "<span aria-hidden='true'>&times;</span></button></div>";
						echo $mensaje;
					}
				}

			} catch (PDOException $exception) {
				die('ERROR: ' . $exception->getMessage());
			}
		}


		function eliminarGasto(){
			
			try {
				getcwd();				
				$db = getDB();
				$id= isset($_GET['id']) ? $_GET['id'] : die('Registro no encontrado.');
				$query = "DELETE FROM gastos WHERE id = ?";
				$stmt = $db->prepare($query);
				$stmt->bindParam(1, $id);     
					if ($stmt->execute()) {
						header('location: ../views/listarGastos.php?action=eliminar');
					}else{
						die('Error al Eliminar');
					}
			} catch (PDOException $exception) {
				die('ERROR: ' . $exception->getMessage());
			}
		}

		function detalleDiario($uid){
			try {
				getcwd();				
				$db = getDB();
				$query = "SELECT g.id as id, g.monto as monto ,g.observaciones as observaciones ,tg.descripcion as descripcion FROM gastos g INNER JOIN tipo_gasto tg ON g.id_tipo_gasto=tg.id AND g.fecha = CURDATE()  AND id_usuario=:id_usuario LIMIT 0,5";
				$stmt = $db->prepare($query);
				$stmt->bindParam("id_usuario", $uid, PDO::PARAM_INT);
				$stmt->execute();
				$cantidad = $stmt->rowCount();
				if ($cantidad > 0) {
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						extract($row);
						echo '<tr>';					
						echo '<td>'. number_format($row['monto'], 0,",",".").'</td>';
						echo '<td>'. $row['observaciones'].'</td>';
						echo '<td>'. $row['descripcion'].'</td>';
						echo '</tr>';
					}					
				}else{
					echo '<tr>';
					echo '<td>0</td>';
					echo '<td>Sin registros el día de hoy</td>';
					echo '<td>No aplica</td>';
					echo '</tr>';
				}
			} catch (PDOException $exception) {
				die('ERROR: ' . $exception->getMessage());
			}
		}

    	function buscaGastos(){
    		
    		try {

    			$db = getDB();
    			 $salida = "";
			    $query = "SELECT G.monto, G.fecha, G.observaciones, TG.descripcion FROM gastos G INNER JOIN tipo_gasto TG ON G.id_tipo_gasto=TG.id ORDER BY G.monto LIMIT 20";

			    if (isset($_POST['consulta'])) {
			    	$q = $conn->real_escape_string($_POST['consulta']);
			    $query = "SELECT G.monto, G.fecha, G.observaciones, TG.descripcion FROM gastos G INNER JOIN tipo_gasto TG ON G.id_tipo_gasto=TG.id WHERE G.monto LIKE '%$q%' OR G.observaciones LIKE '%$q%' OR TG.descripcion LIKE '%$q%'";
			    }
			    $stmt = $db->prepare($query);

			    //$resultado = $conn->query($query);
			    $stmt->execute();
			    if ($stmt->num_rows>0) {
			    	$salida.="<table border=1 class='tabla_datos'>
			    			<thead>
			    				<tr id='titulo'>
			    					<td>Monto</td>
			    					<td>Fecha</td>
			    					<td>Observaciones</td>
			    					<td>Descripcion</td>
			    					<td>Accion</td>
			    				</tr>
			    			</thead>  			
			    	<tbody>";

			    	while ($fila = $stmt->fetch_assoc()) {
			    		$salida.="<tr>
			    					<td>".$fila['monto']."</td>
			    					<td>".$fila['fecha']."</td>
			    					<td>".$fila['observaciones']."</td>
			    					<td>".$fila['descripcion']."</td>			    					
			    				</tr>";

			    	}
			    	$salida.="</tbody></table>";
			    }else{
			    	$salida.="Sin Registros....";
			    }

			    echo $salida;	        			
    		} catch (Exception $e) {
    			echo '{"error":{"text":'. $e->getMessage() .'}}';
    		}
    	}    	

?>
