<?php 

	$username = "root";
	$password = "";
	$host = "127.0.0.1";
	$db = "final";

	if(!mysql_connect($host, $username, $password) || !mysql_select_db($db)) die("<b style='color:red'>Erro ao conectar: </b>".mysql_error()."");
?>