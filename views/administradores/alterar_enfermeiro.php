<?php 
session_start();

try {
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ✅ Consulta completa com junção entre enfermeiro, funcionário e usuário
    $sql = "
        SELECT 
            u.idUsuario,
            u.nomeUsuario,
            u.cpfUsuario,
            u.email,
            u.telefone,
            u.endereco,
            f.idFuncionario,
            f.matricula,
            f.perfilFuncionario,
            e.idEnfermeiro
        FROM enfermeiro e
        INNER JOIN funcionario f ON e.idFuncionario = f.idFuncionario
        INNER JOIN usuario u ON f.idUsuario = u.idUsuario
        WHERE f.perfilFuncionario = 'enfermeiro'
        ORDER BY u.nomeUsuario ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $enfermeiros = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao carregar enfermeiros: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>👩‍⚕️ Alterar Enfermeiros</title>
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #8EC5FC, #E0C3FC);
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    header {
        background-color: #007BFF;
        color: white;
        width: 100%;
        padding: 20px 0;
        text-align: center;
        font-size: 1.4rem;
        font-weight: bold;
        box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
    }

    main {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.25);
        width: 98%;
        max-width: 1300px;
        margin-top: 40px;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 1rem;
        table-layout: fixed;
    }

    th, td {
        padding: 12px 10px;
        border: 1px solid #ccc;
        text-align: left;
        vertical-align: middle;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    th {
        background: #1e3a8a;
        color: white;
        font-size: 1rem;
    }

    tr:nth-child(even) {
        background: #f9f9f9;
    }

    th:nth-child(1), td:nth-child(1) { width: 20%; }
    th:nth-child(2), td:nth-child(2) { width: 12%; }
    th:nth-child(3), td:nth-child(3) { width: 18%; }
    th:nth-child(4), td:nth-child(4) { width: 10%; }
    th:nth-child(5), td:nth-child(5) { width: 15%; }
    th:nth-child(6), td:nth-child(6) { width: 25%; text-align: center; }

    a.botao {
        display: inline-block;
        padding: 12px 18px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 1rem;
    }

    a.botao:hover {
        background: #218838;
    }

    .voltar {
        display: inline-block;
        padding: 12px 20px;
        background: #007BFF;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        margin-top: 30px;
        text-align: center;
        font-size: 1rem;
    }

    .voltar:hover {
        background: #0056b3;
    }

    td a {
        text-decoration: none;
        color: #007BFF;
        margin: 0 3px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    td a:hover {
        text-decoration: underline;
    }
    </style>
</head>
<body>

<header>
    👩‍⚕️ Lista de Enfermeiros
</header>

<main>
    <div style="text-align: left; margin-bottom: 20px;">
        <a href="cadastrar.php" class="botao">➕ Cadastrar Novo Enfermeiro</a>
    </div>

    <table>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Ações</th>
        </tr>

        <?php if (empty($enfermeiros)): ?>
            <tr>
                <td colspan="6" style="text-align:center;">Nenhum enfermeiro cadastrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($enfermeiros as $e): ?>
                <tr>
                    <td><?= htmlspecialchars($e['nomeUsuario']) ?></td>
                    <td><?= htmlspecialchars($e['cpfUsuario']) ?></td>
                    <td><?= htmlspecialchars($e['email']) ?></td>
                    <td><?= htmlspecialchars($e['telefone']) ?></td>
                    <td><?= htmlspecialchars($e['endereco']) ?></td>
                    <td>
                        <a href="consultar.php?id=<?= $e['idEnfermeiro'] ?>">👀 Consultar</a> |
                        <a href="alterar.php?id=<?= $e['idEnfermeiro'] ?>">✏️ Alterar</a> |
                        <a href="excluir.php?id=<?= $e['idEnfermeiro'] ?>" onclick="return confirm('Deseja realmente excluir este enfermeiro?');">🗑️ Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <div style="text-align: center;">
        <a href="../../views/administradores/menu_admin.php" class="voltar">⬅️ Voltar ao Menu</a>
    </div>
</main>

</body>
</html>
