<?php
// ==================== CONEXÃO ====================
try {
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

$mensagem = "";
$tipo_mensagem = "";

// ==================== EXCLUIR VACINA ====================
if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];
    try {
        $stmt = $conn->prepare("DELETE FROM vacina WHERE idVacina = ?");
        $stmt->execute([$id]);
        $mensagem = "Vacina excluída com sucesso!";
        $tipo_mensagem = "sucesso";
    } catch (PDOException $e) {
        $mensagem = "Erro ao excluir vacina: " . $e->getMessage();
        $tipo_mensagem = "erro";
    }
}

// ==================== ATUALIZAR VACINA ====================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idVacina'])) {
    $id = $_POST['idVacina'];
    $vencimento = $_POST['vencimentoVacina'];
    $lote = $_POST['loteVacina'];
    $disponibilidade = $_POST['disponibilidadeVacina'];

    try {
        $sql = "UPDATE vacina 
                SET vencimentoVacina = ?, loteVacina = ?, disponibilidadeVacina = ?
                WHERE idVacina = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$vencimento, $lote, $disponibilidade, $id]);

        $mensagem = "Vacina atualizada com sucesso!";
        $tipo_mensagem = "sucesso";
    } catch (PDOException $e) {
        $mensagem = "Erro ao atualizar vacina: " . $e->getMessage();
        $tipo_mensagem = "erro";
    }
}

// ==================== LISTAR VACINAS ====================
$sql = "SELECT idVacina, nomeVacina, vencimentoVacina, fabricanteVacina, 
               doseVacina, intervaloVacina, loteVacina, disponibilidadeVacina
        FROM vacina
        ORDER BY nomeVacina ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$vacinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Alterar Vacinas</title>
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
    width: 65%; 
    margin: 0 auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 12px rgba(0,0,0,.08);
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
    font-size: 0.9rem;
}
th {
    background: linear-gradient(90deg,#007BFF,#00C6FF);
    color: #fff;
}
tr:hover { background: #eaf4ff; }

input[type="date"], input[type="text"], select {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 100%;
    text-align: center;
}

button {
    background: linear-gradient(90deg,#007BFF,#00C6FF);
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
}
button:hover { background: linear-gradient(90deg,#005fcc,#009ee3); }

.excluir {
    background: #ff4d4d;
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    transition: background 0.3s;
}
.excluir:hover { background: #cc0000; }

.mensagem {
    width: 60%;
    margin: 0 auto 20px auto;
    padding: 12px;
    text-align: center;
    border-radius: 8px;
    font-weight: bold;
    animation: aparecer 0.4s ease-in-out;
}
.sucesso {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.erro {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
@keyframes aparecer {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

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
}
@media (max-width: 768px) {
    table { width: 95%; font-size: 0.85rem; }
    th, td { padding: 8px; }
}
</style>
<script>
// Esconde a mensagem após 4 segundos
setTimeout(() => {
    const msg = document.querySelector('.mensagem');
    if (msg) msg.style.display = 'none';
}, 4000);
</script>
</head>
<body>
<h1>Alterar Vacinas</h1>

<?php if ($mensagem): ?>
<div class="mensagem <?= $tipo_mensagem ?>">
    <?= htmlspecialchars($mensagem) ?>
</div>
<?php endif; ?>

<?php if (count($vacinas) > 0): ?>
<table>
<thead>
<tr>
    
    <th>Nome</th>
    <th>Vencimento</th>
    <th>Lote</th>
    <th>Disponibilidade</th>
    <th>Ações</th>
</tr>
</thead>
<tbody>
<?php foreach ($vacinas as $v): ?>
<tr>
<form method="POST">
    
    <td><?= htmlspecialchars($v['nomeVacina']) ?></td>
    <td>
        <input type="date" name="vencimentoVacina" value="<?= htmlspecialchars($v['vencimentoVacina']) ?>">
    </td>
    <td>
        <input type="text" name="loteVacina" value="<?= htmlspecialchars($v['loteVacina']) ?>">
    </td>
    <td>
        <select name="disponibilidadeVacina">
            <option value="Disponível" <?= $v['disponibilidadeVacina'] === 'Disponível' ? 'selected' : '' ?>>Disponível</option>
            <option value="Indisponível" <?= $v['disponibilidadeVacina'] === 'Indisponível' ? 'selected' : '' ?>>Indisponível</option>
        </select>
    </td>
    <td>
        <input type="hidden" name="idVacina" value="<?= $v['idVacina'] ?>">
        <button type="submit">💾 Alterar</button>
        <a href="?excluir=<?= $v['idVacina'] ?>" class="excluir" onclick="return confirm('Tem certeza que deseja excluir esta vacina?')">🗑 Excluir</a>
    </td>
</form>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
<p style="text-align:center; color:#444; font-size:17px;">Nenhuma vacina cadastrada.</p>
<?php endif; ?>

<div class="botao-container">
    <a href="../../views/farmaceuticos/menu_farmaceutico.php" class="voltar">⬅ Voltar</a>
</div>

</body>
</html>
