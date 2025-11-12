<?php
require_once __DIR__ . '/../Database/Conexao.php';
require_once __DIR__ . '/../Models/Usuario.php';

class EnfermeiroDAO
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConnection();
    }

    /**
     * 🔹 Lista todos os enfermeiros
     */
    public function listar()
    {
        $sql = "SELECT * FROM usuario WHERE tipo = 'enfermeiro' ORDER BY nome ASC";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $enfermeiros = [];
        foreach ($resultado as $linha) {
            $enfermeiro = new Usuario();
            $enfermeiro->setIdUsuario($linha['idUsuario']);
            $enfermeiro->setNome($linha['nome']);
            $enfermeiro->setCpf($linha['cpf']);
            $enfermeiro->setEmail($linha['email']);
            $enfermeiro->setTelefone($linha['telefone'] ?? '');
            $enfermeiro->setEndereco($linha['endereco'] ?? '');
            $enfermeiro->setDataNascimento($linha['dataNascimento'] ?? '');
            $enfermeiro->setTipo($linha['tipo']);
            $enfermeiros[] = $enfermeiro;
        }

        return $enfermeiros;
    }

    /**
     * 🔹 Consulta um enfermeiro pelo ID
     */
    public function consultar($id)
    {
        $sql = "SELECT * FROM usuario WHERE idUsuario = :id AND tipo = 'enfermeiro'";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($linha) {
            $enfermeiro = new Usuario();
            $enfermeiro->setIdUsuario($linha['idUsuario']);
            $enfermeiro->setNome($linha['nome']);
            $enfermeiro->setCpf($linha['cpf']);
            $enfermeiro->setEmail($linha['email']);
            $enfermeiro->setTelefone($linha['telefone'] ?? '');
            $enfermeiro->setEndereco($linha['endereco'] ?? '');
            $enfermeiro->setDataNascimento($linha['dataNascimento'] ?? '');
            $enfermeiro->setTipo($linha['tipo']);
            return $enfermeiro;
        }

        return null;
    }

    /**
     * 🔹 Cadastra um novo enfermeiro
     */
    public function cadastrar(Usuario $enfermeiro)
    {
        $sql = "INSERT INTO usuario (nome, cpf, email, telefone, endereco, dataNascimento, tipo, senha)
                VALUES (:nome, :cpf, :email, :telefone, :endereco, :dataNascimento, 'enfermeiro', :senha)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':nome', $enfermeiro->getNome());
        $stmt->bindValue(':cpf', $enfermeiro->getCpf());
        $stmt->bindValue(':email', $enfermeiro->getEmail());
        $stmt->bindValue(':telefone', $enfermeiro->getTelefone());
        $stmt->bindValue(':endereco', $enfermeiro->getEndereco());
        $stmt->bindValue(':dataNascimento', $enfermeiro->getDataNascimento());
        $stmt->bindValue(':senha', password_hash($enfermeiro->getSenha(), PASSWORD_DEFAULT));

        return $stmt->execute();
    }

    /**
     * 🔹 Atualiza dados do enfermeiro
     */
    public function alterar(Usuario $enfermeiro)
    {
        $sql = "UPDATE usuario 
                SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone, 
                    endereco = :endereco, dataNascimento = :dataNascimento
                WHERE idUsuario = :id AND tipo = 'enfermeiro'";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $enfermeiro->getIdUsuario(), PDO::PARAM_INT);
        $stmt->bindValue(':nome', $enfermeiro->getNome());
        $stmt->bindValue(':cpf', $enfermeiro->getCpf());
        $stmt->bindValue(':email', $enfermeiro->getEmail());
        $stmt->bindValue(':telefone', $enfermeiro->getTelefone());
        $stmt->bindValue(':endereco', $enfermeiro->getEndereco());
        $stmt->bindValue(':dataNascimento', $enfermeiro->getDataNascimento());
        return $stmt->execute();
    }

    /**
     * 🔹 Exclui um enfermeiro pelo ID
     */
    public function excluir($id)
    {
        $sql = "DELETE FROM usuario WHERE idUsuario = :id AND tipo = 'enfermeiro'";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
