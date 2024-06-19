<?php
require_once("../classes/Database.class.php");
class Login{
    private $id;
    private $usuario;
    private $senha;

    public function __construct($id, $usuario, $senha){
        $this->setId($id);
        $this->setUsuario($usuario);
        $this->setSenha($senha);
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }
    public function setSenha($senha){
        $this->senha = $senha;
    }
    public function getId(){ return $this->id;}
    public function getUsuario(){ return $this->usuario;}
    public function getSenha(){ return $this->senha;}

    public function efetuarLogin($usuario, $senha){
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

    }
}