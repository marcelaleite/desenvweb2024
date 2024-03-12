<?php

class Aluno{
    /**
     * Atributos da classe
     * Tudo o que o objeto deve controlar
     * o que o objeto sabe
     */
    public $matricula;
    public $nome;
    public $login;
    public $senha;

    /**
     * Métodos da classe
     * Tudo o que o objeto deve fazer
     * Comportamento do objeto
     * 
     */

     public function efetuarLogin($usuario, $senha){
        echo "Validando acesso...";
        return True;
     }

     public function acessarInternet(){
        echo "Jogando....";
     }

}


?>