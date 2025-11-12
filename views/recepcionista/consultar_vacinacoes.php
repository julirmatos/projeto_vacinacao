<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT 
                v.dataAplicacao,
                vac.nomeVacina,
                p.nomeUsuario AS nomePaciente,
                e.nomeUsuario AS nomeEnfermeiro
            FROM vacinacao v
            JOIN vacina vac ON v.idVacina = vac.idVacina
            JOIN usuario p ON v.idPaciente = p.idUsuario
            JOIN usuario e ON v.idEnfermeiro = e.idUsuario
            ORDER BY v.dataAplicacao DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $vacinacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Vacinas Aplicadas</title>
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
    margin-bottom: 20px;
}
table {
    width: 70%; /* 🔹 Reduzimos a largura */
    margin: 0 auto; /* 🔹 Centraliza a tabela */
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 12px rgba(0,0,0,.08);
}
th, td {
    padding: 10px 8px; /* 🔹 Menos espaçamento interno */
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

/* 🔹 Estilo do botão Voltar */
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
.voltar:active {
    transform: translateY(0);
    box-shadow: 0 4px 8px rgba(0,0,0,.1);
}

/* 🔹 Responsividade */
@media (max-width: 768px) {
    table {
        width: 95%;
        font-size: 0.85rem;
    }
    th, td {
        padding: 8px 5px;
    }
}
</style>
</head>
<body>
<h1>Vacinas Aplicadas</h1>

<?php if (count($vacinacoes) > 0): ?>
<table>
<thead>
<tr>
    <th>Data da Aplicação</th>
    <th>Nome da Vacina</th>
    <th>Nome do Paciente</th>
    <th>Enfermeiro Responsável</th>
</tr>
</thead>
<tbody>
<?php foreach ($vacinacoes as $v): ?>
<tr>
    <td><?= htmlspecialchars(date('d/m/Y', strtotime($v['dataAplicacao']))) ?></td>
    <td><?= htmlspecialchars($v['nomeVacina']) ?></td>
    <td><?= htmlspecialchars($v['nomePaciente']) ?></td>
    <td><?= htmlspecialchars($v['nomeEnfermeiro']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
    <p style="text-align:center; color:#444; font-size:18px;">Nenhuma vacina aplicada até o momento.</p>
<?php endif; ?>

<div class="botao-container">
    <a href="../../views/recepcionista/menu_recepcionista.php" class="voltar">⬅ Voltar</a>
</div>

</body>
</html>
