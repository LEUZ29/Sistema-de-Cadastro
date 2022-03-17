<?php
session_start();
include_once'./conexao.php';
ob_start();

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if(empty($id)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: usuário não encontrado!</p>";
    header("Location: index.php");
    exit();
}
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
        <title>Sistema de Cadastro - Visualizar</title>
    </head>
    <body>
    <a href="lista.php">Lista</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>
        <h1>Visualizar</h1>

        <?php

        $query_usuario = "SELECT id, nome, email FROM usuarios WHERE id = $id LIMIT 1";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->execute();

        if(($result_usuario) AND ($result_usuario->rowCount() != 0) ) {
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
            //var_dump($row_usuario);
            extract($row_usuario);
           // echo "ID: " . $row_usuario['id'] . "<br>";

            echo "ID:  $id <br>";
            echo "Nome:  $nome <br>";
            echo "E-mail:  $email <br>";

        }else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: usuário não encontrado!</p>";
            header("Location: index.php");
        }


?>
        
    </body>
    </html>