<?php
require_once __DIR__ . '/../../src/Controllers/UsuarioController.php';
$controller = new UsuarioController();

$id = $_GET['id'] ?? null;
if ($id) {
    $controller->excluir($id);
}
header("Location: listar.php");
exit;
