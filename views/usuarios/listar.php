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
            width: 98%;
            margin-top: 30px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        th, td {
            padding: 8px 10px;
            border: 1px solid #ccc;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #1e3a8a;
            color: white;
        }

        /* 🔹 Ajuste harmônico das larguras */
        th:nth-child(1) { width: 10%; } /* Nome */
        th:nth-child(2) { width: 5%; } /* CPF */
        th:nth-child(3) { width: 10%; } /* Email */
        th:nth-child(4) { width: 5%; } /* Data de Nascimento */
        th:nth-child(5) { width: 10%; } /* Endereço */
        th:nth-child(6) { width: 10%; } /* Telefone */
        th:nth-child(7) { width: 8%; }  /* Tipo */
        th.acoes, td.acoes { width: 13%; text-align: center; } /* Aumentado e centralizado */

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
            font-weight: bold;
            margin: 0 5px;
        }

        td a:hover {
            text-decoration: underline;
        }

        /* 🔹 Agrupamento dos botões de ação */
        .acoes a {
            display: inline-block;
        }

        @media (max-width: 768px) {
            main {
                padding: 10px;
            }
            table {
                font-size: 0.9rem;
                min-width: 600px;
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
            <th>Data de Nascimento</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Tipo</th>
            <th class="acoes">Ações</th>
        </tr>

        <?php if (empty($usuarios)): ?>
            <tr>
                <td colspan="8" style="text-align:center;">Nenhum usuário cadastrado.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u->getNome()) ?></td>
                    <td><?= htmlspecialchars($u->getCpf()) ?></td>
                    <td><?= htmlspecialchars($u->getEmail()) ?></td>
                    <td><?= htmlspecialchars($u->getDataNascimento()) ?></td>
                    <td><?= htmlspecialchars($u->getEndereco()) ?></td>
                    <td><?= htmlspecialchars($u->getTelefone()) ?></td>
                    <td><?= htmlspecialchars(ucfirst($u->getTipo())) ?></td>
                    <td class="acoes">
                        <a href="consultar.php?id=<?= $u->getIdUsuario(); ?>">Consultar👀</a>
                        <a href="alterar.php?id=<?= $u->getIdUsuario(); ?>">Alterar✏️</a>
                        <a href="excluir.php?id=<?= $u->getIdUsuario(); ?>" onclick="return confirm('Deseja realmente excluir este usuário?');">Excluir🗑️</a>
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
