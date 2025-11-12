<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../views/auth/login.php");
    exit;
}

$idUsuario = $_SESSION['usuario_id'];  
$mensagem = "";


try {
    // Conexão com o banco
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Busca os dados do paciente
    $sql = "SELECT nomeUsuario, cpfUsuario, dataNascimento, endereco, email, telefone
            FROM usuario
            WHERE idUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$idUsuario]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se não encontrar o paciente, redireciona
    if (!$dados) {
        $mensagem = "Paciente não encontrado.";
    }

    // Se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $endereco = trim($_POST['endereco']);

        // Atualiza os campos permitidos
        $sqlUpdate = "UPDATE usuario 
                      SET email = ?, telefone = ?, endereco = ?
                      WHERE idUsuario = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $ok = $stmtUpdate->execute([$email, $telefone, $endereco, $idUsuario]);

        if ($ok) {
            $mensagem = "✅ Dados atualizados com sucesso!";
            // Atualiza os dados na tela
            $dados['email'] = $email;
            $dados['telefone'] = $telefone;
            $dados['endereco'] = $endereco;
        } else {
            $mensagem = "❌ Erro ao atualizar os dados. Tente novamente.";
        }
    }

} catch (PDOException $e) {
    die("Erro no banco de dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Meu Cadastro</title>
<style>
    body {
        font-family: "Segoe UI", sans-serif;
        background: linear-gradient(135deg, #74ABE2, #5563DE);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }
    .container {
        background: #fff;
        padding: 40px;
        border-radius: 20px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
    h2 {
        text-align: center;
        color: #2c3e50;
    }
    form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px 20px;
    }
    label {
        font-weight: 600;
        color: #34495e;
    }
    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
    }
    input[readonly] {
        background-color: #f4f4f4;
        cursor: not-allowed;
    }
    .full {
        grid-column: 1 / 3;
    }
    button {
        grid-column: 1 / 3;
        background: linear-gradient(90deg, #007BFF, #00C6FF);
        color: white;
        padding: 12px;
        border: none;
        border-radius: 25px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    button:hover {
        background: linear-gradient(90deg, #0056b3, #0096FF);
    }
    .mensagem {
        text-align: center;
        margin-top: 15px;
        font-weight: bold;
        color: #2c3e50;
    }
    a.voltar {
        display: block;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        color: #007BFF;
        font-weight: bold;
    }
    a.voltar:hover {
        color: #0056b3;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Meu Cadastro</h2>

    <?php if ($mensagem): ?>
        <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <?php if (!empty($dados)): ?>
    <form method="POST" action="">
        <label>Nome:</label>
        <input type="text" value="<?= htmlspecialchars($dados['nomeUsuario']) ?>" readonly>

        <label>CPF:</label>
        <input type="text" value="<?= htmlspecialchars($dados['cpfUsuario']) ?>" readonly>

        <label>Data de Nascimento:</label>
        <input type="date" value="<?= htmlspecialchars($dados['dataNascimento']) ?>" readonly>

        <label class="full">E-mail:</label>
        <input class="full" type="email" name="email" value="<?= htmlspecialchars($dados['email']) ?>" required>

        <label class="full">Telefone:</label>
        <input class="full" type="text" name="telefone" value="<?= htmlspecialchars($dados['telefone']) ?>" required>

        <label class="full">Endereço:</label>
        <input class="full" type="text" name="endereco" value="<?= htmlspecialchars($dados['endereco']) ?>" required>

        <button type="submit">Salvar Alterações</button>
    </form>
    <?php endif; ?>

    <a class="voltar" href="../../views/pacientes/menu_paciente.php">🏠 Menu Inicial</a>
</div>
</body>
</html>