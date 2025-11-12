<?php
require_once __DIR__ . '/../models/vacina.php';

class VacinaDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // 🔹 LISTAR TODAS AS VACINAS
    public function listar() {
        $sql = "SELECT * FROM vacina";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $vacinas = [];

        foreach ($resultados as $row) {
            $v = new Vacina();
            $v->setIdVacina($row['idVacina']);
            $v->setNomeVacina($row['nomeVacina']);
            $v->setVencimentoVacina($row['vencimentoVacina']);
            $v->setFabricanteVacina($row['fabricanteVacina']);
            $v->setDoseVacina($row['doseVacina']);
            $v->setIntervaloVacina($row['intervaloVacina']);
            $v->setLoteVacina($row['loteVacina']);
            $v->setDisponibilidadeVacina($row['disponibilidadeVacina']);
            $vacinas[] = $v;
        }

        return $vacinas;
    }

    // 🔹 CADASTRAR NOVA VACINA
    public function cadastrar(Vacina $vacina) {
        $sql = "INSERT INTO vacina 
                (nomeVacina, vencimentoVacina, fabricanteVacina, doseVacina, intervaloVacina, loteVacina, disponibilidadeVacina)
                VALUES (:nome, :vencimento, :fabricante, :dose, :intervalo, :lote, :disponibilidade)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $vacina->getNomeVacina());
        $stmt->bindValue(':vencimento', $vacina->getVencimentoVacina());
        $stmt->bindValue(':fabricante', $vacina->getFabricanteVacina());
        $stmt->bindValue(':dose', $vacina->getDoseVacina());
        $stmt->bindValue(':intervalo', $vacina->getIntervaloVacina());
        $stmt->bindValue(':lote', $vacina->getLoteVacina());
        $stmt->bindValue(':disponibilidade', $vacina->getDisponibilidadeVacina());

        return $stmt->execute();
    }

    // 🔹 CONSULTAR VACINA POR ID
    public function consultarPorId($idVacina) {
        $sql = "SELECT * FROM vacina WHERE idVacina = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $idVacina, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $v = new Vacina();
        $v->setIdVacina($row['idVacina']);
        $v->setNomeVacina($row['nomeVacina']);
        $v->setVencimentoVacina($row['vencimentoVacina']);
        $v->setFabricanteVacina($row['fabricanteVacina']);
        $v->setDoseVacina($row['doseVacina']);
        $v->setIntervaloVacina($row['intervaloVacina']);
        $v->setLoteVacina($row['loteVacina']);
        $v->setDisponibilidadeVacina($row['disponibilidadeVacina']);

        return $v;
    }

    // 🔹 ATUALIZAR VACINA EXISTENTE
    public function atualizar(Vacina $vacina) {
        $sql = "UPDATE vacina SET 
                    nomeVacina = :nome,
                    vencimentoVacina = :vencimento,
                    fabricanteVacina = :fabricante,
                    doseVacina = :dose,
                    intervaloVacina = :intervalo,
                    loteVacina = :lote,
                    disponibilidadeVacina = :disponibilidade
                WHERE idVacina = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $vacina->getIdVacina(), PDO::PARAM_INT);
        $stmt->bindValue(':nome', $vacina->getNomeVacina());
        $stmt->bindValue(':vencimento', $vacina->getVencimentoVacina());
        $stmt->bindValue(':fabricante', $vacina->getFabricanteVacina());
        $stmt->bindValue(':dose', $vacina->getDoseVacina());
        $stmt->bindValue(':intervalo', $vacina->getIntervaloVacina());
        $stmt->bindValue(':lote', $vacina->getLoteVacina());
        $stmt->bindValue(':disponibilidade', $vacina->getDisponibilidadeVacina());

        return $stmt->execute();
    }

    // 🔹 EXCLUIR VACINA
    public function excluir($idVacina) {
        $sql = "DELETE FROM vacina WHERE idVacina = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $idVacina, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
