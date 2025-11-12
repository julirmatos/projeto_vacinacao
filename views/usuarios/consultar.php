<?php
require_once __DIR__ . '/../../src/Controllers/usuarioController.php';
$controller = new UsuarioController();

// Verifica se o ID foi informado na URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p>ID do usuário não informado!</p>";
    echo "<p><a href='listar.php'>⬅️ Voltar</a></p>";
    exit;
}

$usuario = $controller->buscarPorId($id);

if (!$usuario) {
    echo "<p>Usuário não encontrado!</p>";
    echo "<p><a href='listar.php'>⬅️ Voltar</a></p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>👀 Consultar Usuário</title>
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #8EC5FC, #E0C3FC);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
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
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
            width: 90%;
            max-width: 500px;
            margin-top: 40px;
        }

        p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 10px;
        }

        strong {
            color: #007BFF;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        footer {
            margin-top: auto;
            padding: 15px;
            text-align: center;
            width: 100%;
            background: #f0f0f0;
            color: #555;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<header>
    👀 Consultar Usuário
</header>

<main>
    <p><strong>ID:</strong> <?= htmlspecialchars($usuario->getIdUsuario()) ?></p>
    <p><strong>Nome:</strong> <?= htmlspecialchars($usuario->getNome()) ?></p>
    <p><strong>CPF:</strong> <?= htmlspecialchars($usuario->getCpf()) ?></p>
    <p><strong>Data de Nascimento:</strong> <?= htmlspecialchars($usuario->getDataNascimento()) ?></p>
    <p><strong>Endereço:</strong> <?= htmlspecialchars($usuario->getEndereco()) ?></p>
    <p><strong>Telefone:</strong> <?= htmlspecialchars($usuario->getTelefone()) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($usuario->getEmail()) ?></p>
    <p><strong>Tipo:</strong> <?= htmlspecialchars($usuario->getTipo()) ?></p>

    <a href="listar.php">⬅️ Voltar à lista</a>
</main>

<footer>
    © 2025 Sistema de Vacinação - Área Administrativa
</footer>

</body>
</html>
