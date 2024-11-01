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
	

	function getCotizacion(){
		
		global $TOKEN_BCRA;

		$url = "https://api.estadisticasbcra.com/usd";

		$headers = array(
		    "Authorization: Bearer $TOKEN_BCRA"
		);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close($ch);

		$data = json_decode($response, true);

		$cotizacion_mas_actual = end($data);

		$resultado["fecha"] = $cotizacion_mas_actual["d"];
		$resultado["cotizacion"] = $cotizacion_mas_actual["v"];

		//header('Content-Type: application/json');
		return ($resultado);

	}
?>