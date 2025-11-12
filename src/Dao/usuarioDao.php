<?php
require_once __DIR__ . '/../../config/Conexao.php';
require_once __DIR__ . '/../Models/usuario.php';

class UsuarioDao {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConnection();
    }

    // CADASTRAR (INSERT)
    public function inserir(Usuario $u) {
        $sql = "INSERT INTO usuario (nomeUsuario, cpfUsuario, dataNascimento, endereco, telefone, email, senha, tipo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $u->getNome(),
            $u->getCpf(),
            $u->getDataNascimento(),
            $u->getEndereco(),
            $u->getTelefone(),
            $u->getEmail(),
            $u->getSenha(),
            $u->getTipo()
        ]);
    }

    // LISTAR (SELECT *)
    public function listar() {
        $sql = "SELECT * FROM usuario";
        $stmt = $this->conn->query($sql);
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $usuarios = [];
        foreach ($resultado as $row) {
            $u = new Usuario();
            $u->setIdUsuario($row['idUsuario']);
            $u->setNome($row['nomeUsuario']);
            $u->setCpf($row['cpfUsuario']);
            $u->setDataNascimento($row['dataNascimento']);
            $u->setEndereco($row['endereco']);
            $u->setTelefone($row['telefone']);
            $u->setEmail($row['email']);   // ✅ usa "email"
            $u->setSenha($row['senha']);   // ✅ usa "senha"
            $u->setTipo($row['tipo']);     // ✅ usa "tipo"
            $usuarios[] = $u;
        }
        return $usuarios;
    }

    // CONSULTAR POR ID
    public function buscarPorId($idUsuario) {
        $sql = "SELECT * FROM usuario WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idUsuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $u = new Usuario();
            $u->setIdUsuario($row['idUsuario']);
            $u->setNome($row['nomeUsuario']);
            $u->setCpf($row['cpfUsuario']);
            $u->setDataNascimento($row['dataNascimento']);
            $u->setEndereco($row['endereco']);
            $u->setTelefone($row['telefone']);
            $u->setEmail($row['email']);   // ✅ correto
            $u->setSenha($row['senha']);   // ✅ correto
            $u->setTipo($row['tipo']);     // ✅ correto
            return $u;
        }
        return null;
    }

    // CONSULTAR POR EMAIL (login)
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuario WHERE email = ?"; // ✅ usa "email"
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $u = new Usuario();
            $u->setIdUsuario($row['idUsuario']);
            $u->setNome($row['nomeUsuario']);
            $u->setCpf($row['cpfUsuario']);
            $u->setDataNascimento($row['dataNascimento']);
            $u->setEndereco($row['endereco']);
            $u->setTelefone($row['telefone']);
            $u->setEmail($row['email']);   // ✅ correto
            $u->setSenha($row['senha']);   // ✅ correto
            $u->setTipo($row['tipo']);     // ✅ correto
            return $u;
        }
        return null;
    }

    // EDITAR (UPDATE)
    public function atualizar(Usuario $u) {
        $sql = "UPDATE usuario 
                   SET nomeUsuario=?, cpfUsuario=?, dataNascimento=?, endereco=?, telefone=?, email=?, senha=?, tipo=? 
                 WHERE idUsuario=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $u->getNome(),
            $u->getCpf(),
            $u->getDataNascimento(),
            $u->getEndereco(),
            $u->getTelefone(),
            $u->getEmail(),
            $u->getSenha(),
            $u->getTipo(),
            $u->getIdUsuario()
        ]);
    }

    // EXCLUIR (DELETE)
    public function excluir($idUsuario) {
        $sql = "DELETE FROM usuario WHERE idUsuario=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idUsuario]);
    }
}
