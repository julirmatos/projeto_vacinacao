<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../Controllers/vacinaController.php';

// Simulação de usuário logado (depois troca pela sessão real)
$usuarioLogado = (object)["tipo" => "farmaceutico"];

$controller = new VacinaController($conn);

if (!isset($_GET['id'])) {
    die("ID da vacina não informado.");
}

$vacina = $controller->consultar($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $_POST['id'] = $_GET['id'];
        $controller->editar($_POST, $usuarioLogado);
        header("Location: listar_vacinas.php");
        exit;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Vacina</title>
</head>
<body>
    <h1>Editar Vacina</h1>
    <?php if (!empty($erro)) echo "<p style='color:red'>$erro</p>"; ?>
    <form method="POST">
        <label>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($vacina->getNomeVacina()) ?>" required></label><br><br>
        <label>Fabricante: <input type="text" name="fabricante" value="<?= htmlspecialchars($vacina->getFabricanteVacina()) ?>" required></label><br><br>
        <label>Doses: <input type="number" name="doses" value="<?= htmlspecialchars($vacina->getDosesVacina()) ?>" required></label><br><br>
        <label>Intervalo (dias): <input type="number" name="intervalo_dias" value="<?= htmlspecialchars($vacina->getIntervaloDiasVacina()) ?>"></label><br><br>
        <label>Lote: <input type="text" name="lote" value="<?= htmlspecialchars($vacina->getLoteVacina()) ?>" required></label><br><br>
        <label>Validade: <input type="date" name="validade" value="<?= htmlspecialchars($vacina->getValidadeVacina()) ?>" required></label><br><br>
        <button type="submit">Salvar Alterações</button>
    </form>
    <br>
    <a href="listar_vacinas.php">Voltar</a>
</body>
</html>
