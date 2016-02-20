<?php 
	//Verificar se o usuario tem permissão de adicionar uma nova materia
	include "../../cfg/mysql.php";

	$target = $_GET['type'];
	$filters = isset($_GET['filters']) ? $_GET['filters'] : "";
	$values = isset($_GET['values']) ? $_GET['values'] : "";

	if($filters != ""){
		$filters = explode(',', $filters);
		$values = explode(',', $values);
	}

	switch ($target) {
		case 'class':
			$query = "select * from classes".((sizeof($filters) != 0) ? generateFilters($filters, $values) : "").";";
			break;
		case 'classAndSub':
			$query = "select classes.*, courses.subject_id, courses.name cname, subjects.name sname from classes, courses, subjects where classes.course_id = courses.id and courses.subject_id = subjects.id;";
			break;
		case 'course':
			$query = "select * from courses".((sizeof($filters) != 0) ? generateFilters($filters, $values) : "").";";
			break;
		case 'subject':
			$query = "select * from subjects".((sizeof($filters) != 0) ? generateFilters($filters, $values) : "").";";
			break;
		default:
			die("Type ".$target." desconhecido!");
			break;
	}

	$r = mysql_query($query);
 	$rows = array();
   	while($l = mysql_fetch_assoc($r)) {
    	$rows[] = $l;
   	}

	print json_encode($rows);
	if(!$r)	die("<span style='color:red'>Error: </span>".mysql_error());
	
	function generateFilters($f, $v){
		if($f == "") return "";
		$result = " where ";
		for($i = 0; $i < sizeof($f); ++$i){
			$result .= $f[$i] . " = " . $v[$i] . (($i != sizeof($f) - 1) ? " and " : "");
		}
		return $result;
	}
?>