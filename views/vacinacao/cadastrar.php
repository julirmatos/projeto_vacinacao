<?php
require_once __DIR__ . '/../../Controllers/VacinacaoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new VacinacaoController();
    $controller->cadastrar($_POST);
    header("Location: listar.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Vacinação</title>
    <style>
        body { font-family: Arial; background: #F5F5F5; padding: 20px; }
        h1 { color: #1E3A8A; }
        form { background: #fff; padding: 20px; border-radius: 6px; width: 400px; margin: auto; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 8px; margin-top: 4px; }
        .btn { padding: 8px 14px; margin-top: 10px; background: #1E3A8A; color: #fff; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Cadastrar Vacinação</h1>
    <form method="POST">
        <label>Paciente ID:</label>
        <input type="number" name="idPaciente" required>

        <label>Dose ID:</label>
        <input type="number" name="idDose" required>

        <label>Vacina ID:</label>
        <input type="number" name="idVacina" required>

        <label>Enfermeiro ID:</label>
        <input type="number" name="idEnfermeiro" required>

        <label>Data Aplicação:</label>
        <input type="date" name="data_aplicacao" required>

        <button type="submit" class="btn">Salvar</button>
    </form>
</body>
</html>
