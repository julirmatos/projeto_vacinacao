<?php
try {
    // 🔹 Conexão com o banco
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 🔹 Consulta dos pacientes
    $sql = "
        SELECT 
            u.idUsuario,
            u.nomeUsuario,
            u.cpfUsuario,
            u.dataNascimento,
            u.endereco,
            u.email,
            u.telefone
        FROM usuario u
        WHERE u.tipo = 'paciente'
        ORDER BY u.nomeUsuario ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Editar/Excluir Pacientes</title>
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
.mensagem {
    text-align: center;
    font-size: 16px;
    margin-bottom: 20px;
    font-weight: bold;
}
.sucesso {
    color: #0f5132;
    background-color: #d1e7dd;
    border: 1px solid #badbcc;
    padding: 10px;
    width: 60%;
    margin: 0 auto 20px auto;
    border-radius: 8px;
}
.erro {
    color: #842029;
    background-color: #f8d7da;
    border: 1px solid #f5c2c7;
    padding: 10px;
    width: 60%;
    margin: 0 auto 20px auto;
    border-radius: 8px;
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
    padding: 10px ;
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
input[type="text"], input[type="email"] {
    padding: 5px;
    border-radius: 6px;
    border: 1px solid #ccc;
    width: 90%;
}
button {
    background: linear-gradient(90deg,#007BFF,#00C6FF);
    border: none;
    color: white;
    padding: 6px 14px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    margin: 2px;
}
button:hover {
    background: linear-gradient(90deg,#005fcc,#009ee3);
}
button.remover {
    background: #dc3545;
}
button.remover:hover {
    background: #b02a37;
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
    table { width: 100%; font-size: 0.85rem; }
    th, td { padding: 8px 5px; }
}
</style>
</head>
<body>

<h1>Editar ou Excluir Pacientes</h1>

<!-- ✅ Mensagem de sucesso -->
<?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
    <div class="mensagem sucesso">✅ Dados alterados com sucesso!</div>
<?php endif; ?>

<!-- ❌ Mensagem de erro -->
<?php if (isset($_GET['erro'])): ?>
    <div class="mensagem erro">⚠️ Ocorreu um erro ao alterar os dados.</div>
<?php endif; ?>

<?php if (count($pacientes) > 0): ?>
<table>
    <thead>
        <tr>
            
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Endereço</th>
            <th>Email</th>
            <th>Telefone</th>
            <th colspan="2">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pacientes as $p): ?>
        <tr>
            <form action="salvar_alteracao.php" method="POST">
                
                <td><?= htmlspecialchars($p['nomeUsuario']) ?></td>
                <td><?= htmlspecialchars($p['cpfUsuario']) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y', strtotime($p['dataNascimento']))) ?></td>

                <td>
                    <input type="text" name="endereco" value="<?= htmlspecialchars($p['endereco']) ?>">
                </td>
                <td>
                    <input type="email" name="email" value="<?= htmlspecialchars($p['email']) ?>">
                </td>
                <td>
                    <input type="text" name="telefone" value="<?= htmlspecialchars($p['telefone']) ?>">
                </td>

                <td>
                    <input type="hidden" name="idUsuario" value="<?= $p['idUsuario'] ?>">
                    <button type="submit">💾 Alterar</button>
                </td>
            </form>
            <td>
                <form action="excluir_paciente.php" method="POST" onsubmit="return confirm('Deseja realmente excluir este paciente?');">
                    <input type="hidden" name="idUsuario" value="<?= $p['idUsuario'] ?>">
                    <button type="submit" class="remover">🗑️ Remover</button>
                </form>
            </td>
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
