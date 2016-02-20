<html>
<head>
	<title>Classes Panel</title>
</head>
<body>
	<h1>Classes Panel</h1>

	<table border='1'>
		<thead>
			<td>Name</td>
			<td>Subject</td>
			<td>Course</td>
			<td>Duration</td>
			<td>Edit</td>
			<td>Delete</td>
		</thead>
		<tbody>
			<?php 
			//Verificar se o usuario possui permissão de acessar essa pagina
			include "../cfg/mysql.php";

			$query = "select classes.id, classes.name, classes.duration, courses.name cname, subjects.name sname from courses, subjects, classes where courses.subject_id = subjects.id and classes.course_id = courses.id;";
			$r = mysql_query($query);
			if(!$r) die("<span style='color:red'>Error: </span>".mysql_error());

			while($l = mysql_fetch_array($r))
				echo "<tr id='cla".$l['id']."'><td>".$l['name']."</td><td>".$l['sname']."</td><td>".$l['cname']."</td><td>".$l['duration']." min</td><td><a href='classEdit.php?id=".$l['id']."'><button>Edit</button></a></td><td><a href='php/remove.php?type=class&url=classesPanel.php&id=".$l['id']."'><button>Remove</button></a></td></tr>";
		?>
		</tbody>
	</table>
	<br>
	<a href="classEdit.php"><button>Add New</button></a>

</body>
</html>