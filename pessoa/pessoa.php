<?php
/** Controle de Pessoa */

require_once("../classes/Pessoa.class.php");
require_once("../classes/Endereco.class.php");

// Esse trecho avalia se foi enviado um ID na requisição GET - nesse caso o sistema deve apresentar o formulário 
// preenchido com os dados do contato para edição
$id =  isset($_GET['id'])?$_GET['id']:0; // pegar busca
$msg =  isset($_GET['MSG'])?$_GET['MSG']:""; // pegar busca
if ($id > 0){
    $contato = Pessoa::listar(1,$id)[0]; // cria a variável contato que será utilizada para preencher o formulário
                                         //       quando o usuário clicar para alterar um registro
}

// Inserir e alterar dados
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id =  isset($_POST['id'])?$_POST['id']:0; 
    $nome =  isset($_POST['nome'])?$_POST['nome']:0; 
    $telefone =  isset($_POST['telefone'])?$_POST['telefone']:0; 
    $usuario =  isset($_POST['usuario'])?$_POST['usuario']:0; 
    // dados do login
    $senha =  isset($_POST['senha'])?$_POST['senha']:0; 
    $acao =  isset($_POST['acao'])?$_POST['acao']:0; 
    // dados do endereço
    $cep =  isset($_POST['cep'])?$_POST['cep']:0; 
    $pais =  isset($_POST['pais'])?$_POST['pais']:0; 
    $estado =  isset($_POST['estado'])?$_POST['estado']:0; 
    $cidade =  isset($_POST['cidade'])?$_POST['cidade']:0; 
    $bairro =  isset($_POST['bairro'])?$_POST['bairro']:0; 
    $rua =  isset($_POST['rua'])?$_POST['rua']:0; 
    $numero =  isset($_POST['numero'])?$_POST['numero']:0; 
    $complemento =  isset($_POST['complemento'])?$_POST['complemento']:0; 
    $idendereco =  isset($_POST['idendereco'])?$_POST['idendereco']:0; 
    try{
        // criar o objeto Pessoa que irá persistir os dados 
        $endereco = new Endereco($idendereco,$cep,$pais,$estado,$cidade,$bairro,$rua,$numero,$complemento,$id);
        $login = new Login($usuario,$senha);
        $pessoa = new Pessoa($id,$nome,$telefone,$login, $endereco);

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
            header('location: index.php?MSG=Erro ao inserir/alterar registro');
    }catch(Exception $e){ // caso ocorra algum erro na validação das regras de negócio dispara uma exceção
        header('location: index.php?MSG=Erro: '.$e->getMessage()); // direciona para o incio com a mensagem de erro
    }
}elseif($_SERVER['REQUEST_METHOD'] == 'GET'){ // se a requisição é 
    //  Listagem e Pesquisa
    $busca =  isset($_GET['busca'])?$_GET['busca']:0; // pegar informação da busca
    $tipo =  isset($_GET['tipo'])?$_GET['tipo']:0; // pegar tipo de busca  
    // chama o método listar da classe Pessoa de forma estática (sem criar o objeto Pessoa) para preencher a variável lista 
       // que será usada para montar a tabela que lista todos os contatos
    $lista = Pessoa::listar($tipo,$busca); 
}
