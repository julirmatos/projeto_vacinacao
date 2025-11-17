<?php
session_start();

// Verifica se o enfermeiro está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../views/auth/login.php");
    exit;
}

// Dados do usuário logado
$nome = $_SESSION['nomeUsuario'] ?? 'Enfermeiro(a)';

// === Conexão com o banco ===
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

// Carrega lista de pacientes (sem administradores)
$pacientes = $conn->query("
    SELECT p.idPaciente, u.nomeUsuario 
    FROM paciente p
    INNER JOIN usuario u ON p.idUsuario = u.idUsuario
    WHERE u.tipo != 'admin'
    ORDER BY u.nomeUsuario ASC
")->fetchAll(PDO::FETCH_ASSOC);

// Filtro de vacinas
$vacinacoes = [];
if (!empty($_GET['idPaciente'])) {
    $idPaciente = $_GET['idPaciente'];

    $stmt = $conn->prepare("
        SELECT 
            v.dataAplicacao,
            va.nomeVacina,
            ue.nomeUsuario AS nomeEnfermeiro
        FROM vacinacao v
        INNER JOIN vacina va ON v.idVacina = va.idVacina
        INNER JOIN enfermeiro e ON v.idEnfermeiro = e.idEnfermeiro
        INNER JOIN usuario ue ON e.idFuncionario = ue.idUsuario
        WHERE v.idPaciente = :idPaciente
        ORDER BY v.dataAplicacao DESC
    ");
    $stmt->bindParam(':idPaciente', $idPaciente, PDO::PARAM_INT);
    $stmt->execute();
    $vacinacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Consultar Vacinas Aplicadas por Paciente</title>
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

.card {
    background: #fff;
    padding: 25px 30px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    text-align: center;
    max-width: 500px;
    width: 100%;
    margin-bottom: 40px;
}

select, button {
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
    margin-top: 10px;
    width: 100%;
}

button {
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
    font-weight: 600;
}

button:hover {
    background: linear-gradient(90deg, #0056b3, #0096FF);
}

.msg {
    margin-top: 20px;
    color: #2C3E50;
    font-weight: 500;
}

table {
    width: 90%;
    max-width: 800px;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
    margin-top: 10px;
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
    <h1>Consultar Vacinas Aplicadas por Paciente</h1>
    <p>Enfermeiro(a): <?= htmlspecialchars($nome) ?></p>
</header>

<div class="card">
    <form method="GET" action="">
        <label for="idPaciente"><strong>Selecione o Paciente:</strong></label><br>
        <select name="idPaciente" id="idPaciente" required>
            <option value="">-- Escolha o paciente --</option>
            <?php foreach ($pacientes as $p): ?>
                <option value="<?= $p['idPaciente'] ?>" <?= (isset($_GET['idPaciente']) && $_GET['idPaciente'] == $p['idPaciente']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['nomeUsuario']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">Consultar</button>

        <?php if (isset($_GET['idPaciente']) && empty($vacinacoes)): ?>
            <p class="msg"><strong>⚠️Nenhuma vacina registrada para este paciente.</strong></p>
        <?php endif; ?>
    </form>
</div>

<?php if (!empty($vacinacoes)): ?>
<table>
    <thead>
        <tr>
            <th>Data da Aplicação</th>
            <th>Vacina</th>
            <th>Enfermeiro</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vacinacoes as $v): ?>
        <tr>
            <td><?= htmlspecialchars(date('d/m/Y', strtotime($v['dataAplicacao']))) ?></td>
            <td><?= htmlspecialchars($v['nomeVacina']) ?></td>
            <td><?= htmlspecialchars($v['nomeEnfermeiro']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<div class="menu-buttons">
    <a href="../../views/enfermeiros/menu_enfermeiro.php">⬅️ Voltar</a>
</div>

</body>
</html>

