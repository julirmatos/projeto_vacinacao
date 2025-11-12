<?php
session_start();

try {
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
        SELECT 
            u.idUsuario,
            u.nomeUsuario,
            u.cpfUsuario,
            u.email,
            u.telefone,
            u.endereco,
            f.matricula,
            f.perfilFuncionario
        FROM funcionario f
        INNER JOIN usuario u ON f.idUsuario = u.idUsuario
        WHERE f.perfilFuncionario = 'recepcionista'
        GROUP BY u.idUsuario
        ORDER BY u.nomeUsuario ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $recepcionistas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao carregar recepcionistas: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>👩🏻‍💼 Alterar Recepcionistas</title>
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

    /* 🔹 Ajuste das larguras */
    th:nth-child(1), td:nth-child(1) { width: 22%; } /* Nome */
    th:nth-child(2), td:nth-child(2) { width: 13%; } /* CPF */
    th:nth-child(3), td:nth-child(3) { width: 15%; } /* Email (reduzido) */
    th:nth-child(4), td:nth-child(4) { width: 13%; } /* Telefone */
    th:nth-child(5), td:nth-child(5) { width: 15%; } /* Endereço */
    th:nth-child(6), td:nth-child(6) {
        width: 22%; /* Ações */
        text-align: center;
        font-size: 0.9rem;
        white-space: nowrap;
    }

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

    td a i, td a img {
        vertical-align: middle;
        font-size: 0.9rem;
    }

    @media (max-width: 900px) {
        main {
            max-width: 100%;
            padding: 15px;
        }
        table {
            font-size: 0.9rem;
        }
        th, td {
            padding: 8px 6px;
        }
        th:nth-child(6), td:nth-child(6) {
            font-size: 0.8rem;
        }
    }
</style>

</head>
<body>

<header>
    👩🏻‍💼 Lista de Recepcionistas
</header>

<main>
    <div style="text-align: left; margin-bottom: 20px;">
        <a href="cadastrar.php" class="botao">➕ Cadastrar Novo Recepcionista</a>
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

        <?php if (empty($recepcionistas)): ?>
            <tr>
                <td colspan="6" style="text-align:center;">Nenhum recepcionista cadastrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($recepcionistas as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['nomeUsuario']) ?></td>
                    <td><?= htmlspecialchars($r['cpfUsuario']) ?></td>
                    <td><?= htmlspecialchars($r['email']) ?></td>
                    <td><?= htmlspecialchars($r['telefone']) ?></td>
                    <td><?= htmlspecialchars($r['endereco']) ?></td>
                    <td>
                        <a href="consultar.php?id=<?= $r['idUsuario'] ?>">👀 Consultar</a> |
                        <a href="alterar.php?id=<?= $r['idUsuario'] ?>">Alterar✏️</a> |
                        <a href="excluir.php?id=<?= $r['idUsuario'] ?>" onclick="return confirm('Deseja realmente excluir este recepcionista?');">Excluir🗑️</a>
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
