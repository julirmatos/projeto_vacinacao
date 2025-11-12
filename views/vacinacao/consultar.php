<?php
session_start();

// Verifica se o enfermeiro está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../views/auth/login.php");
    exit;
}

// Dados do usuário logado
$nome = $_SESSION['nomeUsuario'] ?? 'Enfermeiro(a)';

// === Conexão direta com o banco ===
try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8",
        "root", // seu usuário
        ""      // sua senha
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<p style='color:red;'>Erro ao conectar ao banco: " . htmlspecialchars($e->getMessage()) . "</p>");
}

// === SELECT direto ===
$sql = "SELECT   
            v.dataAplicacao,
            up.nomeUsuario AS nomePaciente,
            va.nomeVacina,
            ue.nomeUsuario AS nomeEnfermeiro
        FROM vacinacao v
        INNER JOIN paciente p   ON v.idPaciente = p.idPaciente
        INNER JOIN usuario up   ON p.idUsuario = up.idUsuario
        INNER JOIN vacina va    ON v.idVacina = va.idVacina
        INNER JOIN enfermeiro e ON v.idEnfermeiro = e.idEnfermeiro
        INNER JOIN usuario ue   ON e.idFuncionario = ue.idUsuario
        ORDER BY v.dataAplicacao DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$vacinacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Consultar Vacinação</title>
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

header {
    text-align: center;
    margin-bottom: 30px;
}

header h1 {
    color: #2C3E50;
}

table {
    width: 90%;
    max-width: 900px;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}

th, td {
    padding: 15px;
    text-align: left;
}

th {
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    color: #fff;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #eaf3ff;
}

.menu-buttons {
    margin-top: 40px;
}

.menu-buttons a {
    display: inline-block;
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    color: #fff;
    text-decoration: none;
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: 600;
    transition: background 0.3s ease;
    box-shadow: 0 6px 12px rgba(0,0,0,0.2);
}

.menu-buttons a:hover {
    background: linear-gradient(90deg, #0056b3, #0096FF);
}
</style>
</head>
<body>
<header>
    <h1>Vacinas Aplicadas</h1>
    <p>Enfermeiro(a): <?= htmlspecialchars($nome) ?></p>
</header>

<table>
    <thead>
        <tr>
            <th>Data da Aplicação</th>
            <th>Paciente</th>
            <th>Vacina</th>
            <th>Enfermeiro</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($vacinacoes)): ?>
            <?php foreach ($vacinacoes as $v): ?>
                <tr>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($v['dataAplicacao']))) ?></td>
                    <td><?= htmlspecialchars($v['nomePaciente']) ?></td>
                    <td><?= htmlspecialchars($v['nomeVacina']) ?></td>
                    <td><?= htmlspecialchars($v['nomeEnfermeiro']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align:center;">Nenhuma vacinação encontrada.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="menu-buttons">
    <a href="../../views/enfermeiros/menu_enfermeiro.php">⬅️ Voltar</a>
</div>

</body>
</html>
