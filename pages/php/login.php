<?php
	//Verificar se já existe uma sessão
	include "../../cfg/mysql.php";

	//Proteger as variaveis contra MSQL Injection
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$url = (isset($_GET['url']) && $_GET['url'] != "") ? $_GET['url'] : "../index.html";

	//O usuário poderá realizar login com o username ou email.
	$query = "select id, username, acess_level from users where (username = '$username' or email = '$username') and password = '$password';";
	$r = mysql_query($query) or die("<b style='color:red'>Erro: </b>".mysql_error());

	echo(mysql_num_rows($r));

	//Verificar os dados e criar a sessão
	if(mysql_num_rows($r) == 1){
		$l = mysql_fetch_array($r);
		$_SESSION['username'] = $l['username'];
		$_SESSION['user_id'] = $l['id'];
		$_SESSION['acess_level'] = $l['acess_level'];
		header("Location: ".$url);
	}else{
		header("Location: ../login.php?error=1");
	}
?>