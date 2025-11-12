<?php
session_start();

// Garante que o recepcionista está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../views/vacinacao/consultar.php");
    exit;
}

$nome = $_SESSION['nomeUsuario'];
$idUsuario = $_SESSION['usuario_id'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menu do Recepcionista - Sistema de Vacinação</title>
<style>
body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: linear-gradient(135deg, #8EC5FC, #E0C3FC);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* ===== CABEÇALHO ===== */
header {
    text-align: center;
    margin: 50px 0 40px 0;
}
header h1 {
    color: #2C3E50;
    font-size: 2rem;
    margin-bottom: 5px;
}
header p {
    color: #34495E;
    font-size: 1.1rem;
}

/* ===== GRID DE CARDS ===== */
.cards-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 35px;
    width: 90%;
    max-width: 1100px;
    margin-bottom: 50px;
}

/* ===== CARD ===== */
.card {
    background: #fff;
    border-radius: 20px;
    padding: 30px 25px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 340px;
}
.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
}
.card h3 {
    color: #2C3E50;
    font-size: 1.3rem;
    margin-bottom: 10px;
}
.card p {
    color: #555;
    font-size: 0.9rem;
    margin: 5px 0 10px;
}
.card a {
    display: inline-block;
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    color: #fff;
    text-decoration: none;
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.card a:hover {
    background: linear-gradient(90deg, #0056b3, #0096FF);
    transform: scale(1.05);
}

/* ===== BOTÃO SAIR ===== */
.menu-buttons {
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
}
.menu-buttons a {
    background: linear-gradient(90deg, #007BFF, #00C6FF);
    color: #fff;
    text-decoration: none;
    padding: 12px 35px;
    border-radius: 30px;
    font-weight: 600;
    transition: background 0.3s ease, transform 0.2s ease;
    box-shadow: 0 6px 12px rgba(0,0,0,0.2);
}
.menu-buttons a:hover {
    background: linear-gradient(90deg, #0056b3, #0096FF);
    transform: translateY(-3px);
}

/* ===== RESPONSIVIDADE ===== */
@media (max-width: 992px) {
    .cards-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }
}
@media (max-width: 650px) {
    .cards-container {
        grid-template-columns: 1fr;
        width: 95%;
    }
    .card {
        height: auto;
    }
    header h1 {
        font-size: 1.6rem;
    }
}
</style>
</head>
<body>

<header>
    <h1>Bem-vindo(a), <?= htmlspecialchars($nome) ?>!</h1>
    <p>Escolha uma das opções abaixo:</p>
</header>

<section class="cards-container">
    <!-- 🩺 CONSULTAS -->
    <div class="card">
        <h3>👩🏻‍💻 Vacinação</h3>
        <a href="../../views/recepcionista/agendar_vacinacao.php">Agendar</a>
        <p>Agende novas aplicações de vacinas para pacientes.</p>
        <a href="../../views/recepcionista/consultar_agendamento.php">Consultar</a>
        <p>Consulte seus agendamentos.</p>
        <a href="../../views/recepcionista/alterar_vacinacao.php">Alterar / Cancelar</a>
        <p>Altere ou exclua um agendamento.</p>
    </div>

    <!-- 👨🏻 PACIENTES -->
    <div class="card">
        <h3>🧑🏻‍🦱 Pacientes</h3>
        <a href="../../views/pacientes/cadastrar.php">Cadastrar</a>
        <p>Cadastre um novo paciente.</p>
        <a href="../../views/pacientes/consultar.php">Consultar</a>
        <p>Consulte pacientes cadastrados.</p>
        <a href="../../views/pacientes/alterar_excluir.php">Alterar / Excluir</a>
        <p>Atualize ou remova um paciente.</p>
    </div>

    <!-- 💉 VACINAS -->
    <div class="card">
        <h3>🩹 Vacinas</h3>
        <p>Consulte vacinas já aplicadas e pacientes atendidos.</p>
        <a href="../../views/recepcionista/consultar_vacinacoes.php">Consultar</a>
        <p>Veja o histórico completo de vacinações.</p>
    </div>
</section>

<div class="menu-buttons">
    <a href="/public/index.php">🏠 Sair</a>
    
</div>

</body>
</html>

