<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de pessoas</title>
</head>
<body>
    <h1>Lista meus contatos</h1>
    <table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Telefone</th>
        </tr>
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
            $sql = "SELECT * FROM pessoa";

            // executar consulta
            $comando = $conexao->prepare($sql); // preparar comando
            $comando->execute(); // executar comando

            // listar o resultado da consulta
            $lista = $comando->fetchAll();
            foreach($lista as $pessoa){
                echo "<tr><td>".$pessoa['id']."</td><td>".$pessoa['nome']."</td><td>".$pessoa['telefone']."</td></tr>";
            }
        ?>
    </table>
</body>
</html>