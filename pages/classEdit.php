<?php 
	include "../cfg/mysql.php";
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$query = "select name, course_id, duration, difficulty, description from classes where id = $id;";
		
		$r = mysql_query($query);
		if(!$r) die("<span style='color:red'>Error:</span> ".mysql_error());
		$r = mysql_fetch_array($r);

		$name = $r['name'];
		$duration = $r['duration'];
		$difficulty = $r['difficulty'];
		$description = $r['description'];
		$course = $r['course_id'];
	}else{
		$id = 0;
		$name = "";
		$course = "";
		$duration = "";
		$description = "";
		$difficulty = "";
	}
	$query = "select id, name from courses;";
	$courses = mysql_query($query);
	if(!$courses) die("<span style='color:red'>Error:</span> ".mysql_error());
?>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="<?php echo $id == 0 ? 'php/add.php' : 'php/update.php'; ?>">
		<input type="hidden" name="type" value="class"/>
		<input type="hidden" name="url" value="classesPanel.php"/>
		<input type="hidden" name="id" value="<?php echo $id; ?>"/>
		<label for="name">Name: </label>
		<input type="text" name="name" id="name" value="<?php echo $name; ?>"></input>
		<br>
		<label for="duration">Duration: </label>
		<input type="text" name="duration" id="duration" value="<?php echo $duration; ?>"></input>
		<br>
		<label for="difficulty">Difficulty: </label>
		<input type="text" name="difficulty" id="difficulty" value="<?php echo $difficulty; ?>"></input>
		<br>
		<label for="description">Description: </label>
		<input type="text" name="description" id="description" value="<?php echo $description; ?>"></input>
		<br>
		<label for="course">Course: </label>
		<select name="course" id="course">
			<option value="" disabled selected>Select the course</option>
			<?php 
				while($l = mysql_fetch_array($courses))
					echo "<option value='".$l['id']."' ".(($course == $l['id']) ? "selected" : "").">".$l['name']."</option>";
			?>
		</select>
		<br>
		<input type="submit" value="Save"></input>
	</form>
</body>
</html>