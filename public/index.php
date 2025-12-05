<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Sistema de Vacinação</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e6f0ff, #ffffff);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            min-height: 100vh;
            margin: 0;
        }

        
        header {
            background-color: #007BFF;
            color: white;
            width: 100%;
            padding: 32px 0;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.25);
        }

        h1 {
            color: #0056b3;
            margin-top: 10px;
            text-align: center;
        }

        
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .cards {
            display: flex;
            gap: 60px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 60px; 
        }

        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 240px;
            height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 25px;
            text-align: center;
            transition: 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-top: 10px;
        }

        h2 {
            font-size: 20px;
            color: #0056b3;
        }

        a.btn {
            background-color: #0056b3;
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
            display: inline-block;
        }

        a.btn:hover {
            background-color: #004494;
            transform: scale(1.05);
        }

        /* 🔹 Rodapé fixo */
        footer {
            background-color: #007BFF;
            color: white;
            width: 100%;
            padding: 15px 0;
            text-align: center;
            font-size: 1rem;
            font-weight: bold;
            box-shadow: 0px -3px 8px rgba(0,0,0,0.25);
            position: fixed;
            bottom: 0;
            left: 0;
        }

        .copyright {
            font-size: 16px;
            color: white;
        }
    </style>
</head>
<body>

    <header></header>

    <div class="main-content">
        <h1>Bem-vindo ao Sistema de Vacinação 💉</h1>

        <div class="cards">
            <!-- Paciente -->
            <div class="card">
                <img src="../src/img/paciente.png" alt="Paciente">
                <h2>Sou Paciente</h2>
                <a href="/views/auth/login_paciente.php" class="btn">Login</a>
            </div>

            <!-- Funcionário -->
            <div class="card">
                <img src="../src/img/carteira-de-identidade.png" alt="Funcionário">
                <h2>Sou Funcionário</h2>
                <a href="/views/auth/login_perfil_funcionario.php" class="btn">Login</a>
            </div>

            <!-- Administrador -->
            <div class="card">
                <img src="../src/img/administracao.png" alt="Administrador">
                <h2>Sou Administrador</h2>
                <a href="/views/auth/login_admin.php" class="btn">Login</a>
            </div>
        </div>
    </div>

    <footer>
        <div class="copyright">
            Sistema Vacinação - I.F.S.P - GRU - © 2025 - Desenvolvido por Juliana Matos 
        </div>
    </footer>

</body>
</html>
