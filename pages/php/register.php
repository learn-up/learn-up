<?php
	//Verificar se já existe uma sessão
	include "../../cfg/mysql.php";

	//Proteger as variaveis contra MSQL Injection
	$username = $_GET['username'];
	$password = md5($_GET['password']);
	$email = $_GET['email'];
	$first_name = $_GET['first_name'];
	$last_name = $_GET['last_name'];
	$phone = $_GET['phone'];

	//Checar se o usuário ou email já está cadastrado.

	$query = "insert into users(username, password, email, first_name, last_name, phone, singin_date) value('$username', '$password', '$email', '$first_name', '$last_name', '$phone', now())";

	mysql_query($query) or die("<b style='color:red'>Erro: </b>".mysql_error());
	//Carregar nova pagina.
?>