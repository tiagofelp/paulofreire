<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Paginação de Usuários</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            width: 250px;
        }
        th {
            background-color: darkblue;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        select, button {
            margin: 10px 0;
        }
        .pagination {
            margin-top: 20px;
        }
        .btn{
        	background-color: rgba(0,0,0,0);
        	margin-color: rgba(0,0,0,0);
        }
        .botao{
            padding: 15px;
            border: none;
            border-radius: 7px;
            background-color: darkblue  ;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
            transition: 0.3s;
        }
        .botao:hover{
            background-color: #0056b3;
            padding: 17px ; 
            transform: scale(1.06); 
            font-size: 16px;
        }
        .pagination{
            text-align: center;
        }
        .sair{
            margin-left: 97%; 
        }
    </style>
    <script type="text/javascript">
        function mudaPagina(pag) {
            document.form1.pag.value = pag;
            document.form1.submit();
        }
        function edit(){
        	window.location.href="editar.php";
        }
    </script>
</head>
<body>
    <?php
        $tamPagina = 10;
        $regInicial = 0;

        if (isset($_POST['tamPagina'])) {
            $tamPagina = $_POST['tamPagina'];
        }
        if (isset($_POST['pag']) && $_POST['pag'] > -1) {
            $regInicial = ($_POST['pag'] - 1) * $tamPagina;
        }

        require("conectaBD.php");
        $sql = "SELECT * FROM pesquisa";
        $dataset = mysqli_query($conn, $sql);
        $qtdeRegistros = mysqli_num_rows($dataset);
        

        $sql = "SELECT * FROM pesquisa ORDER by RM  LIMIT $tamPagina OFFSET $regInicial";
        $dataset = mysqli_query($conn, $sql);

        echo("<table>"); 
        echo("<tr>");
        echo("<th>RM</th>");
        echo("<th>Nivel de Satisfação</th>");
        echo("<th>Detalhe da Experiência</th>");
        echo("</tr>");

        while ($linhaBD = mysqli_fetch_assoc($dataset)) {

            echo("<tr>");
            
            echo("<td>{$linhaBD['RM']}</td>");
            echo("<td>{$linhaBD['nivelDeSatisfacao']}</td>");
            echo("<td>{$linhaBD['detalhesExp']}</td>");
            echo("</tr>");
        
        }
        echo("</table>");
    ?>
    <script type="text/javascript">
         function edita() {
            window.location = "editar.php";
            <?php
                $sqlU;
            ?>
        }
    </script>
 
    <form name="form1" action="paginador.php" method="POST">
        <input type="hidden" name="pag" value="-1">
        <label for="tamPagina">Registros por página:</label>
        <select name="tamPagina" onchange="document.form1.submit()">
            <option value="10" <?php if($tamPagina == 10) echo 'selected'; ?>>10</option>
            <option value="15" <?php if($tamPagina == 15) echo 'selected'; ?>>15</option>
            <option value="20" <?php if($tamPagina == 20) echo 'selected'; ?>>20</option>
        </select>
    </form>

    <div class="pagination">
        <?php
            $qtdePaginas = ceil($qtdeRegistros / $tamPagina);
            for ($pag = 1; $pag <= $qtdePaginas; $pag++) {
                echo("<button class='botao' onclick='mudaPagina($pag)'>$pag</button>  ");
            }
        ?>
    </div>
    <div class="sair">
        <button class="botao" onclick="window.location='menu.php'"> ⤶</button>
    </div>
</body>
</html>
