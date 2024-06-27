<?php
require_once("../classes/Database.class.php");
class Login{
    /**
     * var string
     */
    private $usuario;
    /**
     * var string
     */
    private $senha;

    /**
     * param string $usuario
     * param string $senha
     * return void
     */
    public function __construct($usuario, $senha){
        $this->setUsuario($usuario);
        $this->setSenha($senha);
    }

    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }
    public function setSenha($senha){
        $this->senha = $senha;
    }
    public function getUsuario(){ return $this->usuario;}
    public function getSenha(){ return $this->senha;}

    /**
     * @param string $usuario
     * @param string $senha
     */
    public static function efetuarLogin($usuario, $senha){
        $conexao = Database::getInstance();
        $sql = 'SELECT * FROM pessoa 
                 WHERE usuario = :usuario
                   AND senha = :senha';
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':usuario',$usuario);
        $comando->bindValue(':senha',$senha);
        if ($comando->execute()){
            while($registro = $comando->fetch()){ 
                $login = new Login($registro['id'],$registro['usuario'],$registro['senha'] );
                $pessoa = new Pessoa($registro['id'],$registro['nome'],$registro['telefone'] , $login);
                return $pessoa;
            }
        }
        return false;
    }
}