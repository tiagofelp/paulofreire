<?php 
		if (!session_start()) {
			die("Não foi possível abrir sessão!");
		}
		unset($_SESSION['id']);
			session_destroy();
			ob_clean();
			header("Location: index.php");
	 ?>