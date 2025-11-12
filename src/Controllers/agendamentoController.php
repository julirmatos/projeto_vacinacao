<?php
require_once __DIR__ . '/../Dao/agendamentoDao.php';
require_once __DIR__ . '/../Models/agendamento.php';

class AgendamentoController {
    private $dao;
    private $agendamentos = [];

    public function __construct() {
        $this->dao = new AgendamentoDao();
    }

    // LISTAR (Paciente e Recepcionista)
    public function listar() {
        if (empty($this->agendamentos)) {
            $this->agendamentos = $this->dao->listar();

            // Garante que Paciente e Recepcionista sejam objetos
            foreach ($this->agendamentos as $agendamento) {
                if (is_numeric($agendamento->getPaciente())) {
                    $pacienteController = new PacienteController();
                    $paciente = $pacienteController->consultar($agendamento->getPaciente());
                    $agendamento->setPaciente($paciente);
                }

                if (is_numeric($agendamento->getRecepcionista())) {
                    $usuarioController = new UsuarioController();
                    $recepcionista = $usuarioController->consultar($agendamento->getRecepcionista());
                    $agendamento->setRecepcionista($recepcionista);
                }
            }
        }

        return $this->agendamentos;
    }

    // CONSULTAR POR ID
    public function consultar($id) {
        return $this->dao->buscarPorId($id);
    }

    // CADASTRAR (apenas Recepcionista)
    public function cadastrar($dados, $perfil) {
        if ($perfil !== 'recepcionista') {
            throw new Exception("Permissão negada: apenas recepcionistas podem cadastrar agendamentos.");
        }

        $a = new Agendamento();
        $a->setVacinaId($dados['nomeVacina']);
        $a->setDataAgendamento($dados['dataAgendamento']);
        $a->setPacienteId($dados['paciente_id']);
        $a->setRecepcionistaId($dados['recepcionista_id']);

        return $this->dao->inserir($a);
    }

    // EDITAR (apenas Recepcionista)
    public function editar($dados, $perfil) {
        if ($perfil !== 'recepcionista') {
            throw new Exception("Permissão negada: apenas recepcionistas podem editar agendamentos.");
        }

        $a = new Agendamento();
        $a->setIdAgendamento($dados['id']);
        $a->setVacinaId($dados['nomeVacina']);
        $a->setDataAgendamento($dados['dataAgendamento']);
        $a->setPacienteId($dados['paciente_id']);
        $a->setRecepcionistaId($dados['recepcionista_id']);

        return $this->dao->atualizar($a);
    }

    // EXCLUIR (apenas Recepcionista)
    public function excluir($id, $perfil) {
        if ($perfil !== 'recepcionista') {
            throw new Exception("Permissão negada: apenas recepcionistas podem excluir agendamentos.");
        }

        return $this->dao->excluir($id);
    }
}
?>
