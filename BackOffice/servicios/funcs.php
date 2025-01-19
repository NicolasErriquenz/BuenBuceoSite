<?php  

	function conservarQueryString() {
	    $queryParams = $_GET;
	    unset($queryParams['PHPSESSID']); // Eliminar sesión PHP

	    $queryString = http_build_query($queryParams);
	    if ($queryString) {
	        return '&' . $queryString;
	    } else {
	        return '';
	    }
	}
	
	function limpiarNombreArchivo($nombre) {
	  	$nombre = str_replace(
		array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'ü', 'Ü'),
		array('a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N', 'u', 'U'),
		$nombre
		);
		return preg_replace('/[^a-zA-Z0-9_-]/', '', $nombre);
	}

	function getCotizacion(){
		
		global $TOKEN_BCRA;

		$url = "https://api.estadisticasbcra.com/usd";

		$headers = array(
		    "Authorization: Bearer $TOKEN_BCRA"
		);

		$ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_HEADER, true); // Obtener encabezados de respuesta
	    $response = curl_exec($ch);
	    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);

	    if ($httpCode === 403) { // Código de estado para "Too Many Requests"
	        return "Cantidad de peticiones máximas por día alcanzadas. Ingresa la cotización a mano.";
	    }

		$data = json_decode($response, true);

		if ($data === null) {
		    echo "Error al decodificar JSON: " . json_last_error_msg();
		    exit;
		}

		$cotizacion_mas_actual = end($data);

		$resultado["fecha"] = $cotizacion_mas_actual["d"];
		$resultado["cotizacion"] = $cotizacion_mas_actual["v"];

		//header('Content-Type: application/json');
		return json_encode($resultado);

	}

	function obtenerOracionInspiradora() {
		$num_imagenes = 68;

		$oraciones = [
		    [
		        'titulo' => "El mar, una vez que lanza su hechizo, te atrapa en su red de maravillas para siempre.",
		        'descripcion' => "Jacques Cousteau",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    [
		        'titulo' => "Explorar el mundo submarino es un privilegio, pues es la última gran frontera de la Tierra.",
		        'descripcion' => "Jacques Cousteau",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    [
		        'titulo' => "La gente protege lo que ama y ama lo que entiende.",
		        'descripcion' => "Jacques Cousteau",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    [
		        'titulo' => "Sin azul, no hay verde. Sin océanos, no hay vida.",
		        'descripcion' => "Sylvia Earle",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    [
		        'titulo' => "Desde el nacimiento, el hombre lleva el peso de la gravedad sobre sus hombros. Solo tiene que sumergirse, para sentirse libre.",
		        'descripcion' => "Jacques Cousteau",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    [
		        'titulo' => "El buceo nos permite entrar en el mundo del silencio, donde la paz y la belleza se mezclan en un espacio eterno.",
		        'descripcion' => "Jacques Cousteau",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    [
		        'titulo' => "El mar, una vez que su secreto ha sido revelado, se convierte en nuestro eterno compañero.",
		        'descripcion' => "Rachel Carson",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    [
		        'titulo' => "Para la mayoría de la gente, el mar es solo un espacio azul sin fin. Pero para los buceadores, es un hogar lleno de vida y aventura.",
		        'descripcion' => "Jacques Cousteau",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    [
		        'titulo' => "La gente dice que necesitamos salvar al planeta, pero en realidad es al océano a quien debemos salvar si queremos salvarnos a nosotros mismos.",
		        'descripcion' => "Sylvia Earle",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    [
		        'titulo' => "Los océanos son el verdadero reflejo de nuestro planeta; al sumergirnos en ellos, viajamos a nuestras propias raíces.",
		        'descripcion' => "Jacques Cousteau",
		        'imagen' => 'images/bg' . rand(1, $num_imagenes) . '.JPG'
		    ],
		    // Agrega más frases aquí con el mismo formato...
		];

		$indiceAleatorio = array_rand($oraciones);
		return $oraciones[$indiceAleatorio];
    }

   	function getCostoTotalHabitaciones($costosHospedajes) {
	    $costoTotal = 0;
	    
	    // Validación inicial de la estructura del array
	    if (!is_array($costosHospedajes) || !isset($costosHospedajes['hospedajes']) || !is_array($costosHospedajes['hospedajes'])) {
	        return $costoTotal;
	    }
	    
	    // Iteramos por cada hospedaje
	    foreach ($costosHospedajes['hospedajes'] as $hospedaje) {
	        // Validamos que exista la clave 'tarifas' y sea un array
	        if (!isset($hospedaje['tarifas']) || !is_array($hospedaje['tarifas'])) {
	            continue;
	        }
	        
	        // Iteramos por cada tarifa del hospedaje
	        foreach ($hospedaje['tarifas'] as $tarifa) {
	            // Validamos que exista la clave 'precio'
	            if (!isset($tarifa['precio'])) {
	                continue;
	            }
	            
	            $precioTarifa = floatval($tarifa['precio']);
	            
	            // Validamos que exista la clave 'habitaciones' y sea un array
	            if (!isset($tarifa['habitaciones']) || !is_array($tarifa['habitaciones'])) {
	                continue;
	            }
	            
	            // Por cada habitación
	            foreach ($tarifa['habitaciones'] as $habitacion) {
	                // Validamos que exista la clave 'usuarios' y sea un array
	                if (!isset($habitacion['usuarios']) || !is_array($habitacion['usuarios'])) {
	                    continue;
	                }
	                
	                // Contamos cuántos usuarios hay en la habitación
	                $cantidadUsuarios = count($habitacion['usuarios']);
	                
	                // Si hay usuarios, multiplicamos el precio por la cantidad
	                if ($cantidadUsuarios > 0) {
	                    $costoTotal += $precioTarifa * $cantidadUsuarios;
	                }
	            }
	        }
	    }
	    
	    return $costoTotal;
	}

	function debugQuery($sql, $types, $params) {
	    echo "Valores a insertar:\n";
	    foreach($params as $key => $value) {
	        echo "Parámetro " . ($key + 1) . " (" . $types[$key] . "): " . $value . "\n";
	    }
	    
	    // Construir la consulta real
	    $query = $sql;
	    foreach($params as $param) {
	        $value = is_string($param) ? "'$param'" : $param;
	        $query = preg_replace('/\?/', $value, $query, 1);
	    }
	    return $query;
	}

	function eco($s){
	    if (is_array($s)) {
	        echo json_encode($s);
	    } else {
	        echo $s;
	    }
	    die();
	}
?>