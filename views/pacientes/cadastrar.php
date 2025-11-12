<?php
try {
    // 🔹 Conexão com o banco
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 🔹 Inserir novo paciente
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Dados do formulário
        $nomeUsuario = trim($_POST['nomeUsuario']);
        $cpfUsuario = trim($_POST['cpfUsuario']);
        $dataNascimento = trim($_POST['dataNascimento']);
        $endereco = trim($_POST['endereco']);
        $email = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $senha = trim($_POST['senha']);
        $numCartaoSus = trim($_POST['numCartaoSus']);

        // Validação simples
        if (
            !empty($nomeUsuario) && !empty($cpfUsuario) && !empty($dataNascimento) &&
            !empty($endereco) && !empty($email) && !empty($telefone) &&
            !empty($senha) && !empty($numCartaoSus)
        ) {
            // 🔸 1. Inserir na tabela usuario
            $sqlUsuario = "INSERT INTO usuario 
                (nomeUsuario, cpfUsuario, dataNascimento, endereco, email, telefone, senha, tipo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'paciente')";
            $stmt = $conn->prepare($sqlUsuario);
            $stmt->execute([$nomeUsuario, $cpfUsuario, $dataNascimento, $endereco, $email, $telefone, $senha]);

            // 🔸 2. Pegar o último id inserido
            $idUsuario = $conn->lastInsertId();

            // 🔸 3. Inserir na tabela paciente
            $sqlPaciente = "INSERT INTO paciente (numCartaoSus, idUsuario) VALUES (?, ?)";
            $stmtPaciente = $conn->prepare($sqlPaciente);
            $stmtPaciente->execute([$numCartaoSus, $idUsuario]);

            $mensagem = "✅ Paciente cadastrado com sucesso!";
        } else {
            $mensagem = "⚠️ Por favor, preencha todos os campos.";
        }
    }

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cadastrar Paciente</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f0f6ff;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
}
h1 {
    color: #004aad;
    margin-bottom: 25px;
}
form {
    background: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0,0,0,.1);
    width: 450px;
    max-width: 95%;
}
label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}
input[type="text"], input[type="email"], input[type="date"], input[type="password"], input[type="tel"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
button {
    background: linear-gradient(90deg,#007BFF,#00C6FF);
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
    width: 100%;
    transition: all 0.3s ease;
}
button:hover {
    background: linear-gradient(90deg,#005fcc,#009ee3);
    transform: translateY(-2px);
}
.mensagem {
    text-align: center;
    font-size: 16px;
    margin-top: 15px;
    color: #004aad;
    font-weight: bold;
}
.voltar {
    display: inline-block;
    margin-top: 25px;
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
</style>
</head>
<body>

<h1>Cadastro de Paciente</h1>

<form method="POST">
    <label for="nomeUsuario">Nome completo:</label>
    <input type="text" name="nomeUsuario" id="nomeUsuario" required>

    <label for="cpfUsuario">CPF:</label>
    <input type="text" name="cpfUsuario" id="cpfUsuario" maxlength="11" placeholder="Somente números" required>

    <label for="dataNascimento">Data de nascimento:</label>
    <input type="date" name="dataNascimento" id="dataNascimento" required>

    <label for="endereco">Endereço:</label>
    <input type="text" name="endereco" id="endereco" required>

    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" required>

    <label for="telefone">Telefone:</label>
    <input type="tel" name="telefone" id="telefone" maxlength="11" placeholder="DDD + número" required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>

    <label for="numCartaoSus">Número do Cartão SUS:</label>
    <input type="text" name="numCartaoSus" id="numCartaoSus" maxlength="15" required>

    <button type="submit">💾 Cadastrar Paciente</button>
</form>

<?php if (!empty($mensagem)): ?>
    <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<a href="../../views/recepcionista/menu_recepcionista.php" class="voltar">⬅ Voltar</a>

</body>
</html>
