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
    die("Erro na conexão: " . $e->getMessage());
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
}
table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 6px 12px rgba(0,0,0,.08);
}
th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
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
    padding: 12px 28px;
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
</style>
</head>
<body>
<h1>Vacinas Disponíveis</h1>

<?php if (count($vacinas) > 0): ?>
<table>
<thead>
<tr>
    
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
    <p style="text-align:center; color:#444; font-size:18px;">Nenhuma vacina disponível no momento.</p>
<?php endif; ?>

<!-- 🔹 Botão Voltar fixado ao final -->
<div class="botao-container">
    <a href="../../views/pacientes/menu_paciente.php" class="voltar">⬅ Voltar</a>
</div>

</body>
</html>
