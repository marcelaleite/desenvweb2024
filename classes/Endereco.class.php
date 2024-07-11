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

    public function __construct($idendereco = 0, $cep = "null", $pais = "null", $estado = "null", $cidade = "null", $bairro = "null", $rua = "null",$numero = 0, $complemento = "null", $idpessoa = 0){
        $this->setIdEndereco($idendereco);
        $this->setCep($cep); 
        $this->setPais($pais); 
        $this->setEstado($estado);
        $this->setCidade($cidade);
        $this->setBairro($bairro);
        $this->setRua($rua);
        $this->setNumero($numero);
        $this->setComplemento($complemento);
        $this->setIdPessoa($idpessoa);
    }
  
  

    /*** Inclui uma pessoa no banco  */     
    public function incluir(){
        // abrir conexão com o banco de dados
        $conexao = Database::getInstance(); // chama o método getInstance da classe Database de forma // ... estática para abrir conexão com o banco de dados
        $sql = 'INSERT INTO endereco (cep, pais, estado, cidade, bairro, rua, numero, complemento, idpessoa)   
                     VALUES (:cep, :pais, :estado, :cidade, :bairro, :rua, :numero, :complemento, :idpessoa)';
        $comando = $conexao->prepare($sql);  
        $comando->bindValue(':cep',$this->getCep()); 
        $comando->bindValue(':pais',$this->getPais());
        $comando->bindValue(':estado',$this->getEstado());
        $comando->bindValue(':cidade',$this->getCidade());
        $comando->bindValue(':bairro',$this->getBairro());
        $comando->bindValue(':rua',$this->getRua());
        $comando->bindValue(':numero',$this->getNumero());
        $comando->bindValue(':complemento',$this->getComplemento());
        $comando->bindValue(':idpessoa',$this->getIdPessoa());

        try{
            return $comando->execute(); 
        }catch(PDOException $e){
            throw new Exception ("Erro ao executar o comando no banco de dados: "
               .$e->getMessage()." - ".$comando->errorInfo()[2]);
        }
    }    
    /** Método para excluir uma pessoa do banco de dados */
    public function excluir(){
        $conexao = Database::getInstance();
        $sql = 'DELETE 
                  FROM endereco
                 WHERE idendereco = :id';
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':id',$this->getIdendereco());
        return $comando->execute();
    }  

    /** Essa função altera os dados de uma pessoa no banco de dados  */
    public function alterar(){
        $conexao = Database::getInstance();
        $sql = 'UPDATE endereco 
                   SET cep = :cep, pais = :pais, estado = :estado, cidade = :cidade, bairro = :bairro, rua = :rua, numero = :numero, complemento = :complemento, idpessoa = :idpessoa
                 WHERE idendereco = :id';
        $comando = $conexao->prepare($sql);  
        $comando->bindValue(':id',$this->getIdendereco()); 
        $comando->bindValue(':cep',$this->getCep()); 
        $comando->bindValue(':pais',$this->getPais());
        $comando->bindValue(':estado',$this->getEstado());
        $comando->bindValue(':cidade',$this->getCidade());
        $comando->bindValue(':bairro',$this->getBairro());
        $comando->bindValue(':rua',$this->getRua());
        $comando->bindValue(':numero',$this->getNumero());
        $comando->bindValue(':complemento',$this->getComplemento());
        $comando->bindValue(':idpessoa',$this->getIdPessoa());
        return $comando->execute();
    }    

    //** Método estático para listar pessoas - nesse caso não precisa criar um objeto Pessoa para poder chamar esse método */
    public static function listar($tipo = 0, $busca = "" ){
        $conexao = Database::getInstance();
        // montar consulta
        $sql = "SELECT * FROM endereco";        
        if ($tipo > 0 )
            switch($tipo){
                case 1: $sql .= " WHERE id = :busca"; break;
                case 2: $sql .= " WHERE cep like :busca"; $busca = "%{$busca}%"; break;
                case 3: $sql .= " WHERE rua like :busca";  $busca = "%{$busca}%";  break;
                case 4: $sql .= " WHERE pais like :busca";  $busca = "%{$busca}%";  break;
                case 5: $sql .= " WHERE idpessoa = :busca";  break;
            }
        $comando = $conexao->prepare($sql);      
        if ($tipo > 0 )
            $comando->bindValue(':busca',$busca); 
        $comando->execute();
        $enderecos = array();            
        while($registro = $comando->fetch()){  
            $endereco = new Endereco($registro['idendereco'], 
                                     $registro['cep'], 
                                     $registro['pais'],
                                     $registro['estado'],
                                     $registro['cidade'],
                                     $registro['bairro'],
                                     $registro['rua'],
                                     $registro['numero'],
                                     $registro['complemento'],
                                     $registro['idpessoa']);
            array_push($enderecos,$endereco); 
        }
        return $enderecos;  
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