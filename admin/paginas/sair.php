<?php
		//iniciar sessao
		session_start();

		//apagar a sessao
		unset($_SESSION["hqs"]);

		//redirecionar
		header("Location: index.php");

?>