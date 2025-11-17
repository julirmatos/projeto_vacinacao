<?php
session_start();

try {
    // 🧩 1. Conexão com o banco de dados
    $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 🧩 2. Verifica se a sessão contém o ID do usuário logado
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception("Usuário não autenticado. Faça login novamente.");
    }

    $idUsuarioLogado = $_SESSION['usuario_id'];
    $mensagem = "";

    // 🧩 3. Busca o idRecepcionista vinculado ao usuário logado
    $sql_rec = "
        SELECT r.idRecepcionista
        FROM recepcionista r
        INNER JOIN funcionario f ON r.idFuncionario = f.idFuncionario
        WHERE f.idUsuario = :idUsuario
    ";
    $stmt = $conn->prepare($sql_rec);
    $stmt->execute([':idUsuario' => $idUsuarioLogado]);
    $idRecepcionista = $stmt->fetchColumn();

    if (!$idRecepcionista) {
        throw new Exception("Recepcionista não encontrada na base de dados.");
    }

    // 🧩 4. Processa o formulário de agendamento
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $dataAgendamento = trim($_POST["dataAplicacao"] ?? '');
        $idPaciente = trim($_POST["idPaciente"] ?? '');
        $idVacina = trim($_POST["idVacina"] ?? '');
        $idEnfermeiro = trim($_POST["idEnfermeiro"] ?? '');

        if ($dataAgendamento === '' || $idPaciente === '' || $idVacina === '' || $idEnfermeiro === '') {
            $mensagem = "⚠️ Preencha todos os campos antes de enviar.";
        } else {
            try {
                // Verifica duplicidade
                $sql_check = "
                    SELECT COUNT(*) 
                    FROM agendamento 
                    WHERE dataAgendamento = :data 
                    AND idPaciente = :paciente 
                    AND idVacina = :vacina
                ";
                $stmt = $conn->prepare($sql_check);
                $stmt->execute([
                    ':data' => $dataAgendamento,
                    ':paciente' => $idPaciente,
                    ':vacina' => $idVacina
                ]);
                $existe = (int) $stmt->fetchColumn();

                if ($existe > 0) {
                    $mensagem = "⚠️ Já existe um agendamento dessa vacina para este paciente nesta data.";
                } else {
                    // Inserção na tabela agendamento (CORRIGIDO)
                    $sql_insert = "
                        INSERT INTO agendamento (dataAgendamento, idPaciente, idVacina, idEnfermeiro, idRecepcionista)
                        VALUES (:data, :paciente, :vacina, :enfermeiro, :recepcionista)
                    ";
                    $stmt = $conn->prepare($sql_insert);
                    $stmt->execute([
                        ':data' => $dataAgendamento,
                        ':paciente' => $idPaciente,
                        ':vacina' => $idVacina,
                        ':enfermeiro' => $idEnfermeiro,
                        ':recepcionista' => $idRecepcionista
                    ]);

                    $mensagem = "✅ Consulta agendada com sucesso!";
                }
            } catch (PDOException $e) {
                $mensagem = "❌ Erro ao agendar consulta: " . $e->getMessage();
            }
        }
    }

    // 🧩 5. Carrega listas

    // Pacientes
    $pacientes = $conn->query("
        SELECT p.idPaciente, u.nomeUsuario
        FROM paciente p
        INNER JOIN usuario u ON p.idUsuario = u.idUsuario
        ORDER BY u.nomeUsuario ASC
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Vacinas
    $vacinases = $conn->query("
        SELECT idVacina, nomeVacina 
        FROM vacina 
        ORDER BY nomeVacina ASC
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Enfermeiros
    $enfermeiros = $conn->query("
        SELECT e.idEnfermeiro, u.nomeUsuario
        FROM enfermeiro e
        INNER JOIN funcionario f ON e.idFuncionario = f.idFuncionario
        INNER JOIN usuario u ON f.idUsuario = u.idUsuario
        ORDER BY u.nomeUsuario ASC
    ")->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $mensagem = "❌ Erro: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Agendar Vacinação</title>
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
</style>
</head>
<body>

<h1>Agendar Vacinação</h1>

<form method="POST" action="">
    <label for="dataAplicacao">Data Agendamento:</label>
    <input type="date" id="dataAplicacao" name="dataAplicacao" required>

    <label for="idPaciente">Paciente:</label>
    <select id="idPaciente" name="idPaciente" required>
        <option value="">Selecione o paciente...</option>
        <?php foreach ($pacientes as $p): ?>
            <option value="<?= htmlspecialchars($p['idPaciente']) ?>">
                <?= htmlspecialchars($p['nomeUsuario']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="idVacina">Vacina:</label>
    <select id="idVacina" name="idVacina" required>
        <option value="">Selecione a vacina...</option>
        <?php foreach ($vacinases as $v): ?>
            <option value="<?= htmlspecialchars($v['idVacina']) ?>">
                <?= htmlspecialchars($v['nomeVacina']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="idEnfermeiro">Enfermeiro Responsável:</label>
    <select id="idEnfermeiro" name="idEnfermeiro" required>
        <option value="">Selecione o enfermeiro...</option>
        <?php foreach ($enfermeiros as $e): ?>
            <option value="<?= htmlspecialchars($e['idEnfermeiro']) ?>">
                <?= htmlspecialchars($e['nomeUsuario']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Agendar</button>
</form>

<?php if ($mensagem): ?>
    <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<div class="botao-container">
    <a href="../../views/recepcionista/menu_recepcionista.php" class="voltar">⬅ Voltar</a>
</div>

</body>
</html>
