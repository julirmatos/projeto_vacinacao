<?php
try {
    // 🔹 Conexão com o banco
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 🔹 Consulta de pacientes (apenas tipo = 'paciente')
    $sql = "
        SELECT 
            u.idUsuario,
            u.nomeUsuario,
            u.cpfUsuario,
            u.dataNascimento,
            u.endereco,
            u.email,
            u.telefone,
            p.numCartaoSus
        FROM usuario u
        INNER JOIN paciente p ON u.idUsuario = p.idUsuario
        WHERE u.tipo = 'paciente'
        ORDER BY u.nomeUsuario ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Erro na conexão: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Pacientes Cadastrados</title>
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
    width: 90%;
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
    table { width: 100%; font-size: 0.8rem; }
    th, td { padding: 8px 4px; }
}
</style>
</head>
<body>

<h1>Pacientes Cadastrados</h1>

<?php if (count($pacientes) > 0): ?>
<table>
<thead>
<tr>
    
    <th>Nome</th>
    <th>CPF</th>
    <th>Data de Nascimento</th>
    <th>Endereço</th>
    <th>E-mail</th>
    <th>Telefone</th>
    <th>Cartão SUS</th>
</tr>
</thead>
<tbody>
<?php foreach ($pacientes as $p): ?>
<tr>
    
    <td><?= htmlspecialchars($p['nomeUsuario']) ?></td>
    <td><?= htmlspecialchars($p['cpfUsuario']) ?></td>
    <td><?= htmlspecialchars(date('d/m/Y', strtotime($p['dataNascimento']))) ?></td>
    <td><?= htmlspecialchars($p['endereco']) ?></td>
    <td><?= htmlspecialchars($p['email']) ?></td>
    <td><?= htmlspecialchars($p['telefone']) ?></td>
    <td><?= htmlspecialchars($p['numCartaoSus']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
    <p class="mensagem">Nenhum paciente cadastrado.</p>
<?php endif; ?>

<div class="botao-container">
    <a href="../../views/recepcionista/menu_recepcionista.php" class="voltar">⬅ Voltar</a>
</div>

</body>
</html>
