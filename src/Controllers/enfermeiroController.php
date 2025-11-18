<?php
require_once __DIR__ . '/../DAO/EnfermeiroDAO.php';
require_once __DIR__ . '/../Models/Usuario.php';

class EnfermeiroController
{
    private $EnfermeiroDao;

    public function __construct()
    {
        $this->EnfermeiroDao = new EnfermeiroDAO();
    }

    /**
     * 🔹 Lista todos os enfermeiros
     */
    public function listar()
    {
        return $this->EnfermeiroDao->listar();
    }

    /**
     * 🔹 Consulta um enfermeiro pelo ID
     */
    public function consultar($id)
    {
        if (!is_numeric($id)) {
            throw new Exception("ID inválido para consulta de enfermeiro.");
        }
        return $this->EnfermeiroDao->consultar($id);
    }

    /**
     * 🔹 Cadastra um novo enfermeiro
     */
    public function cadastrar($dados)
    {
        // Validação básica dos campos obrigatórios
        if (empty($dados['nome']) || empty($dados['cpf']) || empty($dados['email']) || empty($dados['senha'])) {
            throw new Exception("Campos obrigatórios não preenchidos.");
        }

        $enfermeiro = new Usuario();
        $enfermeiro->setNome(trim($dados['nome']));
        $enfermeiro->setCpf(trim($dados['cpf']));
        $enfermeiro->setEmail(trim($dados['email']));
        $enfermeiro->setTelefone($dados['telefone'] ?? '');
        $enfermeiro->setEndereco($dados['endereco'] ?? '');
        $enfermeiro->setDataNascimento($dados['dataNascimento'] ?? null);
        $enfermeiro->setSenha($dados['senha']);
        $enfermeiro->setTipo('enfermeiro');

        return $this->EnfermeiroDao->cadastrar($enfermeiro);
    }

    /**
     * 🔹 Atualiza dados de um enfermeiro existente
     */
    public function alterar($id, $dados)
    {
        if (!is_numeric($id)) {
            throw new Exception("ID inválido para alteração.");
        }

        $enfermeiroExistente = $this->EnfermeiroDao->consultar($id);
        if (!$enfermeiroExistente) {
            throw new Exception("Enfermeiro não encontrado.");
        }

        $enfermeiroExistente->setNome(trim($dados['nome']));
        $enfermeiroExistente->setCpf(trim($dados['cpf']));
        $enfermeiroExistente->setEmail(trim($dados['email']));
        $enfermeiroExistente->setTelefone($dados['telefone'] ?? '');
        $enfermeiroExistente->setEndereco($dados['endereco'] ?? '');
        $enfermeiroExistente->setDataNascimento($dados['dataNascimento'] ?? null);

        return $this->EnfermeiroDao->alterar($enfermeiroExistente);
    }

    /**
     * 🔹 Exclui um enfermeiro pelo ID
     */
    public function excluir($id)
    {
        if (!is_numeric($id)) {
            throw new Exception("ID inválido para exclusão.");
        }

        return $this->EnfermeiroDao->excluir($id);
    }

    /**
     * 🔹 Processa requisições HTTP (POST/GET)
     * Pode ser usado diretamente nas views, se desejar.
     */
    public function processarRequisicao()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['acao'])) {
                switch ($_POST['acao']) {
                    case 'cadastrar':
                        $this->cadastrar($_POST);
                        header('Location: listar_enfermeiro.php');
                        exit;
                    case 'alterar':
                        $this->alterar($_POST['idUsuario'], $_POST);
                        header('Location: listar_enfermeiro.php');
                        exit;
                }
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['acao'], $_GET['id'])) {
            switch ($_GET['acao']) {
                case 'excluir':
                    $this->excluir($_GET['id']);
                    header('Location: listar_enfermeiro.php');
                    exit;
            }
        }
    }
}
