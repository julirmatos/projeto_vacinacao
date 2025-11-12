<?php
session_start();

// Garante que o enfermeiro está logado
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

        /* 🔹 Alinhamento em 3 colunas fixas */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            width: 90%;
            max-width: 1000px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.25);
        }

        .card h3 {
            color: #2C3E50;
            margin-bottom: 15px;
        }

        .card p {
            color: #555;
            font-size: 0.95rem;
            margin-bottom: 20px;
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
            margin-top: 40px;
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

        .menu-buttons a.sair {
            background: linear-gradient(90deg, #0056b3, #0096FF);
        }

        .menu-buttons a.sair:hover {
            background: linear-gradient(90deg, #004080, #0080FF);
        }

        @media (max-width: 900px) {
            .cards-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .cards-container {
                grid-template-columns: 1fr;
            }
            header h1 {
                font-size: 1.5rem;
            }
            .card {
                padding: 20px;
            }
            .menu-buttons {
                flex-direction: column;
                width: 80%;
                align-items: center;
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
        <!-- Card 1 -->
        <div class="card" onclick="window.location.href='../../views/vacinas/cadastrar.php'">
            <h3>💉 Cadastrar Vacinas</h3>
            <p>Inclua novas vacinas no sistema</p>
            <a href="../../views/vacinas/cadastrar.php">Cadastrar</a>
        </div>

        <!-- Card 2 -->
        <div class="card" onclick="window.location.href='../../views/vacina/consultar.php'">
            <h3>📋 Consultar Vacinas</h3>
            <p>Verifique doses, lotes e vencimentos</p>
            <a href="/views/farmaceuticos/consultar_vacinas.php">Consultar</a>
        </div>

        <!-- Card 3 -->
        <div class="card" onclick="window.location.href='../../views/vacina/alterar_vacinas.php'">
            <h3>🧾 Alterar Vacinas</h3>
            <p>Atualize doses, lotes e vencimentos</p>
            <a href="/views/farmaceuticos/alterar_vacinas.php">Alterar</a>
        </div>
    </section>

    <div class="menu-buttons">
        <a href="/public/index.php">🏠 Início</a>
        
    </div>

</body>
</html>
