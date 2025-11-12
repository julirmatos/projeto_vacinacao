<?php
require_once __DIR__ . '/../../src/Controllers/usuarioController.php';
$controller = new UsuarioController();
$usuarios = $controller->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>👥 Listar Usuários</title>
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
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
            width: 95%;
            max-width: 950px;
            margin-top: 30px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed; /* ✅ mantém largura uniforme */
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        th {
            background: #1e3a8a;
            color: white;
        }

        /* 🔹 Larguras ajustadas harmonicamente */
        th:nth-child(1), td:nth-child(1) { width: 25%; }  /* Nome */
        th:nth-child(2), td:nth-child(2) { width: 20%; }  /* CPF */
        th:nth-child(3), td:nth-child(3) { width: 25%; }  /* Email */
        th:nth-child(4), td:nth-child(4) { width: 10%; }  /* Tipo */
        th:nth-child(5), td:nth-child(5) { width: 20%; }  /* Ações */

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        a.botao {
            display: inline-block;
            padding: 10px 15px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        a.botao:hover {
            background: #218838;
        }

        .voltar {
            display: inline-block;
            padding: 10px 15px;
            background: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 25px;
            text-align: center;
        }

        .voltar:hover {
            background: #0056b3;
        }

        td a {
            text-decoration: none;
            color: #007BFF;
            margin: 0 3px;
        }

        td a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            main {
                padding: 10px;
            }
            table {
                font-size: 0.9rem;
            }
            th, td {
                padding: 8px;
            }
            a.botao, .voltar {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<header>
    👥 Lista de Usuários
</header>

<main>
    <div style="text-align: left; margin-bottom: 20px;">
        <a href="cadastrar.php" class="botao">➕ Cadastrar Novo Usuário</a>
    </div>

    <table>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>

        <?php if (empty($usuarios)): ?>
            <tr>
                <td colspan="5" style="text-align:center;">Nenhum usuário cadastrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u->getNome()) ?></td>
                    <td><?= htmlspecialchars($u->getCpf()) ?></td>
                    <td><?= htmlspecialchars($u->getEmail()) ?></td>
                    <td><?= htmlspecialchars(ucfirst($u->getTipo())) ?></td>
                    <td>
                        <a href="consultar.php?id=<?= $u->getIdUsuario(); ?>">👀 Consultar</a> |
                        <a href="alterar.php?id=<?= $u->getIdUsuario(); ?>">✏️ Alterar</a> |
                        <a href="excluir.php?id=<?= $u->getIdUsuario(); ?>" onclick="return confirm('Deseja realmente excluir este usuário?');">🗑️ Excluir</a>
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
