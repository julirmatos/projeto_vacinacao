<?php
if (!isset($_SESSION)) {
    session_start();
}

$tipo = $_SESSION['tipoUsuario'] ?? null;
?>

<nav>
    <ul>
        <?php if ($tipo == 'recepcionista'): ?>
            <li><a href="agendamentos.php">📅 Gerenciar Agendamentos</a></li>
            <li><a href="pacientes.php">🧍 Consultar Pacientes</a></li>

        <?php elseif ($tipo == 'enfermeiro'): ?>
            <li><a href="vacinacoes.php">💉 Registrar Vacinação</a></li>
            <li><a href="historico.php">📋 Histórico de Vacinações</a></li>

        <?php elseif ($tipo == 'farmaceutico'): ?>
            <li><a href="vacinas.php">💊 Gerenciar Vacinas</a></li>
            <li><a href="lotes.php">📦 Gerenciar Lotes</a></li>

        <?php elseif ($tipo == 'funcionario'): ?>
            <li><a href="usuarios.php">👥 Gerenciar Usuários</a></li>

        <?php elseif ($tipo == 'paciente'): ?>
            <li><a href="meuAgendamento.php">📅 Meus Agendamentos</a></li>
            <li><a href="minhasVacinacoes.php">💉 Minhas Vacinações</a></li>
        <?php endif; ?>

        <li><a href="auth/logout.php">🚪 Sair</a></li>
    </ul>
</nav>
