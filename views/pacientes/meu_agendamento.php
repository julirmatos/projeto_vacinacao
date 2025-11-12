<?php
session_start();

// Verifica se o paciente está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../views/auth/login.php");
    exit;
}

$idPaciente = $_SESSION['usuario_id'];  

try {
    // Conexão com o banco
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta os agendamentos futuros do paciente
    $sql = "SELECT 
                a.dataAgendamento,
                v.nomeVacina,
                v.doseVacina
            FROM agendamento a
            INNER JOIN vacina v ON a.idVacina = v.idVacina
            WHERE a.idPaciente = :idPaciente
              AND a.dataAgendamento > CURDATE()
            ORDER BY a.dataAgendamento ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idPaciente', $idPaciente, PDO::PARAM_INT); // Substitua pelo ID correto do pacienteUsuario, PDO::PARAM_INT);
    $stmt->execute();
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro no banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Meus Agendamentos</title>
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
        max-width: 700px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: #007BFF;
        color: white;
        border-radius: 5px 5px 0 0;
    }
    tr:nth-child(even) {
        background: #f9f9f9;
    }
    .mensagem {
        text-align: center;
        font-weight: bold;
        padding: 15px;
        border-radius: 8px;
        background: #f0f9ff;
        color: #004085;
        border: 1px solid #b8daff;
        margin-top: 10px;
    }
    .sucesso {
        text-align: center;
        font-weight: bold;
        padding: 15px;
        border-radius: 8px;
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        margin-top: 15px;
    }
    a.voltar {
        display: block;
        text-align: center;
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
    <h2>📅 Meus Agendamentos</h2>

    <?php if ($agendamentos && count($agendamentos) > 0): ?>
        <table>
            <tr>
                <th>Data do Agendamento</th>
                <th>Vacina</th>
                <th>Dose</th>
            </tr>
            <?php foreach ($agendamentos as $ag): ?>
                <tr>
                    <td><?= htmlspecialchars(date('d/m/Y', strtotime($ag['dataAgendamento']))) ?></td>
                    <td><?= htmlspecialchars($ag['nomeVacina']) ?></td>
                    <td><?= htmlspecialchars($ag['doseVacina']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="sucesso">✅ Agendamentos Confirmados👍</div>

    <?php else: ?>
        <div class="mensagem">⚠️ Nenhum agendamento futuro encontrado.</div>
    <?php endif; ?>

    <a class="voltar" href="../../views/pacientes/menu_paciente.php">🏠 Voltar ao Menu</a>
</div>
</body>
</html>
