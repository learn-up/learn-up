<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-select.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

	<div class="container">
		<h1 class="page-header">Painel de Matérias</h1>

		<div class="table-responsive">
			<table class="table  table-hover">
				<thead>
					<td><b>Name</b></td>
					<td><b>Description</b></td>
					<td><b>Edit</b></td>
					<td><b>Delete</b></td>
				</thead>
				<tbody id="list">
					<?php 
						//Verificar se o usuario possui permissão de acessar essa pagina
						include "../cfg/mysql.php";

						$query = "select id, name, description from subjects;";
						$r = mysql_query($query);
						if(!$r) die("<span style='color:red'>Error: </span>".mysql_error());

						while($l = mysql_fetch_array($r))
							echo "<tr id='sub".$l['id']."'><td>".$l['name']."</td><td>".$l['description']."</td><td><a href='subjectEdit.php?id=".$l['id']."'><button class='btn btn-default'><span class='glyphicon glyphicon-pencil'></span></button></a></td><td><a href='php/remove.php?type=subject&url=subjectPanel.php&id=".$l['id']."'><button class='btn btn-default'><span class=' glyphicon glyphicon-trash'></span></button></a></td></tr>";
						

					?>
				</tbody>
			</table>
		</div>
		<br>
		<a href="subjectEdit.php"><button class='btn btn-default'><span class='glyphicon glyphicon-plus'></span></button></a>
	</div>
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script
</body>
</html>