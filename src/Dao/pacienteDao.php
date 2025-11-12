<?php
require_once __DIR__ . '/../../config/Conexao.php';
require_once __DIR__ . '/../Models/paciente.php';

class PacienteDao {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConnection();
    }

    // CREATE
    public function inserir(Paciente $p) {
        $sql = "INSERT INTO pacientes (nome, cpf, data_nascimento, endereco, telefone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $p->getNome(),
            $p->getCpf(),
            $p->getDataNascimento(),
            $p->getEndereco(),
            $p->getTelefone()
        ]);
    }

    // READ ALL
    public function listar() {
        $sql = "SELECT * FROM pacientes";
        $stmt = $this->conn->query($sql);
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pacientes = [];
        foreach ($resultado as $row) {
            $p = new Paciente();
            $p->setIdPaciente($row['id']);
            $p->setNome($row['nome']);
            $p->setCpf($row['cpf']);
            $p->setDataNascimento($row['data_nascimento']);
            $p->setEndereco($row['endereco']);
            $p->setTelefone($row['telefone']);
            $pacientes[] = $p;
        }
        return $pacientes;
    }

    // READ BY ID
    public function buscarPorId($id) {
        $sql = "SELECT * FROM pacientes WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $p = new Paciente();
            $p->setIdPaciente($row['id']);
            $p->setNome($row['nome']);
            $p->setCpf($row['cpf']);
            $p->setDataNascimento($row['data_nascimento']);
            $p->setEndereco($row['endereco']);
            $p->setTelefone($row['telefone']);
            return $p;
        }
        return null;
    }

    // UPDATE
    public function atualizar(Paciente $p) {
        $sql = "UPDATE pacientes SET nome=?, cpf=?, data_nascimento=?, endereco=?, telefone=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $p->getNome(),
            $p->getCpf(),
            $p->getDataNascimento(),
            $p->getEndereco(),
            $p->getTelefone(),
            $p->getIdPaciente()
        ]);
    }

    // DELETE
    public function excluir($id) {
        $sql = "DELETE FROM pacientes WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
