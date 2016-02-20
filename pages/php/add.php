<?php 
	//Verificar se o usuario tem permissão de adicionar uma nova materia
	include "../../cfg/mysql.php";

	$add_target = $_GET['type'];
	$url = (isset($_GET['url']) && $_GET['url'] != "") ? "../".$_GET['url'] : "../index.html";


	switch ($add_target) {
		case 'subject':
			$name = $_GET['name'];
			$description = $_GET['description'];
			$query = "insert into subjects(name, description) value('".$name."', '".$description."');";
			break;
		case 'course':
			$name = $_GET['name'];
			$subject = $_GET['subject'];
			$query = "insert into courses(name, subject_id) value('".$name."', '".$subject."');";
			break;
		case 'class':
			$name = $_GET['name'];
			$duration = $_GET['duration'];
			$difficulty = $_GET['difficulty'];
			$description = $_GET['description'];
			$course = $_GET['course'];
			$query = "insert into classes(name, duration, difficulty, course_id, description) value('$name', $duration, $difficulty, $course, '$description');";
			break;
		default:
			die("Type ".$add_target." desconhecido!");
			break;
	}

	$r = mysql_query($query);
	if(!$r)	die("<span style='color:red'>Error: </span>".mysql_error());
	header("Location: ".$url);
?>