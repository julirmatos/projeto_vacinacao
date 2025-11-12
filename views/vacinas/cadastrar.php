<?php
// cadastrar_vacinas.php
try {
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // sanitização básica
    $nome = trim($_POST["nomeVacina"] ?? '');
    $vencimento = trim($_POST["vencimentoVacina"] ?? '');
    $fabricante = trim($_POST["fabricanteVacina"] ?? '');
    $dose = trim($_POST["doseVacina"] ?? '');
    $intervalo = trim($_POST["intervaloVacina"] ?? '');
    $lote = trim($_POST["loteVacina"] ?? '');
    $disponibilidade = trim($_POST["disponibilidadeVacina"] ?? 'Disponível');

    if ($nome === '' || $vencimento === '' || $fabricante === '' || $dose === '' || $intervalo === '' || $lote === '') {
        $mensagem = "⚠️ Preencha todos os campos antes de enviar.";
    } else {
        try {
            // Verificar duplicidade (comparação case-insensitive e sem espaços extras)
            $sql_check = "
                SELECT COUNT(*) 
                FROM vacina 
                WHERE TRIM(LOWER(nomeVacina)) = TRIM(LOWER(:nome))
                  AND TRIM(LOWER(loteVacina)) = TRIM(LOWER(:lote))
            ";
            $stmt = $conn->prepare($sql_check);
            $stmt->execute([
                ':nome' => $nome,
                ':lote' => $lote
            ]);
            $exists = (int) $stmt->fetchColumn();

            if ($exists > 0) {
                $mensagem = "⚠️ Já existe uma vacina cadastrada com o mesmo NOME e LOTE.";
            } else {
                // Inserir nova vacina
                $sql = "INSERT INTO vacina 
                            (nomeVacina, vencimentoVacina, fabricanteVacina, doseVacina, intervaloVacina, loteVacina, disponibilidadeVacina)
                        VALUES 
                            (:nome, :vencimento, :fabricante, :dose, :intervalo, :lote, :disponibilidade)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':nome' => $nome,
                    ':vencimento' => $vencimento,
                    ':fabricante' => $fabricante,
                    ':dose' => $dose,
                    ':intervalo' => $intervalo,
                    ':lote' => $lote,
                    ':disponibilidade' => $disponibilidade
                ]);
                $mensagem = "✅ Vacina cadastrada com sucesso!";
            }
        } catch (PDOException $e) {
            // Em caso de erro (ex.: constraint no DB), exibe a mensagem
            $mensagem = "❌ Erro ao cadastrar vacina: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cadastrar Vacinas</title>
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
    margin-bottom: 15px;
}
form {
    max-width: 500px;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 6px 12px rgba(0,0,0,.08);
}
label {
    display: block;
    margin-bottom: 4px;
    font-weight: 600;
    color: #004aad;
    font-size: 13px;
}
input, select {
    width: 100%;
    padding: 8px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
}
button {
    width: 100%;
    background: linear-gradient(90deg,#007BFF,#00C6FF);
    color: white;
    border: none;
    padding: 10px;
    border-radius: 10px;
    font-weight: bold;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 12px rgba(0,0,0,.1);
}
button:hover {
    background: linear-gradient(90deg,#005fcc,#009ee3);
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,.15);
}
.mensagem {
    text-align: center;
    font-size: 16px;
    margin-top: 10px;
    color: #004aad;
}
/* Botão voltar */
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
/* Responsivo */
@media (max-width: 480px) {
    form { padding: 15px; }
    label { font-size: 12px; }
    input, select, button { font-size: 13px; }
}
</style>
</head>
<body>

<h1>Cadastrar Nova Vacina</h1>

<form method="POST" action="">
    <label for="nomeVacina">Nome da Vacina:</label>
    <input type="text" id="nomeVacina" name="nomeVacina" required>

    <label for="vencimentoVacina">Data de Vencimento:</label>
    <input type="date" id="vencimentoVacina" name="vencimentoVacina" required>

    <label for="fabricanteVacina">Fabricante:</label>
    <input type="text" id="fabricanteVacina" name="fabricanteVacina" required>

    <label for="doseVacina">Dose:</label>
    <select id="doseVacina" name="doseVacina" required>
        <option value="">Selecione...</option>
        <option value="1ª dose">1ª dose</option>
        <option value="2ª dose">2ª dose</option>
        <option value="Dose única">Dose única</option>
        <option value="Reforço">Reforço</option>
    </select>

    <label for="intervaloVacina">Intervalo entre doses (dias):</label>
    <input type="number" id="intervaloVacina" name="intervaloVacina" min="0" required>

    <label for="loteVacina">Lote:</label>
    <input type="text" id="loteVacina" name="loteVacina" required>

    <label for="disponibilidadeVacina">Disponibilidade:</label>
    <select id="disponibilidadeVacina" name="disponibilidadeVacina">
        <option value="Disponível" selected>Disponível</option>
        <option value="Indisponível">Indisponível</option>
    </select>

    <button type="submit">Cadastrar Vacina</button>
</form>

<?php if ($mensagem): ?>
    <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<div class="botao-container">
    <a href="../../views/farmaceuticos/menu_farmaceutico.php" class="voltar">⬅ Voltar</a>
</div>

</body>
</html>
