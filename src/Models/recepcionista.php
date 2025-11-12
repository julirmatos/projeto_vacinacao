<?php

class Recepcionista extends Funcionario {
    private $idRecepcionista;

    public function __construct($idFuncionario = null, $idRecepcionista = null) {
        parent::__construct($idFuncionario); // passa o idFuncionario para o construtor da classe pai
        $this->idRecepcionista = $idRecepcionista;
    }

    // ==============================
    // GETTER
    // ==============================
    public function getIdRecepcionista() { 
        return $this->idRecepcionista; 
    }

    // ==============================
    // SETTER
    // ==============================
    public function setIdRecepcionista($id) { 
        $this->idRecepcionista = $id; 
    }
}
?>

