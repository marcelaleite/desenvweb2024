<?php  
require_once('../login/validalogin.php');

include_once('pessoa.php'); ?>

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
    <h3><?=$msg?></h3>
    <form action="pessoa.php" method="post">
        <fieldset>
            <legend>Cadastro de Contatos</legend>        
            <fieldset>
                <legend>Dados do Usuário</legend>        
                    <label for="id">Id:</label>
                    <input type="text" name="id" id="id" value="<?=isset($contato)?$contato->getId():0 ?>" readonly>
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" value="<?php if(isset($contato)) echo $contato->getNome()?>">
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" id="telefone" value="<?php if(isset($contato)) echo $contato->getTelefone()?>">
                    <label for="usuario">Usuario:</label>
                    <input type="email" placeholder="informe um e-mail" name="usuario" id="usuario" value="<?php if(isset($contato)) echo $contato->getLogin()->getUsuario()?>">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" value="<?php if(isset($contato)) echo $contato->getLogin()->getSenha()?>">
        
            </fieldset>
            <fieldset>
                <legend>Dados do Endereço</legend>        
                    <input type="hidden" name="idendereco" id="idendereco" value="<?=isset($contato)?$contato->getEndereco()->getIdendereco():0 ?>" readonly>
                    <label for="cep">Cep:</label>
                    <input type="text" name="cep" id="cep" value="<?php if(isset($contato)) echo $contato->getEndereco()->getCep()?>">
                    <label for="pais">Pais:</label>
                    <input type="text" name="pais" id="pais" value="<?php if(isset($contato)) echo $contato->getEndereco()->getPais()?>">
                    <label for="estado">Estado:</label>
                    <input type="text" name="estado" id="estado" value="<?php if(isset($contato)) echo $contato->getEndereco()->getEstado()?>">
                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" value="<?php if(isset($contato)) echo $contato->getEndereco()->getCidade()?>">
                    <label for="bairro">Bairro:</label>
                    <input type="text" name="bairro" id="bairro" value="<?php if(isset($contato)) echo $contato->getEndereco()->getBairro()?>">
                    <label for="rua">Rua:</label>
                    <input type="text" name="rua" id="rua" value="<?php if(isset($contato)) echo $contato->getEndereco()->getRua()?>">
                    <label for="numero">Numero:</label>
                    <input type="text" name="numero" id="numero" value="<?php if(isset($contato)) echo $contato->getEndereco()->getNumero()?>">
                    <label for="complemento">Complemento:</label>
                    <input type="text" name="complemento" id="complemento" value="<?php if(isset($contato)) echo $contato->getEndereco()->getComplemento()?>">                
                </fieldset>
                <button type='submit' name='acao' value='salvar'>Salvar</button>
                <button type='submit' name='acao' value='excluir'>Excluir</button>
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
            <th>Usuário</th>
            <th>País</th>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Rua</th>
            <th>Complemento</th>
            <th>Número</th>
            <th>CEP</th>
        </tr>
        <?php  
            foreach($lista as $pessoa){ // monta a tabela com base na variável lista, criada no pessoa.php
                echo "<tr><td><a href='index.php?id=".$pessoa->getId()."'>".$pessoa->getId()."</a></td><td>".$pessoa->getNome()."</td><td>".$pessoa->getTelefone()."</td><td>".$pessoa->getLogin()->getUsuario()."</td><td>".$pessoa->getEndereco()->getPais()."</td><td>".$pessoa->getEndereco()->getEstado()."</td><td>".$pessoa->getEndereco()->getCidade()."</td><td>".$pessoa->getEndereco()->getRua()."</td><td>".$pessoa->getEndereco()->getComplemento()."</td><td>".$pessoa->getEndereco()->getNumero()."</td><td>".$pessoa->getEndereco()->getCep()."</td></tr>";
            }     
        ?>
    </table>
</body>
</html>
