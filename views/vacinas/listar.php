<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../Controllers/vacinaController.php';

// Simulação de usuário logado (depois troca pela sessão real)
$usuarioLogado = (object)["tipo" => "farmaceutico"]; // ou "enfermeiro"

$controller = new VacinaController($conn);
$vacinas = $controller->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Vacinas</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #F5F5F5; margin: 0; padding: 20px; }
        h1 { color: #1E3A8A; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0px 2px 6px rgba(0,0,0,0.1); }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background: #1E3A8A; color: #fff; }
        tr:nth-child(even) { background: #E5E7EB; }
        a { text-decoration: none; font-weight: bold; }
        .btn { padding: 6px 12px; border-radius: 4px; margin: 2px; }
        .btn-editar { background: #1E3A8A; color: #fff; }
        .btn-excluir { background: #DC2626; color: #fff; }
        .btn-novo { background: #10B981; color: #fff; }
    </style>
</head>
<body>
    <h1>Vacinas</h1>
    <?php if (in_array($usuarioLogado->tipo, ['farmaceutico', 'enfermeiro'])): ?>
        <a href="cadastrar_vacina.php" class="btn btn-novo">+ Nova Vacina</a>
        <br><br>
    <?php endif; ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Fabricante</th>
            <th>Doses</th>
            <th>Intervalo (dias)</th>
            <th>Lote</th>
            <th>Validade</th>
            <?php if (in_array($usuarioLogado->tipo, ['farmaceutico', 'enfermeiro'])): ?>

                <th>Ações</th>
            <?php endif; ?>
        </tr>
        <?php if (!empty($vacinas)): ?>
            <?php foreach ($vacinas as $v): ?>
                <tr>
                    <td><?= htmlspecialchars($v->getIdVacina()) ?></td>
                    <td><?= htmlspecialchars($v->getNomeVacina()) ?></td>
                    <td><?= htmlspecialchars($v->getFabricanteVacina()) ?></td>
                    <td><?= htmlspecialchars($v->getDisponibilidadeVacina()) ?></td>
                    <td><?= htmlspecialchars($v->getIntervaloVacina()) ?></td>
                    <td><?= htmlspecialchars($v->getLoteVacina()) ?></td>
                    <td><?= htmlspecialchars($v->getVencimentoVacina()) ?></td>
                    <?php if ($usuarioLogado->tipo === "farmaceutico"): ?>
                    <td>
                        <a href="editar_vacina.php?id=<?= $v->getIdVacina() ?>" class="btn btn-editar">Editar</a>
                        <a href="excluir_vacina.php?id=<?= $v->getIdVacina() ?>" class="btn btn-excluir" onclick="return confirm('Deseja excluir esta vacina?')">Excluir</a>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8">Nenhuma vacina cadastrada.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
