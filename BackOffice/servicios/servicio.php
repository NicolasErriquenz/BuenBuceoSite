<?php  
	
	require_once ("funcs.php");
	
	function updateHabilitado($id, $habilitado, $tabla, $idNombre){
		global $mysqli;

		$id = intval($id); // Asegurarse de que sea un número entero
	    $habilitado = isset($habilitado) ? intval($habilitado) : 0; // 1 si está habilitado, 0 si no

	    // Actualizar el estado en la base de datos
	    $updateQuery = "UPDATE $tabla SET habilitado_sys = ? WHERE $idNombre = ?";
	    $stmt = $mysqli->prepare($updateQuery);
	    echo ($updateQuery);
	    $stmt->bind_param('ii', $habilitado, $id); // 'ii' significa que ambos son enteros

	    
	    if ($stmt->execute()) {
	        echo json_encode(['status' => 'success', 'message' => 'Estado actualizado correctamente.']);
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el estado: ' . $stmt->error]);
	    }

	    $stmt->close();
	    exit; // Asegúrate de terminar el script aquí para no procesar más nada
	}


	function updateActivo($id, $habilitado, $tabla, $idNombre){
		global $mysqli;

		$id = intval($id); // Asegurarse de que sea un número entero
	    $habilitado = isset($habilitado) ? intval($habilitado) : 0; // 1 si está habilitado, 0 si no

	    // Actualizar el estado en la base de datos
	    $updateQuery = "UPDATE $tabla SET activo = ? WHERE $idNombre = ?";
	    $stmt = $mysqli->prepare($updateQuery);
	    echo ($updateQuery);
	    $stmt->bind_param('ii', $habilitado, $id); // 'ii' significa que ambos son enteros

	    
	    if ($stmt->execute()) {
	        echo json_encode(['status' => 'success', 'message' => 'Estado actualizado correctamente.']);
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el estado: ' . $stmt->error]);
	    }

	    $stmt->close();
	    exit; // Asegúrate de terminar el script aquí para no procesar más nada
	}

	function buscarUsuarios($query) {
		global $mysqli;

		$query = mysqli_real_escape_string($mysqli, $query);

		$sql = "SELECT * FROM usuarios 
		        WHERE nombre LIKE '%$query%' 
		        OR apellido LIKE '%$query%' 
		        OR apodo LIKE '%$query%' 
		        OR comentario LIKE '%$query%' 
		        OR imagen LIKE '%$query%'
		        OR CAST(dni AS CHAR) LIKE '%$query%'";

		$resultado = mysqli_query($mysqli, $sql);

		$usuarios = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$obj["usuarioId"] = $row["usuarioId"];
			$obj["nombre"] = $row["apodo"]." (".$row["nombre"]." ".$row["apellido"].")";
			$obj["viajeroTipoId"] = $row["viajeroTipoId"];
			$usuarios[] = $obj;
		}

		// No es necesario cerrar la conexión aquí, ya que es global

		return json_encode($usuarios);
	}

	function eliminarItem($id, $tabla, $idNombre){
		global $mysqli;

		$id = intval($id); // Asegurarse de que sea un número entero

	    // Actualizar el estado en la base de datos
	    $updateQuery = "UPDATE $tabla SET habilitado_sys = ? WHERE $idNombre = ?";
	    $stmt = $mysqli->prepare($updateQuery);
	    $stmt->bind_param('ii', $habilitado, $id); // 'ii' significa que ambos son enteros


	    if ($stmt->execute()) {
	        echo json_encode(['status' => 'success', 'message' => 'Estado actualizado correctamente.']);
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el estado: ' . $stmt->error]);
	    }

	    $stmt->close();
	    exit; // Asegúrate de terminar el script aquí para no procesar más nada
	}

	function getRubrosPagos($orderByAlfabetico = false) {
	    global $mysqli;

	    $resultArray = [];

	    // Consulta SQL para obtener rubros
	    $query = "SELECT pagosRubroId, rubro, comentario, habilitado_sys 
	              FROM pagos_rubros";

	    // Agregar ordenamiento alfabético si se especifica
	    if ($orderByAlfabetico) {
	        $query .= " ORDER BY rubro ASC";
	    }

	    if ($result = $mysqli->query($query)) {
	        while ($row = $result->fetch_assoc()) {
	            // Consulta SQL para obtener total de subrubros y subrubros no habilitados
	            $totalSubrubros = $mysqli->query("SELECT COUNT(*) 
	                                              FROM pagos_subrubros 
	                                              WHERE pagosRubrosId = " . $row['pagosRubroId'])->fetch_assoc()['COUNT(*)'];
	            $subrubrosHabilitados = $mysqli->query("SELECT COUNT(*) 
	                                                      FROM pagos_subrubros 
	                                                      WHERE pagosRubrosId = " . $row['pagosRubroId'] . 
	                                                      " AND habilitado_sys = 1")->fetch_assoc()['COUNT(*)'];

	            $row['total_subrubros'] = $totalSubrubros;
	            $row['subrubros_habilitados'] = $subrubrosHabilitados;

	            $resultArray[] = $row;
	        }
	        $result->free();
	    } else {
	        echo "Error en la consulta: " . $mysqli->error;
	    }

	    return $resultArray;
	}


	// function getDeudaTipos($orderByAlfabetico = false) {
	//     global $mysqli;

	//     $resultArray = [];

	//     // Consulta SQL para obtener rubros
	//     $query = "SELECT * 
	//               FROM deuda_tipo";

	//     // Agregar ordenamiento alfabético si se especifica
	//     if ($orderByAlfabetico) {
	//         $query .= " ORDER BY rubro ASC";
	//     }

	//     if ($result = $mysqli->query($query)) {
	//         while ($row = $result->fetch_assoc()) {
	//             $resultArray[] = $row;
	//         }
	//         $result->free();
	//     } else {
	//         echo "Error en la consulta: " . $mysqli->error;
	//     }

	//     return $resultArray;
	// }

	function getMediosDePago() {
	    global $mysqli;

	    // Consulta SQL
	    $sql = "SELECT * FROM medios_de_pago WHERE habilitado_sys=1";

	    // Ejecutar consulta
	    $result = $mysqli->query($sql);

	    // Verificar resultado
	    if ($result->num_rows > 0) {
	        // Devolver arreglo de medios de pago
	        $mediosDePago = array();
	        while($row = $result->fetch_assoc()) {
	            $mediosDePago[] = $row;
	        }
	        return $mediosDePago;
	    } else {
	        // Devolver mensaje de error
	        return "No se encontraron medios de pago";
	    }
	}

	function getSubrubrosPagos($orderByAlfabetico = false, $pagosRubrosId = null, $returnJson = false) {
	    global $mysqli;

	    $resultArray = [];

	    // Consulta SQL con INNER JOIN
	    if ($pagosRubrosId) {
	        $query = "SELECT ps.*, pr.rubro 
	                  FROM pagos_subrubros ps 
	                  INNER JOIN pagos_rubros pr ON ps.pagosRubrosId = pr.pagosRubroId
	                  WHERE ps.pagosRubrosId = '$pagosRubrosId'";
	    } else {
	        $query = "SELECT ps.*, pr.rubro 
	                  FROM pagos_subrubros ps 
	                  INNER JOIN pagos_rubros pr ON ps.pagosRubrosId = pr.pagosRubroId";
	    }
	    // Agregar ordenamiento alfabético si se especifica
	    if ($orderByAlfabetico) {
	        $query .= " ORDER BY ps.subrubro ASC";
	    }

	    if ($result = $mysqli->query($query)) {
	        while ($row = $result->fetch_assoc()) {
	            $resultArray[] = $row;
	        }
	        $result->free();
	    } else {
	        echo "Error en la consulta: " . $mysqli->error;
	    }

	    // Retornar resultado en formato JSON si se especifica
	    if ($returnJson) {
	        header('Content-Type: application/json');
	        echo json_encode($resultArray);
	        exit;
	    } else {
	        return $resultArray;
	    }
	}


	function getTransaccionTipos($orderByAlfabetico = false, $returnJson = false) {
	    global $mysqli;

	    $resultArray = [];

	    // Consulta SQL
	    $query = "SELECT *
	              FROM pagos_transaccion_tipo";

	    // Agregar ordenamiento alfabético si se especifica
	    if ($orderByAlfabetico) {
	        $query .= " ORDER BY transaccion ASC";
	    }

	    if ($result = $mysqli->query($query)) {
	        while ($row = $result->fetch_assoc()) {
	            $resultArray[] = $row;
	        }
	        $result->free();
	    } else {
	        echo "Error en la consulta: " . $mysqli->error;
	    }

	    // Retornar resultado en formato JSON si se especifica
	    if ($returnJson) {
	        header('Content-Type: application/json');
	        echo json_encode($resultArray);
	        exit;
	    } else {
	        return $resultArray;
	    }
	}

	function getItem($tabla, $idName, $id) {
		global $mysqli;

	    $query = "SELECT * FROM $tabla WHERE $idName=".$id;
	    
	    if ($result = $mysqli->query($query)) {
	        $row = $result->fetch_assoc();
	        $result->free();
	    } else {
	        echo "Error en la consulta: " . $mysqli->error;
	    }

	    return $row;
	}

	function getMonedas() {
	    global $mysqli;

	    $resultArray = [];

	    // Consulta SQL
	    $query = "SELECT *
	              FROM monedas";


	    if ($result = $mysqli->query($query)) {
	        while ($row = $result->fetch_assoc()) {
	            $resultArray[] = $row;
	        }
	        $result->free();
	    } else {
	        echo "Error en la consulta: " . $mysqli->error;
	    }

	    return $resultArray;
	}


	function altaPago($datos) {
	    global $mysqli;

	    $pago = array(
	        'pagosSubrubroId' => $datos['pagosSubrubroId'],
	        'pagoTransaccionTipoId' => $datos['pagoTransaccionTipoId'],
	        'fecha' => $datos['fecha'],
	        'monedaId' => $datos['monedaId'],
	        'monto' => $datos['monto'],
	        'medioPagoId' => $datos['medioPagoId'],
	        'comentario' => $datos['comentario'] ?? null,
	        'cotizacion' => $datos['cotizacion'] ?? null,
	        'usuarioId' => isset($datos['usuarioId']) && $datos['usuarioId'] !== '' ? $datos['usuarioId'] : null,
	        'habilitado_sys' => isset($datos['habilitado_sys']) ? 1 : 0,
	        'deudaId' => $datos['deudaId'] ?? null,
	        'viajesCostosOperativosId' => $datos['viajesCostosOperativosId'] ?? null,
	        'viajesId' => $datos['viajesId'] ?? null,
	    );

	    // Validaciones
	    if (empty($pago['pagosSubrubroId']) || 
	        empty($pago['pagoTransaccionTipoId']) || 
	        empty($pago['fecha']) || 
	        empty($pago['monedaId']) || 
	        empty($pago['monto']) || 
	        empty($pago['medioPagoId'])) {
	        echo 'Faltan campos obligatorios';
	        return;
	    }

	    // Sentencia SQL para insertar el pago
	    $sql = "INSERT INTO pagos (pagosSubrubroId, pagoTransaccionTipoId, fecha, monedaId, monto, medioPagoId, comentario, cotizacion, habilitado_sys, usuarioId, deudaId, viajesCostosOperativosId, viajesId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

	    $stmt = mysqli_prepare($mysqli, $sql);
	    if (!$stmt) {
	        echo "Error preparando la sentencia: " . mysqli_error($mysqli);
	        return;
	    }

	 	$comentario = $pago['comentario'] ?? '';
		$usuarioId = $pago['usuarioId'] ?? null;

		mysqli_stmt_bind_param($stmt, 'iisddiissdiii', 
		    $pago['pagosSubrubroId'], 
		    $pago['pagoTransaccionTipoId'], 
		    $pago['fecha'], 
		    $pago['monedaId'], 
		    $pago['monto'], 
		    $pago['medioPagoId'], 
		    $comentario, 
		    $pago['cotizacion'], 
		    $pago['habilitado_sys'], 
		    $usuarioId, 
		    $pago['deudaId'],
		    $pago['viajesCostosOperativosId'],
		    $pago['viajesId']
		);

	    // Ejecutar la sentencia
	    if (!mysqli_stmt_execute($stmt)) {
	        echo 'Error al insertar pago: ' . mysqli_stmt_error($stmt);
	        return;
	    }

	    // Verificar si se insertó correctamente
	    if (mysqli_stmt_affected_rows($stmt) > 0) {
	        echo 'ok';
	    } else {
	        echo 'Error al insertar pago';
	    }
	}

	function buscarDeudas($usuarioId) {
	  global $mysqli;
	  
	  $sql = "SELECT 
	            d.deudaId, 
	            d.deuda, 
	            dt.subrubro as tipoDeuda, 
	            d.comentario, 
	            m.moneda, 
	            m.simbolo 
	          FROM 
	            deudas d 
	          INNER JOIN pagos_subrubros dt ON d.pagosSubrubroId = dt.pagosSubrubroId 
	          INNER JOIN monedas m ON d.monedaId = m.monedaId 
	          WHERE 
	            d.usuarioId = ? AND 
	            d.habilitado_sys = 1";
	  $stmt = mysqli_prepare($mysqli, $sql);
	  mysqli_stmt_bind_param($stmt, 'i', $usuarioId);
	  mysqli_stmt_execute($stmt);

	  $resultado = mysqli_stmt_get_result($stmt);
	  $deudas = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
	  
	  foreach ($deudas as &$deuda) {
	    $deuda['comentario'] = $deuda['comentario'] ?? '';
	  }
	  
	  return $deudas;
	}

	function editarPago($datos) {
	    global $mysqli;

		// Preparar datos
		$pagoId = $_GET['pagoId'];
		$usuarioId = isset($datos['usuarioId']) && $datos['usuarioId'] !== '' ? $datos['usuarioId'] : 'NULL';
		$deudaId = $datos['deudaId'] ?? 'NULL';
		$viajesId = !empty($datos['viajesId']) ? $datos['viajesId'] : 'NULL';
		$habilitado_sys = isset($datos['habilitado_sys']) ? 1 : 0;

		// Sentencia SQL para actualizar el pago
		$sql = "UPDATE pagos SET 
		      pagosSubrubroId = ".$datos['pagosSubrubroId'].", 
		      pagoTransaccionTipoId = ".$datos['pagoTransaccionTipoId'].", 
		      fecha = '".$datos['fecha']."', 
		      monedaId = ".$datos['monedaId'].", 
		      monto = '".$datos['monto']."', 
		      medioPagoId = ".$datos['medioPagoId'].", 
		      comentario = '".($datos['comentario'] ?? '')."', 
		      cotizacion = '".($datos['cotizacion'] ?? '')."', 
		      habilitado_sys = ".$habilitado_sys.", 
		      usuarioId = ".$usuarioId.", 
		      deudaId = ".$deudaId.",
		      viajesId = " . $viajesId. "
		  WHERE pagoId = $pagoId";

		$stmt = mysqli_prepare($mysqli, $sql);
		
	    // Ejecutar la sentencia
	    if (!mysqli_stmt_execute($stmt)) {
	        echo 'Error al actualizar pago: ' . mysqli_stmt_error($stmt);
	        return;
	    }
	    // Verificar si se actualizó correctamente
	    if (mysqli_stmt_affected_rows($stmt) > 0 || mysqli_stmt_errno($stmt) == 0) {
	        echo 'ok';
	    } else {
	        echo 'Error al actualizar pago';
	    }
	}
	
	function altaRubroPago($POST) {
	    global $mysqli;

	    // Preparamos la consulta utilizando ? como placeholders
	    $query = "INSERT INTO pagos_rubros (rubro, comentario, habilitado_sys) VALUES (?, ?, ?)";
	    
	    $POST['habilitado_sys'] = 1;

	    // Preparamos la consulta
	    if ($stmt = $mysqli->prepare($query)) {
	        $stmt->bind_param('ssi', $POST['rubro'], $POST['comentario'], $POST['habilitado_sys']);
	        if(!$stmt->execute()) 
	            die("Error al insertar el registro: " . $stmt->error);
	        $stmt->close();
	    } else {
	        echo "Error al preparar la consulta: " . $mysqli->error;
	    }

	    header("location:pagos_rubros.php");
	}	

	function altaDeuda($POST) {
	  global $mysqli;

	  // Preparamos la consulta utilizando ? como placeholders
	  $query = "INSERT INTO deudas (deuda, monedaId, usuarioId, viajesId, pagosSubrubroId, comentario, habilitado_sys) VALUES (?, ?, ?, ?, ?, ?, ?)";

	  $POST['habilitado_sys'] = 1;

	  // Preparamos la consulta
	  if ($stmt = $mysqli->prepare($query)) {

	  	$comentario = empty($POST['comentario']) ? NULL : $POST['comentario'];

	    $stmt->bind_param('diiidsi', 
		  $POST['deuda'], 
		  $POST['monedaId'], 
		  $POST['usuarioId'], 
		  $POST['viajesId'], 
		  $POST['pagosSubrubroId'], 
		  $comentario, 
		  $POST['habilitado_sys']
		);
	    if(!$stmt->execute()) 
	      die("Error al insertar el registro: " . $stmt->error);
	  	else
	  		return "ok";

	    $stmt->close();
	  } else {
	    echo "Error al preparar la consulta: " . $mysqli->error;
	  }  
	}

	function editarDeuda($datos) {
	  global $mysqli;

	  // Preparar datos
	  $deudaId = $_GET['deudaId'];
	  $usuarioId = isset($datos['usuarioId']) && $datos['usuarioId'] !== '' ? $datos['usuarioId'] : 'NULL';
	  $viajesId = isset($datos['viajesId']) && $datos['viajesId'] !== '' ? $datos['viajesId'] : 'NULL';
	  $pagosSubrubroId = $datos['pagosSubrubroId'] ?? 'NULL';
	  $habilitado_sys = isset($datos['habilitado_sys']) ? 1 : 0;

	  // Sentencia SQL para actualizar la deuda
	  $sql = "UPDATE deudas SET 
	          deuda = '".$datos['deuda']."', 
	          monedaId = ".$datos['monedaId'].", 
	          usuarioId = ".$usuarioId.", 
	          viajesId = ".$viajesId.", 
	          pagosSubrubroId = ".$pagosSubrubroId.", 
	          comentario = '".($datos['comentario'] ?? '')."', 
	          habilitado_sys = ".$habilitado_sys."
	      WHERE deudaId = $deudaId";

	  // Ejecutar la sentencia
	  if (!mysqli_query($mysqli, $sql)) {
	    echo 'Error al actualizar deuda: ' . mysqli_error($mysqli);
	    return;
	  }

	  // Verificar si se actualizó correctamente
	  if (mysqli_affected_rows($mysqli) > 0 || mysqli_errno($mysqli) == 0) {
	    echo 'ok';
	  } else {
	    echo 'Error al actualizar deuda';
	  }
	}


	// function altaTipoDeuda($POST) {
	//     global $mysqli;

	//     // Preparamos la consulta utilizando ? como placeholders
	//     $query = "INSERT INTO deuda_tipo (deuda, comentario, habilitado_sys) VALUES (?, ?, ?)";
	    
	//     $POST['habilitado_sys'] = 1;

	//     // Preparamos la consulta
	//     if ($stmt = $mysqli->prepare($query)) {
	//         $stmt->bind_param('ssi', $POST['deuda'], $POST['comentario'], $POST['habilitado_sys']);
	//         if(!$stmt->execute()) 
	//             die("Error al insertar el registro: " . $stmt->error);
	//         $stmt->close();
	//     } else {
	//         echo "Error al preparar la consulta: " . $mysqli->error;
	//     }

	//     header("location:deudaTipo_listado.php");
	// }

	function editarRubroPago($POST, $GET) {
		global $mysqli;
	
		// Verificar si se está intentando editar un rubro
		if ($POST['action'] == 'editar' && isset($GET['pagosRubroId'])) {
			// Preparamos la consulta utilizando ? como placeholders
			$query = "UPDATE pagos_rubros SET rubro = ?, comentario = ?, habilitado_sys = ? WHERE pagosRubroId = ?";
	
			// Preparamos la consulta
			if ($stmt = $mysqli->prepare($query)) {
				$habilitado_sys = ($POST['habilitado_sys'] === 'on') ? 1 : 0;
				$stmt->bind_param('sssi', $POST['rubro'], $POST['comentario'], $habilitado_sys, $GET['pagosRubroId']);
				if (!$stmt->execute()) 
					die("Error al editar el registro: " . $stmt->error);
				$stmt->close();
			} else {
				echo "Error al preparar la consulta: " . $mysqli->error;
			}
	
			// Redireccionamos con el parámetro pagosRubroId si está establecido
			$redirectUrl = "pagos_rubros.php";
			if (isset($POST['pagosRubroId'])) {
				$redirectUrl .= "?pagosRubroId=" . $POST['pagosRubroId'];
			}
	
			header("location: $redirectUrl");
		} else {
			echo "Error: No se proporcionaron los parámetros necesarios.";
		}
	}

	// function editarTipoDeuda($POST, $GET) {
	//     global $mysqli;

	//     // Verificar si se está intentando editar un deuda
	//     if ($POST['action'] == 'editar' && isset($GET['rubroId'])) {
	//         // Preparamos la consulta utilizando ? como placeholders
	//         $query = "UPDATE deuda_tipo SET deuda = ?, comentario = ?, habilitado_sys = ? WHERE rubroId = ?";

	//         // Preparamos la consulta
	//         if ($stmt = $mysqli->prepare($query)) {
	//             $habilitado_sys = $POST['habilitado_sys'] ?? 1; // Si no se envía habilitado_sys, se considera 1
	//             $stmt->bind_param('sssi', $POST['deuda'], $POST['comentario'], $habilitado_sys, $GET['rubroId']);
	//             if (!$stmt->execute()) 
	//                 die("Error al editar el registro: " . $stmt->error);
	//             $stmt->close();
	//         } else {
	//             echo "Error al preparar la consulta: " . $mysqli->error;
	//         }

	//         // Redireccionamos con el parámetro rubroId si está establecido
	//         $redirectUrl = "deudaTipo_listado.php";
	//         if (isset($POST['rubroId'])) {
	//             $redirectUrl .= "?rubroId=" . $POST['rubroId'];
	//         }

	//         header("location: $redirectUrl");
	//     } else {
	//         echo "Error: No se proporcionaron los parámetros necesarios.";
	//     }
	// }

	function altaSubrubroPago($POST, $GET) {
	    global $mysqli;

	    // Preparamos la consulta utilizando ? como placeholders
	    $query = "INSERT INTO pagos_subrubros (subrubro, pagosRubrosId, habilitado_sys) VALUES (?, ?, ?)";
	    
	    $POST['habilitado_sys'] = 1;

	    // Preparamos la consulta
	    if ($stmt = $mysqli->prepare($query)) {
	        $stmt->bind_param('sii', $POST['subrubro'], $POST['pagosRubrosId'], $POST['habilitado_sys']);
	        if(!$stmt->execute()) 
	            die("Error al insertar el registro: " . $stmt->error);
	        $stmt->close();
	    } else {
	        echo "Error al preparar la consulta: " . $mysqli->error;
	    }

	    // Redireccionamos con el parámetro pagosRubrosId si está establecido
	    $redirectUrl = "pagos_subrubros.php";
	    if (isset($GET['pagosRubrosId'])) {
	        $redirectUrl .= "?pagosRubrosId=" . $GET['pagosRubrosId'];
	    }

	    header("location: $redirectUrl");
	}

	function editarSubrubroPago($POST, $GET) {
	    global $mysqli;

	    // Verificar si se está intentando editar un subrubro
	    if ($POST['action'] == 'editar' && isset($GET['pagosSubrubroId'])) {
	        // Preparamos la consulta utilizando ? como placeholders
	        $query = "UPDATE pagos_subrubros SET subrubro = ?, pagosRubrosId = ?, habilitado_sys = ? WHERE pagosSubrubroId = ?";

	        // Preparamos la consulta
	        if ($stmt = $mysqli->prepare($query)) {
	            $habilitado_sys = $POST['habilitado_sys'] ?? 1; // Si no se envía habilitado_sys, se considera 1
	            $stmt->bind_param('siii', $POST['subrubro'], $POST['pagosRubrosId'], $habilitado_sys, $GET['pagosSubrubroId']);
	            if (!$stmt->execute()) 
	                die("Error al editar el registro: " . $stmt->error);
	            $stmt->close();
	        } else {
	            echo "Error al preparar la consulta: " . $mysqli->error;
	        }

	        // Redireccionamos con el parámetro pagosRubrosId si está establecido
	        $redirectUrl = "pagos_subrubros.php";
	        if (isset($POST['pagosRubrosId'])) {
	            $redirectUrl .= "?pagosRubrosId=" . $POST['pagosRubrosId'];
	        }

	        header("location: $redirectUrl");
	    } else {
	        echo "Error: No se proporcionaron los parámetros necesarios.";
	    }
	}

	// function getTipoDeudas() {
	// 	global $mysqli;
		
	//   $query = "SELECT 
	//               rubroId, 
	//               deuda, 
	//               comentario
	//             FROM 
	//               deuda_tipo
	//             WHERE 
	//               habilitado_sys = 1";

	//   $resultado = mysqli_query($mysqli, $query);
	//   $tiposDeudas = array();

	//   while ($fila = mysqli_fetch_assoc($resultado)) {
	//     $tiposDeudas[] = $fila;
	//   }

	//   return $tiposDeudas;
	// }

	function getDeudas($usuarioId = null) {
	    global $mysqli;
	    $query = "SELECT 
	                d.*, 
	                m.moneda, 
	                m.simbolo, 
	                u.nombre as usuario_nombre, 
	                u.apellido as usuario_apellido, 
	                u.apodo, 
	                s.subrubro,
	                r.rubro,
	                COALESCE(SUM(p.monto), 0) as total_pagado
	              FROM 
	                deudas d
	              INNER JOIN 
	                monedas m ON d.monedaId = m.monedaId
	              INNER JOIN 
	                usuarios u ON d.usuarioId = u.usuarioId
	              INNER JOIN 
	                pagos_subrubros s ON d.pagosSubrubroId = s.pagosSubrubroId
	              INNER JOIN 
	                pagos_rubros r ON r.pagosRubroId = s.pagosRubrosId
	              LEFT JOIN 
	                pagos p ON d.deudaId = p.deudaId AND p.habilitado_sys = 1
	              WHERE 1";
	    
	    if ($usuarioId !== null) {
	        $query .= " AND d.usuarioId = '$usuarioId'";
	    }
	    
	    $query .= " GROUP BY d.deudaId";
	    
	    $resultado = mysqli_query($mysqli, $query);
	    $deudas = array();
	    while ($fila = mysqli_fetch_assoc($resultado)) {
	        // Calculamos el saldo pendiente
	        $fila['saldo_pendiente'] = $fila['deuda'] - $fila['total_pagado'];
	        $deudas[] = $fila;
	    }
	    
	    return $deudas;
	}

	function getDeudasViaje($viajesId) {

	  global $mysqli;

	  $query = "SELECT 
	              d.*, 
	              m.moneda, 
	              m.simbolo, 
	              u.nombre as usuario_nombre, 
	              u.apellido as usuario_apellido, 
	              u.apodo, 
	              s.subrubro,
	              r.rubro,
	              COALESCE(SUM(p.monto), 0) as total_pagado
	            FROM 
	              deudas d
	            INNER JOIN 
	              monedas m ON d.monedaId = m.monedaId
	            INNER JOIN 
	              usuarios u ON d.usuarioId = u.usuarioId
	            INNER JOIN 
	              pagos_subrubros s ON d.pagosSubrubroId = s.pagosSubrubroId
	            INNER JOIN 
	              pagos_rubros r ON r.pagosRubroId = s.pagosRubrosId
	            LEFT JOIN 
	              pagos p ON d.deudaId = p.deudaId AND p.habilitado_sys = 1
	            WHERE d.viajesId = ".$viajesId."
				GROUP BY 
				    d.deudaId, 
				    d.monedaId, 
				    d.usuarioId, 
				    d.pagosSubrubroId, 
				    m.moneda, 
				    m.simbolo, 
				    u.nombre, 
				    u.apellido, 
				    u.apodo, 
				    s.subrubro,
   					r.rubro";


	  $resultado = mysqli_query($mysqli, $query);
	  $deudas = array();

	  while ($fila = mysqli_fetch_assoc($resultado)) {
	    $deudas[] = $fila;
	  }

	  return $deudas;
	}

	function getPagos($usuarioId = null, $deudaId = null) {
	    global $mysqli;
	    
	    $query = "
	        SELECT
	            p.*,
	            ps.subrubro,
	            pt.transaccion AS transaccion_tipo,
	            m.simbolo AS simbolo,
	            m.moneda AS moneda,
	            mp.medioPago,
	            u.nombre AS usuario_nombre,
	            u.apellido AS usuario_apellido,
	            u.apodo,
	            u.dni,
	            d.deudaId,
	            d.deuda,
	            d.comentario AS deuda_comentario,
	            dm.simbolo AS deuda_simbolo,
	            dm.moneda AS deuda_moneda,
	            psr.subrubro AS deuda_tipo,
	            pr.rubro,
	            v.anio,
	            pa.pais
	        FROM
	            pagos p
	        INNER JOIN
	            pagos_subrubros ps ON p.pagosSubrubroId = ps.pagosSubrubroId
	        INNER JOIN
	            pagos_rubros pr ON pr.pagosRubroId = ps.pagosRubrosId
	        INNER JOIN
	            pagos_transaccion_tipo pt ON p.pagoTransaccionTipoId = pt.pagoTransaccionTipoId
	        INNER JOIN
	            monedas m ON p.monedaId = m.monedaId
	        INNER JOIN
	            medios_de_pago mp ON p.medioPagoId = mp.medioPagoId
	        LEFT JOIN
	            usuarios u ON p.usuarioId = u.usuarioId
	        LEFT JOIN
	            deudas d ON p.deudaId = d.deudaId
	        LEFT JOIN
	            monedas dm ON d.monedaId = dm.monedaId
	        LEFT JOIN
	            pagos_subrubros psr ON d.pagosSubrubroId = psr.pagosSubrubroId
	        LEFT JOIN
	            viajes v ON p.viajesId = v.viajesId
	        LEFT JOIN
	            paises pa ON v.paisId = pa.paisId
	        WHERE 1=1";
	    
	    $whereConditions = array();
	    
	    if ($usuarioId !== null) {
	        $whereConditions[] = "p.usuarioId = '$usuarioId'";
	    }
	    
	    if ($deudaId !== null) {
	        $whereConditions[] = "p.deudaId = '$deudaId'";
	    }
	    
	    if (!empty($whereConditions)) {
	        $query .= " AND " . implode(" AND ", $whereConditions);
	    }
	    
	    $result = $mysqli->query($query);
	    if (!$result) {
	        die("Error al obtener pagos: " . $mysqli->error);
	    }
	    
	    $pagos = array();
	    while ($row = $result->fetch_assoc()) {
	        $pagos[] = $row;
	    }
	    
	    return $pagos;
	}

	function getPagosViaje($viajesId) {
	  global $mysqli;
	  
	  $query = "
		SELECT
			p.*,
			ps.subrubro,
			pt.transaccion AS transaccion_tipo,
			m.simbolo AS simbolo,
			m.moneda AS moneda,
			mp.medioPago,
			u.nombre AS usuario_nombre,
			u.apellido AS usuario_apellido,
			u.apodo,
			u.dni,
			d.deudaId,
			d.deuda,
			d.comentario AS deuda_comentario,
			dm.simbolo AS deuda_simbolo,
			dm.moneda AS deuda_moneda,
			psr.subrubro AS deuda_tipo,
			pr.rubro,
			v.anio,
			pa.pais
		FROM
			pagos p
		INNER JOIN
			pagos_subrubros ps ON p.pagosSubrubroId = ps.pagosSubrubroId
		INNER JOIN
			pagos_rubros pr ON pr.pagosRubroId = ps.pagosRubrosId
		INNER JOIN
			pagos_transaccion_tipo pt ON p.pagoTransaccionTipoId = pt.pagoTransaccionTipoId
		INNER JOIN
			monedas m ON p.monedaId = m.monedaId
		INNER JOIN
			medios_de_pago mp ON p.medioPagoId = mp.medioPagoId
		LEFT JOIN
			usuarios u ON p.usuarioId = u.usuarioId
		LEFT JOIN
			deudas d ON p.deudaId = d.deudaId
		LEFT JOIN
			monedas dm ON d.monedaId = dm.monedaId
		LEFT JOIN
			pagos_subrubros psr ON d.pagosSubrubroId = psr.pagosSubrubroId
		LEFT JOIN
			viajes v ON p.viajesId = v.viajesId
		LEFT JOIN
			paises pa ON v.paisId = pa.paisId
		";

	  if ($viajesId !== null) {
	    $query .= " WHERE p.viajesId = '$viajesId'";
	  }
	  $result = $mysqli->query($query);
	  if (!$result) {
	    die("Error al obtener pagos: " . $mysqli->error);
	  }

	  $pagos = array();
	  while ($row = $result->fetch_assoc()) {
	    $pagos[] = $row;
	  }

	  return $pagos;
	}

	function getUsuarios() {
	    global $mysqli;

	    // Consulta SQL para obtener datos de usuarios
	    $sql = "
		    SELECT 
		      u.*, 
		      p.pais, 
		      s.sexo, 
		      ut.tipo, 
		      vt.viajero_tipo,
		      (SELECT COUNT(*) FROM pagos WHERE usuarioId = u.usuarioId) AS cantidad_pagos,
		      (SELECT COUNT(*) FROM deudas WHERE usuarioId = u.usuarioId) AS cantidad_deudas
		    FROM 
		      usuarios u
		    INNER JOIN 
		      usuarios_tipo ut ON ut.usuarioTipoId = u.usuarioTipoId
		    LEFT JOIN 
		      paises p ON u.paisId = p.paisId
		    LEFT JOIN 
		      sexo s ON u.sexoId = s.sexoId
		    LEFT JOIN
		      viajes_viajero_tipo vt ON vt.viajeroTipoId = u.viajeroTipoId
		";

	    // Ejecutar consulta
	    $result = $mysqli->query($sql);

	    // Verificar resultado
	    if ($result->num_rows > 0) {
	        // Devolver arreglo de usuarios
	        $usuarios = array();
	        while($row = $result->fetch_assoc()) {
	            // Consulta SQL para obtener redes sociales del usuario
	            $sqlRedes = "
	                SELECT 
	                  rs.red, 
	                  urs.link, 
	                  urs.username
	                FROM 
	                  usuarios_redes_sociales urs
	                INNER JOIN 
	                  redes_sociales rs ON urs.redId = rs.redSocialId
	                WHERE 
	                  urs.usuarioId = " . $row['usuarioId'] . "
	            ";

	            // Ejecutar consulta
	            $resultRedes = $mysqli->query($sqlRedes);

	            // Verificar resultado
	            if ($resultRedes->num_rows > 0) {
	                // Agregar redes sociales al arreglo de usuario
	                $redes = array();
	                while($rowRed = $resultRedes->fetch_assoc()) {
	                    $redes[] = $rowRed;
	                }
	                $row['redes_sociales'] = $redes;
	            } else {
	                $row['redes_sociales'] = array();
	            }

	            $usuarios[] = $row;
	        }
	        return $usuarios;
	    } else {
	        // Devolver mensaje de error
	        return array();
	    }
	}	

	function getRedes() {
	  global $mysqli;

	  // Consulta SQL para obtener redes sociales
	  $sql = "
	    SELECT 
	      redSocialId, 
	      red
	    FROM 
	      redes_sociales
	  ";

	  // Ejecutar consulta
	  $result = $mysqli->query($sql);

	  // Verificar resultado
	  if ($result->num_rows > 0) {
	    // Devolver arreglo de redes sociales
	    $redes = array();
	    while($row = $result->fetch_assoc()) {
	      $redes[] = $row;
	    }
	    return $redes;
	  } else {
	    // Devolver arreglo vacío
	    return array();
	  }
	}

	function guardarRedSocial($POST) {
	  global $mysqli;

	  // Consulta SQL para guardar red social
	  $sql = "
	    INSERT INTO usuarios_redes_sociales (usuarioId, redId, username, link)
	    VALUES (" . $mysqli->real_escape_string($POST["usuarioId"]) . ", 
	            " . $mysqli->real_escape_string($POST["redId"]) . ", 
	            '" . $mysqli->real_escape_string($POST["username"]) . "', 
	            '" . $mysqli->real_escape_string($POST["link"]) . "')
	  ";

	  // Ejecutar consulta
	  if ($mysqli->query($sql) === true) {
	    // Obtener todas las redes sociales del usuario
	    $sqlRedes = "
	      SELECT 
	        rs.red, 
	        urs.usuariosRedSocialId,
	        urs.username,
	        urs.link
	      FROM 
	        usuarios_redes_sociales urs
	      INNER JOIN 
	        redes_sociales rs ON urs.redId = rs.redSocialId
	      WHERE 
	        urs.usuarioId = " . $mysqli->real_escape_string($POST["usuarioId"]);
	    $result = $mysqli->query($sqlRedes);
	    $redes = array();
	    while ($row = $result->fetch_assoc()) {
	      $redes[] = $row;
	    }

	    return json_encode(array("estado" => "ok", "mensaje" => "Red social guardada con éxito", "redes" => $redes));
	  } else {
	    return json_encode(array("estado" => "error", "mensaje" => "Error al guardar red social: " . $mysqli->error));
	  }
	}

	function getUsuarioRedes($usuarioID) {
	    global $mysqli;

	    // Consulta SQL para obtener redes sociales del usuario
	    $sql = "
	        SELECT 
	          rs.red, 
	          rs.redSocialId, 
	          urs.*
	        FROM 
	          usuarios_redes_sociales urs
	        INNER JOIN 
	          redes_sociales rs ON urs.redId = rs.redSocialId
	        WHERE 
	          urs.usuarioId = " . $mysqli->real_escape_string($usuarioID) . "
	    ";

	    // Ejecutar consulta
	    $result = $mysqli->query($sql);

	    // Verificar resultado
	    if ($result->num_rows > 0) {
	        // Devolver arreglo de redes sociales
	        $redes = array();
	        while($row = $result->fetch_assoc()) {
	            $redes[] = $row;
	        }
	        return $redes;
	    } else {
	        // Devolver arreglo vacío
	        return array();
	    }
	}

	function altaUsuario($datos) {
	    global $mysqli;

	    // Validaciones básicas
	    if (empty($datos['nombre']) || empty($datos['email'])) {
	        echo 'Faltan campos obligatorios (nombre y email)';
	        return;
	    }

	    $datos['fecha_registro'] = date('Y-m-d H:i:s');

	    // Escapar valores
	    $nombre = $mysqli->real_escape_string($datos['nombre']);
	    $apellido = $mysqli->real_escape_string($datos['apellido'] ?? '');
	    $email = $mysqli->real_escape_string($datos['email']);
	    $dni = $mysqli->real_escape_string($datos['dni'] ?? '');
	    $apodo = $mysqli->real_escape_string($datos['apodo'] ?? '');
	    $comentario = $mysqli->real_escape_string($datos['comentario'] ?? '');
	    $direccion = $mysqli->real_escape_string($datos['direccion'] ?? '');
	    $ciudad = $mysqli->real_escape_string($datos['ciudad'] ?? '');
	    $fecha_registro = $mysqli->real_escape_string($datos['fecha_registro']);
	    $fecha_nacimiento = $mysqli->real_escape_string($datos['fecha_nacimiento'] ?? '0000-00-00');
	    $telefono = $mysqli->real_escape_string($datos['telefono'] ?? '');

	    // Valores numéricos - asegurándonos que sean 0 si están vacíos
		$altura = !empty($datos['altura']) ? intval($datos['altura']) : 0;
		$peso = !empty($datos['peso']) ? intval($datos['peso']) : 0;
		$talle = !empty($datos['talle']) ? intval($datos['talle']) : 0;
		$habilitado_sys = !empty($datos['habilitado_sys']) ? intval($datos['habilitado_sys']) : 1;
		$paisId = !empty($datos['paisId']) ? intval($datos['paisId']) : 0;
		$viajeroTipoId = !empty($datos['viajeroTipoId']) ? intval($datos['viajeroTipoId']) : 0;
		$sexoId = !empty($datos['sexoId']) ? intval($datos['sexoId']) : 0;

		

	    // Campos extra solo para username, password y usuarioTipoId
	    $camposExtra = [];
	    $valoresExtra = [];

	    if (isset($datos['username']) && !empty($datos['username'])) {
	        $usuario = $mysqli->real_escape_string($datos['username']);
	        $camposExtra[] = 'usuario';
	        $valoresExtra[] = "'$usuario'";
	    }

	    if (isset($datos['password']) && !empty($datos['password'])) {
	        $password = password_hash($datos['password'], PASSWORD_DEFAULT);
	        $camposExtra[] = 'password';
	        $valoresExtra[] = "'$password'";
	    }

	    if (isset($datos['usuarioTipoId'])) {
	        $usuarioTipoId = intval($datos['usuarioTipoId']);
	        $camposExtra[] = 'usuarioTipoId';
	        $valoresExtra[] = $usuarioTipoId;
	    }

	    // Preparar campos extras
	    $camposExtraStr = $camposExtra ? ', ' . implode(', ', $camposExtra) : '';
	    $valoresExtraStr = $valoresExtra ? ', ' . implode(', ', $valoresExtra) : '';

	    // Sentencia SQL
		$sql = "INSERT INTO usuarios (
		    nombre, apellido, email, dni, apodo, comentario, altura, peso, talle, 
		    direccion, ciudad, fecha_registro, fecha_nacimiento, habilitado_sys, 
		    paisId, viajeroTipoId, sexoId, telefono" . 
		    (!empty($datos['usuarioTipoId']) ? ", usuarioTipoId" : "") . 
		") VALUES (
		    '$nombre', '$apellido', '$email', '$dni', '$apodo', '$comentario', 
		    $altura, $peso, $talle, '$direccion', '$ciudad', '$fecha_registro', 
		    '$fecha_nacimiento', $habilitado_sys, $paisId, $viajeroTipoId, $sexoId, '$telefono'" .
		    (!empty($datos['usuarioTipoId']) ? ", " . intval($datos['usuarioTipoId']) : "") .
		")";

	    // Ejecutar la sentencia
	    if ($mysqli->query($sql)) {
	        $usuarioId = $mysqli->insert_id;

		    if ($_FILES['imagen']['size'] > 0) {
			    $imagen = $_FILES['imagen'];
			    $nombreArchivo = $usuarioId . '.jpg';
			    $nombreArchivoSmall = $usuarioId . '_small.jpg';
			    $rutaGuardar = '_recursos/profile_pics/' . $nombreArchivo;
			    $rutaGuardarSmall = '_recursos/profile_pics/' . $nombreArchivoSmall;

			    // Verificar tipo de archivo
			    $tiposPermitidos = array('image/jpeg', 'image/png');
			    if (!in_array($imagen['type'], $tiposPermitidos)) {
			        echo json_encode(['estado' => 'error', 'mensaje' => 'Solo se aceptan imágenes JPEG y PNG']);
			        return;
			    }

			    // Guardar imagen original
			    move_uploaded_file($imagen['tmp_name'], $rutaGuardar);

			    // Verificar si podemos procesar la imagen
			    if (extension_loaded('gd') && function_exists('imagecreatefromjpeg') && function_exists('imagecreatefrompng')) {
			        // Código original de procesamiento de imagen
			        $tipoImagen = strtolower(pathinfo($rutaGuardar, PATHINFO_EXTENSION));
			        switch ($tipoImagen) {
			            case 'jpg':
			            case 'jpeg':
			                $img = imagecreatefromjpeg($rutaGuardar);
			                break;
			            case 'png':
			                $img = imagecreatefrompng($rutaGuardar);
			                break;
			        }

			        if ($img) {
			            if (function_exists('exif_read_data')) {
			                $exif = @exif_read_data($rutaGuardar);
			                $orientacion = isset($exif['Orientation']) ? $exif['Orientation'] : 1;

			                switch ($orientacion) {
			                    case 3:
			                        $img = imagerotate($img, 180, 0);
			                        break;
			                    case 6:
			                        $img = imagerotate($img, -90, 0);
			                        break;
			                    case 8:
			                        $img = imagerotate($img, 90, 0);
			                        break;
			                }
			            }

			            $ancho = 100;
			            $alto = (int) (($ancho / imagesx($img)) * imagesy($img));
			            $imgSmall = imagecreatetruecolor($ancho, $alto);
			            imagecopyresampled($imgSmall, $img, 0, 0, 0, 0, $ancho, $alto, imagesx($img), imagesy($img));
			            imagejpeg($imgSmall, $rutaGuardarSmall);
			        }
			    } else {
			        // Si no podemos procesar, simplemente copiamos la imagen original como versión small
			        copy($rutaGuardar, $rutaGuardarSmall);
			    }

			    // Actualizar campo imagen en la base de datos
			    $nombreImagen = $mysqli->real_escape_string($nombreArchivoSmall);
			    $sql = "UPDATE usuarios SET imagen = '$nombreImagen' WHERE usuarioId = $usuarioId";
			    
			    if (!$mysqli->query($sql)) {
			        echo json_encode(['estado' => 'error', 'mensaje' => 'Error al actualizar la imagen en la base de datos: ' . $mysqli->error]);
			        return;
			    }
			}

		    echo json_encode(array('estado' => 'ok', 'usuarioId' => $usuarioId));
		} else {
		    if (!$mysqli->query($sql)) {
			    echo json_encode([
			        'estado' => 'error', 
			        'mensaje' => 'Error al insertar usuario: ' . $mysqli->error,
			        'sql' => $sql  // Agregar el SQL para debugging
			    ]);
			    return;
			}
		}			
	}

	function editarUsuario($datos) {
	    global $mysqli;

	    if ($_FILES['imagen']['size'] > 0) {
	        $imagen = $_FILES['imagen'];
	        $nombreArchivo = $datos['usuarioId'] . '.jpg';
	        $rutaGuardar = '_recursos/profile_pics/' . $nombreArchivo;
	        $rutaGuardarSmall = '_recursos/profile_pics/' . $datos['usuarioId'] . '_small.jpg';

	        // Verificar tipo de archivo
	        $tiposPermitidos = array('image/jpeg', 'image/png');
	        if (!in_array($imagen['type'], $tiposPermitidos)) {
	            echo 'Error: Solo se aceptan imágenes JPEG y PNG';
	            return;
	        }

	        // Guardar imagen original
	        move_uploaded_file($imagen['tmp_name'], $rutaGuardar);

	        // Crear versión pequeña de la imagen
	        $tipoImagen = strtolower(pathinfo($rutaGuardar, PATHINFO_EXTENSION));
	        switch ($tipoImagen) {
	            case 'jpg':
	            case 'jpeg':
	                $img = imagecreatefromjpeg($rutaGuardar);
	                break;
	            case 'png':
	                $img = imagecreatefrompng($rutaGuardar);
	                break;
	        }

	        if (!$img) {
	            echo 'Error: No se pudo crear la imagen';
	            return;
	        }

	        $exif = exif_read_data($rutaGuardar);
	        $orientacion = isset($exif['Orientation']) ? $exif['Orientation'] : 1;

	        switch ($orientacion) {
	            case 3:
	                // Rotar 180 grados
	                $img = imagerotate($img, 180, 0);
	                break;
	            case 6:
	                // Rotar 90 grados a la derecha
	                $img = imagerotate($img, -90, 0);
	                break;
	            case 8:
	                // Rotar 90 grados a la izquierda
	                $img = imagerotate($img, 90, 0);
	                break;
	        }

	        $ancho = 100;
	        $alto = (int) (($ancho / imagesx($img)) * imagesy($img));
	        $imgSmall = imagecreatetruecolor($ancho, $alto);
	        imagecopyresampled($imgSmall, $img, 0, 0, 0, 0, $ancho, $alto, imagesx($img), imagesy($img));
	        imagejpeg($imgSmall, $rutaGuardarSmall);

	        // Actualizar campo imagen en la base de datos
	        $datos['imagen'] = $datos['usuarioId'] . '_small.jpg';
	    } elseif (isset($datos['imagen'])) {
	        // No se subió imagen, mantener la existente
	        $datos['imagen'] = $datos['imagen'];
	    } else {
	        // No se subió imagen, obtener la imagen existente desde la base de datos
	        $sql = "SELECT imagen FROM usuarios WHERE usuarioId = '{$datos['usuarioId']}'";
	        $resultado = $mysqli->query($sql);
	        $fila = $resultado->fetch_assoc();
	        $datos['imagen'] = $fila['imagen'];
	    }

	    $usuario = array(
	        'usuarioId' => $datos['usuarioId'],
	        'nombre' => $datos['nombre'],
	        'apellido' => $datos['apellido'] ?? null,
	        'email' => $datos['email'],
	        'dni' => $datos['dni'] ?? null,
	        'apodo' => $datos['apodo'] ?? null,
	        'altura' => $datos['altura'] ?? null,
	        'peso' => $datos['peso'] ?? null,
	        'talle' => $datos['talle'] ?? null,
	        'comentario' => $datos['comentario'] ?? null,
	        'direccion' => $datos['direccion'] ?? null,
	        'ciudad' => $datos['ciudad'] ?? null,
	        'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
	        'imagen' => $datos['imagen'] ?? null,
	        'habilitado_sys' => $datos['habilitado_sys'],
	        'paisId' => $datos['paisId'] ?? null,
	        'viajeroTipoId' => $datos['viajeroTipoId'] ?? null,
	        'sexoId' => $datos['sexoId'] ?? null,
	        'telefono' => $datos['telefono'] ?? null,
	        'usuarioTipoId' => $datos['usuarioTipoId'] ?? null,
	    );

	    // Validaciones
	    if (empty($usuario['nombre']) || empty($usuario['email'])) {
	        echo 'Faltan campos obligatorios (nombre y email)';
	        return;
	    }

	    // Verificar formato email
	    if (!filter_var($usuario['email'], FILTER_VALIDATE_EMAIL)) {
	        echo 'Email inválido';
	        return;
	    }

	    // Escapar y manejar valores
	    $nombre = $mysqli->real_escape_string($usuario['nombre']);
	    $apellido = $mysqli->real_escape_string($usuario['apellido'] ?? '');
	    $email = $mysqli->real_escape_string($usuario['email']);
	    $dni = $mysqli->real_escape_string($usuario['dni'] ?? '');
	    $apodo = $mysqli->real_escape_string($usuario['apodo'] ?? '');
	    
	    $altura = $usuario['altura'] === null ? 'NULL' : floatval($usuario['altura']);
	    $peso = $usuario['peso'] === null ? 'NULL' : floatval($usuario['peso']);
	    $talle = $usuario['talle'] === null ? 'NULL' : floatval($usuario['talle']);
	    
	    $comentario = $mysqli->real_escape_string($usuario['comentario'] ?? '');
	    $direccion = $mysqli->real_escape_string($usuario['direccion'] ?? '');
	    $ciudad = $mysqli->real_escape_string($usuario['ciudad'] ?? '');
	    $fecha_nacimiento = $usuario['fecha_nacimiento'] === null || $usuario['fecha_nacimiento'] === '' ? 'NULL' : "'" . $mysqli->real_escape_string($usuario['fecha_nacimiento']) . "'";
	    $imagen = $mysqli->real_escape_string($usuario['imagen'] ?? '');
	    $habilitado_sys = $usuario['habilitado_sys'] ? 1 : 0;
	    
	    $paisId = $usuario['paisId'] === null ? 'NULL' : intval($usuario['paisId']);
	    $viajeroTipoId = $usuario['viajeroTipoId'] === null ? 'NULL' : intval($usuario['viajeroTipoId']);
	    $sexoId = $usuario['sexoId'] === null ? 'NULL' : intval($usuario['sexoId']);
	    
	    $telefono = $mysqli->real_escape_string($usuario['telefono'] ?? '');
	    $usuarioTipoId = $usuario['usuarioTipoId'] === null ? 'NULL' : intval($usuario['usuarioTipoId']);
	    $usuarioId = intval($usuario['usuarioId']);

	    // Sentencia SQL para actualizar el usuario
	    $sql = "UPDATE usuarios SET 
	        nombre = '$nombre', 
	        apellido = '$apellido', 
	        email = '$email', 
	        dni = '$dni', 
	        apodo = '$apodo', 
	        altura = $altura, 
	        peso = $peso, 
	        talle = $talle, 
	        comentario = '$comentario', 
	        direccion = '$direccion', 
	        ciudad = '$ciudad', 
	        fecha_nacimiento = $fecha_nacimiento, 
	        imagen = '$imagen', 
	        habilitado_sys = $habilitado_sys, 
	        paisId = $paisId, 
	        viajeroTipoId = $viajeroTipoId, 
	        sexoId = $sexoId,
	        telefono = '$telefono',
	        usuarioTipoId = $usuarioTipoId
	    WHERE usuarioId = $usuarioId";

	    // Ejecutar la sentencia
	    if ($mysqli->query($sql)) {
	        echo json_encode(array('estado' => 'ok', 'usuarioId' => $usuarioId));
	    } else {
	        echo json_encode(array(
	            'estado' => 'error', 
	            'mensaje' => 'Error al actualizar el usuario',
	            'msqlerror' => $mysqli->error,
	            'sql' => $sql
	        ));
	    }
	}

	function getPaises() {
	  global $mysqli;

	  // Consulta SQL
	  $sql = "SELECT * FROM paises ORDER BY pais ASC";

	  // Ejecutar consulta
	  $result = $mysqli->query($sql);

	  // Verificar resultado
	  if ($result->num_rows > 0) {
	    // Devolver arreglo de paises
	    $paises = array();
	    while($row = $result->fetch_assoc()) {
	      $paises[] = $row;
	    }
	    return $paises;
	  } else {
	    // Devolver mensaje de error
	    return "No se encontraron paises";
	  }
	}

	function getPais($paisId) {
	  global $mysqli;

	  $sql = "SELECT pais FROM paises WHERE paisId = ?";
	  $stmt = $mysqli->prepare($sql);
	  $stmt->bind_param("i", $paisId);
	  $stmt->execute();
	  $stmt->bind_result($pais);
	  $stmt->fetch();

	  return $pais;
	}

	function getSexos() {
	  global $mysqli;

	  // Consulta SQL
	  $sql = "SELECT * FROM sexo ORDER BY sexo ASC";

	  // Ejecutar consulta
	  $result = $mysqli->query($sql);

	  // Verificar resultado
	  if ($result->num_rows > 0) {
	    // Devolver arreglo de sexos
	    $sexos = array();
	    while($row = $result->fetch_assoc()) {
	      $sexos[] = $row;
	    }
	    return $sexos;
	  } else {
	    // Devolver mensaje de error
	    return "No se encontraron sexos";
	  }
	}

	function getViajes($usuarioId = null) {
	  global $mysqli;
	  
	  $query = "
	    SELECT 
	      v.*,
	      p.pais,
	      vu.cantidad_usuarios
	    FROM 
	      viajes v
	    INNER JOIN 
	      paises p ON v.paisId = p.paisId
	    LEFT JOIN 
	      (
	        SELECT 
	          viajesId, 
	          COUNT(usuarioId) AS cantidad_usuarios
	        FROM 
	          viajes_usuarios
	        GROUP BY 
	          viajesId
	      ) vu ON v.viajesId = vu.viajesId
	  ";

	  if ($usuarioId !== null) {
	    $query .= "
	      WHERE 
	        vu.usuarioId = '$usuarioId' OR 
	        vu.usuarioId IS NULL
	    ";
	  }

	  $result = $mysqli->query($query);
	  if (!$result) {
	    die("Error al obtener viajes: " . $mysqli->error);
	  }

	  $viajes = array();
	  while ($row = $result->fetch_assoc()) {
	    $viajes[] = $row;
	  }

	  return $viajes;
	}

	function getTodosViajesUsuarios($viajesId) {
	  global $mysqli;

	  $query = "
	    SELECT 
	      vu.*,
	      u.*,
	      vvt.viajeroTipoId,
	      vvt.viajero_tipo
	    FROM 
	      viajes_usuarios vu
	    INNER JOIN 
	      usuarios u ON u.usuarioId = vu.usuarioId
	    INNER JOIN 
	      viajes_viajero_tipo vvt ON vu.viajeroTipoId = vvt.viajeroTipoId
	  ";

	  $query .= "
	    AND 
	      vu.viajesId = '$viajesId'
	  ";

	  $result = $mysqli->query($query);
	  if (!$result) {
	    die("Error al obtener viajeros: " . $mysqli->error);
	  }

		$viajeros = array();

		while ($row = $result->fetch_assoc()) {
			$viajero = array(
			  "viajesUsuariosId" => $row["viajesUsuariosId"],
			  "habilitado_sys" => $row["habilitado_sys"],
			  "venta_paquete" => $row["venta_paquete"],
			  "usuario" => array(
			    "usuarioId" => $row["usuarioId"],
			    "nombre" => $row["nombre"],
			    "apellido" => $row["apellido"],
			    "apodo" => $row["apodo"],
			    "email" => $row["email"],
			    "dni" => $row["dni"],
			    "altura" => $row["altura"],
			    "peso" => $row["peso"],
			    "talle" => $row["talle"],
			    "comentario" => $row["comentario"],
			    "direccion" => $row["direccion"],
			    "telefono" => $row["telefono"],
			    "ciudad" => $row["ciudad"],
			    "fecha_registro" => $row["fecha_registro"],
			    "fecha_nacimiento" => $row["fecha_nacimiento"],
			    "imagen" => $row["imagen"],
			    "habilitado_sys" => $row["habilitado_sys"],
			    "paisId" => $row["paisId"],
			    "sexoId" => $row["sexoId"]
			  ),
			  "viajeroTipo" => array(
			    "viajeroTipoId" => $row["viajeroTipoId"],
			    "viajero_tipo" => $row["viajero_tipo"]
			  ),
			  "habitaciones_asignadas" => 0,
			  "pagos_realizado" => 0,
			);

			// Consulta para obtener el número de habitaciones asignadas
			$queryHabitaciones = "SELECT COUNT(*) AS habitaciones_asignadas 
			                     FROM viajes_hospedajes_habitaciones_usuarios 
			                     WHERE viajesUsuariosId = " . $row["viajesUsuariosId"];
			$resultHabitaciones = $mysqli->query($queryHabitaciones);
			if ($resultHabitaciones) {
			  $habitaciones = $resultHabitaciones->fetch_assoc();
			  $viajero["habitaciones_asignadas"] = $habitaciones["habitaciones_asignadas"];
			}

			// Obtengo pagos hechos por el usuario
			$queryPagos = "SELECT SUM(monto) AS totalPagado 
			                     FROM pagos 
			                     WHERE usuarioId = ".$row["usuarioId"]."
			                     AND viajesId = ".$viajesId;
			$resultPagos = $mysqli->query($queryPagos);
			if ($resultPagos) {
			  $pagos = $resultPagos->fetch_assoc();
			  $viajero["pagos_realizado"] = $pagos["totalPagado"];
			}

			// Obtengo deudas
			$queryPagos = "SELECT SUM(deuda) AS totalDeuda 
			                     FROM deudas 
			                     WHERE usuarioId = ".$row["usuarioId"]."
			                     AND viajesId = ".$viajesId;
			$resultPagos = $mysqli->query($queryPagos);
			if ($resultPagos) {
			  $pagos = $resultPagos->fetch_assoc();
			  $viajero["total_deuda"] = $pagos["totalDeuda"];
			}

			$viajeros[] = $viajero;
		}

	  return $viajeros;
	}

	function getViajesUsuarios($viajeId, $viajesHospedajesId, $conHospedaje = false) {
	  global $mysqli;
	  
		 $query = "
		  SELECT 
		    vu.viajesUsuariosId,
		    vu.habilitado_sys,
		    u.*,
		    vvt.viajeroTipoId,
		    vvt.viajero_tipo
		  FROM 
		    viajes_usuarios vu
		  INNER JOIN 
		    usuarios u ON u.usuarioId = vu.usuarioId
		  INNER JOIN 
		    viajes_viajero_tipo vvt ON vu.viajeroTipoId = vvt.viajeroTipoId
		";

		if ($conHospedaje) {
		  $query .= "
		    INNER JOIN 
		      viajes_hospedajes_habitaciones_usuarios vhhhu ON vu.viajesUsuariosId = vhhhu.viajesUsuariosId
		    WHERE 
		      vhhhu.viajesHospedajesId = '$viajesHospedajesId'
		  ";
		} else {
		  $query .= "
		    LEFT JOIN 
		      viajes_hospedajes_habitaciones_usuarios vhhhu ON vu.viajesUsuariosId = vhhhu.viajesUsuariosId
		    WHERE 
		      (vhhhu.viajesHospedajesId <> '$viajesHospedajesId' OR vhhhu.viajesUsuariosId IS NULL)
		  ";
		}

		$query .= "
		  AND 
		    vu.viajesId = '$viajeId'
		";
	  
	
	  $result = $mysqli->query($query);
	  if (!$result) {
	    die("Error al obtener viajeros: " . $mysqli->error);
	  }
	  
	  $viajeros = array();
	  while ($row = $result->fetch_assoc()) {
	    $viajero = array(
	      "viajesUsuariosId" => $row["viajesUsuariosId"],
	      "habilitado_sys" => $row["habilitado_sys"],
	      "usuario" => array(
	        "usuarioId" => $row["usuarioId"],
	        "nombre" => $row["nombre"],
	        "apellido" => $row["apellido"],
	        "apodo" => $row["apodo"],
	        "email" => $row["email"],
	        "dni" => $row["dni"],
	        "altura" => $row["altura"],
	        "peso" => $row["peso"],
	        "talle" => $row["talle"],
	        "comentario" => $row["comentario"],
	        "direccion" => $row["direccion"],
	        "ciudad" => $row["ciudad"],
	        "fecha_registro" => $row["fecha_registro"],
	        "fecha_nacimiento" => $row["fecha_nacimiento"],
	        "imagen" => $row["imagen"],
	        "habilitado_sys" => $row["habilitado_sys"],
	        "paisId" => $row["paisId"],
	        "sexoId" => $row["sexoId"]
	      ),
	      "viajeroTipo" => array(
	        "viajeroTipoId" => $row["viajeroTipoId"],
	        "viajero_tipo" => $row["viajero_tipo"]
	      )
	    );
	    $viajeros[] = $viajero;
	  }
	  
	  return $viajeros;
	}

	function getHospedajes($paisId = null) {
	  global $mysqli;

	  // Consulta SQL para obtener hospedajes
	  $sql = "
	    SELECT 
	      h.*, 
	      p.pais
	    FROM 
	      hospedajes h
	    INNER JOIN 
	      paises p ON h.paisId = p.paisId
	  ";

	  // Agregar condición de país si se proporciona
	  if ($paisId !== null) {
	    $sql .= " WHERE h.paisId = '$paisId'";
	  }

	  // Ejecutar consulta
	  $result = $mysqli->query($sql);

	  // Verificar resultado
	  if ($result->num_rows > 0) {
	    // Devolver arreglo de hospedajes
	    $hospedajes = array();
	    while($row = $result->fetch_assoc()) {
	      $hospedajes[] = $row;
	    }
	    return $hospedajes;
	  } else {
	    // Devolver arreglo vacío
	    return array();
	  }
	}

	function getHospedajeHabitacionesBases($baseId = null) {
	  global $mysqli;

	  $sql = "
	    SELECT 
	      baseHospedajeId, 
	      nombre 
	    FROM 
	      hospedaje_habitaciones_bases
	  ";

	  if ($baseId !== null) {
	    $sql .= " WHERE baseHospedajeId = '$baseId'";
	  }

	  $sql .= " ORDER BY baseHospedajeId ASC";

	  $result = $mysqli->query($sql);

	  if ($result->num_rows > 0) {
	    if ($baseId !== null) {
	      return $result->fetch_assoc();
	    } else {
	      $bases = array();
	      while($row = $result->fetch_assoc()) {
	        $bases[] = $row;
	      }
	      return $bases;
	    }
	  } else {
	    return array();
	  }
	}

	function getHospedajeHabitacionesTipos() {
	  global $mysqli;

	  $sql = "
	    SELECT 
	      tipoHospedajeId, 
	      nombre 
	    FROM 
	      hospedaje_habitaciones_tipos
	  ";

	  $result = $mysqli->query($sql);

	  if ($result->num_rows > 0) {
	    $tipos = array();
	    while($row = $result->fetch_assoc()) {
	      $tipos[] = $row;
	    }
	    return $tipos;
	  } else {
	    return array();
	  }
	}

	function getHospedajeHabitacionesTarifasAvanzado($hospedajesId){
	  global $mysqli;

	  $sql = "SELECT * FROM hospedaje_habitaciones_tarifas WHERE hospedajesId = ".$hospedajesId;
	  $result = $mysqli->query($sql);
	  $aTarifas = array();
	  while($row = $result->fetch_assoc()) {
	  	$base = getHospedajeHabitacionesBases($row["baseHospedajeId"]);
  		$row["base"] = $base;
  		$aTarifas[] = $row;
	  }

	  return $aTarifas;
	}

	function getHospedajeHabitacionesTarifas($hospedajesId) {
	  global $mysqli;

	  $sql = "
	    SELECT 
	      ht.hospedajeTarifaId, 
	      ht.alias, 
		  hb.baseHospedajeId,
	      hb.nombre AS base, 
	      ht.tipoHospedajeId, 
	      htt.nombre AS tipo, 
	      ht.precio 
	    FROM 
	      hospedaje_habitaciones_tarifas ht 
	    INNER JOIN 
	      hospedaje_habitaciones_bases hb ON ht.baseHospedajeId = hb.baseHospedajeId 
	    INNER JOIN 
	      hospedaje_habitaciones_tipos htt ON ht.tipoHospedajeId = htt.tipoHospedajeId
	    WHERE
	      ht.hospedajesId = ".$hospedajesId."
		ORDER BY 
      	  ht.alias ASC";


	  $result = $mysqli->query($sql);

	  if ($result->num_rows > 0) {
	    $tarifas = array();
	    while($row = $result->fetch_assoc()) {
	      $tarifas[] = $row;
	    }
	    return $tarifas;
	  } else {
	    return array();
	  }
	}

	function getViajesHospedajes($viajesId) {
		global $mysqli;
	  
		$sql = "
		  SELECT 
		    vh.viajesHospedajesId, 
		    v.viajesId, 
		    h.hospedajesId, 
		    h.nombre AS hospedaje,
		    (SELECT COUNT(*) FROM hospedaje_habitaciones_tarifas WHERE hospedajesId = h.hospedajesId) AS tarifas_cargadas,
		    (SELECT COUNT(*) FROM viajes_hospedajes_habitaciones WHERE viajesHospedajesId = vh.viajesHospedajesId) AS habitaciones_creadas,
		    (SELECT COUNT(*) FROM viajes_hospedajes_habitaciones_usuarios WHERE viajesHospedajesHabitacionId IN (SELECT viajesHospedajesHabitacionId FROM viajes_hospedajes_habitaciones WHERE viajesHospedajesId = vh.viajesHospedajesId)) AS usuarios_asignados,
		    COALESCE(SUM(vhh.camas_dobles * 2 + vhh.camas_simples), 0) AS capacidad_total,
		    COALESCE(SUM(vhh.camas_dobles * 2 + vhh.camas_simples), 0) - (SELECT COUNT(*) FROM viajes_hospedajes_habitaciones_usuarios WHERE viajesHospedajesHabitacionId IN (SELECT viajesHospedajesHabitacionId FROM viajes_hospedajes_habitaciones WHERE viajesHospedajesId = vh.viajesHospedajesId)) AS capacidad_disponible
		  FROM 
		    viajes_hospedajes vh 
		  INNER JOIN 
		    viajes v ON vh.viajesId = v.viajesId 
		  INNER JOIN 
		    hospedajes h ON vh.hospedajesId = h.hospedajesId
		  LEFT JOIN 
		    viajes_hospedajes_habitaciones vhh ON vh.viajesHospedajesId = vhh.viajesHospedajesId
		  WHERE 
		    vh.viajesId = ?
		  GROUP BY 
		    vh.viajesHospedajesId, 
		    v.viajesId, 
		    h.hospedajesId, 
		    h.nombre 
		";
	  
		$stmt = $mysqli->prepare($sql);

		if ($stmt === false) {
		    echo "Error en la consulta SQL: " . $mysqli->error;
		    return array();
		}

		$stmt->bind_param("i", $viajesId);
		$stmt->execute();
		$result = $stmt->get_result();
	  
		if ($result->num_rows > 0) {
		  $viajesHospedajes = array();
		  while($row = $result->fetch_assoc()) {
			$viajesHospedajes[] = $row;
		  }
		  return $viajesHospedajes;
		} else {
		  return array();
		}
	 }

	function getViajesViajeroTipo() {
	  global $mysqli;

	  // Consulta SQL
	  $sql = "SELECT * FROM viajes_viajero_tipo ORDER BY viajero_tipo ASC";

	  $result = $mysqli->query($sql);

	  if ($result->num_rows > 0) {
	    $viajesViajeroTipo = array();
	    while($row = $result->fetch_assoc()) {
	      $viajesViajeroTipo[] = $row;
	    }
	    return $viajesViajeroTipo;
	  } else {
	    return array();
	  }
	}

	function getUsuariosTipo() {
	  global $mysqli;

	  // Consulta SQL
	  $sql = "SELECT * FROM usuarios_tipo";

	  $result = $mysqli->query($sql);

	  if ($result->num_rows > 0) {
	    $viajesViajeroTipo = array();
	    while($row = $result->fetch_assoc()) {
	      $viajesViajeroTipo[] = $row;
	    }
	    return $viajesViajeroTipo;
	  } else {
	    return array();
	  }
	}


	function altaHospedaje($data) {
	  global $mysqli;
	  
	  	// Buscar o insertar país
		$pais = trim(strtolower($data['pais']));
		$sqlBuscarPais = "SELECT paisId FROM paises WHERE LOWER(pais) = '" . $mysqli->real_escape_string($pais) . "'";
		$resultPais = $mysqli->query($sqlBuscarPais);

		if ($resultPais->num_rows > 0) {
			$rowPais = $resultPais->fetch_assoc();
			$paisId = $rowPais['paisId'];
		} else {
			$paisCapitalizado = ucwords(strtolower($data['pais']));
			$sqlInsertPais = "INSERT INTO paises (pais) VALUES ('" . $mysqli->real_escape_string($paisCapitalizado) . "')";
			$mysqli->query($sqlInsertPais);
			$paisId = $mysqli->insert_id;
		}

	  // Escapar valores
	  $nombre = $mysqli->real_escape_string($data['nombre']);
	  $paisId = intval($paisId);
	  $direccion = $mysqli->real_escape_string($data['direccion']);
	  $telefono = $mysqli->real_escape_string($data['telefono']);
	  $email = $mysqli->real_escape_string($data['email']);
	  $estrellas = floatval($data['estrellas']);
	  $comentario = $mysqli->real_escape_string($data['comentario']);

	  // Consulta SQL
	  $query = "INSERT INTO hospedajes (nombre, paisId, direccion, telefono, email, estrellas, comentario) 
	            VALUES ('$nombre', $paisId, '$direccion', '$telefono', '$email', $estrellas, '$comentario')";
	  
	  if ($mysqli->query($query)) {
	    echo "ok";
	  } else {
	    die("Error al insertar el registro: " . $mysqli->error);
	  }
	}

	function altaViaje($params) {
	    global $mysqli;
	    
	    // Primero buscar o insertar el país y obtener su ID
	    $pais = trim(strtolower($params['pais'])); // Normalizar el nombre del país
	    
	    // Buscar el país en la base de datos
	    $sqlBuscarPais = "SELECT paisId FROM paises WHERE LOWER(pais) = ?";
	    $stmtBuscarPais = $mysqli->prepare($sqlBuscarPais);
	    $stmtBuscarPais->bind_param("s", $pais);
	    $stmtBuscarPais->execute();
	    $resultadoPais = $stmtBuscarPais->get_result();
	    
	    if ($resultadoPais->num_rows > 0) {
	        // Si el país existe, obtener su ID
	        $rowPais = $resultadoPais->fetch_assoc();
	        $paisId = $rowPais['paisId'];
	    } else {
	        // Si el país no existe, insertarlo
	        $sqlInsertarPais = "INSERT INTO paises (pais) VALUES (?)";
	        $stmtInsertarPais = $mysqli->prepare($sqlInsertarPais);
	        $paisCapitalizado = ucwords(strtolower($params['pais'])); // Capitalizar el nombre del país
	        $stmtInsertarPais->bind_param("s", $paisCapitalizado);
	        
	        if (!$stmtInsertarPais->execute()) {
	            return json_encode(array(
	                'estado' => 'error', 
	                'mensaje' => 'Error al crear nuevo país'
	            ));
	        }
	        
	        $paisId = $mysqli->insert_id;
	    }
	    
	    // Extraer año de fecha_inicio
	    $anio = date('Y', strtotime($params['fecha_inicio']));
	    // Valores por defecto
	    $activo = 0;
	    
	    // Consulta SQL para insertar el viaje
	    // Consulta SQL para insertar el viaje
		$sql = "
		    INSERT INTO 
		        viajes (paisId, nombre, anio, fecha_inicio, fecha_fin, activo, descripcion, viaje_pdf)
		    VALUES 
		        (?, ?, ?, ?, ?, ?, ?, ?)
		";

		// Preparar consulta
		$stmt = $mysqli->prepare($sql);

		// Vincular parámetros
		$stmt->bind_param("isisssss", 
		    $paisId,  // Usar el ID del país que encontramos o insertamos
		    $params['nombre'], // Agregar el nombre del viaje
		    $anio, 
		    $params['fecha_inicio'], 
		    $params['fecha_fin'], 
		    $activo, 
		    $params['descripcion'], 
		    $params['viaje_pdf']
		);
	    
	    // Ejecutar consulta
	    if ($stmt->execute()) {
	        return json_encode(array(
	            'estado' => 'ok', 
	            'mensaje' => 'Viaje creado con éxito'
	        ));
	    } else {
	        return json_encode(array(
	            'estado' => 'error', 
	            'mensaje' => 'Error al crear viaje'
	        ));
	    }
	}

	function eliminarArchivo($viajesId) {
	  global $mysqli, $RUTA_FILE_VIAJES;

	  // // Consultar el archivo asociado al viaje
	  // $sql = "SELECT viaje_pdf FROM viajes WHERE viajesId = $viajesId";
	  // $result = $mysqli->query($sql);
      // $row = $result->fetch_assoc();

	  // $archivo = "_recursos/viajes_pdf/" . $row["viaje_pdf"];
	  
	  // // Eliminar el archivo
	  // if (file_exists($archivo)) {
	  //   if (!unlink($archivo)) {
	  //     echo "Error al eliminar archivo";
	  //     return false;
	  //   }
	  // }

	  // Actualizar la base de datos
	  $sql = "UPDATE viajes SET viaje_pdf = NULL WHERE viajesId = $viajesId";
	  $result = $mysqli->query($sql);
	}

	function editarViaje($params, $viajesId) {
	    global $mysqli, $RUTA_FILE_VIAJES;
	    
	    // Buscar o insertar país
	    $pais = trim(strtolower($params['pais']));
	    $sqlBuscarPais = "SELECT paisId FROM paises WHERE LOWER(pais) = '" . $mysqli->real_escape_string($pais) . "'";
	    $resultPais = $mysqli->query($sqlBuscarPais);
	    
	    if ($resultPais->num_rows > 0) {
	        $rowPais = $resultPais->fetch_assoc();
	        $paisId = $rowPais['paisId'];
	    } else {
	        $paisCapitalizado = ucwords(strtolower($params['pais']));
	        $sqlInsertPais = "INSERT INTO paises (pais) VALUES ('" . $mysqli->real_escape_string($paisCapitalizado) . "')";
	        $mysqli->query($sqlInsertPais);
	        $paisId = $mysqli->insert_id;
	    }

	    $anio = date('Y', strtotime($params['fecha_inicio']));
	    $rutaDestino = $_SERVER['DOCUMENT_ROOT'] . '/' . $RUTA_FILE_VIAJES;
	    $nombreArchivo = limpiarNombreArchivo($params['nombre']) . '_' . $anio . '_' . $viajesId . '_' . time() . '.pdf';
	    
	    if (isset($_FILES['viaje_pdf'])) {
	        $tmpNombre = $_FILES['viaje_pdf']['tmp_name'];
	        move_uploaded_file($tmpNombre, $rutaDestino . $nombreArchivo);
	    } else {
	        $nombreArchivo = $params['viaje_pdf'] ?? null;
	    }
	    
	    $activo = !empty($params['activo']) ? 1 : 0;
	    
	    $sql = "UPDATE viajes 
	            SET paisId = " . $paisId . ",
	                nombre = '" . $mysqli->real_escape_string($params['nombre']) . "',
	                anio = " . $anio . ", 
	                fecha_inicio = '" . $mysqli->real_escape_string($params['fecha_inicio']) . "', 
	                fecha_fin = '" . $mysqli->real_escape_string($params['fecha_fin']) . "', 
	                activo = " . $activo . ", 
	                descripcion = '" . $mysqli->real_escape_string($params['descripcion']) . "'
	                
	            WHERE viajesId = " . $viajesId;

	    if ($mysqli->query($sql)) {
	        $respuesta = array(
	            'estado' => 'ok',
	            'mensaje' => 'Viaje actualizado con éxito',
	            'viaje_pdf' => $rutaDestino . $nombreArchivo
	        );
	    } else {
	        $respuesta = array(
	            'estado' => 'error',
	            'mensaje' => 'Error al actualizar viaje'
	        );
	    }
	    
	    return json_encode($respuesta);
	}

	function eliminarViajero($data) {
	  global $mysqli;

	  // Consulta para verificar si el usuario está participando del viaje
	  $queryVerificar = "SELECT viajesUsuariosId FROM viajes_usuarios WHERE viajesId = ? AND usuarioId = ?";
	  $stmtVerificar = $mysqli->prepare($queryVerificar);
	  $stmtVerificar->bind_param('ii', $data['viajesId'], $data['usuarioId']);
	  $stmtVerificar->execute();
	  $result = $stmtVerificar->get_result();
	  $stmtVerificar->close();


	  if ($result->num_rows == 0) {
	    echo "El usuario no está participando del viaje";
	    return;
	  }

	  $fila = $result->fetch_assoc();
	  $viajesUsuariosId = $fila['viajesUsuariosId'];

	  //elimino usuario
	  agregarDeudaUsuarioPaquete($viajesUsuariosId, true);

	  // Eliminar al usuario de las habitaciones asignadas
	  $queryEliminarHabitacionUsuario = "DELETE FROM viajes_hospedajes_habitaciones_usuarios WHERE viajesUsuariosId = ?";
	  if ($stmt = $mysqli->prepare($queryEliminarHabitacionUsuario)) {
	    $stmt->bind_param('i', $viajesUsuariosId);
	    $stmt->execute();
	    $stmt->close();
	  } else {
	    echo "Error al preparar la consulta de habitación: " . $mysqli->error;
	  }

	  // Eliminar al usuario del viaje
	  $queryEliminarViajeUsuario = "DELETE FROM viajes_usuarios WHERE viajesId = ? AND usuarioId = ?";
	  if ($stmt = $mysqli->prepare($queryEliminarViajeUsuario)) {
	    $stmt->bind_param('ii', $data['viajesId'], $data['usuarioId']);
	    if($stmt->execute()) {
	      $stmt->close();

	      

	      echo "ok";


	    } else {
	      die("Error al eliminar el registro de viaje: " . $stmt->error);
	    }
	  } else {
	    echo "Error al preparar la consulta de viaje: " . $mysqli->error;
	  }
	}

	function altaViajero($data) {
	  global $mysqli;

	  // Consulta para verificar si el usuario ya existe en el viaje
	  $queryVerificar = "SELECT * FROM viajes_usuarios WHERE viajesId = ? AND usuarioId = ?";
	  $stmtVerificar = $mysqli->prepare($queryVerificar);
	  $stmtVerificar->bind_param('ii', $data['viajesId'], $data['usuarioId']);
	  $stmtVerificar->execute();
	  $result = $stmtVerificar->get_result();
	  $stmtVerificar->close();

	  if ($result->num_rows > 0) {
	    echo "El usuario ya está participando del viaje";
	    return;
	  }

	  // Establece venta_paquete en NULL si es 0
	  $venta_paquete = $data["venta_paquete"] == 0 ? NULL : $data["venta_paquete"];

	  // Si no existe, procedemos con la alta
	  $query = "INSERT INTO viajes_usuarios (viajesId, usuarioId, viajeroTipoId, venta_paquete, habilitado_sys) VALUES (?, ?, ?, ?, ?)";
	  $data['habilitado_sys'] = 1;

	  if ($stmt = $mysqli->prepare($query)) {
	    if ($venta_paquete === NULL) {
	      $stmt->bind_param('iiis', $data['viajesId'], $data['usuarioId'], $data['viajeroTipoId'], $venta_paquete, $data['habilitado_sys']);
	    } else {
	      $stmt->bind_param('iiidi', $data['viajesId'], $data['usuarioId'], $data['viajeroTipoId'], $venta_paquete, $data['habilitado_sys']);
	    }
	    if($stmt->execute()) {
	      $stmt->close();

	      $viajesUsuariosId = $mysqli->insert_id;
	      agregarDeudaUsuarioPaquete($viajesUsuariosId);

	      echo "ok";
	    } else {
	      die("Error al insertar el registro: " . $stmt->error);
	    }
	  } else {
	    echo "Error al preparar la consulta: " . $mysqli->error;
	  }
	}

	function agregarDeudaUsuarioPaquete($viajesUsuariosId, $soloBorrar = false){

		global $mysqli, $SUBRUBRO_ID_PAQUETE_TURISTICO;

		$query = "SELECT vu.*, v.nombre, p.pais, v.anio FROM viajes_usuarios vu 
				  INNER JOIN viajes v ON v.viajesId = vu.viajesId
				  INNER JOIN paises p ON v.paisId = p.paisId
				  WHERE viajesUsuariosId = ".$viajesUsuariosId;
		$result = $mysqli->query($query);
		$row = $result->fetch_assoc();

		$sqlDelete = "DELETE FROM deudas 
					  WHERE viajesId = ".$row["viajesId"]."
					  	AND usuarioId = ".$row["usuarioId"]."
					  	AND pagosSubrubroId = ".$SUBRUBRO_ID_PAQUETE_TURISTICO;
	    $mysqli->query($sqlDelete);
		if($soloBorrar)
			return;

		if(!empty($row['venta_paquete'])) {

			$deuda["comentario"] = "Venta paquete ".$row['nombre']." ".$row['anio'];
			$deuda['deuda'] = $row['venta_paquete'];
			$deuda['monedaId'] = 2; //dolares 
			$deuda['usuarioId'] = $row["usuarioId"];
			$deuda['viajesId'] = $row["viajesId"];
			$deuda['pagosSubrubroId'] = $SUBRUBRO_ID_PAQUETE_TURISTICO; //Venta paquetes
			$deuda['habilitado_sys'] = 1;

			$res = altaDeuda($deuda);
		}	
	}

	function editarViajero($data){

	  global $mysqli;

	  // Establece venta_paquete en NULL si es 0
  	  $venta_paquete = $data["venta_paquete"] == 0 ? NULL : $data["venta_paquete"];

		// Si existe, procedemos con la edición
	  $query = "UPDATE viajes_usuarios SET viajeroTipoId = ?, venta_paquete = ? WHERE viajesUsuariosId = ?";
	  if ($stmt = $mysqli->prepare($query)) {
	    $stmt->bind_param('idi', $data['viajeroTipoId'], $venta_paquete, $data['viajesUsuariosId']);
	    if($stmt->execute()) {
	      	$stmt->close();

			$query = "SELECT vu.*, v.anio, p.pais FROM viajes_usuarios vu 
						INNER JOIN viajes v ON v.viajesId = vu.viajesId
						INNER JOIN paises p ON v.paisId = p.paisId
						WHERE viajesUsuariosId = ".$data['viajesUsuariosId'];
			$result = $mysqli->query($query);
			$row = $result->fetch_assoc();

	      	if(!empty($row['venta_paquete'])) {
			    agregarDeudaUsuarioPaquete($data['viajesUsuariosId']);
			}

	      echo "ok";
	    } else {
	      die("Error al editar el registro: " . $stmt->error);
	    }
	  } else {
	    echo "Error al preparar la consulta: " . $mysqli->error;
	  }

	}

	// function borrarViajero($viajesUsuariosId) {
	//   global $mysqli;

	//   // Preparamos la consulta utilizando ? como placeholders
	//   $query = "DELETE FROM viajes_usuarios WHERE viajesUsuariosId = ?";

	//   agregarDeudaUsuarioPaquete($viajesUsuariosId, true);

	//   // Preparamos la consulta
	//   if ($stmt = $mysqli->prepare($query)) {
	//     $stmt->bind_param('i', $viajesUsuariosId);
	//     if($stmt->execute()) {
	//       $stmt->close();
	//       echo "ok";
	//     } else {
	//       die("Error al eliminar el registro: " . $stmt->error);
	//     }
	//   } else {
	//     echo "Error al preparar la consulta: " . $mysqli->error;
	//   }
	// }

	function editarHospedaje($data, $hospedajesId) {
		global $mysqli;

		// Buscar o insertar país
		$pais = trim(strtolower($data['pais']));
		$sqlBuscarPais = "SELECT paisId FROM paises WHERE LOWER(pais) = '" . $mysqli->real_escape_string($pais) . "'";
		$resultPais = $mysqli->query($sqlBuscarPais);

		if ($resultPais->num_rows > 0) {
			$rowPais = $resultPais->fetch_assoc();
			$paisId = $rowPais['paisId'];
		} else {
			$paisCapitalizado = ucwords(strtolower($data['pais']));
			$sqlInsertPais = "INSERT INTO paises (pais) VALUES ('" . $mysqli->real_escape_string($paisCapitalizado) . "')";
			$mysqli->query($sqlInsertPais);
			$paisId = $mysqli->insert_id;
		}

		// Consulta para editar hospedaje
		$query = "UPDATE hospedajes SET 
		        nombre = '" . $data['nombre'] . "', 
		        paisId = " . $paisId . ", 
		        direccion = '" . $data['direccion'] . "', 
		        telefono = '" . $data['telefono'] . "', 
		        email = '" . $data['email'] . "', 
		        estrellas = " . $data['estrellas'] . ", 
		        comentario = '" . $data['comentario'] . "' 
		        WHERE hospedajesId = " . $hospedajesId;

		// Ejecutar consulta
		if ($mysqli->query($query)) {
			echo "ok";
		} else {
			die("Error al actualizar el registro: " . $mysqli->error);
		}
	}


	function altaViajeHospedaje($data) {
	  global $mysqli;

	  // Consulta para verificar si el usuario ya existe en el viaje
	  $queryVerificar = "SELECT * FROM viajes_hospedajes WHERE viajesId = ? AND hospedajesId = ?";
	  $stmtVerificar = $mysqli->prepare($queryVerificar);
	  $stmtVerificar->bind_param('ii', $data['viajesId'], $data['hospedajesId']);
	  $stmtVerificar->execute();
	  $result = $stmtVerificar->get_result();
	  $stmtVerificar->close();

	  if ($result->num_rows > 0) {
	    echo "El hospedaje ya está declarado en el viaje";
	    return;
	  }

	  // Si no existe, procedemos con la alta
	  $query = 'INSERT INTO viajes_hospedajes (viajesId, hospedajesId) 
	  			VALUES ('.$data["viajesId"].', '.$data["hospedajesId"].')';
	  
	  if ($mysqli->query($query)) {
	    echo "ok";
	  } else {
	    die("Error al actualizar el registro: " . $mysqli->error);
	  }
	}

	function getMatrizHospedaje() {
	  return array(
	    'bases' => getHospedajeHabitacionesBases(),
	    'tipos' => getHospedajeHabitacionesTipos()
	  );
	}

	function guardarHospedajeHabitacionesTarifas($data) {
	  global $mysqli;

	  // Consulta para verificar si la tarifa ya existe
	  $queryVerificar = "SELECT * FROM hospedaje_habitaciones_tarifas 
	                     WHERE baseHospedajeId = ? AND tipoHospedajeId = ? AND hospedajesId = ?";
	  $stmtVerificar = $mysqli->prepare($queryVerificar);
	  $stmtVerificar->bind_param('iii', $data['baseHospedajeId'], $data['tipoHospedajeId'], $data['hospedajesId']);
	  $stmtVerificar->execute();
	  $result = $stmtVerificar->get_result();
	  $stmtVerificar->close();

	  if ($result->num_rows > 0) {
	    // Si existe, actualizamos la tarifa
	    $query = 'UPDATE hospedaje_habitaciones_tarifas 
	              SET precio = ?, alias = ? 
	              WHERE baseHospedajeId = ? AND tipoHospedajeId = ? AND hospedajesId = ?';
	    $stmt = $mysqli->prepare($query);
	    $stmt->bind_param('ssiii', 
	      $data['precio'], 
	      $data['alias'], 
	      $data['baseHospedajeId'], 
	      $data['tipoHospedajeId'], 
	      $data['hospedajesId']
	    );
	  } else {
	    // Si no existe, procedemos con la alta
	    $query = 'INSERT INTO hospedaje_habitaciones_tarifas (baseHospedajeId, tipoHospedajeId, hospedajesId, precio, alias) 
	              VALUES (?, ?, ?, ?, ?)';
	    $stmt = $mysqli->prepare($query);
	    $stmt->bind_param('iiids', 
	      $data['baseHospedajeId'], 
	      $data['tipoHospedajeId'], 
	      $data['hospedajesId'], 
	      $data['precio'], 
	      $data['alias']
	    );
	  }

	  if ($stmt->execute()) {
	    echo "ok";
	  } else {
	    die("Error al actualizar el registro: " . $mysqli->error);
	  }
	}

	function eliminarHospedajeHabitacionesTarifas($data) {
	  global $mysqli;

	  $query = 'DELETE FROM hospedaje_habitaciones_tarifas 
	            WHERE baseHospedajeId = ? AND tipoHospedajeId = ? AND hospedajesId = ?';
	  $stmt = $mysqli->prepare($query);
	  $stmt->bind_param('iii', $data["baseHospedajeId"], $data["tipoHospedajeId"], $data["hospedajesId"]);

	  if ($stmt->execute()) {
	    echo "ok";
	  } else {
	    die("Error al eliminar el registro: " . $mysqli->error);
	  }
	}

	function getViajeHospedajeHabitaciones($viajesHospedajesId) {
		global $mysqli;
		
		$bases = getHospedajeHabitacionesBases();
		
		// // Obtiene el hospedaje id
		// $viajeHospedajesQuery = "SELECT * FROM viajes_hospedajes WHERE viajesHospedajesId = '$viajesHospedajesId'";
		// $viajeHospedajesResult = $mysqli->query($viajeHospedajesQuery);
		// $viajeHospedajesRow = $viajeHospedajesResult->fetch_assoc();

		// $hospedajeId = $viajeHospedajesRow["hospedajeId"];

		// Obtiene las habitaciones del hospedaje
		$viajeHospedajesHabitacionesQuery = "SELECT * FROM viajes_hospedajes_habitaciones vhh WHERE vhh.viajesHospedajesId = '$viajesHospedajesId'";
		$viajeHospedajesHabitacionesResult = $mysqli->query($viajeHospedajesHabitacionesQuery);
		$viajeHospedajesHabitaciones = array();

		while ($viajeHospedajesHabitacionesRow = $viajeHospedajesHabitacionesResult->fetch_assoc()) {
			
			$aViajeHabitacion = $viajeHospedajesHabitacionesRow;


			$tarifaQuery = "SELECT * FROM hospedaje_habitaciones_tarifas ht WHERE ht.hospedajeTarifaId = ".$viajeHospedajesHabitacionesRow['hospedajeTarifaId'];
		  	$tarifaResult = $mysqli->query($tarifaQuery);
		  	$aTarifas = array();
		  	$tarifaRow = $tarifaResult->fetch_assoc();

		  		$base = getHospedajeHabitacionesBases($tarifaRow["baseHospedajeId"]);
		  		$tarifaRow["base"] = $base;
		  	
		  	$aViajeHabitacion["tarifa"] = $tarifaRow;

			$viajesHospedajesHabitacionUsuariosQuery = "SELECT * 
			  		FROM viajes_hospedajes_habitaciones_usuarios vhhu
					INNER JOIN viajes_usuarios vu ON vu.viajesUsuariosId = vhhu.viajesUsuariosId
					INNER JOIN usuarios u ON u.usuarioId = vu.usuarioId
			  		WHERE viajesHospedajesHabitacionId = '" . $viajeHospedajesHabitacionesRow['viajesHospedajesHabitacionId'] . "'";
			  		
			$viajesHospedajesHabitacionUsuariosResult = $mysqli->query($viajesHospedajesHabitacionUsuariosQuery);

			$aViajesHabitacionesUsuarios = array();
			$aViajeHabitacion["viajesHospedajesHabitacionUsuarios"] = array();

		  	while ($viajesHospedajesHabitacionUsuariosRow = $viajesHospedajesHabitacionUsuariosResult->fetch_assoc()) {

		  		$usuarioTemp;
		  		$usuarioTemp["usuarioId"] = $viajesHospedajesHabitacionUsuariosRow["usuarioId"];
				$usuarioTemp["viajeroTipoId"] = $viajesHospedajesHabitacionUsuariosRow["viajeroTipoId"];
				$usuarioTemp["habilitado_sys"] = $viajesHospedajesHabitacionUsuariosRow["habilitado_sys"];
				$usuarioTemp["nombre"] = $viajesHospedajesHabitacionUsuariosRow["nombre"];
				$usuarioTemp["apellido"] = $viajesHospedajesHabitacionUsuariosRow["apellido"];
				$usuarioTemp["email"] = $viajesHospedajesHabitacionUsuariosRow["email"];
				$usuarioTemp["dni"] = $viajesHospedajesHabitacionUsuariosRow["dni"];
				$usuarioTemp["apodo"] = $viajesHospedajesHabitacionUsuariosRow["apodo"];
				$usuarioTemp["altura"] = $viajesHospedajesHabitacionUsuariosRow["altura"];
				$usuarioTemp["peso"] = $viajesHospedajesHabitacionUsuariosRow["peso"];
				$usuarioTemp["talle"] = $viajesHospedajesHabitacionUsuariosRow["talle"];
				$usuarioTemp["comentario"] = $viajesHospedajesHabitacionUsuariosRow["comentario"];
				$usuarioTemp["direccion"] = $viajesHospedajesHabitacionUsuariosRow["direccion"];
				$usuarioTemp["ciudad"] = $viajesHospedajesHabitacionUsuariosRow["ciudad"];
				$usuarioTemp["fecha_registro"] = $viajesHospedajesHabitacionUsuariosRow["fecha_registro"];
				$usuarioTemp["fecha_nacimiento"] = $viajesHospedajesHabitacionUsuariosRow["fecha_nacimiento"];
				$usuarioTemp["imagen"] = $viajesHospedajesHabitacionUsuariosRow["imagen"];
				$usuarioTemp["paisId"] = $viajesHospedajesHabitacionUsuariosRow["paisId"];
				$usuarioTemp["sexoId"] = $viajesHospedajesHabitacionUsuariosRow["sexoId"];

				$habitacionTemp;

				$habitacionTemp["viajesHospedajesHabitacionId"] = $viajesHospedajesHabitacionUsuariosRow["viajesHospedajesHabitacionId"];
				$habitacionTemp["viajesUsuariosId"] = $viajesHospedajesHabitacionUsuariosRow["viajesUsuariosId"];
				$habitacionTemp["viajesId"] = $viajesHospedajesHabitacionUsuariosRow["viajesId"];
				$habitacionTemp["cama_doble"] = $viajesHospedajesHabitacionUsuariosRow["cama_doble"];
				$habitacionTemp["cama_simple"] = $viajesHospedajesHabitacionUsuariosRow["cama_simple"];
				$habitacionTemp["usuario"] = $usuarioTemp;

		  		$aViajesHabitacionesUsuarios[] = $habitacionTemp;


		  		$aViajeHabitacion["viajesHospedajesHabitacionUsuarios"] = $aViajesHabitacionesUsuarios;


		  	}

		  	$viajeHospedajesHabitaciones[] = $aViajeHabitacion;

		}


		return $viajeHospedajesHabitaciones;

		// // Obtiene los datos del viaje hospedaje
		// $query = "SELECT * FROM viajes_hospedajes vh WHERE vh.viajesHospedajesId = '$viajesHospedajesId'";
		// $result = $mysqli->query($query);
		// $row = $result->fetch_assoc();
	  
		// // Obtiene los datos del hospedaje
		// $hospedajeQuery = "
		//   SELECT * FROM hospedajes h WHERE h.hospedajesId = '" . $row['hospedajesId'] . "'";
		// $hospedajeResult = $mysqli->query($hospedajeQuery);
		// $hospedajeRow = $hospedajeResult->fetch_assoc();
	  
		
	  
		// while ($habitacionRow = $habitacionesResult->fetch_assoc()) {
		//   // Obtiene la tarifa de la habitación
		//   $tarifaQuery = "SELECT * FROM hospedaje_habitaciones_tarifas ht WHERE ht.hospedajeTarifaId = '" . $habitacionRow['hospedajeTarifaId'] . "'";
		//   $tarifaResult = $mysqli->query($tarifaQuery);
		//   $tarifaRow = $tarifaResult->fetch_assoc();

		//   $idColumn = array_column($bases, 'nombre', 'baseHospedajeId');
		//   $nombreBase = $idColumn[$tarifaRow['baseHospedajeId']] ?? null;
			
		//   $usuariosQuery = "SELECT * 
		//   		FROM viajes_hospedajes_habitaciones_usuarios vhhu
		// 		INNER JOIN viajes_usuarios vu ON vu.viajesUsuariosId = vhhu.viajesUsuariosId
		// 		INNER JOIN usuarios u ON u.usuarioId = vu.usuarioId
		//   		WHERE viajesHospedajesHabitacionId = '" . $habitacionRow['viajesHospedajesHabitacionId'] . "'";
		//   $usuarioResult = $mysqli->query($usuariosQuery);
		//   $viajesUsuarios = array();
		//   while ($usuarios = $usuarioResult->fetch_assoc()) {
					
		// 	$viajesUsuarios[] = array(
		// 		"viajesUsuariosId" => $usuarios["viajesUsuariosId"],
		// 		"viajesId" => $usuarios["viajesId"],
		// 		"viajesHospedajesHabitacionesUsuariosId" => $usuarios["viajesHospedajesHabitacionesUsuariosId"],
		// 		"usuario" => array(
		// 			"usuarioId" => $usuarios["usuarioId"],
		// 			"viajeroTipoId" => $usuarios["viajeroTipoId"],
		// 			"habilitado_sys" => $usuarios["habilitado_sys"],
		// 			"nombre" => $usuarios["nombre"],
		// 			"apellido" => $usuarios["apellido"],
		// 			"email" => $usuarios["email"],
		// 			"dni" => $usuarios["dni"],
		// 			"apodo" => $usuarios["apodo"],
		// 			"altura" => $usuarios["altura"],
		// 			"peso" => $usuarios["peso"],
		// 			"talle" => $usuarios["talle"],
		// 			"comentario" => $usuarios["comentario"],
		// 			"direccion" => $usuarios["direccion"],
		// 			"ciudad" => $usuarios["ciudad"],
		// 			"fecha_registro" => $usuarios["fecha_registro"],
		// 			"fecha_nacimiento" => $usuarios["fecha_nacimiento"],
		// 			"imagen" => $usuarios["imagen"],
		// 			"paisId" => $usuarios["paisId"],
		// 			"sexoId" => $usuarios["sexoId"],
		// 		),
		// 	);
		//   }

		//   $habitaciones[] = array(
		// 	"viajesHospedajesHabitacionId" => $habitacionRow['viajesHospedajesHabitacionId'],
		// 	"hospedajeTarifaId" => $habitacionRow['hospedajeTarifaId'],
		// 	"camas_dobles" => $habitacionRow['camas_dobles'],
		// 	"camas_simples" => $habitacionRow['camas_simples'],
		// 	"tarifa" => array(
		// 	  "hospedajeTarifaId" => $tarifaRow['hospedajeTarifaId'],
		// 	  "baseHospedajeId" => $tarifaRow['baseHospedajeId'],
		// 	  "tipoHospedajeId" => $tarifaRow['tipoHospedajeId'],
		// 	  "hospedajesId" => $tarifaRow['hospedajesId'],
		// 	  "precio" => $tarifaRow['precio'],
		// 	  "alias" => $tarifaRow['alias'],
		// 	  "base" => $nombreBase,
		// 	),
		// 	"usuarios" => $viajesUsuarios,
		//   );
		// }
	  
		// $viajeHospedaje = array(
		//   "viajesHospedajesId" => $row['viajesHospedajesId'],
		//   "viajesId" => $row['viajesId'],
		//   "hospedaje" => array(
		// 	"hospedajesId" => $hospedajeRow['hospedajesId'],
		// 	"nombre" => $hospedajeRow['nombre'],
		// 	"paisId" => $hospedajeRow['paisId'],
		// 	"direccion" => $hospedajeRow['direccion'],
		// 	"estrellas" => $hospedajeRow['estrellas'],
		// 	"comentario" => $hospedajeRow['comentario'],
		// 	"telefono" => $hospedajeRow['telefono'],
		// 	"email" => $hospedajeRow['email'],
		//   )
		// );

		// $viajeHospedaje["hospedaje"]["habitaciones"] = $habitaciones;
		
		// return $viajeHospedaje;
	}

	function altaViajesHospedajesHabitacion($data) {
	    global $mysqli;
	    $cantidad = $data['cantidad_habitaciones'] ?? 1;
	    $respuesta = [];

	    for($i = 0; $i < $cantidad; $i++) {
	        $query = "INSERT INTO viajes_hospedajes_habitaciones 
	                  (viajesHospedajesId, hospedajeTarifaId, camas_dobles, camas_simples, codigo_reserva, reserva_nombre)
	                  VALUES 
	                  (?, ?, ?, ?, ?, ?)";
	        
	        $stmt = $mysqli->prepare($query);
	        $stmt->bind_param("iiisss", 
	            $data['viajesHospedajesId'],
	            $data['hospedajeTarifaId'],
	            $data['camasDobles'],
	            $data['camasSimples'],
	            $data['codigo_reserva'],
	            $data['reserva_nombre']
	        );
	        $stmt->execute();
	        $respuesta[] = ['viajesHospedajesHabitacionId' => $mysqli->insert_id];
	    }
	    
	    return $respuesta;
	}

	function eliminarViajesHospedajesHabitacion($viajesHospedajesHabitacionId) {
	    global $mysqli;

	    // Eliminar registros de usuarios en la habitación
	    $query = "DELETE FROM viajes_hospedajes_habitaciones_usuarios 
	              WHERE viajesHospedajesHabitacionId = '$viajesHospedajesHabitacionId'";
	    $mysqli->query($query);

	    // Eliminar registro de la habitación
	    $query = "DELETE FROM viajes_hospedajes_habitaciones 
	              WHERE viajesHospedajesHabitacionId = '$viajesHospedajesHabitacionId'";
	    if ($mysqli->query($query) === TRUE)
	        return 'ok';
	    else 
	        return 'error';
	}

	function eliminarViajeroCama($data) {
	  global $mysqli;

	  $query = "SELECT * FROM viajes_hospedajes_habitaciones_usuarios 
	             WHERE viajesUsuariosId = ".$data["viajesUsuariosId"]." AND viajesHospedajesId=".$data["viajesHospedajesId"];
	  $resultado = $mysqli->query($query);
	  $row = mysqli_fetch_assoc($resultado);

	  $query = "DELETE FROM viajes_hospedajes_habitaciones_usuarios 
	            WHERE viajesUsuariosId = ".$data["viajesUsuariosId"]." AND viajesHospedajesId=".$data["viajesHospedajesId"];;

	  if ($mysqli->query($query) === TRUE)
	    return $row["viajesHospedajesHabitacionId"];
	  else 
	    return 'error';
	}

	function altaViajesHospedajesHabitacionesUsuarios($data) {
	    global $mysqli;

	    // Obtener la cantidad de camas dobles y simples disponibles en la habitación
	    $viajesHospedajesHabitacionId = $data['viajesHospedajesHabitacionId'];
	    $viajesHospedajesId = $data['viajesHospedajesId'];
	    $sql = "SELECT camas_dobles, camas_simples FROM viajes_hospedajes_habitaciones WHERE viajesHospedajesHabitacionId = ?";
	    $stmt = $mysqli->prepare($sql);
	    $stmt->bind_param("i", $viajesHospedajesHabitacionId);
	    $stmt->execute();
	    $stmt->bind_result($camasDobles, $camasSimples);
	    $stmt->fetch();
	    $stmt->close();

	    // Validar si ya hay alguien en la cama
	    $camaDoble = ($data['tipoCama'] == 'doble') ? 1 : 0;
	    $camaSimple = ($data['tipoCama'] == 'simple') ? 1 : 0;

	    $sql = "SELECT COUNT(*) AS cantidad FROM viajes_hospedajes_habitaciones_usuarios 
	            WHERE viajesHospedajesHabitacionId = ? AND cama_doble = ?";
	    $stmt = $mysqli->prepare($sql);
	    $stmt->bind_param("ii", $viajesHospedajesHabitacionId, $camaDoble);
	    $stmt->execute();
	    $stmt->bind_result($cantidadDobles);
	    $stmt->fetch();
	    $stmt->close();

	    $sql = "SELECT COUNT(*) AS cantidad FROM viajes_hospedajes_habitaciones_usuarios 
	            WHERE viajesHospedajesHabitacionId = ? AND cama_simple = ?";
	    $stmt = $mysqli->prepare($sql);
	    $stmt->bind_param("ii", $viajesHospedajesHabitacionId, $camaSimple);
	    $stmt->execute();
	    $stmt->bind_result($cantidadSimples);
	    $stmt->fetch();
	    $stmt->close();

	    // Verificar si hay espacio disponible en la cama
	    if ($data['tipoCama'] == 'doble' && $cantidadDobles >= $camasDobles * 2) {
	        return "La cama doble ya está ocupada.";
	    } elseif ($data['tipoCama'] == 'simple' && $cantidadSimples >= $camasSimples) {
	        return "La cama simple ya está ocupada.";
	    }

	    $viajesUsuariosId = $data['viajesUsuariosId'];

	    // Eliminar registro anterior
	    $query = "DELETE FROM viajes_hospedajes_habitaciones_usuarios 
	              WHERE viajesUsuariosId = '$viajesUsuariosId'";
	    $mysqli->query($query);

	    // Preparar consulta
	    $sql = "INSERT INTO viajes_hospedajes_habitaciones_usuarios (viajesUsuariosId, viajesHospedajesHabitacionId, viajesHospedajesId, cama_doble, cama_simple) VALUES (?, ?, ?, ?, ?)";
	    $stmt = $mysqli->prepare($sql);
	    $stmt->bind_param("iiiii", $viajesUsuariosId, $viajesHospedajesHabitacionId, $viajesHospedajesId, $camaDoble, $camaSimple);
	    $stmt->execute();

	    return ($mysqli->affected_rows > 0) ? "ok" : $mysqli->error;
	}

	function getCostos($viajesId) {
		global $mysqli;
		
		$query = "
		    SELECT 
		      vc.*,
		      s.subrubro,
		      m.simbolo,
		      (
		        SELECT 
		          COUNT(*) 
		        FROM 
		          viajes_costos_usuarios vcu 
		        WHERE 
		          vcu.viajeCostoId = vc.viajeCostoId
		      ) AS cantidad_personas
		    FROM 
		      viajes_costos vc
		    INNER JOIN 
		      pagos_subrubros s ON vc.pagosSubrubroId = s.pagosSubrubroId
		    INNER JOIN 
		      monedas m ON vc.monedaId = m.monedaId
		    WHERE 
		      vc.viajesId = '$viajesId'
		  ";
		
		$result = $mysqli->query($query);
		if (!$result) {
		  die("Error al obtener costos: " . $mysqli->error);
		}
		
		$costos = array();
		while ($row = $result->fetch_assoc()) {
		  $costos[] = $row;
		}
		
		return $costos;
	  }

	  function altaViajeCostos($params) {
		global $mysqli;
		
		// Validar parámetros
		if (!isset($params["pagosSubrubroId"], $params["viajesId"], $params["monedaId"], $params["monto"], $params["soloBuzos"])) {
		  die("Error: Faltan parámetros requeridos");
		}
		
		// Preparar consulta
		$query = "
		  INSERT INTO viajes_costos (
			viajesId,
			pagosSubrubroId,
			monto,
			cotizacion,
			monedaId,
			soloBuzos,
			comentario
		  ) VALUES (
			?, ?, ?, ?, ?, ?, ?
		  )
		";
		
		// Preparar parámetros
		$viajesId = $params["viajesId"];
		$pagosSubrubroId = $params["pagosSubrubroId"];
		$monto = $params["monto"];
		$cotizacion = $params["cotizacion"] ?? NULL;
		$monedaId = $params["monedaId"];
		$soloBuzos = $params["soloBuzos"] == "2" ? 1 : 0;
		$comentario = $params["comentario"] ?? NULL;
		
		// Ejecutar consulta
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param("iiiiids", $viajesId, $pagosSubrubroId, $monto, $cotizacion, $monedaId, $soloBuzos, $comentario);
		$stmt->execute();
		
		// Verificar resultado
		if ($stmt->affected_rows > 0) {
			if( isset($params["aplicarCostoViajeros"]) && $params["aplicarCostoViajeros"] == "on"){
				$viajeCostoId = $mysqli->insert_id;

				$res = aplicarViajeCostoaTodosViajeros($viajeCostoId);
			}
		  	return "ok";
		} else {
		  	die("Error al insertar costo: " . $mysqli->error);
		}
	}

	function editarViajeCosto($params) {
	    global $mysqli;
	  
	    // Validar parámetros
	    if (!isset($params["viajeCostoId"], $params["pagosSubrubroId"], $params["viajesId"], $params["monedaId"], $params["monto"], $params["soloBuzos"])) {
	        die("Error: Faltan parámetros requeridos");
	    }
	  
	    // Escapar y preparar valores
	    $viajeCostoId = intval($params["viajeCostoId"]);
	    $pagosSubrubroId = intval($params["pagosSubrubroId"]);
	    $viajesId = intval($params["viajesId"]);
	    $monto = floatval($params["monto"]);
	    
	    // Manejar valores que pueden ser nulos
	    $cotizacion = $params["cotizacion"] === '' || $params["cotizacion"] === null ? 'NULL' : floatval($params["cotizacion"]);
	    $monedaId = intval($params["monedaId"]);
	    
	    $soloBuzos = $params["soloBuzos"];
	    
	    // Escapar comentario
	    $comentario = $params["comentario"] === '' || $params["comentario"] === null ? 'NULL' : "'" . $mysqli->real_escape_string($params["comentario"]) . "'";
	  
	    // Consulta SQL
	    $query = "
	        UPDATE viajes_costos
	        SET
	            pagosSubrubroId = $pagosSubrubroId,
	            viajesId = $viajesId,
	            monto = $monto,
	            cotizacion = $cotizacion,
	            monedaId = $monedaId,
	            soloBuzos = $soloBuzos,
	            comentario = $comentario
	        WHERE viajeCostoId = $viajeCostoId
	    ";
	  
	    // Ejecutar consulta
	    if ($mysqli->query($query)) {
	        $res = aplicarViajeCostoaTodosViajeros($viajeCostoId);
	        return "ok";
	    } else {
	        die("Error al editar costo: " . $mysqli->error . " - Consulta: " . $query);
	    }
	}

	function eliminarViajeCostos($params) {
		global $mysqli;
		
		// Validar parámetros
		if (!isset($params["viajeCostoId"])) {
		  die("Error: Faltan parámetros requeridos");
		}
		
		// Preparar consulta
		$query = "
		  DELETE FROM viajes_costos
		  WHERE viajeCostoId = ?
		";
		
		// Preparar parámetros
		$viajeCostoId = $params["viajeCostoId"];
		
		// Ejecutar consulta
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param("i", $viajeCostoId);
		$stmt->execute();

		$query = "
		  DELETE FROM viajes_costos_usuarios
		  WHERE viajeCostoId = ?
		";
		
		// Ejecutar consulta
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param("i", $viajeCostoId);
		$stmt->execute();
		
		// Verificar resultado
		if ($stmt->affected_rows > 0) {
		  return "ok";
		} else {
		  die("Error al eliminar costo: " . $mysqli->error);
		}
	}

	function aplicarViajeCostoaTodosViajeros($viajeCostoId){
		global $mysqli;

		$query = "SELECT * FROM viajes_costos vc WHERE vc.viajeCostoId = '$viajeCostoId'";
		$result = $mysqli->query($query);
		$row = $result->fetch_assoc();

		$viajesId = $row["viajesId"]; 
		$monto = $row["monto"]; 
		$soloBuzos = $row["soloBuzos"]; 

		$query = "SELECT * FROM viajes_usuarios WHERE viajesId = '$viajesId'";
		$result = $mysqli->query($query);

		while ($row_usuario = $result->fetch_assoc()) {
		  $viajesUsuariosId = $row_usuario["viajesUsuariosId"];
		  $viajeroTipoId = $row_usuario["viajeroTipoId"];

		  // Validación para eliminar registro existente
		  $query_validacion = "SELECT viajesCostosUsuariosId 
		                       FROM viajes_costos_usuarios 
		                       WHERE viajesUsuariosId = '$viajesUsuariosId' 
		                       AND viajeCostoId = '$viajeCostoId'";

		  $result_validacion = $mysqli->query($query_validacion);

		  if ($result_validacion->num_rows > 0) {
		    $row_validacion = $result_validacion->fetch_assoc();
		    $viajesCostosUsuariosId = $row_validacion["viajesCostosUsuariosId"];

		    // Eliminar registro existente
		    $query_delete = "DELETE FROM viajes_costos_usuarios 
		                     WHERE viajesCostosUsuariosId = '$viajesCostosUsuariosId'";

		    $mysqli->query($query_delete);
		  }
		  // FIN DELETE

		  if (($soloBuzos == 1 && $viajeroTipoId != 3) || $soloBuzos == 0) {
			$query = "INSERT INTO viajes_costos_usuarios (
				viajesUsuariosId,
				viajeCostoId,
				viajesId,
				monto
			)
			VALUES (
				'$viajesUsuariosId',
				'$viajeCostoId',
				'$viajesId',
				'$monto'
			)";

			$mysqli->query($query);
		  }
		}

		return "ok";
	}

	function getDetalleCostosTotalesPorViaje($viajesId){
		global $mysqli;

		$query = "SELECT 
		            ps.subrubro,
		            SUM(vcu.monto) AS monto_total,
		            COUNT(vcu.viajesCostosUsuariosId) AS cantidad_registros,
		            vc.soloBuzos 
		          FROM 
		            viajes_costos_usuarios vcu
		          INNER JOIN 
		            viajes_costos vc ON vcu.viajeCostoId = vc.viajeCostoId
		          INNER JOIN 
		            pagos_subrubros ps ON vc.pagosSubrubroId = ps.pagosSubrubroId
		          WHERE 
		            vcu.viajesId = ?
		          GROUP BY 
		            ps.subrubro";

		$stmt = $mysqli->prepare($query);
		$stmt->bind_param("i", $viajesId);
		$stmt->execute();
		$result = $stmt->get_result();

		$data = array();
		while ($row = $result->fetch_assoc()) {
		  $data[] = $row;
		}

		return ($data);
	}

	function getDetallesCostosHospedajes($viajesId){
		global $mysqli;

		$query = "SELECT * FROM viajes_hospedajes vh
				  INNER JOIN  hospedajes h ON h.hospedajesId = vh.hospedajesId
				  WHERE vh.viajesId = '$viajesId'";
		$result = $mysqli->query($query);

		$respuesta = array();

		while ($row = $result->fetch_assoc()){

			$hospedajeId = $row["hospedajesId"];

			$sqlTarifas = "SELECT 
			                    hht.*
			                FROM 
			                    hospedaje_habitaciones_tarifas hht
			                INNER JOIN 
			                    viajes_hospedajes vh ON vh.hospedajesId = hht.hospedajesId
			                WHERE 
			                    vh.hospedajesId =".$hospedajeId;

			$resultTarifas = $mysqli->query($sqlTarifas);
			while ($rowTarifas = $resultTarifas->fetch_assoc()){

				$sqlHabitaciones = "SELECT * FROM viajes_hospedajes_habitaciones vhh
									WHERE vhh.hospedajeTarifaId = ".$rowTarifas["hospedajeTarifaId"];
				$resultHabitaciones = $mysqli->query($sqlHabitaciones);
				$rowTarifas["habitaciones"] = array();
				while ($rowHabitaciones = $resultHabitaciones->fetch_assoc()){
					$viajesHospedajesHabitacionId = $rowHabitaciones["viajesHospedajesHabitacionId"];

					$sqlUsuarios = "SELECT vhhu.*, vu.viajeroTipoId, vu.venta_paquete, vu.habilitado_sys, u.nombre, u.apellido, u.apodo, vt.* 
									FROM viajes_hospedajes_habitaciones_usuarios vhhu
									INNER JOIN viajes_usuarios vu ON vu.viajesUsuariosId = vhhu.viajesUsuariosId
									INNER JOIN viajes_viajero_tipo vt ON vt.viajeroTipoId = vu.viajeroTipoId
									INNER JOIN usuarios u ON u.usuarioId = vu.usuarioId
									WHERE vhhu.viajesHospedajesHabitacionId = ".$viajesHospedajesHabitacionId;
					$resUsuarios = $mysqli->query($sqlUsuarios);
					$rowHabitaciones["usuarios"] = array();
					while ($rowUsuarios = $resUsuarios->fetch_assoc()){
						$rowHabitaciones["usuarios"][] = $rowUsuarios;
					}
					$rowTarifas["habitaciones"][] = $rowHabitaciones;
				}
				$row["tarifas"][] = $rowTarifas;
			}

			$respuesta["hospedajes"][] = $row;

		}

		return ($respuesta);
	}

	function getAlquilerEquipos() {
		global $mysqli;
	
		$query = "SELECT 
					alquilerEquiposId,
					equipo,
					acronimo,
					orden
				  FROM 
					alquiler_equipos
				  ORDER BY 
					orden ASC";
	
		$result = $mysqli->query($query);
	
		$data = array();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
	
		return ($data);
	}

	function guardarViajeTarifas($post) {
		global $mysqli;
	 
		// Validar datos requeridos
		if (!isset($post['viajesId']) || !isset($post['tarifas'])) {
			return ['error' => 'Faltan datos requeridos'];
		}
	 
		$viajesId = intval($post['viajesId']);
		$tarifas = json_decode($post['tarifas'], true);
	 
		if (!is_array($tarifas)) {
			return ['error' => 'Formato de tarifas inválido'];
		}
	 
		try {
			// Comenzar transacción
			$mysqli->begin_transaction();
	 
			// Primero eliminar tarifas existentes para este viaje
			$query = "DELETE FROM viajes_alquiler_equipos_tarifas WHERE viajesId = ?";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("i", $viajesId);
			$stmt->execute();
	 
			// Preparar query para insertar nuevas tarifas
			$query = "INSERT INTO viajes_alquiler_equipos_tarifas 
					  (alquilerEquiposId, costo, valor_venta, viajesId) 
					  VALUES (?, ?, ?, ?)";
			$stmt = $mysqli->prepare($query);
			
			// Insertar cada tarifa
			foreach ($tarifas as $tarifa) {
				$alquilerEquiposId = intval($tarifa['alquilerEquiposId']);
				$costo = floatval($tarifa['costo']);
				$valor_venta = floatval($tarifa['valor_venta']);
	 
				$stmt->bind_param("iddi", 
					$alquilerEquiposId,
					$costo,
					$valor_venta,
					$viajesId
				);
				
				if (!$stmt->execute()) {
					throw new Exception("Error al insertar tarifa para equipo ID: " . $alquilerEquiposId);
				}
			}
	 
			// Confirmar transacción
			$mysqli->commit();
			
			return ['success' => true, 'message' => 'Tarifas guardadas correctamente'];
	 
		} catch (Exception $e) {
			// Rollback en caso de error
			$mysqli->rollback();
			return ['error' => $e->getMessage()];
		}
	}

	function tieneEquipoCompleto($mysqli, $viajesUsuariosId, $viajesId) {
		$query = "SELECT vaet.alquilerEquiposId 
				  FROM viajes_alquiler_equipos vae
				  JOIN viajes_alquiler_equipos_tarifas vaet ON vae.viajesAlquilerEquiposTarifaId = vaet.viajesAlquilerEquiposTarifaId
				  WHERE vae.viajesUsuariosId = ? 
				  AND vae.viajesId = ? 
				  AND vaet.alquilerEquiposId = 8";
		
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param("ii", $viajesUsuariosId, $viajesId);
		$stmt->execute();
		return $stmt->get_result()->num_rows > 0;
	}
	
	function verificarTodosLosEquipos($mysqli, $viajesUsuariosId, $viajesId, $nuevoEquipoId = null) {
		// Obtener todos los equipos individuales existentes
		$query = "SELECT DISTINCT ae.alquilerEquiposId
				  FROM alquiler_equipos ae
				  WHERE ae.alquilerEquiposId != 8
				  ORDER BY ae.alquilerEquiposId";
		
		$stmt = $mysqli->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		$todosLosEquipos = [];
		while ($row = $result->fetch_assoc()) {
			$todosLosEquipos[] = $row['alquilerEquiposId'];
		}
	
		// Obtener equipos actuales del usuario
		$query = "SELECT DISTINCT vaet.alquilerEquiposId
				  FROM viajes_alquiler_equipos vae
				  JOIN viajes_alquiler_equipos_tarifas vaet ON vae.viajesAlquilerEquiposTarifaId = vaet.viajesAlquilerEquiposTarifaId
				  WHERE vae.viajesUsuariosId = ? 
				  AND vae.viajesId = ?
				  AND vaet.alquilerEquiposId != 8";
		
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param("ii", $viajesUsuariosId, $viajesId);
		$stmt->execute();
		$result = $stmt->get_result();
		$equiposActuales = [];
		while ($row = $result->fetch_assoc()) {
			$equiposActuales[] = $row['alquilerEquiposId'];
		}
	
		// Agregar el nuevo equipo si existe
		if ($nuevoEquipoId && !in_array($nuevoEquipoId, $equiposActuales)) {
			$equiposActuales[] = $nuevoEquipoId;
		}
	
		// Verificar si tiene todos los equipos
		sort($equiposActuales);
		sort($todosLosEquipos);
		return $equiposActuales == $todosLosEquipos;
	}

	function guardarAlquilerEquipo($post) {
		global $mysqli;
		
		// Validar datos requeridos
		if (!isset($post['viajesId']) || 
			!isset($post['viajesUsuariosId']) || 
			!isset($post['alquilerEquiposId']) || 
			!isset($post['estado'])) {
			return ['error' => 'Faltan datos requeridos'];
		}

		$viajesId = intval($post['viajesId']);
		$viajesUsuariosId = intval($post['viajesUsuariosId']);
		$alquilerEquiposId = intval($post['alquilerEquiposId']);
		$estado = intval($post['estado']);

		try {
			$mysqli->begin_transaction();

			if ($estado === 1) {
				if ($alquilerEquiposId === 8) {
					// Si marca equipo completo, eliminar otros y guardar solo el completo
					$query = "DELETE FROM viajes_alquiler_equipos 
							WHERE viajesUsuariosId = ? AND viajesId = ?";
					$stmt = $mysqli->prepare($query);
					$stmt->bind_param("ii", $viajesUsuariosId, $viajesId);
					$stmt->execute();
				} else {
					// Si es equipo individual, verificar si completaría el set
					if (verificarTodosLosEquipos($mysqli, $viajesUsuariosId, $viajesId, $alquilerEquiposId)) {
						// Cambiar a equipo completo
						$alquilerEquiposId = 8;
						$query = "DELETE FROM viajes_alquiler_equipos 
								WHERE viajesUsuariosId = ? AND viajesId = ?";
						$stmt = $mysqli->prepare($query);
						$stmt->bind_param("ii", $viajesUsuariosId, $viajesId);
						$stmt->execute();
					}
				}

				// Obtener el ID de la tarifa correspondiente
				$query = "SELECT viajesAlquilerEquiposTarifaId 
						FROM viajes_alquiler_equipos_tarifas 
						WHERE alquilerEquiposId = ? AND viajesId = ?";
				
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ii", $alquilerEquiposId, $viajesId);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if ($result->num_rows === 0) {
					throw new Exception("No se encontró tarifa para el equipo seleccionado");
				}
				
				$tarifa = $result->fetch_assoc();
				$tarifaId = $tarifa['viajesAlquilerEquiposTarifaId'];

				// Insertar el registro
				$query = "INSERT INTO viajes_alquiler_equipos 
						(viajesUsuariosId, viajesId, viajesAlquilerEquiposTarifaId)
						VALUES (?, ?, ?)
						ON DUPLICATE KEY UPDATE viajesAlquilerEquiposTarifaId = ?";
				
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("iiii", 
					$viajesUsuariosId, 
					$viajesId, 
					$tarifaId,
					$tarifaId
				);

				
				if (!$stmt->execute()) {
					throw new Exception("Error al guardar el alquiler del equipo");
				}

			} else {
				// Si se desmarca
				if ($alquilerEquiposId === 8) {
					// Si es equipo completo, eliminar todo
					$query = "DELETE FROM viajes_alquiler_equipos 
							 WHERE viajesUsuariosId = ? AND viajesId = ?";
					$stmt = $mysqli->prepare($query);
					$stmt->bind_param("ii", $viajesUsuariosId, $viajesId);
				} else {
					// Primero verificar si tenía equipo completo
					$tieneEquipoCompleto = tieneEquipoCompleto($mysqli, $viajesUsuariosId, $viajesId);
					
					if ($tieneEquipoCompleto) {
						// Si tenía equipo completo, primero eliminar todo
						$query = "DELETE FROM viajes_alquiler_equipos 
								 WHERE viajesUsuariosId = ? AND viajesId = ?";
						$stmt = $mysqli->prepare($query);
						$stmt->bind_param("ii", $viajesUsuariosId, $viajesId);
						$stmt->execute();
						
						// Luego reinsertar todos menos el que se desmarcó
						$query = "INSERT INTO viajes_alquiler_equipos 
								 (viajesUsuariosId, viajesId, viajesAlquilerEquiposTarifaId)
								 SELECT ?, ?, viajesAlquilerEquiposTarifaId
								 FROM viajes_alquiler_equipos_tarifas
								 WHERE viajesId = ? 
								 AND alquilerEquiposId != 8 
								 AND alquilerEquiposId != ?";
						
						$stmt = $mysqli->prepare($query);
						$stmt->bind_param("iiii", 
							$viajesUsuariosId, 
							$viajesId, 
							$viajesId,
							$alquilerEquiposId
						);
					} else {
						// Si no tenía equipo completo, solo eliminar el equipo específico
						$query = "DELETE FROM viajes_alquiler_equipos 
								 WHERE viajesUsuariosId = ? 
								 AND viajesId = ? 
								 AND viajesAlquilerEquiposTarifaId IN (
									 SELECT viajesAlquilerEquiposTarifaId 
									 FROM viajes_alquiler_equipos_tarifas 
									 WHERE alquilerEquiposId = ?
								 )";
						$stmt = $mysqli->prepare($query);
						$stmt->bind_param("iii", $viajesUsuariosId, $viajesId, $alquilerEquiposId);
					}
				}
				
				if (!$stmt->execute()) {
					throw new Exception("Error al eliminar el alquiler del equipo");
				}

			}

			$mysqli->commit();
			
			agregarDeudaUsuarioAlquilerEquipo($viajesUsuariosId, false);

			return [
				'success' => true, 
				'message' => 'Alquiler de equipo actualizado correctamente',
				'equipoCompleto' => ($alquilerEquiposId === 8)
			];

			

		} catch (Exception $e) {
			$mysqli->rollback();
			return ['error' => $e->getMessage()];
		}
	}

	function obtenerIngresosAlquileres($post) {
		global $mysqli;
		
		// Validar datos requeridos
		if (!isset($post['viajesId'])) {
			return ['error' => 'Falta el ID del viaje'];
		}
	 
		$viajesId = intval($post['viajesId']);
	 
		try {
			// Query para obtener la suma de ventas y costos
			$query = "SELECT 
						SUM(vaet.valor_venta) as ingresoTotal,
						SUM(vaet.costo) as costoTotal
					 FROM viajes_alquiler_equipos vae
					 JOIN viajes_alquiler_equipos_tarifas vaet 
						ON vae.viajesAlquilerEquiposTarifaId = vaet.viajesAlquilerEquiposTarifaId
					 WHERE vae.viajesId = ?
					 GROUP BY vae.viajesId";
	 
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("i", $viajesId);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$ingresoTotal = floatval($row['ingresoTotal']);
				$costoTotal = floatval($row['costoTotal']);
				
				return [
					'success' => true,
					'ingresoTotal' => $ingresoTotal,
					'costoTotal' => $costoTotal,
					'ganancia' => $ingresoTotal - $costoTotal
				];
			}
			
			// Si no hay resultados, devolver todos en 0
			return [
				'success' => true,
				'ingresoTotal' => 0,
				'costoTotal' => 0,
				'ganancia' => 0
			];
	 
		} catch (Exception $e) {
			return ['error' => $e->getMessage()];
		}
	}

	function obtenerTarifasAlquilerEquipo($viajesId) {
		global $mysqli;
		
		$viajesId = intval($viajesId);
		$tarifas = array();
	
		try {
			// Primero obtenemos las tarifas
			$query = "SELECT 
						vaet.alquilerEquiposId,
						vaet.costo,
						vaet.valor_venta,
						COUNT(vae.viajesAlquilerEquiposId) as cantidad
					 FROM viajes_alquiler_equipos_tarifas vaet
					 LEFT JOIN viajes_alquiler_equipos vae ON 
						vae.viajesAlquilerEquiposTarifaId = vaet.viajesAlquilerEquiposTarifaId
						AND vae.viajesId = vaet.viajesId
					 WHERE vaet.viajesId = ?
					 GROUP BY vaet.alquilerEquiposId, vaet.costo, vaet.valor_venta";
	
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("i", $viajesId);
			$stmt->execute();
			$result = $stmt->get_result();
			
			// Indexar por alquilerEquiposId para fácil acceso en el template
			while ($row = $result->fetch_assoc()) {
				$tarifas[$row['alquilerEquiposId']] = array(
					'costo' => $row['costo'],
					'valor_venta' => $row['valor_venta'],
					'cantidad' => intval($row['cantidad'])
				);
			}
	
			return $tarifas;
	
		} catch (Exception $e) {
			return array();
		}
	}

	function obtenerEquiposSeleccionados($viajesId) {
		global $mysqli;
		
		$viajesId = intval($viajesId);
		$equiposSeleccionados = array();
	
		try {
			$query = "SELECT 
						vae.viajesUsuariosId,
						vaet.alquilerEquiposId
					 FROM viajes_alquiler_equipos vae
					 JOIN viajes_alquiler_equipos_tarifas vaet 
						ON vae.viajesAlquilerEquiposTarifaId = vaet.viajesAlquilerEquiposTarifaId
					 WHERE vae.viajesId = ?";
	
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("i", $viajesId);
			$stmt->execute();
			$result = $stmt->get_result();
			
			while ($row = $result->fetch_assoc()) {
				if (!isset($equiposSeleccionados[$row['viajesUsuariosId']])) {
					$equiposSeleccionados[$row['viajesUsuariosId']] = array();
				}
				$equiposSeleccionados[$row['viajesUsuariosId']][] = $row['alquilerEquiposId'];
				
				// Si es equipo completo, agregar todos los demás IDs
				if ($row['alquilerEquiposId'] == 8) {
					$query_todos = "SELECT alquilerEquiposId 
								  FROM alquiler_equipos 
								  WHERE alquilerEquiposId != 8";
					$result_todos = $mysqli->query($query_todos);
					while ($equipo = $result_todos->fetch_assoc()) {
						if (!in_array($equipo['alquilerEquiposId'], $equiposSeleccionados[$row['viajesUsuariosId']])) {
							$equiposSeleccionados[$row['viajesUsuariosId']][] = $equipo['alquilerEquiposId'];
						}
					}
				}
			}
	
			return $equiposSeleccionados;
	
		} catch (Exception $e) {
			return array();
		}
	}

	function agregarDeudaUsuarioAlquilerEquipo($viajesUsuariosId, $soloBorrar = false){

		global $mysqli;

		$sqlAlquileres = "SELECT a.*, SUM(t.valor_venta) as total, vu.usuarioId, v.nombre, v.anio
						FROM viajes_alquiler_equipos a
						INNER JOIN viajes_alquiler_equipos_tarifas t 
						   ON a.viajesAlquilerEquiposTarifaId = t.viajesAlquilerEquiposTarifaId
						INNER JOIN viajes_usuarios vu
						   ON a.viajesUsuariosId = vu.viajesUsuariosId
						INNER JOIN viajes v
						   ON vu.viajesId = v.viajesId
						WHERE a.viajesUsuariosId = ".$viajesUsuariosId;
		$result = $mysqli->query($sqlAlquileres);
		$row = $result->fetch_assoc();
		$totalAlquiler = $row['total'];

		$sqlDelete = "DELETE FROM deudas 
					  WHERE viajesId = ".$row["viajesId"]."
					  	AND usuarioId = ".$row["usuarioId"]."
					  	AND pagosSubrubroId = ".SUBRUBRO_ID_ALQUILER_EQUIPOS;
	    $mysqli->query($sqlDelete);
		if($soloBorrar)
			return;

		// este fi podria ser para validar que determinados tipode v aierjso no tengan deudas de este tipo
		if($totalAlquiler > 0) {

			$deuda["comentario"] = "Alquiler equipos - ".$row['nombre']." ".$row['anio'];
			$deuda['deuda'] = $totalAlquiler; //AGREGAR DEUDA SUMADA ACA;
			$deuda['monedaId'] = 2; //dolares 
			$deuda['usuarioId'] = $row["usuarioId"];
			$deuda['viajesId'] = $row["viajesId"];
			$deuda['pagosSubrubroId'] = SUBRUBRO_ID_ALQUILER_EQUIPOS; //alquiler equipos
			$deuda['habilitado_sys'] = 1;

			$res = altaDeuda($deuda);
		}	
	}

	function eliminarRedSocial($usuarioRedSocialId) {
	    global $mysqli;
	    $sql = "DELETE FROM usuarios_redes_sociales WHERE usuariosRedSocialId = $usuarioRedSocialId";
	    if($mysqli->query($sql)) {
	        echo json_encode(['estado' => 'ok']);
	    } else {
	        echo json_encode(['estado' => 'error', 'mensaje' => $mysqli->error]);
	    }
	    die();
	}

	function getCostosOperativos($viajesId) {
	    global $mysqli;
	    
	    $sql = "SELECT 
	        vco.*,
	        CONCAT(pr.rubro, ' - ', ps.subrubro) as categoria,
	        COALESCE((SELECT SUM(monto) FROM pagos WHERE viajesCostosOperativosId = vco.viajesCostosOperativosId), 0) as total_pagado
	    FROM 
	        viajes_costos_operativos vco
	        INNER JOIN pagos_subrubros ps ON vco.pagosSubrubroId = ps.pagosSubrubroId
	        INNER JOIN pagos_rubros pr ON ps.pagosRubrosId = pr.pagosRubroId
	    WHERE 
	        vco.viajesId = ?
	    ORDER BY 
	        vco.fecha DESC";
	                
	    $stmt = $mysqli->prepare($sql);
	    $stmt->bind_param("i", $viajesId);
	    $stmt->execute();
	    $result = $stmt->get_result();
	    
	    $costosOperativos = [];
	    while($row = $result->fetch_assoc()) {
	        $costosOperativos[] = $row;
	    }
	    
	    return $costosOperativos;
	}

	function altaCostoOperativo($datos) {
	    global $mysqli;
	    
	    // Si es liberado y el monto es positivo, hacerlo negativo
	    $monto = $datos['monto'];
	    if (isset($datos['liberado']) && $datos['liberado'] && $monto > 0) {
	        $monto = -$monto;
	    }
	    
	    $sql = "INSERT INTO viajes_costos_operativos 
	            (monto, descripcion, pagosSubrubroId, viajesId, liberado, fecha) 
	            VALUES (?, ?, ?, ?, ?, ?)";
	            
	    $stmt = $mysqli->prepare($sql);
	    
	    $liberado = isset($datos['liberado']) ? 1 : 0;
	    $fecha = date('Y-m-d H:i:s', strtotime($datos['fecha']));
	    
	    $stmt->bind_param(
	        "dsiiis",
	        $monto,
	        $datos['descripcion'],
	        $datos['pagosSubrubroId'],
	        $datos['viajesId'],
	        $liberado,
	        $fecha
	    );
	    
	    return $stmt->execute();
	}

	function editarCostoOperativo($datos) {
	    global $mysqli;
	    
	    $viajesCostosOperativosId = $datos['viajesCostosOperativosId'];
	    $viajesId = $datos['viajesId'];
	    $pagosSubrubroId = $datos['pagosSubrubroId'];
	    $descripcion = $mysqli->real_escape_string($datos['descripcion']);
	    $monto = $datos['monto'];
	    $liberado = isset($datos['liberado']) ? 1 : 0;
	    $fecha = date('Y-m-d H:i:s', strtotime($datos['fecha']));
	    
	    // Si es liberado y el monto es positivo, hacerlo negativo
	    if ($liberado && $monto > 0) {
	        $monto = -$monto;
	    }
	    
	    $sql = "UPDATE viajes_costos_operativos
	            SET monto = '$monto',
	                descripcion = '$descripcion',
	                pagosSubrubroId = '$pagosSubrubroId',
	                viajesId = '$viajesId',
	                liberado = '$liberado',
	                fecha = '$fecha'
	            WHERE viajesCostosOperativosId = '$viajesCostosOperativosId'";
	    
	    return $mysqli->query($sql);
	}

	function eliminarCosto($viajesCostosOperativosId) {
	    global $mysqli;

	    // Verificar si el costo está asociado a pagos
	    $queryPagos = "SELECT COUNT(*) AS total FROM pagos WHERE viajesCostosOperativosId = $viajesCostosOperativosId";
	    $resultadoPagos = $mysqli->query($queryPagos);
	    $filaPagos = $resultadoPagos->fetch_assoc();
	    $totalPagos = $filaPagos['total'];

	    if ($totalPagos > 0) {
	        // El costo tiene pagos asociados, no se puede eliminar
	        return json_encode(array(
	            "success" => false,
	            "message" => "No se puede eliminar el costo porque tiene pagos asociados."
	        ));
	    } else {
	        // El costo no tiene pagos asociados, se puede eliminar
	        $sql = "DELETE FROM viajes_costos_operativos WHERE viajesCostosOperativosId = $viajesCostosOperativosId";
	        $resultadoCosto = $mysqli->query($sql);

	        if ($resultadoCosto) {
	            return json_encode(array(
	                "success" => true,
	                "message" => "El costo se ha eliminado correctamente."
	            ));
	        } else {
	            return json_encode(array(
	                "success" => false,
	                "message" => "Ha ocurrido un error al eliminar el costo."
	            ));
	        }
	    }
	}

	function getDocumentacionViaje($viajesId) {
	    global $mysqli;
	    
	    // Prepare statement with error checking
	    $stmt = $mysqli->prepare("SELECT 
	        vu.usuarioId,
	        vu.viajesId,
	        u.nombre,
	        u.apellido,
	        u.apodo,
	        u.imagen,
	        vt.viajero_tipo,
	        d.documentacionId,
	        d.documento,
	        d.comentario,
	        dt.tipo,
	        dt.alcance
	    FROM viajes_usuarios vu
	    INNER JOIN usuarios u ON vu.usuarioId = u.usuarioId
	    INNER JOIN viajes_viajero_tipo vt ON vu.viajeroTipoId = vt.viajeroTipoId
	    LEFT JOIN documentacion d ON (
	        d.usuarioId = vu.usuarioId AND 
	        d.habilitado_sys = 1 AND
	        (d.viajesId = vu.viajesId OR d.viajesId IS NULL)
	    )
	    LEFT JOIN documentacion_tipos dt ON d.documentacionTipoId = dt.documentacionTipoId
	    WHERE vu.viajesId = ? 
	    AND vu.habilitado_sys = 1
	    ORDER BY u.apodo, dt.alcance, dt.tipo");
	    
	    // Check if prepare was successful
	    if ($stmt === false) {
	        die("Error preparing statement: " . $mysqli->error);
	    }
	    
	    // Bind parameters
	    if (!$stmt->bind_param("i", $viajesId)) {
	        die("Error binding parameters: " . $stmt->error);
	    }
	    
	    // Execute statement
	    if (!$stmt->execute()) {
	        die("Error executing statement: " . $stmt->error);
	    }
	    
	    $result = $stmt->get_result();
	    
	    $viajeros = [];
	    while($row = $result->fetch_assoc()) {
	        $usuarioId = $row['usuarioId'];
	        
	        if (!isset($viajeros[$usuarioId])) {
	            $viajeros[$usuarioId] = [
	                'usuarioId' => $row['usuarioId'],
	                'nombre' => $row['nombre'],
	                'apellido' => $row['apellido'],
	                'apodo' => $row['apodo'],
	                'imagen' => $row['imagen'],
	                'viajero_tipo' => $row['viajero_tipo'],
	                'documentos' => [
	                    'USUARIO' => [],
	                    'VIAJERO' => []
	                ]
	            ];
	        }
	        
	        if ($row['documentacionId']) {
	            $viajeros[$usuarioId]['documentos'][$row['alcance']][] = [
	                'documentacionId' => $row['documentacionId'],
	                'tipo' => $row['tipo'],
	                'documento' => $row['documento'],
	                'comentario' => $row['comentario']
	            ];
	        }
	    }
	    
	    return array_values($viajeros);
	}

	function getTipoDocumentacion() {
	    global $mysqli;
	    
	    $sql = "SELECT 
	            documentacionTipoId,
	            tipo,
	            alcance 
	        FROM documentacion_tipos 
	        WHERE habilitado_sys = 1
	        ORDER BY alcance, tipo";
	    
	    $stmt = $mysqli->prepare($sql);
	    $stmt->execute();
	    $result = $stmt->get_result();
	    
	    $tipos = [
	        'USUARIO' => [],
	        'VIAJERO' => [],
	        'VIAJE' => []
	    ];
	    
	    while($row = $result->fetch_assoc()) {
	        $tipos[$row['alcance']][] = $row;
	    }
	    
	    return $tipos;
	}