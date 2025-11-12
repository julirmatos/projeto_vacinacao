<?php
session_start();
$nomeUsuario = $_SESSION['nomeUsuario'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador - Sistema de Vacinação</title>
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

        /* 🔹 Faixa azul no topo */
        header {
            background-color: #007BFF;
            color: white;
            width: 100%;
            padding: 20px 0;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.25);
        }

        .welcome {
            text-align: center;
            margin: 40px 0 30px;
        }

        .welcome h2 {
            color: #2C3E50;
            font-size: 1.6rem;
            margin-bottom: 5px;
        }

        .welcome p {
            color: #34495E;
            font-size: 1rem;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

        .sub-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }

        .sub-buttons a {
            background: linear-gradient(90deg, #007BFF, #00C6FF);
            color: #fff;
            border-radius: 25px;
            padding: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .sub-buttons a:hover {
            background: linear-gradient(90deg, #0056b3, #0096FF);
        }

        .menu-buttons {
            display: flex;
            gap: 20px;
            margin-top: 50px;
            margin-bottom: 40px;
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

        @media (max-width: 500px) {
            header {
                font-size: 1.3rem;
            }
            .card {
                padding: 20px;
            }
            .menu-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<header>
    Painel do Administrador
</header>

<div class="welcome">
    <h2>Bem-vindo(a), <?= htmlspecialchars($nomeUsuario) ?>!</h2>
    <p>Escolha uma das opções abaixo:</p>
</div>

<section class="cards-container">
    <!-- Card Usuários -->
    <div class="card">
        <h3>👥 Usuários</h3>
        <p>Gerencie cadastros, consultas e alterações de usuários.</p>
        <a href="../../views/usuarios/listar.php">Acessar</a>
    </div>

    <!-- Card Funcionários -->
    <div class="card">
        <h3>🏥 Funcionários</h3>
        <p>Gerencie os profissionais cadastrados no sistema.</p>
        <div class="sub-buttons">
            <a href="../../views/administradores/alterar_recepcionista.php">👩🏼‍💼 Recepcionista</a>
            <a href="../../views/administradores/alterar_farmaceutico.php">👩🏽‍🔬 Farmacêutico</a>
            <a href="../../views/administradores/alterar_enfermeiro.php">👩🏻‍⚕️ Enfermeiro</a>
        </div>
    </div>
</section>

<div class="menu-buttons">
    <a href="/public/index.php">🏠 Início</a>
    
</div>

</body>
</html>

