<?php
/** Controle de Pessoa */

require_once('config.inc.php');

// conectar com o banco 
$conexao = new PDO(DSN, USUARIO, SENHA);
require_once("Pessoa.class.php");

$id =  isset($_GET['id'])?$_GET['id']:0; // pegar busca
if ($id > 0){
    $pessoa = new Pessoa(); //
    $contato = $pessoa->listar($conexao,1,$id)[0];
}
// Inserir e alterar dados
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id =  isset($_POST['id'])?$_POST['id']:0; 
    $nome =  isset($_POST['nome'])?$_POST['nome']:0; 
    $telefone =  isset($_POST['telefone'])?$_POST['telefone']:0; 
    $acao =  isset($_POST['acao'])?$_POST['acao']:0; 

    // criar o objeto Pessoa que irá persistir os dados 
    $pessoa = new Pessoa($id,$nome,$telefone);
    $resultado = "";
    if($acao == 'salvar'){
        if($id > 0)//alterando
            // chamar o método para alterar uma pessoa
            $resultado = $pessoa->alterar($conexao);
        else // inserindo                        
            // chamar o método para incluir uma pessoa
            $resultado = $pessoa->incluir($conexao);
    }elseif ($acao == 'excluir'){
        // chamar o método para exluir uma pessoa
        $resultado = $pessoa->excluir($conexao);
    }
    if ($resultado)
        header('location: listapessoas.php');
    else
        echo "erro ao inserir dados!";
}elseif($_SERVER['REQUEST_METHOD'] == 'GET'){

    //  Listagem e Pesquisa
    $busca =  isset($_GET['busca'])?$_GET['busca']:0; // pegar busca
    $tipo =  isset($_GET['tipo'])?$_GET['tipo']:0; // pegar busca
    $pessoa = new Pessoa();
    $lista = $pessoa->listar($conexao,$tipo,$busca);
}
