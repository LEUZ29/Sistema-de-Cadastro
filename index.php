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
        <title>Sistema de Cadastro</title>
    </head>
    <body>
        
        <h1>Seja bem vindo ao sistema de cadastro</h1>
        <p>Selecione abaixo a opção desejada</p>
        <a href="cadastrar.php">Cadastrar</a><br><br>
        <a href="lista.php">Listar</a><br><br>
        
        
       
    </body>
    </html>