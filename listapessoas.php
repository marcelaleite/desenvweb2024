<?php

define('USUARIO', 'marr'); /// root
define('SENHA', 'marR.123#'); // ''
define('HOST', 'localhost'); 
define('PORT', '3306'); 
define('DB', 'contatos'); 
define('DSN', "mysql:host=".HOST.";port=".PORT.";dbname=".DB.";charset=UTF8");

// conectar com o banco 
$conexao = new PDO(DSN, USUARIO, SENHA);

// montar consulta
$sql = "SELECT * FROM pessoa WHERE id = :id";
$id =  isset($_GET['id'])?$_GET['id']:0; // pegar busca
if ($id > 0){
    // prepara o comando
    $comando = $conexao->prepare($sql); // preparar comando
    // vincular os parâmetros
    $comando->bindValue(':id',$id);
    // executar consulta
    $comando->execute(); // executar comando
    // listar o resultado da consulta
    $contato = $comando->fetch();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de pessoas</title>
</head>
<body>
    <!-- Formulário de Cadastro -->
    <h1>CRUD de Contatos</h1>
    <form action="" method="post">
        <fieldset>
            <legend>Cadastro de Contatos</legend>        
                <label for="id">Id:</label>
                <input type="text" name="id" id="id" value="<?php if(isset($contato)) echo $contato['id']?>" readonly>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="<?php if(isset($contato)) echo $contato['nome']?>">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" value="<?php if(isset($contato)) echo $contato['telefone']?>">
                <button type='submit'>Salvar</button>
                <button type='reset'>Cancelar</button>
        </fieldset>
    </form>
    <hr>
    <!-- Formulário de pesquisa -->
    <form action="" method="get">
        <fieldset>
            <legend>Pesquisa</legend>
            <label for="busca">Busca:</label>
            <input type="text" name="busca" id="busca" value="">
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo">
                <option value="0">Escolha</option>
                <option value="1">Id</option>
                <option value="2">Nome</option>
                <option value="3">Telefone</option>
            </select>
        <button type='submit'>Buscar</button>

        </fieldset>
    </form>
    <hr>
    <h1>Lista meus contatos</h1>
    <table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Telefone</th>
        </tr>
        <?php
           
  
            // Inserir e alterar dados
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id =  isset($_POST['id'])?$_POST['id']:0; 
                $nome =  isset($_POST['nome'])?$_POST['nome']:0; 
                $telefone =  isset($_POST['telefone'])?$_POST['telefone']:0; 
                
                if($id > 0) { //alterando
                    $sql = 'UPDATE pessoa 
                               SET nome = :nome, telefone = :telefone
                             WHERE id = :id';
                    $comando = $conexao->prepare($sql); 
                    $comando->bindValue(':id',$id);
                    $comando->bindValue(':nome',$nome);
                    $comando->bindValue(':telefone',$telefone);

                }else{ // inserindo
                    $sql = 'INSERT INTO pessoa (nome, telefone)
                            VALUES (:nome, :telefone)';
                    $comando = $conexao->prepare($sql); 
                    $comando->bindValue(':nome',$nome);
                    $comando->bindValue(':telefone',$telefone);
                }
                if ($comando->execute())
                    echo "Dados inseridos/alterados com sucesso!";
                else
                    echo "erro ao inserir dados!";
            }
            //  Listagem e Pesquisa
            // montar consulta
            $sql = "SELECT * FROM pessoa";

            $busca =  isset($_GET['busca'])?$_GET['busca']:0; // pegar busca
            $tipo =  isset($_GET['tipo'])?$_GET['tipo']:0; // pegar busca

            if ($tipo > 0 )
                switch($tipo){
                    case 1: $sql .= " WHERE id = :busca"; break;
                    case 2: $sql .= " WHERE nome like :busca"; $busca = "%{$busca}%"; break;
                    case 3: $sql .= " WHERE telefone like :busca";  $busca = "%{$busca}%";  break;

                }

            // prepara o comando
            $comando = $conexao->prepare($sql); // preparar comando
            // vincular os parâmetros
            if ($tipo > 0 )
                $comando->bindValue(':busca',$busca);

            // executar consulta
            $comando->execute(); // executar comando

            // listar o resultado da consulta
            $lista = $comando->fetchAll();

            foreach($lista as $pessoa){
                echo "<tr><td><a href='listapessoas.php?id=".$pessoa['id']."'>".$pessoa['id']."</a></td><td>".$pessoa['nome']."</td><td>".$pessoa['telefone']."</td></tr>";
            }
        ?>
    </table>
</body>
</html>