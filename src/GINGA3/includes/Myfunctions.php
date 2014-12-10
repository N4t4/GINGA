<?php
/*---------------------------------------------
Criado por   Natã                19/10/2012 -
revisado por Natã                23/10/2012 -   
---------------------------------------------*/

	function converte_html($valor) {
		$acentos = array('Á', 'É', 'Í', 'Ó', 'Ú', 
						 'á', 'é', 'í', 'ó', 'ú', 
						 'Ç', 'ç','Ã', 'ã');
		$cod_html = array('&Aacute;', '&Eacute;', '&Iacute;','&Oacute;', '&Uacute;', 
						  '&aacute;', '&eacute;','&iacute;', '&oacute;', '&uacute;', 
						  '&Ccedil;', '&ccdil;', '&Atilde;', '&atilde;');
		$valor = str_replace($acentos, $cod_html, $valor);
		return $valor;
	}

	function SelectHtml($str){
	  	return " replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace( replace(".$str.", 'Á' , '&Aacute;'), 'É' , '&Eacute;'), 'Í' , '&Iacute;'), 'Ó' , '&Oacute;'), 'Ú' , '&Uacute;'), 'á' , '&aacute;'), 'é' , '&eacute;'), 'í' , '&iacute;'), 'ó' , '&oacute;'), 'ú' , '&uacute;'), 'Ç' , '&Ccedil;'), 'ç' , '&ccdil;' ), 'Ã' , '&Atilde;'), 'ã' , '&atilde;'), 'Â' , '&Acirc;' ), 'â' , '&acirc;' ), 'Ê' , '&Ecirc;' ), 'ê' , '&ecirc;' ), 'Ô' , '&Ocirc;' ), 'ô' , '&ocirc;' ), 'À' , '&Agrave;'), 'à' , '&agrave;') ";
	}
?>
