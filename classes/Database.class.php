<?php
require_once('../config/config.inc.php');

/**
 * A classe Database é responsável pela conexão
 * com o banco de dados
 */
class Database{
    //private $conexao;

    public static function getInstance(){
        try{ // com tratamento de exceção para conexão com o BD
            // conectar com o banco 
            return new PDO(DSN, USUARIO, SENHA);
        }catch(PDOException $e){
            echo "Erro ao conectar ao banco de dados: ".$e->getMessage();
        }
    }
}