<?php
require_once("../classes/Database.class.php");

class Pessoa{
    private $id; // atributos privados podem ser lidos e escritos somente pelos membros da classe
    private $nome; 
    private $telefone;

    public function __construct($id = 0, $nome = "null", $telefone = "null"){
        $this->setId($id);
        $this->setNome($nome);
        $this->setTelefone($telefone);
    }

    /**
     * Métodos da classe: definem o comportamento do objeto pessoa
     */
    public function setId($novoId){
        if ($novoId < 0)
            echo "Erro: id inválido!";
        else
            $this->id = $novoId;
    }
    // função que define (set) o valor de um atributo
    public function setNome($novoNome){
        if ($novoNome == "")
            echo "Erro: nome inválido!";
        else
            $this->nome = $novoNome;
    }
    public function setTelefone($novoTelefone){
        if ($novoTelefone == "")
            echo "Erro: Telefone inválido!";
        else
            $this->telefone = $novoTelefone;
    }
    // função para ler (get) o valor de um atributo da classe
    public function getId(){
        return $this->id;
    }
    public function getNome() { return $this->nome;}
    public function getTelefone() { return $this->telefone;}

    /***
     * Inclui uma pessoa no banco  */     
    public function incluir(){
        $conexao = Database::getInstance();
        $sql = 'INSERT INTO pessoa (nome, telefone)
                     VALUES (:nome, :telefone)';
        $comando = $conexao->prepare($sql);  // prepara o comando para executar no banco de dados
        $comando->bindValue(':nome',$this->nome); // vincula os valores com o comando do banco de dados
        $comando->bindValue(':telefone',$this->telefone);
        return $comando->execute(); // executa o comando
    }    
    /** Método para excluir uma pessoa do banco de dados */
    public function excluir(){
        $conexao = Database::getInstance();
        $sql = 'DELETE 
                  FROM pessoa
                 WHERE id = :id';
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':id',$this->id);
        return $comando->execute();
    }  

    /**
     * Essa função altera os dados de uma pessoa no banco de dados
     */
    public function alterar(){
        $conexao = Database::getInstance();
        $sql = 'UPDATE pessoa 
                   SET nome = :nome, telefone = :telefone
                 WHERE id = :id';
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':id',$this->id);
        $comando->bindValue(':nome',$this->nome);
        $comando->bindValue(':telefone',$this->telefone);
        return $comando->execute();
    }    

    //** Método estático para listar pessoas */
    public static function listar($tipo = 0, $busca = "" ){
        $conexao = Database::getInstance();
        // montar consulta
        $sql = "SELECT * FROM pessoa";        
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
        $pessoas = array();
        // listar o resultado da consulta         
        while($registro = $comando->fetch()){
            $pessoa = new Pessoa($registro['id'],$registro['nome'],$registro['telefone'] );
            array_push($pessoas,$pessoa);
        }
        return $pessoas;  
    }    
}

?>