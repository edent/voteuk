<?php	
	header ("Cache-Control: max-age=3600");
	//Fix Stupid IE and non-stupid W3C
	if(stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") or stristr($_SERVER["HTTP_USER_AGENT"],"W3C_Validator")) 
	{
		header('Content-type: application/xhtml+xml');
	}
	else
	{
		header('Content-type: text/html');
	}
	
	header("Vary: Accept");
	//header('Content-type: application/vnd.wap.xhtml+xml');
	echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/dtd.xhtml-mp");
?>

