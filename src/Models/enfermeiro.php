<?php
// caminho: src/Models/Enfermeiro.php
require_once __DIR__ . '/Funcionario.php';

class Enfermeiro extends Funcionario {
    private $idEnfermeiro;

    public function __construct(
        $idUsuario = null,
        $matricula = null,
        $cargoFuncionario = null,
        $perfilFuncionario = "ENFERMEIRO",
        $idFuncionario = null,
        $idEnfermeiro = null
    ) {
        // Chama o construtor da superclasse Funcionario (mesma ordem de parâmetros)
        parent::__construct($idUsuario, $matricula, $cargoFuncionario, $perfilFuncionario, $idFuncionario);
        $this->idEnfermeiro = $idEnfermeiro;
    }

    public function getIdEnfermeiro() {
        return $this->idEnfermeiro;
    }

    public function setIdEnfermeiro($id) {
        $this->idEnfermeiro = $id;
    }

    // Getters e setters adicionais podem ser herdados da superclasse
}
?>
