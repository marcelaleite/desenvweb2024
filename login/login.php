<?php
/** Controle de Pessoa */

require_once("../classes/Login.class.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario =  isset($_POST['usuario'])?$_POST['usuario']:0; 
    $senha =  isset($_POST['senha'])?$_POST['senha']:0; 

    try{
        // criar o objeto Pessoa que irá persistir os dados 
        $pessoa = Login::efetuarLogin($usuario,$senha);
        if ($pessoa){
            session_start();
            $_SESSION['idusuario'] = $pessoa->getId();
            $_SESSION['nome'] = $pessoa->getNome();
            header('location: ../pessoa/index.php');

        }
        else{
            echo "Efetuar login";
        }
    }catch(Exception $e){ // caso ocorra algum erro na validação das regras de negócio dispara uma exceção
        header('location: index.php?MSG=Erro: '.$e->getMessage()); // direciona para o incio com a mensagem de erro
    }
}