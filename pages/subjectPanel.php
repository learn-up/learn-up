<html>
<head>
	<title>Subject Panel</title>
</head>
<body>
	<h1>Subject Panel</h1>

	<table border='1'>
		<thead>
			<td>Name</td>
			<td>Description</td>
			<td>Edit</td>
			<td>Delete</td>
		</thead>
		<?php 
			//Verificar se o usuario possui permissão de acessar essa pagina
			include "../cfg/mysql.php";

			$query = "select id, name, description from subjects;";
			$r = mysql_query($query);
			if(!$r) die("<span style='color:red'>Error: </span>".mysql_error());

			while($l = mysql_fetch_array($r))
				echo "<tr id='sub".$l['id']."'><td>".$l['name']."</td><td>".$l['description']."</td><td><a href='subjectEdit.php?id=".$l['id']."'><button>Edit</button></a></td><td><a href='php/remove.php?type=subject&url=subjectPanel.php&id=".$l['id']."'><button>Remove</button></a></td></tr>";
			

		?>
	</table>
	<br>
	<a href="subjectEdit.php"><button>Add New</button></a>
</body>
</html>