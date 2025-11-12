<?php
require_once __DIR__ . '/../Models/Funcionario.php';
require_once __DIR__ . '/../../config/Conexao.php';

class FuncionarioDao {

    public static function create(Funcionario $func) {
        $conn = Conexao::getConnection();
        $sql = "INSERT INTO funcionario (idUsuario, matricula, cargoFuncionario, perfilFuncionario) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $func->getIdUsuario(),
            $func->getMatricula(),
            $func->getPerfilFuncionario()
        ]);
    }

    public static function readAll() {
        $conn = Conexao::getConnection();
        $sql = "SELECT * FROM funcionario f 
                JOIN usuario u ON f.idUsuario = u.idUsuario";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function readById($id) {
        $conn = Conexao::getConnection();
        $sql = "SELECT * FROM funcionario f 
                JOIN usuario u ON f.idUsuario = u.idUsuario
                WHERE f.idFuncionario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update(Funcionario $func) {
        $conn = Conexao::getConnection();
        $sql = "UPDATE funcionario SET matricula = ?, cargoFuncionario = ?, perfilFuncionario = ? 
                WHERE idFuncionario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $func->getMatricula(),
            $func->getPerfilFuncionario(),
            $func->getIdFuncionario()
        ]);
    }

    public static function delete($id) {
        $conn = Conexao::getConnection();
        $sql = "DELETE FROM funcionario WHERE idFuncionario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
    }
}
