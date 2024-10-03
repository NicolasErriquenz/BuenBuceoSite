<?php  
	
	function updateHabilitado($conn, $id, $habilitado, $tabla, $idNombre){

		$id = intval($id); // Asegurarse de que sea un número entero
	    $habilitado = isset($habilitado) ? intval($habilitado) : 0; // 1 si está habilitado, 0 si no

	    // Actualizar el estado en la base de datos
	    $updateQuery = "UPDATE $tabla SET habilitado_sys = ? WHERE $idNombre = ?";
	    $stmt = $conn->prepare($updateQuery);
	    $stmt->bind_param('ii', $habilitado, $id); // 'ii' significa que ambos son enteros


	    if ($stmt->execute()) {
	        echo json_encode(['status' => 'success', 'message' => 'Estado actualizado correctamente.']);
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el estado: ' . $stmt->error]);
	    }

	    $stmt->close();
	    exit; // Asegúrate de terminar el script aquí para no procesar más nada
	}

	function getRubrosPagos($conn) {
	    $resultArray = [];

	    $query = "SELECT * FROM pagos_rubros";

	    if ($result = $conn->query($query)) {
	        while ($row = $result->fetch_assoc()) {
	            $resultArray[] = $row;
	        }
	        $result->free();
	    } else {
	        echo "Error en la consulta: " . $conn->error;
	    }

	    return $resultArray;
	}

?>
