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
		$oraciones = [
			[
			  'titulo' => "La atención es la nueva moneda.",
			  'descripcion' => "La creatividad es la llave que abre puertas al éxito.",
			  'imagen' => 'images/insp1.jpg'
			],
			[
			  'titulo' => "El esfuerzo silencioso es el que más rinde frutos.",
			  'descripcion' => "Cuanto más fácil parece, más esfuerzo hay detrás.",
			  'imagen' => 'images/insp2.jpg'
			],
			[
			  'titulo' => "La simplicidad es la nueva sofisticación.",
			  'descripcion' => "La pasión es el combustible que impulsa tus sueños.",
			  'imagen' => 'images/insp3.jpg'
			],
			[
			  'titulo' => "La claridad es la llave del éxito.",
			  'descripcion' => "La resiliencia es el escudo que protege tus objetivos.",
			  'imagen' => 'images/insp4.jpg'
			],
			[
			  'titulo' => "La profundidad es la que da valor a tus palabras.",
			  'descripcion' => "La imaginación es el puente que conecta tus sueños con la realidad.",
			  'imagen' => 'images/insp5.jpg'
			],
			// Agrega más oraciones aquí...
		];

		$indiceAleatorio = array_rand($oraciones);
		return $oraciones[$indiceAleatorio];
    }
?>