<?php
/** Controle de Pessoa */

require_once("../classes/Pessoa.class.php");

$id =  isset($_GET['id'])?$_GET['id']:0; // pegar busca
$msg =  isset($_GET['MSG'])?$_GET['MSG']:""; // pegar busca
if ($id > 0){
    $contato = Pessoa::listar(1,$id)[0];
}

// Inserir e alterar dados
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id =  isset($_POST['id'])?$_POST['id']:0; 
    $nome =  isset($_POST['nome'])?$_POST['nome']:0; 
    $telefone =  isset($_POST['telefone'])?$_POST['telefone']:0; 
    $acao =  isset($_POST['acao'])?$_POST['acao']:0; 

    try{
        // criar o objeto Pessoa que irá persistir os dados 
        $pessoa = new Pessoa($id,$nome,$telefone);
    }catch(Exception $e){ // caso ocorra algum erro na validação das regras de negócio dispara uma exceção
        header('location: index.php?MSG=Erro: '.$e->getMessage()); // direciona para o incio com a mensagem de erro
    }
    $resultado = "";
    if($acao == 'salvar'){
        if($id > 0)//alterando
            // chamar o método para alterar uma pessoa
            $resultado = $pessoa->alterar();
        else // inserindo                        
            // chamar o método para incluir uma pessoa
            $resultado = $pessoa->incluir();
    }elseif ($acao == 'excluir'){
        // chamar o método para exluir uma pessoa
        $resultado = $pessoa->excluir();
    }
    if ($resultado)
        header('location: index.php?MSG=Dados inseridos/Alterados com sucesso!');
    else
        echo "erro ao inserir dados!";
}elseif($_SERVER['REQUEST_METHOD'] == 'GET'){

    //  Listagem e Pesquisa
    $busca =  isset($_GET['busca'])?$_GET['busca']:0; // pegar busca
    $tipo =  isset($_GET['tipo'])?$_GET['tipo']:0; // pegar busca
  
    $lista = Pessoa::listar($tipo,$busca);
}
