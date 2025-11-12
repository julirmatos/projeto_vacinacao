<?php
class Vacinacao extends Vacina {
    private $idVacinacao;
    private $dataAplicacao;
    private $idPaciente;
    private $idVacina;
    private $idEnfermeiro;
    

    private $disponibilidadeVacina;

    // 🔹 ID VACINAÇÃO
    public function getIdVacinacao() {
        return $this->idVacinacao;
    }

    public function setIdVacinacao($idVacinacao) {
        $this->idVacinacao = $idVacinacao;
    }

    // 🔹 ID PACIENTE
    public function getIdPaciente() {
        return $this->idPaciente;
    }

    public function setIdPaciente($idPaciente) {
        $this->idPaciente = $idPaciente;
    }

    // 🔹 ID VACINA
    public function getIdVacina() {
        return $this->idVacina;
    }

    public function setIdVacina($idVacina) {
        $this->idVacina = $idVacina;
    }

    // 🔹 ID ENFERMEIRO
    public function getIdEnfermeiro() {
        return $this->idEnfermeiro;
    }

    public function setIdEnfermeiro($idEnfermeiro) {
        $this->idEnfermeiro = $idEnfermeiro;
    }

    // 🔹 DATA DE APLICAÇÃO
    public function getDataAplicacao() {
        return $this->dataAplicacao;
    }

    public function setDataAplicacao($dataAplicacao) {
        $this->dataAplicacao = $dataAplicacao;
    }
}
?>