<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../views/auth/login.php");
    exit;
}

$nomeUsuario = $_SESSION['nomeUsuario'];

try {
    // Conexão com o banco de dados
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta somente nome, fabricante e disponibilidade das vacinas disponíveis
    $sql = "SELECT 
                nomeVacina,
                fabricanteVacina,
                disponibilidadeVacina
            FROM vacina
            WHERE disponibilidadeVacina = 'Disponível'
            ORDER BY nomeVacina ASC";
    
    $stmt = $conn->query($sql);
    $vacinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Vacinas Disponíveis</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: linear-gradient(135deg, #8EC5FC, #E0C3FC);
        margin: 0;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #2C3E50;
        margin-bottom: 20px;
    }
    table {
        width: 70%;
        margin: 30px auto;
        border-collapse: collapse;
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    th, td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: linear-gradient(90deg, #007BFF, #00C6FF);
        color: white;
    }
    tr:hover {
        background-color: #f2f8ff;
    }
    .container {
        text-align: center;
    }
    .voltar {
        display: inline-block;
        background: linear-gradient(90deg, #007BFF, #00C6FF);
        color: #fff;
        text-decoration: none;
        padding: 8px 18px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: background 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        margin-top: 25px;
    }
    .voltar:hover {
        background: linear-gradient(90deg, #0056b3, #0096FF);
        transform: translateY(-2px);
    }
</style>
</head>
<body>
<div class="container">
    <h1>Vacinas Disponíveis</h1>

    <?php if (count($vacinas) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome da Vacina</th>
                    <th>Fabricante</th>
                    <th>Disponibilidade</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vacinas as $v): ?>
                    <tr>
                        <td><?= htmlspecialchars($v['nomeVacina']) ?></td>
                        <td><?= htmlspecialchars($v['fabricanteVacina']) ?></td>
                        <td style="color: green; font-weight: bold;">
                            <?= htmlspecialchars($v['disponibilidadeVacina']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; font-size:18px; color:#333; margin-top:30px;">
            Nenhuma vacina disponível no momento.
        </p>
    <?php endif; ?>

    <a href="../../views/pacientes/menu_paciente.php" class="voltar">⬅ Voltar</a>
</div>
</body>
</html>
