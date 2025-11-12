<?php
session_start();
require_once __DIR__ . '/../../config/conexao.php'; 

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        try {
            // Cria a conexão
            $conn = Conexao::getConnection();

            // Busca o paciente pelo e-mail
        $sql = "SELECT u.* 
        FROM usuario u
        INNER JOIN paciente p ON p.idUsuario = u.idUsuario
        WHERE u.email = :email
        LIMIT 1";
        $stmt = $conn->prepare($sql);
$stmt->bindParam(":email", $email);
$stmt->execute();

            if ($stmt->rowCount() === 1) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verifica a senha (sem hash)
                if ($senha === $usuario['senha']) {
                    $_SESSION['usuario_id'] = $usuario['idUsuario'];
                    $_SESSION['nomeUsuario'] = $usuario['nomeUsuario'];
                    $_SESSION['tipoUsuario'] = $usuario['perfilUsuario'];

                    // ✅ Redirecionamento corrigido
                    header("Location: ../../views/pacientes/menu_paciente.php");
                    exit;
                } else {
                    $erro = "Senha incorreta. Tente novamente.";
                }
            } else {
                $erro = "Nenhum paciente encontrado com este e-mail.";
            }
        } catch (PDOException $e) {
            $erro = "Erro ao acessar o banco de dados: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Paciente - Sistema de Vacinação</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #8EC5FC, #E0C3FC);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            flex-direction: column;
        }

        .login-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 380px;
            padding: 25px;
            text-align: center;
            animation: fadeIn 0.8s ease;
        }

        h3 {
            color: #2C3E50;
            margin-bottom: 5px;
        }

        h5 {
            color: #555;
            margin-bottom: 20px;
        }

        .erro {
            color: #e74c3c;
            background: #fcebea;
            border: 1px solid #f5c6cb;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 25px;
            font-size: 1rem;
        }

        button, .btn-voltar {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        button {
            background-color: #007BFF;
            color: white;
        }

        button:hover {
            background-color: #0056b3;
        }

        .btn-voltar {
            background-color: #ccc;
            color: #333;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-voltar:hover {
            background-color: #999;
        }

        footer {
            position: absolute;
            bottom: 10px;
            text-align: center;
            font-size: 0.9rem;
            color: #2C3E50;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h3>Sistema de Vacinação</h3>
        <h5>Login do Paciente</h5>

        <?php if (!empty($erro)): ?>
            <div class="erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
            <a href="/public/index.php" class="btn-voltar">Voltar</a>
        </form>
    </div>

    <footer>© 2025 Sistema de Vacinação - Todos os direitos reservados</footer>

</body>
</html>
