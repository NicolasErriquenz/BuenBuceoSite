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
	            $subrubrosNoHabilitados = $mysqli->query("SELECT COUNT(*) 
	                                                      FROM pagos_subrubros 
	                                                      WHERE pagosRubrosId = " . $row['pagosRubroId'] . 
	                                                      " AND habilitado_sys = 0")->fetch_assoc()['COUNT(*)'];

	            $row['total_subrubros'] = $totalSubrubros;
	            $row['subrubros_no_habilitados'] = $subrubrosNoHabilitados;

	            $resultArray[] = $row;
	        }
	        $result->free();
	    } else {
	        echo "Error en la consulta: " . $mysqli->error;
	    }

	    return $resultArray;
	}

	function getDeudaTipos($orderByAlfabetico = false) {
	    global $mysqli;

	    $resultArray = [];

	    // Consulta SQL para obtener rubros
	    $query = "SELECT * 
	              FROM deuda_tipo";

	    // Agregar ordenamiento alfabético si se especifica
	    if ($orderByAlfabetico) {
	        $query .= " ORDER BY rubro ASC";
	    }

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

	function getItem($tabla, $idName, $pagosRubroId) {
		global $mysqli;

	    $query = "SELECT * FROM $tabla WHERE $idName=".$pagosRubroId;

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

	function altaTipoDeuda($POST) {
	    global $mysqli;

	    // Preparamos la consulta utilizando ? como placeholders
	    $query = "INSERT INTO deuda_tipo (deuda, comentario, habilitado_sys) VALUES (?, ?, ?)";
	    
	    $POST['habilitado_sys'] = 1;

	    // Preparamos la consulta
	    if ($stmt = $mysqli->prepare($query)) {
	        $stmt->bind_param('ssi', $POST['deuda'], $POST['comentario'], $POST['habilitado_sys']);
	        if(!$stmt->execute()) 
	            die("Error al insertar el registro: " . $stmt->error);
	        $stmt->close();
	    } else {
	        echo "Error al preparar la consulta: " . $mysqli->error;
	    }

	    header("location:deudaTipo_listado.php");
	}

	function editarRubroPago($POST, $GET) {
	    global $mysqli;

	    // Verificar si se está intentando editar un rubro
	    if ($POST['action'] == 'editar' && isset($GET['pagosRubroId'])) {
	        // Preparamos la consulta utilizando ? como placeholders
	        $query = "UPDATE pagos_rubros SET rubro = ?, comentario = ?, habilitado_sys = ? WHERE pagosRubroId = ?";

	        // Preparamos la consulta
	        if ($stmt = $mysqli->prepare($query)) {
	            $habilitado_sys = $POST['habilitado_sys'] ?? 1; // Si no se envía habilitado_sys, se considera 1
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

	function editarTipoDeuda($POST, $GET) {
	    global $mysqli;

	    // Verificar si se está intentando editar un deuda
	    if ($POST['action'] == 'editar' && isset($GET['deudaTipoId'])) {
	        // Preparamos la consulta utilizando ? como placeholders
	        $query = "UPDATE deuda_tipo SET deuda = ?, comentario = ?, habilitado_sys = ? WHERE deudaTipoId = ?";

	        // Preparamos la consulta
	        if ($stmt = $mysqli->prepare($query)) {
	            $habilitado_sys = $POST['habilitado_sys'] ?? 1; // Si no se envía habilitado_sys, se considera 1
	            $stmt->bind_param('sssi', $POST['deuda'], $POST['comentario'], $habilitado_sys, $GET['deudaTipoId']);
	            if (!$stmt->execute()) 
	                die("Error al editar el registro: " . $stmt->error);
	            $stmt->close();
	        } else {
	            echo "Error al preparar la consulta: " . $mysqli->error;
	        }

	        // Redireccionamos con el parámetro deudaTipoId si está establecido
	        $redirectUrl = "deudaTipo_listado.php";
	        if (isset($POST['deudaTipoId'])) {
	            $redirectUrl .= "?deudaTipoId=" . $POST['deudaTipoId'];
	        }

	        header("location: $redirectUrl");
	    } else {
	        echo "Error: No se proporcionaron los parámetros necesarios.";
	    }
	}

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

	function getPagos() {

		global $mysqli;
	    $query = "
	        SELECT p.*, ps.subrubro, pt.transaccion AS transaccion_tipo, m.moneda, mp.medioPago,
	               u.nombre AS usuario_nombre, d.deuda
	        FROM pagos p
	        INNER JOIN pagos_subrubros ps ON p.pagosSubrubroId = ps.pagosSubrubroId
	        INNER JOIN pagos_transaccion_tipo pt ON p.pagoTransaccionTipoId = pt.pagoTransaccionTipoId
	        INNER JOIN monedas m ON p.monedaId = m.monedaId
	        INNER JOIN medios_de_pago mp ON p.medioPagoId = mp.medioPagoId
	        LEFT JOIN usuarios u ON p.usuarioId = u.usuarioId
	        LEFT JOIN deudas d ON p.deudaId = d.deudaId
	    ";

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
?>
