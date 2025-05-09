<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>menu</title>
	</head>
	<body>
		<?php
			$RM=$_POST['RM'];

			require_once("conectaBD.php");

			$sql="SELECT RM FROM alunos WHERE RM=? ";
			// Prepara o SQL
			$stmt = mysqli_prepare($conn,$sql);
			if (!$stmt) {
				die("Não foi possível preparar a consulta!");
			}
			if (!mysqli_stmt_bind_param($stmt,"s",$RM)) {
				die("Não foi possível vincular parâmetros!");
			}
			if (!mysqli_stmt_execute($stmt)) {
				die("Não foi possível executar busca no Banco de Dados!");
			}
			if (!mysqli_stmt_bind_result($stmt, $RM)) {
				die("Não foi possível vincular resultados");
			}
			if (mysqli_stmt_fetch($stmt)) {
			    // Já existe esse RM
			    echo('
				    <style>
				    @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap");

					body {
						margin: 0;
						font-family: "Montserrat", sans-serif;
						font-optical-sizing: auto;
						font-style: normal;
						font-size: 15pt;
						background-color: radial-gradient(circle, rgba(46, 191, 165, 1) 0%, rgba(78, 65, 135, 1) 100%);
						color: white;
					}
				        .mensagem-centralizada {
				            display: flex;
				            align-items: center;
				            justify-content: center;
				            height: 100vh;
				            background-color: #f9fafb;
				        }
				        .mensagem-box {
				            background-color: white;
				            padding: 2rem 3rem;
				            border-radius: 12px;
				            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
				            text-align: center;
				        }
				        .mensagem-box h2 {
				            color: #6d28d9;
				            margin-bottom: 1rem;
				        }
				        .mensagem-box a {
				            text-decoration: none;
				            color: #7c3aed;
				            font-weight: bold;
				        }
				        .mensagem-box a:hover {
				            text-decoration: underline;
				        }
				    </style>
				    <div class="mensagem-centralizada">
				        <div class="mensagem-box">
				            <h2>Este RM já realizou a pesquisa!</h2>
				            <p><a href="index.php">Clique aqui para voltar à página de login</a></p>
				        </div>
				    </div>
				');
			} else {
			    // Não existe, então insere
			    mysqli_stmt_close($stmt);
			    
			    $sql1 = "INSERT INTO alunos (RM) VALUES (?)";
			    $stmt = mysqli_prepare($conn, $sql1);
			    if (!$stmt) {
			        die("Não foi possível preparar a consulta dos RMs!");
			    }
			    if (!mysqli_stmt_bind_param($stmt, "s", $RM)) {
			        die("Não foi possível vincular parâmetros!");
			    }
			    if (!mysqli_stmt_execute($stmt)) {
			        die("Não foi possível executar cadastro de RMs no Banco de Dados!!");
			    }
			    mysqli_stmt_close($stmt);

			    session_start();
			    $_SESSION['id'] = session_id();
			    $_SESSION['operador'] = $RM;

			    header("Location: forms.php");
			    exit;
			}			

		?>

	</body>
</html>