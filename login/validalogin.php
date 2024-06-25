
<?php

session_start();

if (!isset($_SESSION['idusuario'])){
    header('location: ../login/index.php');
}