<?php
class Pessoa{
    private $id; // atributos privados podem ser lidos e escritos somente pelos membros da classe
    private $nome;
    private $telefone;

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

    /***
     * Inclui uma pessoa no banco  */     
    public function incluir($conexao){
        $sql = 'INSERT INTO pessoa (nome, telefone)
                     VALUES (:nome, :telefone)';
        $comando = $conexao->prepare($sql);  // prepara o comando para executar no banco de dados
        $comando->bindValue(':nome',$this->nome); // vincula os valores com o comando do banco de dados
        $comando->bindValue(':telefone',$this->telefone);
        return $comando->execute(); // executa o comando
    }    
    /** Método para excluir uma pessoa do banco de dados */
    public function excluir($conexao){
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
    public function alterar($conexao){
        $sql = 'UPDATE pessoa 
                   SET nome = :nome, telefone = :telefone
                 WHERE id = :id';
        $comando = $conexao->prepare($sql); 
        $comando->bindValue(':id',$this->id);
        $comando->bindValue(':nome',$this->nome);
        $comando->bindValue(':telefone',$this->telefone);
        return $comando->execute();
    }    
    public function listar($conexao){}    

}

?>