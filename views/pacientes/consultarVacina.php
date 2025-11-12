<?php
session_start();

// Verifica se o paciente está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../views/auth/login.php");
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
$nomeUsuario = $_SESSION['nomeUsuario'];

try {
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 🔍 Agora buscamos as vacinas aplicadas através da relação completa entre as tabelas
    $sql = "SELECT 
            v.dataAplicacao,
            va.nomeVacina,
            va.doseVacina,
            u_enf.nomeUsuario AS nomeEnfermeiro
        FROM vacinacao v
        INNER JOIN vacina va ON v.idVacina = va.idVacina
        INNER JOIN paciente p ON v.idPaciente = p.idPaciente
        INNER JOIN usuario u ON p.idUsuario = u.idUsuario
        INNER JOIN enfermeiro e ON v.idEnfermeiro = e.idEnfermeiro
        INNER JOIN funcionario f ON e.idFuncionario = f.idFuncionario
        INNER JOIN usuario u_enf ON f.idUsuario = u_enf.idUsuario
        WHERE u.idUsuario = :idUsuario
          AND v.dataAplicacao <= CURDATE()
        ORDER BY v.dataAplicacao DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    $vacinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro no banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Vacinas Aplicadas</title>
<style>
    body {
        font-family: "Segoe UI", sans-serif;
        background: linear-gradient(135deg, #74ABE2, #5563DE);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }
    .container {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        width: 90%;
        max-width: 650px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
        text-align: center;
    }
    h2 {
        color: #2c3e50;
        margin-bottom: 25px;
    }
    .mensagem {
        font-weight: bold;
        padding: 15px;
        border-radius: 8px;
        background: #f0f9ff;
        color: #004085;
        border: 1px solid #b8daff;
        display: inline-block;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }
    th {
        background: #007BFF;
        color: white;
        border-radius: 5px 5px 0 0;
    }
    tr:nth-child(even) {
        background: #f9f9f9;
    }
    a.voltar {
        display: inline-block;
        margin-top: 25px;
        text-decoration: none;
        color: #007BFF;
        font-weight: bold;
    }
    a.voltar:hover {
        color: #0056b3;
    }
</style>
</head>
<body>
<div class="container">
    <h2>💉 Vacinas Aplicadas - <?= htmlspecialchars($nomeUsuario) ?></h2>

    <?php if (!empty($vacinas)): ?>
        <table>
            <tr>
                <th>Data de Aplicação</th>
                <th>Vacina</th>
                <th>Dose</th>
                <th>Enfermeiro</th>
            </tr>
            <?php foreach ($vacinas as $v): ?>
                <tr>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($v['dataAplicacao']))) ?></td>
                    <td><?= htmlspecialchars($v['nomeVacina']) ?></td>
                    <td><?= htmlspecialchars($v['doseVacina']) ?></td>
                    <td><?= isset($v['nomeEnfermeiro']) ? htmlspecialchars($v['nomeEnfermeiro']) : 'N/A' ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <div class="mensagem">⚠️ Nenhuma vacina aplicada até o momento.</div>
    <?php endif; ?>

    <a class="voltar" href="../../views/pacientes/menu_paciente.php">🏠 Voltar ao Menu</a>
</div>
</body>
</html>
