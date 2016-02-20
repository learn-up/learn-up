<html>
<head>
	<title>Courses Panel</title>
</head>
<body>
	<h1>Courses Panel</h1>

	<table border='1'>
		<thead>
			<td>Name</td>
			<td>Subject</td>
			<td>Edit</td>
			<td>Delete</td>
		</thead>
		<tbody>
			<?php 
			//Verificar se o usuario possui permissão de acessar essa pagina
			include "../cfg/mysql.php";

			$query = "select courses.id, courses.name, subjects.name sname from courses, subjects where courses.subject_id = subjects.id order by subjects.id;";
			$r = mysql_query($query);
			if(!$r) die("<span style='color:red'>Error: </span>".mysql_error());

			while($l = mysql_fetch_array($r))
				echo "<tr id='cou".$l['id']."'><td>".$l['name']."</td><td>".$l['sname']."</td><td><a href='courseEdit.php?id=".$l['id']."'><button>Edit</button></a></td><td><a href='php/remove.php?type=course&url=coursesPanel.php&id=".$l['id']."'><button>Remove</button></a></td></tr>";
		?>
		</tbody>
	</table>
	<br>
	<a href="courseEdit.php"><button>Add New</button></a>

</body>
</html>