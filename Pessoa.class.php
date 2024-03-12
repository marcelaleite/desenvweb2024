<?php
class Pessoa{
    private $id; // atributos privados podem ser lidos e escritos somente pelos membros da classe
    private $nome;
    private $telefone;

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

    /***
     * Inclui uma pessoa no banco  */ 
    
    public function incluir($conexao){
        $sql = 'INSERT INTO pessoa (nome, telefone)
                     VALUES (:nome, :telefone)';
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':nome',$this->nome);
        $comando->bindValue(':telefone',$this->telefone);
        return $comando->execute();
    }    
    public function excluir(){}    
    public function alterar(){}    
    public function listar(){}    

}

?>