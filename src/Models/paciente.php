<?php
require_once '../Models/usuario.php';

class Paciente extends Usuario {
    private $idPaciente;
    private $numCartaoSus;

    public function __construct(
        $idUsuario = null, 
        $nome = null, 
        $cpf = null, 
        $dataNascimento = null, 
        $endereco = null, 
        $telefone = null, 
        $email = null, 
        $senha = null,
        $idPaciente = null, 
        $numCartaoSus = null
    ) {
        parent::__construct($idUsuario, $nome, $cpf, $dataNascimento, $endereco, $telefone, $email, $senha);
        $this->idPaciente = $idPaciente;
        $this->numCartaoSus = $numCartaoSus;
    }

    // ==============================
    // GETTERS
    // ==============================
    public function getIdPaciente() {
        return $this->idPaciente;
    }

    public function getCartaoSus() {
        return $this->numCartaoSus;
    }

    // ==============================
    // SETTERS
    // ==============================
    public function setIdPaciente($id) {
        $this->idPaciente = $id;
    }

    public function setCartaoSus($numCartaoSus) {
        $this->numCartaoSus = $numCartaoSus;
    }
}
?>

