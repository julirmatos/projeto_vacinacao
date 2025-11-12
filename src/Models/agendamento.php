<?php
class Agendamento {
    private $idAgendamento;
    private $dataAgendamento;
    private $idPaciente;
    private $idVacina;
    private $idRecepcionista;
    

    // ==============================
    // GETTERS
    // ==============================
    public function getIdAgendamento() {
        return $this->idAgendamento;
    }

    public function getDataAgendamento($formatado = true) {
        if ($this->dataAgendamento && $formatado) {
            return date('d/m/Y H:i', strtotime($this->dataAgendamento));
        }
        return $this->dataAgendamento;
    }

    public function getPacienteId() {
        return $this->idPaciente;
    }

    public function getVacinaId() {
        return $this->idVacina;
    }

    public function getRecepcionistaId() {
        return $this->idRecepcionista;
    }

    // ==============================
    // SETTERS
    // ==============================
    public function setIdAgendamento($idAgendamento) {
        $this->idAgendamento = $idAgendamento;
    }

    public function setDataAgendamento($dataAgendamento) {
        // Se vier no formato brasileiro (dd/mm/yyyy), converte para Y-m-d H:i:s
        if ($dataAgendamento && preg_match('/\d{2}\/\d{2}\/\d{4}/', $dataAgendamento)) {
            $this->dataAgendamento = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $dataAgendamento)));
        } else {
            $this->dataAgendamento = $dataAgendamento;
        }
    }

    public function setPacienteId($idPaciente) {
        $this->idPaciente = $idPaciente;
    }

    public function setVacinaId($idVacina) {
        $this->idVacina = $idVacina;
    }

    public function setRecepcionistaId($idRecepcionista) {
        $this->idRecepcionista = $idRecepcionista;
    }
}
?>
