<?php
// caminho: src/Models/Farmaceutico.php
require_once __DIR__ . '/Funcionario.php';

class Farmaceutico extends Funcionario {
    private $idFarmaceutico;

    public function __construct(
        $idUsuario = null,
        $matricula = null,
        $cargoFuncionario = null,
        $perfilFuncionario = "FARMACEUTICO",
        $idFuncionario = null,
        $idFarmaceutico = null
    ) {
        // Chama o construtor da superclasse Funcionario (mesma ordem de parâmetros)
        parent::__construct($idUsuario, $matricula, $cargoFuncionario, $perfilFuncionario, $idFuncionario);
        $this->idFarmaceutico = $idFarmaceutico;
    }

    public function getIdFarmaceutico() {
        return $this->idFarmaceutico;
    }

    public function setIdFarmaceutico($id) {
        $this->idFarmaceutico = $id;
    }

    // Se quiser, adicione getters/setters extras para campos herdados (são providos pela superclasse)
}
?>
