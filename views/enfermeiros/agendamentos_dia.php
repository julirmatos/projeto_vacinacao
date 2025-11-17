<?php 
session_start();

// Verifica se o enfermeiro está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../views/auth/login.php");
    exit;
}

$nome = $_SESSION['nomeUsuario'] ?? 'Enfermeiro(a)';

// === Conexão com o banco ===
try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8",
        "root",
        ""
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<p style='color:red;'>Erro ao conectar ao banco: " . htmlspecialchars($e->getMessage()) . "</p>");
}

// --- Data selecionada ---
$dataSelecionada = $_GET['data'] ?? date('Y-m-d');

// === SELECT para AGENDAMENTOS DO DIA ===
$sql = "SELECT 
            a.dataAgendamento,
            up.nomeUsuario AS nomePaciente,
            v.nomeVacina,
            ue.nomeUsuario AS nomeRecepcionista
        FROM agendamento a
        INNER JOIN paciente p         ON a.idPaciente = p.idPaciente
        INNER JOIN usuario up         ON p.idUsuario = up.idUsuario
        INNER JOIN vacina v           ON a.idVacina = v.idVacina
        INNER JOIN recepcionista r    ON a.idRecepcionista = r.idRecepcionista
        INNER JOIN usuario ue         ON r.idFuncionario = ue.idUsuario
        WHERE DATE(a.dataAgendamento) = :data
        ORDER BY a.dataAgendamento ASC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':data', $dataSelecionada);
$stmt->execute();
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// === SELECT para AGENDAMENTOS FUTUROS ===
$sqlFuturos = "SELECT 
            a.dataAgendamento,
            up.nomeUsuario AS nomePaciente,
            v.nomeVacina,
            ue.nomeUsuario AS nomeRecepcionista
        FROM agendamento a
        INNER JOIN paciente p         ON a.idPaciente = p.idPaciente
        INNER JOIN usuario up         ON p.idUsuario = up.idUsuario
        INNER JOIN vacina v           ON a.idVacina = v.idVacina
        INNER JOIN recepcionista r    ON a.idRecepcionista = r.idRecepcionista
        INNER JOIN usuario ue         ON r.idFuncionario = ue.idUsuario
        WHERE DATE(a.dataAgendamento) > CURDATE()
        ORDER BY a.dataAgendamento ASC";

$stmtF = $conn->prepare($sqlFuturos);
$stmtF->execute();
$agendamentosFuturos = $stmtF->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agendamentos do Dia</title>

<style>
body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: linear-gradient(135deg, #8EC5FC, #E0C3FC);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

header { text-align: center; margin-bottom: 30px; }
header h1 { color: #2C3E50; margin-bottom: 10px; }

form { margin-bottom: 30px; }

input[type="date"] {
    padding: 10px;
    font-size: 16px;
    border-radius: 8px;
    border: 1px solid #888;
}

button {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    color: #fff;
    cursor: pointer;
    font-weight: bold;
}
button:hover {
    background: linear-gradient(90deg, #0056b3, #0096FF);
}

table {
    width: 90%;
    max-width: 900px;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 20px;
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}

th, td { padding: 15px; text-align: left; }

th {
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    color: #fff;
}

tr:nth-child(even) { background-color: #f2f2f2; }
tr:hover { background-color: #eaf3ff; }

.menu-buttons { margin-top: 40px; }
.menu-buttons a {
    display: inline-block;
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    color: #fff;
    text-decoration: none;
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: 600;
    box-shadow: 0 6px 12px rgba(0,0,0,0.2);
}
.menu-buttons a:hover {
    background: linear-gradient(90deg, #0056b3, #0096FF);
}
</style>
</head>
<body>

<header>
    <h1>Agendamentos do Dia</h1>
    <p>Enfermeiro(a): <?= htmlspecialchars($nome) ?></p>
</header>

<form method="GET">
    <label for="data"><strong>Selecione a data:</strong></label>
    <input type="date" id="data" name="data" value="<?= htmlspecialchars($dataSelecionada) ?>" required>
    <button type="submit">Buscar</button>
</form>

<!-- TABELA DOS AGENDAMENTOS DO DIA -->
<table>
    <thead>
        <tr>
            <th>Data</th>
            <th>Paciente</th>
            <th>Vacina</th>
            <th>Recepcionista</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($agendamentos): ?>
            <?php foreach ($agendamentos as $v): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($v['dataAgendamento'])) ?></td>
                    <td><?= htmlspecialchars($v['nomePaciente']) ?></td>
                    <td><?= htmlspecialchars($v['nomeVacina']) ?></td>
                    <td><?= htmlspecialchars($v['nomeRecepcionista']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align:center;">Nenhum agendamento para esta data.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- NOVA TABELA: AGENDAMENTOS FUTUROS -->
<h2 style="margin-top:40px; color:#2C3E50;">Agendamentos Futuros</h2>

<table>
    <thead>
        <tr>
            <th>Data</th>
            <th>Paciente</th>
            <th>Vacina</th>
            <th>Recepcionista</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($agendamentosFuturos): ?>
            <?php foreach ($agendamentosFuturos as $v): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($v['dataAgendamento'])) ?></td>
                    <td><?= htmlspecialchars($v['nomePaciente']) ?></td>
                    <td><?= htmlspecialchars($v['nomeVacina']) ?></td>
                    <td><?= htmlspecialchars($v['nomeRecepcionista']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align:center;">Nenhum agendamento futuro encontrado.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="menu-buttons">
    <a href="../../views/enfermeiros/menu_enfermeiro.php">⬅️ Voltar</a>
</div>

</body>
</html>
