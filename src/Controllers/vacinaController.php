<?php
require_once __DIR__ . '../Dao/vacinaDao.php';
require_once __DIR__ . '../../config/Conexao.php';

$conn = (new Conexao())->getConnection();

class VacinaController {
    private $dao;

    // ✅ Aceita a conexão como parâmetro
    public function __construct($conn) {
        $this->dao = new VacinaDAO($conn);
    }

    // 🔹 LISTAR (acessível a enfermeiro e farmacêutico)
    public function listar() {
        return $this->dao->listar(); // 🔄 corrigido: trocar "consultarTodos" por "listar"
    }

    // 🔹 CADASTRAR (apenas farmacêutico)
    public function cadastrar($dados, $usuario) {
        if ($usuario->getTipo() !== 'farmaceutico') {
            throw new Exception("Apenas farmacêuticos podem cadastrar vacinas.");
        }

        $vacina = new Vacina();
        $vacina->setNomeVacina($dados['nomeVacina']);
        $vacina->setVencimentoVacina($dados['vencimentoVacina']);
        $vacina->setFabricanteVacina($dados['fabricanteVacina']);
        $vacina->setDoseVacina($dados['doseVacina']);
        $vacina->setIntervaloVacina($dados['intervaloVacina']);
        $vacina->setLoteVacina($dados['loteVacina']);
        $vacina->setDisponibilidadeVacina($dados['disponibilidadeVacina']);

        return $this->dao->cadastrar($vacina);
    }

    // 🔹 EDITAR (apenas farmacêutico)
    public function editar($dados, $usuario) {
        if ($usuario->getTipo() !== 'farmaceutico') {
            throw new Exception("Apenas farmacêuticos podem editar vacinas.");
        }

        $vacina = $this->dao->consultarPorId($dados['idVacina']);
        if (!$vacina) {
            throw new Exception("Vacina não encontrada.");
        }

        $vacina->setNomeVacina($dados['nomeVacina']);
        $vacina->setVencimentoVacina($dados['vencimentoVacina']);
        $vacina->setFabricanteVacina($dados['fabricanteVacina']);
        $vacina->setDoseVacina($dados['doseVacina']);
        $vacina->setIntervaloVacina($dados['intervaloVacina']);
        $vacina->setLoteVacina($dados['loteVacina']);
        $vacina->setDisponibilidadeVacina($dados['disponibilidadeVacina']);

        return $this->dao->atualizar($vacina);
    }

    // 🔹 EXCLUIR (apenas farmacêutico)
    public function excluir($idVacina, $usuario) {
        if ($usuario->getTipo() !== 'farmaceutico') {
            throw new Exception("Apenas farmacêuticos podem excluir vacinas.");
        }
        return $this->dao->excluir($idVacina);
    }

    // 🔹 CONSULTAR POR ID (enfermeiro e farmacêutico)
    public function consultar($idVacina) {
        return $this->dao->consultarPorId($idVacina);
    }
}
?>

