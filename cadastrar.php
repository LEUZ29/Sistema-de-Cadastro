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
        <title>Sistema de Cadastro - Cadastrar</title>
    </head>
    <body>
    <a href="index.php">Página Inicial</a><br>
        <a href="lista.php">Lista</a><br>
        <h1>Cadastrar</h1>
        <?php
        // Recebe os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        // verificar se o usuário clicou no botão 
        if(!empty($dados['CadUsuario'])) {
            //var_dump($dados);
            $empty_input = false;

            $dados = array_map('trim', $dados);
            if(in_array("", $dados)){
                $empty_input = true;
                // Caso o usuário não preencha os campos
                echo "<p style='color: #F00;'>Erro: Necessário preencher todos os campos!</p>";    
            }elseif(!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
                $empty_input = true;
                // Caso o usuário não informe um E-mail válido
                echo "<p style='color: #F00;'>Erro: Necessário preencher o campo com o e-mail válido!</p>";
            }
            

            if(!$empty_input) {
           $query_usuario = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email) ";
           $cad_usuario = $conn->prepare($query_usuario);
           $cad_usuario->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
           $cad_usuario->bindParam(':email', $dados['email'], PDO::PARAM_STR);
           $cad_usuario->execute(); 
           if($cad_usuario->rowCount()) {
            unset($dados);
               // Caso o usuário informe os dados corretamente
               $_SESSION['msg'] = "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
               header("Location: lista.php");
           }else {
               // Caso o usuário não informe os dados corretamente
            echo "<p style='color: #F00;'>Erro: Usuário não cadastrado com sucesso!</p>";
           }
        }
    }
        ?>
        <form name="cad-usuario" method="POST" action="">
            <label>Nome: </label>
            <input type="text" name="nome" id="nome" placeholder="Nome Completo" value="<?php if
             (isset ($dados['nome'])) { 
                 echo $dados['nome'];
             } 
             ?>"><br><br>

            <label>Email: </label>
            <input type="email" name="email" id="email" placeholder="Seu e-mail" value="<?php if
            (isset($dados['email'])) { 
                echo $dados['email'];
             } 
             ?>"><br><br>
            
        
            <input type="submit" value="Cadastrar" name="CadUsuario">
            
        </form>
    </body>
    </html>