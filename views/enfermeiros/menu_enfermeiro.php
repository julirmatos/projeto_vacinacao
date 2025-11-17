<?php
session_start();

// Garante que o enfermeiro está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../views/auth/login_perfil_funcionario.php");
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
    <title>Menu do Enfermeiro - Sistema de Vacinação</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #8EC5FC, #E0C3FC);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        header h1 {
            color: #2C3E50;
            margin-bottom: 5px;
        }

        header p {
            color: #34495E;
            font-size: 1rem;
        }

        /* === GRID DUAS COLUNAS + MENOR LARGURA === */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 35px;
            width: 70%;
            max-width: 850px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 30px 20px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.25);
        }

        .card h3 {
            color: #2C3E50;
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .card p {
            color: #555;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .card a {
            display: inline-block;
            background: linear-gradient(90deg, #007BFF, #00C6FF);
            color: #fff;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .card a:hover {
            background: linear-gradient(90deg, #0056b3, #0096FF);
        }

        .menu-buttons {
            display: flex;
            gap: 20px;
            margin-top: 50px;
        }

        .menu-buttons a {
            display: inline-block;
            background: linear-gradient(90deg, #007BFF, #00C6FF);
            color: #fff;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: background 0.3s ease;
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        .menu-buttons a:hover {
            background: linear-gradient(90deg, #0056b3, #0096FF);
        }

        @media (max-width: 800px) {
            .cards-container {
                grid-template-columns: 1fr;
                width: 90%;
            }
            .card {
                height: auto;
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
        <div class="card" onclick="window.location.href='../../views/vacinacao/consultar.php'">
            <h3>Consultar Vacinação Geral</h3>
            <p>Consulte todas as vacinas aplicadas.</p>
            <a href="/views/vacinacao/consultar.php">Consultar</a>
        </div>

        <div class="card" onclick="window.location.href='../../views/vacinas/consultar_vacinas.php'">
            <h3>Consultar Vacinas</h3>
            <p>Verifique doses, lotes e datas de vencimento.</p>
            <a href="/views/enfermeiros/consultar_vacinas.php">Consultar</a>
        </div>

        <div class="card" onclick="window.location.href='../../views/vacinacao/consultar_vacinacao_paciente.php'">
            <h3>Consultar Vacinas Aplicadas por Paciente</h3>
            <p>Consulte histórico vacinal individual.</p>
            <a href="/views/enfermeiros/consultar_vacinacao_paciente.php">Consultar</a>
        </div>

        <div class="card" onclick="window.location.href='../../views/enfermeiros/agendamentos_dia.php'">
            <h3>Agendamentos do Dia</h3>
            <p>Visualize todos os agendamentos de hoje.</p>
            <a href="/views/enfermeiros/agendamentos_dia.php">Ver Agenda</a>
        </div>
    </section>

    <div class="menu-buttons">
        <a href="/public/index.php">🏠 Início</a>
    </div>

</body>
</html>
