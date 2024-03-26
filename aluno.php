<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Alunos</title>
</head>
<body>
    <?php
    require_once("Aluno.class.php");

    // Criar o objeto aluno
    $a1 = new Aluno(); // instanciando um objeto do tipo aluno

    //  definir informações do objeto
    $a1->matricula = "1111"; // usar -> para acessar o membro da classe
    $a1->nome = "João";
    $a1->login = "joao@mail.com";
    $a1->senha = "xxxx";
    echo $a1->nome; // mesma forma para ler
    $a1->acessarInternet();
    $a1->efetuarLogin("mar","123");

    ?>
</body>
</html>