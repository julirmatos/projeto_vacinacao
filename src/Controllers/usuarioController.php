<?php
require_once __DIR__ . '/../Dao/usuarioDao.php';
require_once __DIR__ . '/../Models/usuario.php';

class UsuarioController {
    private $usuarioDao;

    public function __construct() {
        $this->usuarioDao = new UsuarioDao();
    }

    // ✅ Listar todos os usuários
    public function listar() {
        return $this->usuarioDao->listar();
    }

    // ✅ Buscar usuário por ID
    public function buscarPorId($idUsuario) {
        return $this->usuarioDao->buscarPorId($idUsuario);
    }

    // ✅ Inserir novo usuário
    public function inserir($dados) {
        $usuario = new Usuario();
        $usuario->setNome($dados['nomeUsuario']);
        $usuario->setCpf($dados['cpfUsuario']);
        $usuario->setDataNascimento($dados['dataNascimento']);
        $usuario->setEndereco($dados['endereco']);
        $usuario->setTelefone($dados['telefone']);
        $usuario->setEmail($dados['email']);
        $usuario->setSenha(password_hash($dados['senha'], PASSWORD_DEFAULT)); // Criptografa a senha
        $usuario->setTipo($dados['tipo']);

        return $this->usuarioDao->inserir($usuario);
    }

    // ✅ Atualizar usuário existente
    public function atualizar($dados) {
        $usuario = new Usuario();
        $usuario->setIdUsuario($dados['idUsuario']);
        $usuario->setNome($dados['nomeUsuario']);
        $usuario->setCpf($dados['cpfUsuario']);
        $usuario->setDataNascimento($dados['dataNascimento']);
        $usuario->setEndereco($dados['endereco']);
        $usuario->setTelefone($dados['telefone']);
        $usuario->setEmail($dados['email']);

        // Atualiza senha apenas se vier no formulário
        if (!empty($dados['senha'])) {
            $usuario->setSenha(password_hash($dados['senha'], PASSWORD_DEFAULT));
        } else {
            // Mantém senha antiga
            $usuarioExistente = $this->usuarioDao->buscarPorId($dados['idUsuario']);
            $usuario->setSenha($usuarioExistente->getSenha());
        }

        $usuario->setTipo($dados['tipo']);
        return $this->usuarioDao->atualizar($usuario);
    }

    // ✅ Excluir usuário
    public function excluir($idUsuario) {
        return $this->usuarioDao->excluir($idUsuario);
    }

    // ✅ Login (valida e retorna objeto)
    public function autenticar($email, $senha) {
        $usuario = $this->usuarioDao->buscarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario->getSenha())) {
            return $usuario;
        }
        return null;
    }
}
