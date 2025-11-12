<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../Controllers/vacinaController.php';

// Simulação de usuário logado (depois troca pela sessão real)
$usuarioLogado = (object)["tipo" => "farmaceutico"];

if (!isset($_GET['id'])) {
    die("ID da vacina não informado.");
}

$controller = new VacinaController($conn);

try {
    $controller->excluir($_GET['id'], $usuarioLogado);
    header("Location: listar_vacinas.php");
    exit;
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
