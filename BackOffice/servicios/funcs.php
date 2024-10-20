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

		//BNA gratis
		// $url = 'https://www.bcra.gob.ar/PublicacionesEstadisticas/Principales_variables.asp';
		// $html = file_get_contents($url);
		// $dom = new DOMDocument();
		// $dom->loadHTML($html);
		// $xpath = new DOMXPath($dom);
		// $cotizacion = $xpath->query('//td[contains(text(), "Dólar MEP")]/following-sibling::td');
		// return $cotizacion->item(0)->nodeValue;


		// $url = 'https://api.ambito.com/v1/cotizaciones/dolar-mep';
		// $json = file_get_contents($url);
		// $data = json_decode($json, true);
		// var_dump($data['cotizacion']);
		// die();

		$url = 'https://api.invertirenargentina.com/v1/cotizaciones/dolar-mep';
		$json = file_get_contents($url);
		$data = json_decode($json, true);
		var_dump($data['cotizacion']);
		die();
		return $data['cotizacion'];

	}
?>