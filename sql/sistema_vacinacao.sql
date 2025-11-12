-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/10/2025 às 15:05
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_vacinacao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `idAgendamento` int(11) NOT NULL,
  `dataAgendamento` date NOT NULL,
  `idPaciente` int(11) NOT NULL,
  `idVacina` int(11) DEFAULT NULL,
  `idRecepcionista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamento`
--

INSERT INTO `agendamento` (`idAgendamento`, `dataAgendamento`, `idPaciente`, `idVacina`, `idRecepcionista`) VALUES
(17, '2025-10-10', 1, 1, 18),
(23, '2025-10-10', 1, 1, 3),
(24, '2025-10-11', 2, 2, 14),
(25, '2025-10-12', 3, 3, 15),
(26, '2025-10-13', 1, 4, 16),
(27, '2025-10-14', 2, 5, 17);

-- --------------------------------------------------------

--
-- Estrutura para tabela `enfermeiro`
--

CREATE TABLE `enfermeiro` (
  `idEnfermeiro` int(11) NOT NULL,
  `idFuncionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enfermeiro`
--

INSERT INTO `enfermeiro` (`idEnfermeiro`, `idFuncionario`) VALUES
(9, 3),
(10, 4),
(11, 22),
(12, 23),
(13, 24),
(14, 25);

-- --------------------------------------------------------

--
-- Estrutura para tabela `farmaceutico`
--

CREATE TABLE `farmaceutico` (
  `idFarmaceutico` int(11) NOT NULL,
  `idFuncionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `farmaceutico`
--

INSERT INTO `farmaceutico` (`idFarmaceutico`, `idFuncionario`) VALUES
(7, 5),
(8, 26),
(9, 27),
(10, 28),
(11, 29);

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `idFuncionario` int(11) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `perfilFuncionario` enum('recepcionista','farmaceutico','enfermeiro') NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`idFuncionario`, `matricula`, `perfilFuncionario`, `idUsuario`) VALUES
(1, 'REC1101', 'recepcionista', 6),
(2, 'REC1102', 'recepcionista', 7),
(3, 'ENF1101', 'enfermeiro', 8),
(4, 'ENF1102', 'enfermeiro', 9),
(5, 'FAR1101', 'farmaceutico', 10),
(22, 'ENF007', 'enfermeiro', 22),
(23, 'ENF008', 'enfermeiro', 12),
(24, 'ENF009', 'enfermeiro', 19),
(25, 'ENF010', 'enfermeiro', 14),
(26, 'FAR002', 'farmaceutico', 15),
(27, 'FAR003', 'farmaceutico', 16),
(28, 'FAR004', 'farmaceutico', 17),
(29, 'FAR005', 'farmaceutico', 18),
(30, 'REC003', 'recepcionista', 13),
(31, 'REC004', 'recepcionista', 20),
(32, 'REC005', 'recepcionista', 21),
(33, 'REC006', 'recepcionista', 11);

-- --------------------------------------------------------

--
-- Estrutura para tabela `paciente`
--

CREATE TABLE `paciente` (
  `idPaciente` int(11) NOT NULL,
  `numCartaoSus` varchar(20) DEFAULT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `paciente`
--

INSERT INTO `paciente` (`idPaciente`, `numCartaoSus`, `idUsuario`) VALUES
(1, '1234567890001', 1),
(2, '1234567890002', 2),
(3, '1234567890003', 3),
(4, '1234567890004', 4),
(5, '1234567890005', 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `recepcionista`
--

CREATE TABLE `recepcionista` (
  `idRecepcionista` int(11) NOT NULL,
  `idFuncionario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `recepcionista`
--

INSERT INTO `recepcionista` (`idRecepcionista`, `idFuncionario`) VALUES
(3, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `cpfUsuario` char(11) NOT NULL,
  `dataNascimento` date NOT NULL,
  `endereco` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('paciente','funcionario') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nomeUsuario`, `cpfUsuario`, `dataNascimento`, `endereco`, `email`, `telefone`, `senha`, `tipo`) VALUES
(1, 'Maria Souza', '12345678901', '1985-02-10', 'Rua das Flores, 45', 'maria@email.com', '11987654321', '1234', 'paciente'),
(2, 'João Silva', '98765432100', '1990-05-20', 'Rua Central, 120', 'joao@email.com', '11981234567', '1234', 'paciente'),
(3, 'Ana Costa', '45678912300', '2000-03-18', 'Av. Paulista, 200', 'ana@email.com', '11999887766', '1234', 'paciente'),
(4, 'Ricardo Lima', '32165498700', '1987-10-15', 'Rua Verde, 33', 'ricardo@email.com', '11992223344', '1234', 'paciente'),
(5, 'Paula Mendes', '14725836900', '1975-11-25', 'Rua Azul, 77', 'paula@email.com', '11993335555', '1234', 'paciente'),
(6, 'Carla Torres', '11223344556', '1982-09-09', 'Rua Rosa, 12', 'carla@email.com', '11991112222', '1234', 'funcionario'),
(7, 'Fernanda Lopes', '22334455667', '1995-12-22', 'Rua das Acácias, 80', 'fernanda@email.com', '11998887711', '1234', 'funcionario'),
(8, 'Juliana Prado', '33445566778', '1989-06-06', 'Rua do Sol, 14', 'juliana@email.com', '11995554422', '1234', 'funcionario'),
(9, 'Bruna Ferreira', '44556677889', '1992-07-30', 'Rua das Oliveiras, 55', 'bruna@email.com', '11997776688', '1234', 'funcionario'),
(10, 'Carlos Nogueira', '55667788990', '1980-01-02', 'Rua Aroeira, 100', 'carlos@email.com', '11994443322', '1234', 'funcionario'),
(11, 'Ana Souza', '11111111111', '1985-03-12', 'Rua das Flores, 10', 'ana.souza@email.com', '11999990001', '1234', 'funcionario'),
(12, 'Bruno Lima', '22222222222', '1987-07-08', 'Rua Verde, 22', 'bruno.lima@email.com', '11999990002', '1234', 'funcionario'),
(13, 'Clara Martins', '33333333333', '1990-01-21', 'Rua Azul, 33', 'clara.martins@email.com', '11999990003', '1234', 'funcionario'),
(14, 'Diego Nunes', '44444444444', '1989-11-02', 'Rua Branca, 44', 'diego.nunes@email.com', '11999990004', '1234', 'funcionario'),
(15, 'Elaine Castro', '55555555555', '1986-05-16', 'Rua Rosa, 55', 'elaine.castro@email.com', '11999990005', '1234', 'funcionario'),
(16, 'Fábio Mendes', '66666666666', '1991-09-30', 'Rua Lilás, 66', 'fabio.mendes@email.com', '11999990006', '1234', 'funcionario'),
(17, 'Gustavo Rocha', '77777777777', '1983-02-10', 'Rua Central, 77', 'gustavo.rocha@email.com', '11999990007', '1234', 'funcionario'),
(18, 'Helena Prado', '88888888888', '1988-04-25', 'Rua Leste, 88', 'helena.prado@email.com', '11999990008', '1234', 'funcionario'),
(19, 'Igor Santos', '99999999999', '1992-12-19', 'Rua Oeste, 99', 'igor.santos@email.com', '11999990009', '1234', 'funcionario'),
(20, 'Juliana Reis', '10101010101', '1984-06-15', 'Rua Norte, 101', 'juliana.reis@email.com', '11999990010', '1234', 'funcionario'),
(21, 'Karina Alves', '12121212121', '1990-08-11', 'Rua Sul, 121', 'karina.alves@email.com', '11999990011', '1234', 'funcionario'),
(22, 'Luiz Torres', '13131313131', '1982-03-03', 'Rua Nova, 131', 'luiz.torres@email.com', '11999990012', '1234', 'funcionario');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vacina`
--

CREATE TABLE `vacina` (
  `idVacina` int(11) NOT NULL,
  `nomeVacina` varchar(100) NOT NULL,
  `vencimentoVacina` date DEFAULT NULL,
  `fabricanteVacina` varchar(100) DEFAULT NULL,
  `doseVacina` varchar(50) DEFAULT NULL,
  `intervaloVacina` int(11) DEFAULT NULL,
  `loteVacina` varchar(50) DEFAULT NULL,
  `disponibilidadeVacina` enum('Disponível','Indisponível') NOT NULL DEFAULT 'Disponível'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vacina`
--

INSERT INTO `vacina` (`idVacina`, `nomeVacina`, `vencimentoVacina`, `fabricanteVacina`, `doseVacina`, `intervaloVacina`, `loteVacina`, `disponibilidadeVacina`) VALUES
(1, 'HPV', '2026-05-10', 'Pfizer', '1', 180, 'L001', 'Disponível'),
(2, 'Gripe', '2025-12-15', 'Butantan', '1', 365, 'L002', 'Indisponível'),
(3, 'Hepatite B', '2027-04-01', 'Fiocruz', '3', 60, 'L003', 'Disponível'),
(4, 'Febre Amarela', '2026-11-20', 'Sanofi', '1', 3650, 'L004', 'Disponível'),
(5, 'COVID-19', '2026-07-15', 'Pfizer', '2', 120, 'L005', 'Disponível'),
(6, 'Sarampo', '2027-03-25', 'Fiocruz', '2', 30, 'L006', 'Disponível'),
(7, 'Poliomielite', '2028-01-12', 'Butantan', '3', 60, 'L007', 'Disponível'),
(8, 'Varicela', '2026-09-30', 'Sanofi', '2', 30, 'L008', 'Indisponível'),
(9, 'Tétano', '2027-06-18', 'Fiocruz', '1', 3650, 'L009', 'Disponível'),
(10, 'Meningite', '2028-05-05', 'Pfizer', '1', 365, 'L010', 'Disponível');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vacinacao`
--

CREATE TABLE `vacinacao` (
  `idVacinacao` int(11) NOT NULL,
  `dataAplicacao` date NOT NULL,
  `idPaciente` int(11) NOT NULL,
  `idVacina` int(11) NOT NULL,
  `idEnfermeiro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vacinacao`
--

INSERT INTO `vacinacao` (`idVacinacao`, `dataAplicacao`, `idPaciente`, `idVacina`, `idEnfermeiro`) VALUES
(61, '2025-10-07', 4, 10, 9),
(62, '2025-09-13', 2, 5, 10),
(63, '2025-10-03', 3, 10, 11),
(64, '2025-09-09', 2, 4, 12),
(65, '2025-10-05', 1, 1, 13),
(66, '2025-09-18', 3, 6, 14);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`idAgendamento`),
  ADD KEY `idPaciente` (`idPaciente`),
  ADD KEY `idRecepcionista` (`idRecepcionista`),
  ADD KEY `fk_agendamento_vacina` (`idVacina`);

--
-- Índices de tabela `enfermeiro`
--
ALTER TABLE `enfermeiro`
  ADD PRIMARY KEY (`idEnfermeiro`),
  ADD KEY `idFuncionario` (`idFuncionario`);

--
-- Índices de tabela `farmaceutico`
--
ALTER TABLE `farmaceutico`
  ADD PRIMARY KEY (`idFarmaceutico`),
  ADD KEY `idFuncionario` (`idFuncionario`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`idFuncionario`),
  ADD UNIQUE KEY `matricula` (`matricula`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`idPaciente`),
  ADD UNIQUE KEY `numCartaoSus` (`numCartaoSus`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `recepcionista`
--
ALTER TABLE `recepcionista`
  ADD PRIMARY KEY (`idRecepcionista`),
  ADD KEY `idFuncionario` (`idFuncionario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `cpfUsuario` (`cpfUsuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `vacina`
--
ALTER TABLE `vacina`
  ADD PRIMARY KEY (`idVacina`);

--
-- Índices de tabela `vacinacao`
--
ALTER TABLE `vacinacao`
  ADD PRIMARY KEY (`idVacinacao`),
  ADD KEY `idPaciente` (`idPaciente`),
  ADD KEY `idVacina` (`idVacina`),
  ADD KEY `idEnfermeiro` (`idEnfermeiro`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `idAgendamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `enfermeiro`
--
ALTER TABLE `enfermeiro`
  MODIFY `idEnfermeiro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `farmaceutico`
--
ALTER TABLE `farmaceutico`
  MODIFY `idFarmaceutico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `idFuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `paciente`
--
ALTER TABLE `paciente`
  MODIFY `idPaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `recepcionista`
--
ALTER TABLE `recepcionista`
  MODIFY `idRecepcionista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `vacina`
--
ALTER TABLE `vacina`
  MODIFY `idVacina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `vacinacao`
--
ALTER TABLE `vacinacao`
  MODIFY `idVacinacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamento`
--
ALTER TABLE `agendamento`
  ADD CONSTRAINT `agendamento_ibfk_1` FOREIGN KEY (`idPaciente`) REFERENCES `paciente` (`idPaciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agendamento_ibfk_2` FOREIGN KEY (`idRecepcionista`) REFERENCES `recepcionista` (`idRecepcionista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_agendamento_vacina` FOREIGN KEY (`idVacina`) REFERENCES `vacina` (`idVacina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `enfermeiro`
--
ALTER TABLE `enfermeiro`
  ADD CONSTRAINT `enfermeiro_ibfk_1` FOREIGN KEY (`idFuncionario`) REFERENCES `funcionario` (`idFuncionario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enfermeiro_funcionario` FOREIGN KEY (`idFuncionario`) REFERENCES `funcionario` (`idFuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `farmaceutico`
--
ALTER TABLE `farmaceutico`
  ADD CONSTRAINT `farmaceutico_ibfk_1` FOREIGN KEY (`idFuncionario`) REFERENCES `funcionario` (`idFuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `recepcionista`
--
ALTER TABLE `recepcionista`
  ADD CONSTRAINT `recepcionista_ibfk_1` FOREIGN KEY (`idFuncionario`) REFERENCES `funcionario` (`idFuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `vacinacao`
--
ALTER TABLE `vacinacao`
  ADD CONSTRAINT `vacinacao_ibfk_1` FOREIGN KEY (`idPaciente`) REFERENCES `paciente` (`idPaciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vacinacao_ibfk_3` FOREIGN KEY (`idVacina`) REFERENCES `vacina` (`idVacina`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vacinacao_ibfk_4` FOREIGN KEY (`idEnfermeiro`) REFERENCES `enfermeiro` (`idEnfermeiro`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
