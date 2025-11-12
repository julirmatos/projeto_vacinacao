<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT 
                idVacina,
                nomeVacina,
                vencimentoVacina,
                fabricanteVacina,
                doseVacina,
                intervaloVacina,
                loteVacina,
                disponibilidadeVacina
            FROM vacina
            WHERE disponibilidadeVacina = 'Disponível'
            ORDER BY nomeVacina ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $vacinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro na conexão: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Vacinas Disponíveis</title>
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
    width: 60%; /* 🔹 Largura ajustada de 70% para 60% */
    margin: 0 auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 12px rgba(0,0,0,.08);
}
th, td {
    padding: 8px; /* 🔹 Levemente reduzido para proporcionalidade */
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

/* 🔹 Botão Voltar estilizado */
.botao-container {
    margin-top: 30px;
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
    table { width: 95%; font-size: 0.85rem; }
    th, td { padding: 7px; }
}
</style>
</head>
<body>
<h1>Vacinas Disponíveis</h1>

<?php if (count($vacinas) > 0): ?>
<table>
<thead>
<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Vencimento</th>
    <th>Fabricante</th>
    <th>Dose</th>
    <th>Intervalo (dias)</th>
    <th>Lote</th>
</tr>
</thead>
<tbody>
<?php foreach ($vacinas as $v): ?>
<tr>
    <td><?= htmlspecialchars($v['idVacina']) ?></td>
    <td><?= htmlspecialchars($v['nomeVacina']) ?></td>
    <td><?= htmlspecialchars($v['vencimentoVacina']) ?></td>
    <td><?= htmlspecialchars($v['fabricanteVacina']) ?></td>
    <td><?= htmlspecialchars($v['doseVacina']) ?></td>
    <td><?= htmlspecialchars($v['intervaloVacina']) ?></td>
    <td><?= htmlspecialchars($v['loteVacina']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
    <p style="text-align:center; color:#444; font-size:17px;">Nenhuma vacina disponível no momento.</p>
<?php endif; ?>

<div class="botao-container">
    <a href="../../views/enfermeiros/menu_enfermeiro.php" class="voltar">⬅ Voltar</a>
</div>

</body>
</html>
