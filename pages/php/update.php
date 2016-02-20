<?php 
	//Verificar se o usuario tem permissão de adicionar uma nova materia
	include "../../cfg/mysql.php";

	$target = $_GET['type'];
	$url = (isset($_GET['url']) && $_GET['url'] != "") ? "../".$_GET['url'] : "../index.html";
	$id = $_GET['id'];

	switch ($target) {
		case 'subject':
			$name = $_GET['name'];
			$description = $_GET['description'];
			$query = "update subjects set name = '$name', description = '$description' where id = $id;";
			break;
		case 'course':
			$name = $_GET['name'];
			$subject = $_GET['subject'];
			$query = "update courses set name = '$name', subject_id = $subject where id = $id;";
			break;
		case 'class':
			$name = $_GET['name'];
			$duration = $_GET['duration'];
			$difficulty = $_GET['difficulty'];
			$course = $_GET['course'];
			$description = $_GET['description'];
			$query = "update classes set name = '$name', duration = $duration, difficulty = $difficulty, course_id = $course, description = '$description' where id = $id;";
			break;
		default:
			die("Type ".$target." desconhecido!");
			break;
	}

	$r = mysql_query($query);
	if(!$r)	die("<span style='color:red'>Error: </span>".mysql_error());
	header("Location: ".$url);
?>