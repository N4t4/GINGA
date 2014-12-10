<?php
	function converte_html($valor) {
		$acentos = array('Á', 'É', 'Í', 'Ó', 'Ú', 'á', 'é', 'í', 'ó', 'ú', 'Ç');
		$cod_html = array('&Aacute;', '&Eacute;', '&Iacute;',
							'&Oacute;', '&Uacute;', 'aacute;', '&eacute;',
							'&iacute;', '&oacute;', '&uacute;', '&Ccedil;');
		$valor = str_replace($acentos, $cod_html, $valor);
		return $valor;
	}
	
	function full_url()
	{
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
		$protocol = substr($sp, 0, strpos($sp, "/")) . $s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	}
	
	function the_header(){
		$response=file_get_contents("header0.php");
		echo $response;
		return;
	}
	
	function get_header()
	{	
		$response=file_get_contents("header.php");
		echo $response;
		return;
	}

	function get_header_gen()
	{
		$response=file_get_contents("header_gen.php");
		echo $response;
		return;
	}
	
	function get_footer()
	{
		$response=file_get_contents("footer.php");
		echo $response;
		return;
	}
	
	
	
?>