<?php 

class Pessoa{
    public $id_pessoa;
    public $nome;
    public $idade;
    public $data_registro;

    public function __construct($id_pessoa=false)
    // construtor passando id como parametro
    //valor padrao de id é falso
    {
        if($id_pessoa){ // caso seja passado um id ao construtor
            $this->id_pessoa = $id_pessoa;
            // associa o id recebido no parametro
            // ao id propriedade da classe
            $this->carregar();
            // e carrega o restante das propriedades
        }
    }

    public function carregar(){
        $query = "SELECT nome, idade, data_registro FROM pessoas
        WHERE id_pessoa = :id_pessoa";
        $conexao = Conexao::conectar();
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(':id_pessoa', $this->id_pessoa);
        $stmt->execute();

        $lista = $stmt->fetch();
        $this->nome = $lista['nome'];
        $this->idade = $lista['idade'];
        $this->data_registro = $lista['data_registro'];

    }

    public function inserir(){ // insere 1 registro
        $query = "INSERT INTO pessoas (nome, idade) 
        VALUES (:nome, :idade)";
        // insere usando query preparada
        $conexao = Conexao::conectar();
        // cria a conexao
        $stmt = $conexao->prepare($query);
        // prepara a query
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':idade', $this->idade);
        // acima vinculam os valores da query com
        // as propriedades da classe
        $stmt->execute();
        // executa
    }

    public function listar(){ // lista todos os registros da tabela
        $query = "SELECT * FROM pessoas";
        // seleciona todas a colunas da tabela
        $conexao = Conexao::conectar();
        // cria conexao
        $resultado = $conexao->query($query);
        // executa a query e guarda o resultado na variavel
        $lista = $resultado->fetchAll();
        // transforma o resultado em 
        // um array associativo ("chave":"valor")
        return $lista;
        // retorna a lista
    }

    public function atualizar(){// atualiza 1 registro
        $query = "UPDATE pessoas SET nome = :nome,
        idade = :idade WHERE id_pessoa = :id_pessoa";
        // atualiza o registro desejado atraves do id
        $conexao = Conexao::conectar();
        // cria conexao
        $stmt = $conexao->prepare($query);
        // prepara a query
        $stmt->bindValue(":nome", $this->nome);
        $stmt->bindValue(":idade", $this->idade);
        $stmt->bindValue(":id_pessoa", $this->id_pessoa);
        // vincula os valores
        $stmt->execute();
        // executa
    }

    public function deletar(){ // exclui 1 registro
        $query = "DELETE FROM pessoas WHERE id_pessoa=:id_pessoa";
        // deleta pelo id 
        $conexao = Conexao::conectar();
        // cria conexao
        $stmt = $conexao->prepare($query);
        // prepara a query
        $stmt->bindValue(":id_pessoa", $this->id_pessoa);
        // vincula o valor
        $stmt->execute();
        // executa
    }

    public function listarPorNome($palavra){ 
        // lista todos os registros da tabela com base numa string
        $palavra = '%' . $palavra . '%'; // %palavra%
        $query = "SELECT * FROM pessoas WHERE nome LIKE :palavra";
        // seleciona todas a colunas da tabela
        $conexao = Conexao::conectar();
        // cria conexao
        $stmt = $conexao->prepare($query);
        // executa a query e guarda o resultado na variavel
        $stmt->bindValue(":palavra", $palavra);
        // vincula o placeholder de palavra com 
        // a variavel palavra do metodo
        $stmt->execute();
        //executa
        $lista = $stmt->fetchAll();
        // transforma o resultado em 
        // um array associativo ("chave":"valor")
        return $lista;
        // retorna a lista
    }
}





?>