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
		<h1 class="page-header">Painel de Conteúdos</h1>
		<div class="panel panel-default">
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="col-md-6">
				  		<label for="search_box">Procurar: </label>
				 		<input id="search_box" type="text" class="form-control" placeholder="Procurar"/>
					</div>
					<div class="col-md-6">
						<label for="subjects">Matéria:</label><br>
						<select id="subjects" name="subjects" class="selectpicker" data-live-search="true">
							<option selected value='-1'>Todos</option>
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
					<td><b>Edit</b></td>
					<td><b>Delete</b></td>
				</thead>
				<tbody id="list"></tbody>
			</table>
		</div>
		<br>
		<a href="courseEdit.php"><button class='btn btn-default'><span class='glyphicon glyphicon-plus'></span></button></a>
	</div>
	 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>

    <script type="text/javascript">
    	var subjects;
    	var allSubjects;
    	var subject_selected;
    	var allCourses;
    	var courses;
    	var sWord;

    	$(window ).on("load", function (){
    		$.get("php/select.php?type=subject", function (data){
	    		try{
	    			data = $.parseJSON(data);
	    			
	    			allSubjects = data;
	    			subjects = allSubjects;
	    			
	    			for(var i = 0; i < data.length; ++i)
						$("#subjects").html($("#subjects").html()+"<option value='"+i+"'>"+subjects[i]['name']+"</option>");
					
				    $("#subjects").selectpicker('refresh');
					
					// Filtra a lista de conteúdos de acordo com a matéria selecionada.
					$('#subjects').on('change', function(){
						subject_selected = $(this).find("option:selected").val();
						//A matéria -1 é Todos
						if(subject_selected == '-1'){
							courses = allCourses;
						}else{
							//Retorna a lista de conteúdos da matéria selecionada;
							courses = allCourses.filter(function (el,i){
								//Se o id da matéria é igual ao id da matéria do conteúdo
								return subjects[subject_selected]['id'] == el['subject_id'];
							});
							if(sWord != null && sWord != "")
								courses = courses.filter(function (el,i){
								return el['name'].toLowerCase().indexOf(sWord) != -1;
							});
						}
						updateList();
					});
	    		}catch(err){
	    			console.log(err);
	    			alert(err);
	    		}
	    	});

	    	//Pega a lista de conteúdos
	    	$.get("php/select.php?type=courseAndSub", function (data){
	    		try{
	    			data = $.parseJSON(data);

	    			allCourses = data;
	    			courses = allCourses;
	  				updateList();
	    		}catch(err){
	    			console.log(err);
	    			alert(err);
	    		}
	    	});

	    	$('#search_box').on('input',function(e){
	    		sWord = $("#search_box").val().toLowerCase();
	    		if(sWord == null)
	    			sWord = "";
		    	courses = allCourses.filter(function (el,i){
					return el['name'].toLowerCase().indexOf(sWord) != -1;
				});

				if(subject_selected != null && subject_selected != '-1')
					courses = courses.filter(function (el,i){
						//Se o id da matéria é igual ao id da matéria do conteúdo
						return subjects[subject_selected]['id'] == el['subject_id'];
					});
				updateList();
		    });
    	});

		//Atualiza a lista da tabela.
		function updateList(){
			$("#list").html("");
			for(var i = 0; i < courses.length; ++i){
				$("#list").html($("#list").html()+"<tr id='cou"+courses[i]['id']+"'><td>"+courses[i]['name']+"</td><td>"+courses[i]['sname']+"</td><td><a href='courseEdit.php?id="+courses[i]['id']+"'><button class='btn btn-default'><span class='glyphicon glyphicon-pencil'></span></button></a></td><td><a href='php/remove.php?type=course&url=coursesPanel.php&id="+courses[i]['id']+"'><button class='btn btn-default'><span class=' glyphicon glyphicon-trash'></span></button></a></td></tr>");
			}
			return;
		}
    </script>

</body>
</html>