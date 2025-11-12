<?php
require_once __DIR__ . '/../../Controllers/vacinacaoController.php';
$controller = new VacinacaoController();

if (isset($_GET['id'])) {
    $controller->excluir($_GET['id']);
}
header("Location: listar.php");
exit;
