<?php
session_start();
include_once'./conexao.php';
ob_start();
?>
<!DOCTYPE html>
<html>
    <style>
        body{
            background-image: url(background-cinza.png);
text-align: center;
        }
    </style>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Cadastro - Lista</title>
    </head>
    <body>
        <a href="index.php">Página Inicial</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>
        <h1>Usuários Cadastrados</h1>
        <?php
        if(isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        //Receber o número da página
        $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
        $pagina = ( !empty($pagina_atual)) ? $pagina_atual : 1 ;
        //var_dump($pagina);

        //Setar a quantidade de registros por página
        $limite_resultado = 40;
        
        //Calcular o inicio da visualização
        $inicio = ($limite_resultado * $pagina) - $limite_resultado;

        $query_usuarios = "SELECT id, nome, email FROM usuarios ORDER By id DESC LIMIT $inicio, $limite_resultado";
        $result_usuarios = $conn->prepare($query_usuarios);
        $result_usuarios->execute();

        if(($result_usuarios) AND ($result_usuarios->rowCount() != 0)) {
            while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
                //var_dump($row_usuario);
                extract($row_usuario);
                echo "ID: $id <br><br>";
                echo "Nome: $nome <br><br>";
                echo "E-MAIL: $email <br><br>";
                echo "<a href='visualizar.php?id=$id'>Visualizar<?a><br>";
                echo "<a href='editar.php?id=$id'>Editar<?a><br>";
                echo "<a href='apagar.php?id=$id'>Apagar</a><br>";
                echo "<hr>";
            }

            // Contar a quantidade de registro no BD
            $query_qtd_registros = "SELECT COUNT(id) AS num_result FROM usuarios";
            $result_qtd_registros =$conn->prepare($query_qtd_registros);
            $result_qtd_registros->execute();
            $row_qtd_registros = $result_qtd_registros->fetch(PDO::FETCH_ASSOC);

            // Quantidade de páginas
            $qnt_pagina = ceil($row_qtd_registros['num_result'] / $limite_resultado);
            
            // Máximo de link
            $maximo_link = 2;

            echo "<a href='index.php?page=1'>Primeira</a> ";

            for($pagina_anterior = $pagina - $maximo_link; $pagina_anterior <= $pagina - 1; 
            $pagina_anterior++) {
                if($pagina_anterior >=1) {
                echo "<a href='index.php?page=$pagina_anterior'>$pagina_anterior</a> ";
                }
            }

            echo "<a href='#'>$pagina</a>";

            for($proxima_pagina = $pagina +1 ; $proxima_pagina <= $pagina + $maximo_link; 
            $proxima_pagina++){
                if($proxima_pagina <= $qnt_pagina){
                echo "<a href='index.php='>$proxima_pagina</a> ";
                }
            }

            echo "<a href='index.php?page=$qnt_pagina'>Última</a> ";
        }else{
            echo "<p style='color: #F00;'>Erro: Nenhum usuário encontrado!</p>";
        }

?>
       
    </body>
    </html>