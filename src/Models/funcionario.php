<?php
// caminho: src/Models/Funcionario.php
require_once __DIR__ . '/Usuario.php';

class Funcionario extends Usuario {
    private $idFuncionario;
    private $matricula;
    private $perfilFuncionario;
    

    // ==============================
    // CONSTRUTOR
    // ==============================
    public function __construct(
        $idUsuario = null,
        $matricula = null,
        $perfilFuncionario = null,
        $idFuncionario = null,
        $nome = null,
        $cpf = null,
        $dataNascimento = null,
        $endereco = null,
        $telefone = null,
        $email = null,
        $senha = null,
        $tipo = null
    ) {
        // Chama o construtor completo da superclasse Usuario
        parent::__construct(
            $idUsuario,
            $nome,
            $cpf,
            $dataNascimento,
            $endereco,
            $telefone,
            $email,
            $senha,
            $tipo
        );

        $this->matricula = $matricula;
        $this->perfilFuncionario = $perfilFuncionario;
        $this->idFuncionario = $idFuncionario;
    }

    // ==============================
    // GETTERS E SETTERS
    // ==============================
    public function getIdFuncionario() {
        return $this->idFuncionario;
    }

    public function setIdFuncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

        public function getPerfilFuncionario() {
        return $this->perfilFuncionario;
    }

    public function setPerfilFuncionario($perfilFuncionario) {
        $this->perfilFuncionario = $perfilFuncionario;
    }
}
?>
