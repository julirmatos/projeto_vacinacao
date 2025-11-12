<?php
class Usuario {
    private $idUsuario;
    private $nomeUsuario;
    private $cpfUsuario;
    private $dataNascimento;
    private $endereco;
    private $email;
    private $telefone;
    private $senha;
    private $tipo; // tipo de usuário (ex: paciente, funcionário, etc.)

    public function __construct(
        $idUsuario = null,
        $nome = null,
        $cpf = null,
        $dataNascimento = null,
        $endereco = null,
        $telefone = null,
        $email = null,
        $senha = null,
        $tipo = null
    ) {
        $this->idUsuario = $idUsuario;
        $this->nomeUsuario = $nome;
        $this->cpfUsuario = $cpf;
        $this->dataNascimento = $dataNascimento;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = $senha;
        $this->tipo = $tipo;
    }

    // ==============================
    // GETTERS E SETTERS
    // ==============================
    public function getIdUsuario() { return $this->idUsuario; }
    public function setIdUsuario($idUsuario) { $this->idUsuario = $idUsuario; }

    public function getNome() { return $this->nomeUsuario; }
    public function setNome($nome) { $this->nomeUsuario = $nome; }

    public function getCpf() { return $this->cpfUsuario; }
    public function setCpf($cpf) { $this->cpfUsuario = $cpf; }

    public function getDataNascimento() { return $this->dataNascimento; }
    public function setDataNascimento($dataNascimento) { $this->dataNascimento = $dataNascimento; }

    public function getEndereco() { return $this->endereco; }
    public function setEndereco($endereco) { $this->endereco = $endereco; }

    public function getTelefone() { return $this->telefone; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getSenha() { return $this->senha; }
    public function setSenha($senha) { $this->senha = $senha; }

    public function getTipo() { return $this->tipo; }
    public function setTipo($tipo) { $this->tipo = $tipo; }
}
?>
