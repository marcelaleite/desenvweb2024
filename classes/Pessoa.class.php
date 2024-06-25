<?php
require_once("../classes/Database.class.php");
require_once("../classes/Login.class.php");

class Pessoa{
    // Atributos da classe - informações que a classe irá controlar/manter
    private $id; // atributos privados podem ser lidos e escritos somente pelos membros da classe, 
    private $nome; // ... públicos pode ser manipulados por qualquer outro objeto/programa
    private $telefone;
    private $login; // objeto login

    //construtor da classe - permite definir o estado incial do objeto quando instanciado
    public function __construct($id = 0, $nome = "null", $telefone = "null", Login $login = null){
        $this->setId($id); // chama os métodos da classe para definir os valores dos atributos,
        $this->setNome($nome); //...   enviando os parâmetros recebidos no construtor, em vez de
        $this->setTelefone($telefone); // .... atribuir direto, assim passa pelas regras de negócio
        $this->setLogin($login);
    }
    public function setLogin(Login $login){
        $this->login = $login;
    }
    /**  Métodos da classe: definem o comportamento do objeto pessoa */
    public function setId($novoId){
        if ($novoId < 0)
            throw new Exception("Erro: id inválido!"); //dispara uma exceção
        else
            $this->id = $novoId;
    }
    // função que define (set) o valor de um atributo
    public function setNome($novoNome){
        if ($novoNome == "")
            throw new Exception("Erro: nome inválido!");
        else
            $this->nome = $novoNome;
    }
    public function setTelefone($novoTelefone){
        if ($novoTelefone == "")
            throw new Exception("Erro: Telefone inválido!");
        else
            $this->telefone = $novoTelefone;
    }
    // função para ler (get) o valor de um atributo da classe
    public function getId(){ return $this->id; }
    public function getNome() { return $this->nome;}
    public function getTelefone() { return $this->telefone;}
    public function getLogin() { return $this->login;}

    /*** Inclui uma pessoa no banco  */     
    public function incluir(){
        // abrir conexão com o banco de dados
        $conexao = Database::getInstance(); // chama o método getInstance da classe Database de forma // ... estática para abrir conexão com o banco de dados
        $sql = 'INSERT INTO pessoa (nome, telefone, usuario, senha)   
                     VALUES (:nome, :telefone, :usuario, :senha)';
        $comando = $conexao->prepare($sql);  // prepara o comando para executar no banco de dados
        $comando->bindValue(':nome',$this->nome); // vincula os valores com o comando do banco de dados
        $comando->bindValue(':telefone',$this->telefone);
        $comando->bindValue(':usuario',$this->getLogin()->getUsuario());
        $comando->bindValue(':senha',$this->getLogin()->getSenha());
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

    /** Essa função altera os dados de uma pessoa no banco de dados  */
    public function alterar(){
        $conexao = Database::getInstance();
        $sql = 'UPDATE pessoa 
                   SET nome = :nome, telefone = :telefone, usuario = :usuario, senha = :senha
                 WHERE id = :id';
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':id',$this->id);
        $comando->bindValue(':nome',$this->nome);
        $comando->bindValue(':telefone',$this->telefone);
        $comando->bindValue(':usuario',$this->login->getUsuario());
        $comando->bindValue(':senha',$this->login->getSenha());
        return $comando->execute();
    }    

    //** Método estático para listar pessoas - nesse caso não precisa criar um objeto Pessoa para poder chamar esse método */
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
        $comando = $conexao->prepare($sql); // preparar comando         
        if ($tipo > 0 )
            $comando->bindValue(':busca',$busca); // vincular os parâmetros
        $comando->execute(); // executar comando
        $pessoas = array(); // cria um vetor para armazenar o resultado da busca            
        while($registro = $comando->fetch()){   // listar o resultado da consulta    
            $login = new Login($registro['id'],$registro['usuario'],$registro['senha'] );
            $pessoa = new Pessoa($registro['id'],$registro['nome'],$registro['telefone'] , $login); // cria um objeto pessoa com os dados que vem do banco
            array_push($pessoas,$pessoa); // armazena no vetor pessoas
        }
        return $pessoas;  // retorna o vetor pessoas com uma coleção de objetos do tipo Pessoa
    }    
}

?>