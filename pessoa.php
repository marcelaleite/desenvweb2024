<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pessoa</title>
</head>
<body>
    <?php
    require_once("Pessoa.class.php");
    $pessoa = new Pessoa();
    $pessoa->defineId(-1);

    $pessoa->incluir();
    ?>
</body>
</html>