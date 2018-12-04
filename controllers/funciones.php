<?php 
		#region AlimentaCombos
		function getTipoIngreso(){

			try {
				getcwd();				
				$db = getDB();
				$query = "SELECT id, descripcion FROM tipo_ingreso";
				$stmt = $db->prepare($query);

				$stmt->execute();   				
				var_dump($stmt);
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
