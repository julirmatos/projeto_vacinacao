<?php
try {
    // 🔹 Conexão com o banco
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 🔹 Atualizar agendamento
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'atualizar') {
        $id = $_POST['idAgendamento'];
        $data = $_POST['dataAgendamento'];
        $idVacina = $_POST['idVacina'];

        $update = $conn->prepare("UPDATE agendamento SET dataAgendamento = ?, idVacina = ? WHERE idAgendamento = ?");
        $update->execute([$data, $idVacina, $id]);
        $mensagem = "✅ Agendamento atualizado com sucesso!";
    }

    // 🔹 Remover agendamento
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'remover') {
        $id = $_POST['idAgendamento'];
        $delete = $conn->prepare("DELETE FROM agendamento WHERE idAgendamento = ?");
        $delete->execute([$id]);
        $mensagem = "🗑️ Agendamento removido com sucesso!";
    }

    // 🔹 Consulta de agendamentos
    $sql = "
        SELECT 
            a.idAgendamento,
            a.dataAgendamento,
            u.nomeUsuario AS nomePaciente,
            v.nomeVacina,
            a.idVacina
        FROM agendamento a
        INNER JOIN usuario u ON a.idPaciente = u.idUsuario
        INNER JOIN vacina v ON a.idVacina = v.idVacina
        ORDER BY a.dataAgendamento ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 🔹 Buscar todas as vacinas (para o <select>)
    $vacinas = $conn->query("SELECT idVacina, nomeVacina FROM vacina ORDER BY nomeVacina")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Editar Agendamentos</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f0f6ff;
    padding: 20px;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
h1 {
    text-align: center;
    color: #004aad;
    margin-bottom: 25px;
}
table {
    width: 65%;
    margin: 0 auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 12px rgba(0,0,0,.08);
}
th, td {
    padding: 8px 8px;
    border-bottom: 1px solid #ddd;
    text-align: center;
    font-size: 0.9rem;
}
th {
    background: linear-gradient(90deg,#007BFF,#00C6FF);
    color: #fff;
}
tr:hover {
    background: #eaf4ff;
}
input[type="date"], select {
    padding: 5px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
button {
    background: linear-gradient(90deg,#007BFF,#00C6FF);
    border: none;
    color: white;
    padding: 6px 14px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    margin: 2px;
}
button:hover {
    background: linear-gradient(90deg,#005fcc,#009ee3);
}
button.remover {
    background: #dc3545;
}
button.remover:hover {
    background: #b02a37;
}
.mensagem {
    text-align: center;
    font-size: 16px;
    margin-top: 20px;
    color: green;
    font-weight: bold;
}
.botao-container {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}
.voltar {
    display: inline-block;
    background: linear-gradient(90deg,#007BFF,#00C6FF);
    color: white;
    text-decoration: none;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: bold;
    box-shadow: 0 6px 12px rgba(0,0,0,.1);
    transition: all 0.3s ease;
}
.voltar:hover {
    background: linear-gradient(90deg,#005fcc,#009ee3);
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,.15);
}
@media (max-width: 768px) {
    table { width: 100%; font-size: 0.85rem; }
    th, td { padding: 8px 5px; }
}
</style>
</head>
<body>

<h1>Alterar Vacinação</h1>

<?php if (!empty($mensagem)): ?>
<p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<?php if (count($agendamentos) > 0): ?>
<table>
<thead>
<tr>
    
    <th>Paciente</th>
    <th>Data</th>
    <th>Vacina</th>
    <th colspan="2">Ações</th>
</tr>
</thead>
<tbody>
<?php foreach ($agendamentos as $a): ?>
<tr>
<form method="POST" style="display:inline;">
    
    <td><?= htmlspecialchars($a['nomePaciente']) ?></td>
    <td>
        <input type="date" name="dataAgendamento" value="<?= htmlspecialchars($a['dataAgendamento']) ?>">
    </td>
    <td>
        <select name="idVacina">
            <?php foreach ($vacinas as $v): ?>
                <option value="<?= $v['idVacina'] ?>" <?= ($v['idVacina'] == $a['idVacina']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($v['nomeVacina']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>
    <td>
        <input type="hidden" name="idAgendamento" value="<?= $a['idAgendamento'] ?>">
        <input type="hidden" name="acao" value="atualizar">
        <button type="submit">💾 Alterar</button>
    </td>
</form>
<td>
    <form method="POST" onsubmit="return confirm('Tem certeza que deseja remover este agendamento?');">
        <input type="hidden" name="idAgendamento" value="<?= $a['idAgendamento'] ?>">
        <input type="hidden" name="acao" value="remover">
        <button type="submit" class="remover">🗑️ Remover</button>
    </form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
    <p class="mensagem">Nenhum agendamento encontrado.</p>
<?php endif; ?>

<div class="botao-container">
    <a href="../../views/recepcionista/menu_recepcionista.php" class="voltar">⬅ Voltar</a>
</div>

</body>
</html>
