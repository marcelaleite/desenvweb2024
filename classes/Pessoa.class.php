<?php
require_once("../classes/Database.class.php");
require_once("../classes/Login.class.php");

class Pessoa{
    // Atributos da classe - informações que a classe irá controlar/manter
    private $id; // atributos privados podem ser lidos e escritos somente pelos membros da classe, 
    private $nome; // ... públicos pode ser manipulados por qualquer outro objeto/programa
    private $telefone;
    private $login; // objeto login
    private $endereco;

    //construtor da classe - permite definir o estado incial do objeto quando instanciado
    public function __construct($id = 0, $nome = "null", $telefone = "null", Login $login = null, Endereco $endereco = null){
        $this->setId($id); // chama os métodos da classe para definir os valores dos atributos,
        $this->setNome($nome); //...   enviando os parâmetros recebidos no construtor, em vez de
        $this->setTelefone($telefone); // .... atribuir direto, assim passa pelas regras de negócio
        $this->setLogin($login);
        $this->setEndereco($endereco);
    }

    public function setLogin(Login $login){
        $this->login = $login;
    }

    public function setEndereco(Endereco $endereco = null){
        $this->endereco = $endereco;
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
    public function getEndereco() { return $this->endereco;}

    /*** Inclui uma pessoa no banco  */     
    public function incluir(){
        $sql = 'INSERT INTO pessoa (nome, telefone, usuario, senha)   
                     VALUES (:nome, :telefone, :usuario, :senha)';
        $parametros = array(':nome'=>$this->nome,
                            ':telefone'=>$this->telefone,
                            ':senha'=>$this->getLogin()->getSenha(),
                            ':usuario'=>$this->getLogin()->getUsuario());

        Database::executar($sql, $parametros);
        
        $this->endereco->setIdPessoa(Database::$lastId);
        $this->endereco->incluir();
      
    }    
    /** Método para excluir uma pessoa do banco de dados */
    public function excluir(){
        $sql = 'DELETE 
                  FROM pessoa
                 WHERE id = :id';
        $parametros = array(':id'=> $this->id);
        return Database::executar($sql, $parametros);
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
   
        try{
            $comando->execute(); 
            $this->getEndereco()->alterar();
            return true;
        }catch(PDOException $e){
            throw new Exception ("Erro ao executar o comando no banco de dados: "
               .$e->getMessage()." - ".$comando->errorInfo()[2]);
        }
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
            $login = new Login($registro['usuario'],$registro['senha'] );
            $endereco = Endereco::listar(5,$registro['id'])[0];
            $pessoa = new Pessoa($registro['id'],$registro['nome'],$registro['telefone'] , $login, $endereco); // cria um objeto pessoa com os dados que vem do banco
            array_push($pessoas,$pessoa); // armazena no vetor pessoas
        }
        return $pessoas;  // retorna o vetor pessoas com uma coleção de objetos do tipo Pessoa
    }    
}

?>