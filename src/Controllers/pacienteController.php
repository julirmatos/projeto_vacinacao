<?php
require_once __DIR__ . '/../Dao/pacienteDao.php';
require_once __DIR__ . '/../Models/paciente.php';

class PacienteController {
    private $dao;

    public function __construct() {
        $this->dao = new PacienteDao();
    }

    // LISTAR
    public function listar() {
        return $this->dao->listar();
    }

    // CADASTRAR
    public function cadastrar($dados) {
        $paciente = new Paciente();
        $paciente->setNome($dados['nome']);
        $paciente->setCpf($dados['cpf']);
        $paciente->setDataNascimento($dados['data_nascimento']);
        $paciente->setEndereco($dados['endereco']);
        $paciente->setTelefone($dados['telefone']);

        return $this->dao->inserir($paciente);
    }

    // CONSULTAR POR ID
    public function consultar($id) {
        return $this->dao->buscarPorId($id);
    }

    // EDITAR
    public function editar($dados) {
        $paciente = new Paciente();
        $paciente->setIdPaciente($dados['id']);
        $paciente->setNome($dados['nome']);
        $paciente->setCpf($dados['cpf']);
        $paciente->setDataNascimento($dados['data_nascimento']);
        $paciente->setEndereco($dados['endereco']);
        $paciente->setTelefone($dados['telefone']);

        return $this->dao->atualizar($paciente);
    }

    // EXCLUIR
    public function excluir($id) {
        return $this->dao->excluir($id);
    }
}
