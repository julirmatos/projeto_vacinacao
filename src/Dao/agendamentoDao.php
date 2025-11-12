<?php
require_once __DIR__ . '/../../config/Conexao.php';
require_once __DIR__ . '/../Models/agendamento.php';

class AgendamentoDao {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::getConnection();
    }

    // CADASTRAR (apenas Recepcionista)
    public function inserir(Agendamento $a) {
        $sql = "INSERT INTO agendamentos (nome_vacina, data_agendamento, paciente_id, recepcionista_id, criado_em) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $a->getNomeVacina(),
            $a->getDataAgendamento(false), // salva no formato MySQL
            $a->getPacienteId(),
            $a->getRecepcionistaId(),
            
        ]);
    }

    // LISTAR (Paciente e Recepcionista)
    public function listar() {
        $sql = "SELECT * FROM agendamentos";
        $stmt = $this->conn->query($sql);
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $agendamentos = [];
        foreach ($resultado as $row) {
            $a = new Agendamento();
            $a->setIdAgendamento($row['id']);
            $a->setNomeVacina($row['nome_vacina']);
            $a->setDataAgendamento($row['data_agendamento']); // já formata no Model
            $a->setPacienteId($row['paciente_id']);
            $a->setRecepcionistaId($row['recepcionista_id']);
            $agendamentos[] = $a;
        }
        return $agendamentos;
    }

    // BUSCAR POR ID
    public function buscarPorId($id) {
        $sql = "SELECT * FROM agendamentos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $a = new Agendamento();
            $a->setIdAgendamento($row['id']);
            $a->setNomeVacina($row['nome_vacina']);
            $a->setDataAgendamento($row['data_agendamento']);
            $a->setPacienteId($row['paciente_id']);
            $a->setRecepcionistaId($row['recepcionista_id']);
            return $a;
        }
        return null;
    }

    // ATUALIZAR (apenas Recepcionista)
    public function atualizar(Agendamento $a) {
        $sql = "UPDATE agendamentos 
                   SET nomeVacina=?, dataAgendamento=?, idPaciente, idRecepcionista=? 
                 WHERE id=?";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $a->getnomeVacina(),
            $a->getDataAgendamento(false), // salva no formato MySQL
            $a->getPacienteId(),
            $a->getRecepcionistaId(),
            $a->getIdVacina()
        ]);
    }

    // EXCLUIR (apenas Recepcionista)
    public function excluir($id) {
        $sql = "DELETE FROM agendamentos WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>

