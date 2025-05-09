<?php 

		if (!session_start()) {
			die("Não foi possível abrir sessão!");
		}
		if (!isset($_SESSION['id'])){
			ob_clean();
			header("Location: index.php");
		}
	 ?>