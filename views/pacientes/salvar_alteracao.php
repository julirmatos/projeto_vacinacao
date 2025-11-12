<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['idUsuario'];
    $endereco = $_POST['endereco'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=sistema_vacinacao;charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE usuario 
                SET endereco = :endereco, email = :email, telefone = :telefone
                WHERE idUsuario = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':endereco' => $endereco,
            ':email' => $email,
            ':telefone' => $telefone,
            ':id' => $id
        ]);

        // ✅ Redireciona com mensagem de sucesso
        header("Location: alterar_excluir.php?sucesso=1");
        exit;
    } catch (PDOException $e) {
        // ❌ Redireciona com mensagem de erro
        header("Location: alterar_excluir.php?erro=1");
        exit;
    }
}
?>
