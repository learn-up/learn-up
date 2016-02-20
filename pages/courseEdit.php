<?php 
	include "../cfg/mysql.php";
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$query = "select name, subject_id from courses where id = $id;";
		
		$r = mysql_query($query);
		if(!$r) die("<span style='color:red'>Error:</span> ".mysql_error());
		$r = mysql_fetch_array($r);

		$name = $r['name'];
		$subject = $r['subject_id'];
	}else{
		$id = 0;
		$name = "";
		$subject = "";
	}
	$query = "select id, name from subjects;";
	$subjects = mysql_query($query);
	if(!$subjects) die("<span style='color:red'>Error:</span> ".mysql_error());
?>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="<?php echo $id == 0 ? 'php/add.php' : 'php/update.php'; ?>">
		<input type="hidden" name="type" value="course"/>
		<input type="hidden" name="url" value="coursesPanel.php"/>
		<input type="hidden" name="id" value="<?php echo $id; ?>"/>
		<label for="name">Name: </label>
		<input type="text" name="name" id="name" value="<?php echo $name; ?>"></input>
		<br>
		<label for="subject">Subject: </label>
		<select name="subject" id="subject">
			<option value="" disabled selected>Select the subject</option>
			<?php 
				while($l = mysql_fetch_array($subjects))
					echo "<option value='".$l['id']."' ".(($subject == $l['id']) ? "selected" : "").">".$l['name']."</option>";
			?>
		</select>
		<br>
		<input type="submit" value="Save"></input>
	</form>
</body>
</html>