<?php
// Conexão com o banco
    require("ses_start.php");
    require("conectaBD.php");

    $RM=$_POST['RM'];
    $emocao=$_POST['emocao'];
    $texto=$_POST['texto'];
//$stmt = $conn->prepare("INSERT INTO sentimentos (emocao, data_registro) VALUES (?, ?)");
    $sql1 = "insert into pesquisa (RM,nivelDeSatisfacao,detalhesExp ) values (?,?,?)";
    $stmt = mysqli_prepare($conn,$sql1);
    if (!$stmt) {
        die("Não foi possível preparar a consulta dos RMs!");
    }
    if (!mysqli_stmt_bind_param($stmt,"sss",$RM,$emocao,$texto)) {
        die("Não foi possível vincular parâmetros!");
    }
    if (!mysqli_stmt_execute($stmt)) {
        die("Não foi possível executar cadastro de RMs no Banco de Dados!!");
    }          
    if (!mysqli_stmt_close($stmt)) {
        echo("Não foi possível efetuar limpeza da conexão. Avise o setor de TI");           
    }

// Consulta para o gráfico
$sql = "SELECT nivelDeSatisfacao, COUNT(*) as total FROM pesquisa GROUP BY nivelDeSatisfacao";
$result = $conn->query($sql);

$emocoes = [];
$quantidades = [];

while ($row = $result->fetch_assoc()) {
    $emocoes[] = $row['nivelDeSatisfacao'];
    $quantidades[] = $row['total'];
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gráfico de Emoções</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding: 40px;
        }
        .grafico-container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
        }
        canvas {
            width: 100% !important;
            height: 500px !important;
        }
        a {
            display: inline-block;
            margin-top: 30px;
            background: #8a4fff;
            padding: 12px 20px;
            color: #fff;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Ranking de Emoções</h2>
    <div class="grafico-container">
        <canvas id="graficoEmocoes"></canvas>
    </div>

    <a href="sair.php">Voltar para o login</a>

    <script>
        const ctx = document.getElementById('graficoEmocoes').getContext('2d');

        const emojiLabels = {
            "Muito Triste": "😭 Muito Triste",
            "Triste": "😔 Triste",
            "Neutro": "😐 Neutro",
            "Feliz": "😊 Feliz",
            "Muito Feliz": "😄 Muito Feliz"
        };

        const barColors = [
            '#FF6384', '#FF9F40', '#FFCD56', '#4BC0C0', '#36A2EB'
        ];

        const labelsOriginais = <?php echo(json_encode($emocoes)); ?>;
        const labels = labelsOriginais.map(emocao => emojiLabels[emocao] || emocao);
        const data = <?php echo(json_encode($quantidades)); ?>;

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Número de votos',
                    data: data,
                    backgroundColor: barColors.slice(0, data.length),
                    borderRadius: 10
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>

</body>
</html>
