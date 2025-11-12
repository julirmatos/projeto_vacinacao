<?php
try {
    // 🔹 Conexão com o banco
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 🔹 Consulta de agendamentos futuros (ou do dia atual)
    $sql = "
        SELECT 
            a.dataAgendamento,
            u.nomeUsuario AS nomePaciente,
            v.nomeVacina,
            v.doseVacina,
            ur.nomeUsuario AS nomeRecepcionista
        FROM agendamento a
        INNER JOIN usuario u ON a.idPaciente = u.idUsuario
        INNER JOIN vacina v ON a.idVacina = v.idVacina
        INNER JOIN recepcionista r ON a.idRecepcionista = r.idRecepcionista
        INNER JOIN funcionario f ON r.idFuncionario = f.idFuncionario
        INNER JOIN usuario ur ON f.idUsuario = ur.idUsuario
        WHERE a.dataAgendamento >= CURDATE()
        ORDER BY a.dataAgendamento ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Consultas Agendadas</title>
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
    width: 70%;
    margin: 0 auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 12px rgba(0,0,0,.08);
}
th, td {
    padding: 10px 8px;
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
.mensagem {
    text-align: center;
    font-size: 16px;
    margin-top: 20px;
    color: #444;
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
    table { width: 95%; font-size: 0.85rem; }
    th, td { padding: 8px 5px; }
}
</style>
</head>
<body>

<h1>Vacinações Agendadas</h1>

<?php if (count($agendamentos) > 0): ?>
<table>
<thead>
<tr>
    <th>Data do Agendamento</th>
    <th>Paciente</th>
    <th>Vacina</th>
    <th>Dose</th>
    <th>Recepcionista</th>
</tr>
</thead>
<tbody>
<?php foreach ($agendamentos as $a): ?>
<tr>
    <td><?= htmlspecialchars(date('d/m/Y', strtotime($a['dataAgendamento']))) ?></td>
    <td><?= htmlspecialchars($a['nomePaciente']) ?></td>
    <td><?= htmlspecialchars($a['nomeVacina']) ?></td>
    <td><?= htmlspecialchars($a['doseVacina']) ?></td>
    <td><?= htmlspecialchars($a['nomeRecepcionista']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
    <p class="mensagem">Nenhuma consulta agendada !.</p>
<?php endif; ?>

<div class="botao-container">
    <a href="../../views/recepcionista/menu_recepcionista.php" class="voltar">⬅ Voltar</a>
</div>

</body>
</html>
