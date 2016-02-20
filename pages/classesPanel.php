<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Learn-Up Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-select.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<h1 class="page-header">Painel de Aulas</h1>
		<div class="panel panel-default">
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="col-md-12">
				  		<label for="search_box">Procurar: </label>
				 		<input id="search_box" type="text" class="form-control" placeholder="Procurar"/>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-6">
						<label for="subjects">Matéria:</label><br>
						<select id="subjects" name="subjects" class="selectpicker" data-live-search="true">
							<option selected>Todos</option>
						</select>
					</div>
					<div class="col-md-6">
						<label for="courses">Conteúdo:</label><br>
						<select id="courses" name="courses" class="selectpicker" data-live-search="true">
							<option selected>Todos</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="table-responsive">
			<table class="table  table-hover">
				<thead>
					<td><b>Name</b></td>
					<td><b>Subject</b></td>
					<td><b>Course</b></td>
					<td><b>Duration</b></td>
					<td><b>Edit</b></td>
					<td><b>Delete</b></td>
				</thead>
				<tbody id="list">
				</tbody>
			</table>
		</div>
		<br>
		<a href="classEdit.php"><button class='btn btn-default'><span class='glyphicon glyphicon-plus'></span></button></a>
	</div>
	    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>

    <script type="text/javascript">
    	//Lista de todas as matérias
    	var allSubjects;
    	
    	//Lista das matérias sendo mostradas na lista
    	var subjects;
    	
    	//Matéria selecionada
    	var subject_selected;
    	
    	//Lista de todos os conteúdos
    	var allCourses;
    	
    	//Lista de todos os conteúdos sendo mostrados na lista
    	var courses;

    	//Conteúdo selecionado
    	var course_selected;

    	var allClasses;
    	var classes;
    	var sWord;

    	//Quando a página carregar, carrega as listas.
    	$(window ).on("load", function(){
    		//Pega a lista de matérias
	    	$.get("php/select.php?type=subject", function (data){
	    		try{
	    			data = $.parseJSON(data);
	    			
	    			allSubjects = data;
	    			subjects = allSubjects;
	    			
	    			update("subjects");
					
					// Filtra a lista de conteúdos de acordo com a matéria selecionada.
					$('#subjects').on('change', function(){
						subject_selected = $(this).find("option:selected").val();
						//A matéria -1 é Todos
						if(subject_selected == '-1'){
							courses = allCourses;
							classes = allClasses;
						}else{
							//Retorna a lista de conteúdos da matéria selecionada;
							courses = allCourses.filter(function (el,i){
								//Se o id da matéria é igual ao id da matéria do conteúdo
								return subjects[subject_selected]['id'] == el['subject_id'];
							});
							classes = allClasses.filter(function (el,i){
								return subjects[subject_selected]['id'] == el['subject_id'];
							});
							if(sWord != null && sWord != "")
								classes = classes.filter(function (el,i){
									return el['name'].toLowerCase().indexOf(sWord) != -1;
								});
						}
						update("courses");
						updateList();
					});
	    		}catch(err){
	    			console.log(err);
	    			alert(err);
	    		}
	    	});

	    	//Pega a lista de conteúdos
	    	$.get("php/select.php?type=course", function (data){
	    		try{
	    			data = $.parseJSON(data);

	    			allCourses = data;
	    			courses = allCourses;
	    			
	    			update("courses");
					
					$('#courses').on('change', function(){
						course_selected = $(this).find("option:selected").val();
						if(course_selected != '-1'){
							classes = allClasses.filter(function (el,i){
									return courses[course_selected]['id'] == el['course_id'];
							});
							if(sWord != null && sWord != "")
								classes = classes.filter(function (el,i){
									return el['name'].toLowerCase().indexOf(sWord) != -1;
								});
						}else
							classes = allClasses;
						updateList();
					});
	    		}catch(err){
	    			console.log(err);
	    			alert(err);
	    		}
	    	});

	    	//Pega a lista de aulas
	    	$.get("php/select.php?type=classAndSub", function (data){
	    		try{
	    			data = $.parseJSON(data);

	    			allClasses = data;
	    			classes = allClasses;
	    			
	    			updateList();
	    		}catch(err){
	    			console.log(err);
	    			alert(err);
	    		}
	    	});

	    	$('#search_box').on('input',function(e){
	    		sWord = $("#search_box").val().toLowerCase();
		    	classes = allClasses.filter(function (el,i){
					return el['name'].toLowerCase().indexOf(sWord) != -1;
				});
				if(subject_selected != null && subject_selected != '-1')
					classes = classes.filter(function (el,i){
						return el['subject_id'] == subjects[subject_selected]['id'];
					});
				if(course_selected != null && course_selected != '-1')
					classes = classes.filter(function (el,i){
						return el['course_id'] == courses[course_selected]['id'];
					});
				updateList();
		    });
    	});

	//Atualiza as listas com o que deve ser mostrado.
	function update(item){
		$("#"+item).html("<option value='-1'>Todos</option>");
		var data = (item == "subjects") ? subjects : courses;
		for(var i = 0; i < data.length; ++i){
			$("#"+item).html($("#"+item).html()+"<option value='"+i+"'>"+data[i]['name']+"</option>");
		}
	    $("#"+item).selectpicker('refresh');
	}

	//Atualiza a lista da tabela.
	function updateList(){
		$("#list").html("");
		for(var i = 0; i < classes.length; ++i){
			$("#list").html($("#list").html()+"<tr id='cla"+classes[i]['id']+"'><td>"+classes[i]['name']+"</td><td>"+classes[i]['sname']+"</td><td>"+classes[i]['cname']+"</td><td>"+classes[i]['duration']+" min</td><td><a href='classEdit.php?id="+classes[i]['id']+"'><button class='btn btn-default'><span class='glyphicon glyphicon-pencil'></span></button></a></td><td><a href='php/remove.php?type=class&url=classesPanel.php&id="+classes[i]['id']+"'><button class='btn btn-default'><span class=' glyphicon glyphicon-trash'></span></button></a></td></tr>");
		}
		return;
	}
    </script>
</body>
</html>