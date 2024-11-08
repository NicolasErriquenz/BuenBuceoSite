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
			$obj["nombre"] = $row["nombre"]." ".$row["apellido"]." (".$row["apodo"].") - ".$row["dni"];
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
	    $sql = "INSERT INTO pagos (pagosSubrubroId, pagoTransaccionTipoId, fecha, monedaId, monto, medioPagoId, comentario, cotizacion, habilitado_sys, usuarioId, deudaId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

	    $stmt = mysqli_prepare($mysqli, $sql);
	    if (!$stmt) {
	        echo "Error preparando la sentencia: " . mysqli_error($mysqli);
	        return;
	    }

	 	$comentario = $pago['comentario'] ?? '';
		$usuarioId = $pago['usuarioId'] ?? null;

		mysqli_stmt_bind_param($stmt, 'iisddiissdi', 
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
		    $pago['deudaId']
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
	            dt.rubro as tipoDeuda, 
	            d.comentario, 
	            m.moneda, 
	            m.simbolo 
	          FROM 
	            deudas d 
	          INNER JOIN pagos_rubros dt ON d.pagosRubroId = dt.pagosRubroId 
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
		      deudaId = ".$deudaId."
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
	  $query = "INSERT INTO deudas (deuda, monedaId, usuarioId, pagosRubroId, comentario, habilitado_sys) VALUES (?, ?, ?, ?, ?, ?)";

	  $POST['habilitado_sys'] = 1;

	  // Preparamos la consulta
	  if ($stmt = $mysqli->prepare($query)) {

	  	$comentario = empty($POST['comentario']) ? NULL : $POST['comentario'];

	    $stmt->bind_param('diidsi', 
		  $POST['deuda'], 
		  $POST['monedaId'], 
		  $POST['usuarioId'], 
		  $POST['pagosRubroId'], 
		  $comentario, 
		  $POST['habilitado_sys']
		);
	    if(!$stmt->execute()) 
	      die("Error al insertar el registro: " . $stmt->error);
	  	else
	  		echo "ok";

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
	  $pagosRubroId = $datos['pagosRubroId'] ?? 'NULL';
	  $habilitado_sys = isset($datos['habilitado_sys']) ? 1 : 0;

	  // Sentencia SQL para actualizar la deuda
	  $sql = "UPDATE deudas SET 
	          deuda = '".$datos['deuda']."', 
	          monedaId = ".$datos['monedaId'].", 
	          usuarioId = ".$usuarioId.", 
	          pagosRubroId = ".$pagosRubroId.", 
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
	              r.rubro
	            FROM 
	              deudas d
	            INNER JOIN 
	              monedas m ON d.monedaId = m.monedaId
	            INNER JOIN 
	              usuarios u ON d.usuarioId = u.usuarioId
	            INNER JOIN 
	              pagos_rubros r ON d.pagosRubroId = r.pagosRubroId
	            ";

	  if ($usuarioId !== null) {
	    $query .= " AND d.usuarioId = '$usuarioId'";
	  }

	  $resultado = mysqli_query($mysqli, $query);
	  $deudas = array();

	  while ($fila = mysqli_fetch_assoc($resultado)) {
	    $deudas[] = $fila;
	  }

	  return $deudas;
	}

	function getPagos($usuarioId = null) {
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
	      r.rubro AS deuda_tipo, 
	      pr.rubro
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
	      pagos_rubros r ON d.pagosRubroId = r.pagosRubroId
	  ";

	  if ($usuarioId !== null) {
	    $query .= " WHERE p.usuarioId = '$usuarioId'";
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
	          (SELECT COUNT(*) FROM pagos WHERE usuarioId = u.usuarioId) AS cantidad_pagos,
	          (SELECT COUNT(*) FROM deudas WHERE usuarioId = u.usuarioId) AS cantidad_deudas
	        FROM 
	          usuarios u
	        LEFT JOIN 
	          paises p ON u.paisId = p.paisId
	        LEFT JOIN 
	          sexo s ON u.sexoId = s.sexoId
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
	          urs.link, 
	          urs.username
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
		} 

	  $usuario = array(
	    'nombre' => $datos['nombre'],
	    'apellido' => $datos['apellido'] ?? null,
	    'email' => $datos['email'],
	    'dni' => $datos['dni'] ?? null,
	    'apodo' => $datos['apodo'] ?? null,
	    'comentario' => $datos['comentario'] ?? null,
	    'direccion' => $datos['direccion'] ?? null,
	    'altura' => $datos['altura'] ?? null,
	    'peso' => $datos['peso'] ?? null,
	    'talle' => $datos['talle'] ?? null,
	    'ciudad' => $datos['ciudad'] ?? null,
	    'fecha_registro' => date('Y-m-d'),
	    'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
	    'imagen' => $datos['imagen'] ?? null,
	    'habilitado_sys' => isset($datos['habilitado_sys']) ? 1 : 0,
	    'paisId' => $datos['paisId'] ?? null,
	    'sexoId' => $datos['sexoId'] ?? null,
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

	  // Sentencia SQL para insertar el usuario
	  $sql = "INSERT INTO usuarios (nombre, apellido, email, dni, apodo, comentario,altura,peso,talle, direccion, ciudad, fecha_registro, fecha_nacimiento, imagen, habilitado_sys, paisId, sexoId) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?, ?, ?, ?, ?, ?, ?)";

	  $stmt = mysqli_prepare($mysqli, $sql);
	  if (!$stmt) {
	    echo "Error preparando la sentencia: " . mysqli_error($mysqli);
	    return;
	  }

	  // Manejar campos como NULL si es necesario
	  $apellido = $usuario['apellido'];
	  $dni = $usuario['dni'];
	  $apodo = $usuario['apodo'];
	  $comentario = $usuario['comentario'];
	  $altura = $usuario['altura'];
	  $peso = $usuario['peso'];
	  $talle = $usuario['talle'];
	  $direccion = $usuario['direccion'];
	  $ciudad = $usuario['ciudad'];
	  $fecha_nacimiento = $usuario['fecha_nacimiento'];
	  $imagen = $usuario['imagen'];
	  $paisId = $usuario['paisId'];
	  $sexoId = $usuario['sexoId'];

	  mysqli_stmt_bind_param($stmt, 'sssissssssssssiii', 
	    $usuario['nombre'], 
	    $apellido, 
	    $usuario['email'], 
	    $dni, 
	    $apodo, 
	    $altura, 
	    $peso, 
	    $talle, 
	    $comentario, 
	    $direccion, 
	    $ciudad, 
	    $usuario['fecha_registro'], 
	    $fecha_nacimiento, 
	    $imagen, 
	    $usuario['habilitado_sys'], 
	    $paisId, 
	    $sexoId
	  );

	  // Ejecutar la sentencia
	  if (!mysqli_stmt_execute($stmt)) {
	    echo 'Error al insertar usuario: ' . mysqli_stmt_error($stmt);
	    return;
	  }

	  // Verificar si se insertó correctamente
	  if (mysqli_stmt_affected_rows($stmt) > 0) {
		  $usuarioId = mysqli_insert_id($mysqli);
		  echo json_encode(array('estado' => 'ok', 'usuarioId' => $usuarioId));
		} else {
		  echo json_encode(array('estado' => 'error', 'mensaje' => 'Error al insertar usuario'));
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
		  $sql = "SELECT imagen FROM usuarios WHERE usuarioId = ?";
		  $stmt = mysqli_prepare($mysqli, $sql);
		  mysqli_stmt_bind_param($stmt, 'i', $datos['usuarioId']);
		  mysqli_stmt_execute($stmt);
		  $resultado = mysqli_stmt_get_result($stmt);
		  $fila = mysqli_fetch_assoc($resultado);
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
	    'habilitado_sys' => isset($datos['habilitado_sys']) ? 1 : 0,
	    'paisId' => $datos['paisId'] ?? null,
	    'sexoId' => $datos['sexoId'] ?? null,
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

	  // Sentencia SQL para actualizar el usuario
	  $sql = "UPDATE usuarios SET 
	            nombre = ?, 
	            apellido = ?, 
	            email = ?, 
	            dni = ?, 
	            apodo = ?, 
	            altura = ?, 
	            peso = ?, 
	            talle = ?, 
	            comentario = ?, 
	            direccion = ?, 
	            ciudad = ?, 
	            fecha_nacimiento = ?, 
	            imagen = ?, 
	            habilitado_sys = ?, 
	            paisId = ?, 
	            sexoId = ? 
	          WHERE usuarioId = ?";

	  $stmt = mysqli_prepare($mysqli, $sql);
	  if (!$stmt) {
	    echo "Error preparando la sentencia: " . mysqli_error($mysqli);
	    return;
	  }

	  // Manejar campos como NULL si es necesario
	  $apellido = $usuario['apellido'];
	  $dni = $usuario['dni'];
	  $apodo = $usuario['apodo'];
	  $altura = $usuario['altura'];
	  $peso = $usuario['peso'];
	  $talle = $usuario['talle'];
	  $comentario = $usuario['comentario'];
	  $direccion = $usuario['direccion'];
	  $ciudad = $usuario['ciudad'];
	  $fecha_nacimiento = $usuario['fecha_nacimiento'];
	  $imagen = $usuario['imagen']; //ACA $usuario['imagen'] es null pero $imagen termina siendo "" cuando ingresa a la base
	  $paisId = $usuario['paisId'];
	  $sexoId = $usuario['sexoId'];

	 	$fechaNacimiento = $fecha_nacimiento ?? '';
		$imagen = $imagen === null ? null : $imagen;
		$paisId = $paisId ?? 0; 
		$sexoId = $sexoId ?? 0;
		$usuarioId = $usuario['usuarioId'] ?? 0;

		mysqli_stmt_bind_param($stmt, 'sssssssssssssiiii', 
		  $usuario['nombre'], 
		  $apellido, 
		  $usuario['email'], 
		  $dni, 
		  $apodo, 
		  $altura, 
		  $peso, 
		  $talle, 
		  $comentario, 
		  $direccion, 
		  $ciudad, 
		  $fechaNacimiento, 
		  $imagen, 
		  $usuario['habilitado_sys'], 
		  $paisId, 
		  $sexoId,
		  $usuarioId
		);


		// Ejecutar la sentencia
		if (!mysqli_stmt_execute($stmt)) {
		}

	  	// Verificar si se actualizó correctamente
	  	if (mysqli_stmt_affected_rows($stmt) > 0 || mysqli_stmt_errno($stmt) == 0) {
	    	echo json_encode(array('estado' => 'ok', 'usuarioId' => $usuarioId));
		} else {
		  	echo json_encode(
		  		array(
		  			'estado' => 'error', 
		  			'mensaje' => 'Error al actualizar el usuario',
		  			'msqlerror' => mysqli_error($mysqli),
		  		)
		  	);
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

	function getViajesUsuarios($viajesId) {
	  global $mysqli;
	  
	  $query = "
	    SELECT 
	      vu.viajesUsuariosId,
		  vu.habilitado_sys,
		  u.nombre,
		  u.apellido,
		  u.apodo,
	      vvt.viajero_tipo
	    FROM 
	      viajes_usuarios vu
		INNER JOIN 
	      usuarios u ON u.usuarioId = vu.usuarioId
	    INNER JOIN 
	      viajes_viajero_tipo vvt ON vu.viajeroTipoId = vvt.viajeroTipoId
	    WHERE 
	      vu.viajesId = '$viajesId'
	  ";

	  $result = $mysqli->query($query);
	  if (!$result) {
	    die("Error al obtener viajes de usuario: " . $mysqli->error);
	  }

	  $viajes = array();
	  while ($row = $result->fetch_assoc()) {
	    $viajes[] = $row;
	  }

	  return $viajes;
	}

	function getHospedajes() {
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

	function getHospedajeHabitacionesBases() {
	  global $mysqli;

	  $sql = "
	    SELECT 
	      baseHospedajeId, 
	      nombre 
	    FROM 
	      hospedaje_habitaciones_bases
	      ORDER BY baseHospedajeId ASC
	  ";

	  $result = $mysqli->query($sql);

	  if ($result->num_rows > 0) {
	    $bases = array();
	    while($row = $result->fetch_assoc()) {
	      $bases[] = $row;
	    }
	    return $bases;
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

	function getHospedajeHabitacionesTarifas($hospedajesId) {
	  global $mysqli;

	  $sql = "
	    SELECT 
	      ht.hospedajeTarifaId, 
	      ht.alias, 
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
	      ht.hospedajesId = ".$hospedajesId;

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
	      (SELECT COUNT(*) FROM hospedaje_habitaciones_tarifas WHERE hospedajesId = h.hospedajesId) AS tarifas_cargadas
	    FROM 
	      viajes_hospedajes vh 
	    INNER JOIN 
	      viajes v ON vh.viajesId = v.viajesId 
	    INNER JOIN 
	      hospedajes h ON vh.hospedajesId = h.hospedajesId
	    WHERE 
	      vh.viajesId = ?
	  ";

	  $stmt = $mysqli->prepare($sql);
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


	function altaHospedaje($data) {
	  global $mysqli;

	  // Preparamos la consulta utilizando ? como placeholders
	  $query = "INSERT INTO hospedajes (nombre, paisId, direccion, telefono, email, estrellas, comentario) VALUES (?, ?, ?, ?, ?)";

	  // Preparamos la consulta
	  if ($stmt = $mysqli->prepare($query)) {
	    $stmt->bind_param('sisssds', 
	                      $data['nombre'], 
	                      $data['paisId'], 
	                      $data['direccion'], 
	                      $data['telefono'], 
	                      $data['email'], 
	                      $data['estrellas'], 
	                      $data['comentario']);

	    if($stmt->execute()) {
	      $stmt->close();
	      echo "ok";
	    } else {
	      die("Error al insertar el registro: " . $stmt->error);
	    }
	  } else {
	    echo "Error al preparar la consulta: " . $mysqli->error;
	  }
	}

	function altaViaje($params) {
	  global $mysqli;

	  // Extraer año de fecha_inicio
	  $anio = date('Y', strtotime($params['fecha_inicio']));

	  // Valores por defecto
	  $activo = 0;

	  // Consulta SQL
	  $sql = "
	    INSERT INTO 
	      viajes (paisId, anio, fecha_inicio, fecha_fin, activo, descripcion, viaje_pdf)
	    VALUES 
	      (?, ?, ?, ?, ?, ?, ?)
	  ";

	  // Preparar consulta
	  $stmt = $mysqli->prepare($sql);

	  // Vincular parámetros
	  $stmt->bind_param("iisssss", 
	    $params['paisId'], 
	    $anio, 
	    $params['fecha_inicio'], 
	    $params['fecha_fin'], 
	    $activo, 
	    $params['descripcion'], 
	    $params['viaje_pdf']
	  );

	  // Ejecutar consulta
	  if ($stmt->execute()) {
	    return json_encode(array('estado' => 'ok', 'mensaje' => 'Viaje creado con éxito'));
	  } else {
	    return json_encode(array('estado' => 'error', 'mensaje' => 'Error al crear viaje'));
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

	  // Extraer año de fecha_inicio
	  $anio = date('Y', strtotime($params['fecha_inicio']));

	  // Ruta de destino para el archivo
	  $rutaDestino = $RUTA_FILE_VIAJES;
	  $nombreArchivo = limpiarNombreArchivo(getPais($params['paisId'])) . '_' . $anio . '_' . $viajesId . '_' . time() . '.pdf';

	  // Mover archivo a ruta de destino
	  if (isset($_FILES['viaje_pdf'])) {
	    $tmpNombre = $_FILES['viaje_pdf']['tmp_name'];
	    move_uploaded_file($tmpNombre, $rutaDestino . $nombreArchivo);
	  } else {
	    // Si no se subió archivo, mantener el nombre del archivo anterior
	    $nombreArchivo = $params['viaje_pdf'];
	  }

	  // Consulta SQL
	  $sql = "
	    UPDATE 
	      viajes 
	    SET 
	      paisId = ?, 
	      anio = ?, 
	      fecha_inicio = ?, 
	      fecha_fin = ?, 
	      activo = ?, 
	      descripcion = ?, 
	      viaje_pdf = ?
	    WHERE 
	      viajesId = ?
	  ";

	  // Preparar consulta
	  $stmt = $mysqli->prepare($sql);

	  // Vincular parámetros
	  $activo = !empty($params['activo']) ? 1 : 0;
	  $viajesId = $viajesId;
	  $viajePdf = $nombreArchivo;

	  $stmt->bind_param("iisssssi", 
	    $params['paisId'], 
	    $anio, 
	    $params['fecha_inicio'], 
	    $params['fecha_fin'], 
	    $activo, 
	    $params['descripcion'], 
	    $viajePdf, 
	    $viajesId
	  );

	  // Ejecutar consulta
	  if ($stmt->execute()) {
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

	  // Si no existe, procedemos con la alta
	  $query = "INSERT INTO viajes_usuarios (viajesId, usuarioId, viajeroTipoId, habilitado_sys) VALUES (?, ?, ?, ?)";
	  $data['habilitado_sys'] = 1;

	  if ($stmt = $mysqli->prepare($query)) {
	    $stmt->bind_param('iiii', $data['viajesId'], $data['usuarioId'], $data['viajeroTipoId'], $data['habilitado_sys']);
	    if($stmt->execute()) {
	      $stmt->close();
	      echo "ok";
	    } else {
	      die("Error al insertar el registro: " . $stmt->error);
	    }
	  } else {
	    echo "Error al preparar la consulta: " . $mysqli->error;
	  }
	}

	function borrarViajero($viajesUsuariosId) {
	  global $mysqli;

	  // Preparamos la consulta utilizando ? como placeholders
	  $query = "DELETE FROM viajes_usuarios WHERE viajesUsuariosId = ?";

	  // Preparamos la consulta
	  if ($stmt = $mysqli->prepare($query)) {
	    $stmt->bind_param('i', $viajesUsuariosId);
	    if($stmt->execute()) {
	      $stmt->close();
	      echo "ok";
	    } else {
	      die("Error al eliminar el registro: " . $stmt->error);
	    }
	  } else {
	    echo "Error al preparar la consulta: " . $mysqli->error;
	  }
	}

	function editarHospedaje($data, $hospedajesId) {
	  global $mysqli;

	 // Consulta para editar hospedaje
	  $query = "UPDATE hospedajes SET 
	            nombre = '" . $data['nombre'] . "', 
	            paisId = " . $data['paisId'] . ", 
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
?>
