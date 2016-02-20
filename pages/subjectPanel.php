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
		<div class="panel panel-default">
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="col-md-12">
				  		<label for="search_box">Procurar: </label>
				 		<input id="search_box" type="text" class="form-control" placeholder="Procurar"/>
					</div>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table  table-hover">
				<thead>
					<td><b>Name</b></td>
					<td><b>Description</b></td>
					<td><b>Edit</b></td>
					<td><b>Delete</b></td>
				</thead>
				<tbody id="list"></tbody>
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
    <script src="js/bootstrap-select.js"></script>

     <script type="text/javascript">
    	var subjects;
    	var allSubjects;
    	var sWord;

    	$(window ).on("load", function (){
    		$.get("php/select.php?type=subject", function (data){
	    		try{
	    			data = $.parseJSON(data);
	    			
	    			allSubjects = data;
	    			subjects = allSubjects;
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
		    	subjects = allSubjects.filter(function (el,i){
					return el['name'].toLowerCase().indexOf(sWord) != -1;
				});

				updateList();
		    });
    	});

		//Atualiza a lista da tabela.
		function updateList(){
			$("#list").html("");
			for(var i = 0; i < subjects.length; ++i){
				$("#list").html($("#list").html()+"<tr id='sub"+subjects[i]['id']+"'><td>"+subjects[i]['name']+"</td><td>"+subjects[i]['description']+"</td><td><a href='subjectEdit.php?id="+subjects[i]['id']+"'><button class='btn btn-default'><span class='glyphicon glyphicon-pencil'></span></button></a></td><td><a href='php/remove.php?type=subject&url=subjectPanel.php&id="+subjects[i]['id']+"'><button class='btn btn-default'><span class=' glyphicon glyphicon-trash'></span></button></a></td></tr>");
			}
			return;
		}
    </script>
</body>
</html>