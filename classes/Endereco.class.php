<?php
require_once("../classes/Database.class.php");

class Endereco{
    private $idendereco; 
    private $cep; 
    private $pais;
    private $estado; 
    private $cidade; 
    private $bairro; 
    private $rua; 
    private $numero; 
    private $complemento; 
    private $idpessoa;


    //construtor da classe - permite definir o estado incial do objeto quando instanciado
    public function __construct($id = 0, $nome = "null", $telefone = "null", Login $login = null){
        $this->setId($id); // chama os métodos da classe para definir os valores dos atributos,
        $this->setNome($nome); //...   enviando os parâmetros recebidos no construtor, em vez de
        $this->setTelefone($telefone); // .... atribuir direto, assim passa pelas regras de negócio
        $this->setLogin($login);
    }
  
  

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
            $login = new Login($registro['usuario'],$registro['senha'] );
            $pessoa = new Pessoa($registro['id'],$registro['nome'],$registro['telefone'] , $login); // cria um objeto pessoa com os dados que vem do banco
            array_push($pessoas,$pessoa); // armazena no vetor pessoas
        }
        return $pessoas;  // retorna o vetor pessoas com uma coleção de objetos do tipo Pessoa
    }    

    /**
     * Get the value of rua
     */
    public function getRua()
    {
        return $this->rua;
    }

    /**
     * Set the value of rua
     */
    public function setRua($rua): self
    {
        $this->rua = $rua;

        return $this;
    }

    /**
     * Get the value of cep
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set the value of cep
     */
    public function setCep($cep): self
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get the value of pais
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set the value of pais
     */
    public function setPais($pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get the value of estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     */
    public function setEstado($estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get the value of cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set the value of cidade
     */
    public function setCidade($cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get the value of bairro
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set the value of bairro
     */
    public function setBairro($bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }

    /**
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     */
    public function setNumero($numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of complemento
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set the value of complemento
     */
    public function setComplemento($complemento): self
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get the value of idpessoa
     */
    public function getIdpessoa()
    {
        return $this->idpessoa;
    }

    /**
     * Set the value of idpessoa
     */
    public function setIdpessoa($idpessoa): self
    {
        $this->idpessoa = $idpessoa;

        return $this;
    }

    /**
     * Get the value of idendereco
     */
    public function getIdendereco()
    {
        return $this->idendereco;
    }

    /**
     * Set the value of idendereco
     */
    public function setIdendereco($idendereco): self
    {
        $this->idendereco = $idendereco;

        return $this;
    }
}

?>