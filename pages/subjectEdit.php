<?php 
	if(isset($_GET['id'])){
		include "../cfg/mysql.php";
		$id = $_GET['id'];

		$query = "select name, description from subjects where id = $id;";
		
		$r = mysql_query($query);
		if(!$r) die("<span style='color:red'>Error:</span> ".mysql_error());
		$r = mysql_fetch_array($r);

		$name = $r['name'];
		$description = $r['description'];
	}else{
		$id = 0;
		$name = "";
		$description = "";
	}
?>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="<?php echo $id == 0 ? 'php/add.php' : 'php/update.php'; ?>">
		<input type="hidden" name="type" value="subject"/>
		<input type="hidden" name="url" value="subjectPanel.php"/>
		<input type="hidden" name="id" value="<?php echo $id; ?>"/>
		<label for="name">Name: </label>
		<input type="text" name="name" id="name" value="<?php echo $name; ?>"></input>
		<br>
		<label for="description">Description: </label>
		<input type="text" name="description" id="description" value="<?php echo $description; ?>"></input>
		<br>
		<input type="submit" value="Save"></input>
	</form>
</body>
</html>