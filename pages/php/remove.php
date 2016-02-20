<?php 
	//Verificar se o usuario tem permissão de adicionar uma nova materia
	include "../../cfg/mysql.php";

	$target = $_GET['type'];
	$url = (isset($_GET['url']) && $_GET['url'] != "") ? "../".$_GET['url'] : "../index.html";
	$id = $_GET['id'];

	switch ($target) {
		case 'subject':
			$query = "delete from subjects where id = $id;";
			break;
		case 'course':
			$query = "delete from courses where id = $id;";
			break;
		case 'class':
			$query = "delete from classes where id = $id;";
			break;
		default:
			die("Type ".$target." desconhecido!");
			break;
	}

	$r = mysql_query($query);
	if(!$r)	die("<span style='color:red'>Error: </span>".mysql_error());
	header("Location: ".$url);
?>