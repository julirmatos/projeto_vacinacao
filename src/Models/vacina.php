<?php
class Vacina {
    private $idVacina;
    private $nomeVacina;
    private $vencimentoVacina;
    private $fabricanteVacina;
    private $doseVacina;
    private $intervaloVacina;
    private $loteVacina;
    private $disponibilidadeVacina;

    // --- GETTERS ---
    public function getIdVacina() {
        return $this->idVacina;
    }

    public function getNomeVacina() {
        return $this->nomeVacina;
    }

    public function getVencimentoVacina() {
        return $this->vencimentoVacina;
    }

    public function getFabricanteVacina() {
        return $this->fabricanteVacina;
    }

    public function getDoseVacina() {
        return $this->doseVacina;
    }

    public function getIntervaloVacina() {
        return $this->intervaloVacina;
    }

    public function getLoteVacina() {
        return $this->loteVacina;
    }

    public function getDisponibilidadeVacina() {
        return $this->disponibilidadeVacina;
    }

    // --- SETTERS ---
    public function setIdVacina($idVacina) {
        $this->idVacina = $idVacina;
    }

    public function setNomeVacina($nomeVacina) {
        $this->nomeVacina = $nomeVacina;
    }

    public function setVencimentoVacina($vencimentoVacina) {
        $this->vencimentoVacina = $vencimentoVacina;
    }

    public function setFabricanteVacina($fabricanteVacina) {
        $this->fabricanteVacina = $fabricanteVacina;
    }

    public function setDoseVacina($doseVacina) {
        $this->doseVacina = $doseVacina;
    }

    public function setIntervaloVacina($intervaloVacina) {
        $this->intervaloVacina = $intervaloVacina;
    }

    public function setLoteVacina($loteVacina) {
        $this->loteVacina = $loteVacina;
    }

    public function setDisponibilidadeVacina($disponibilidadeVacina) {
        $this->disponibilidadeVacina = $disponibilidadeVacina;
    }
}
?>
