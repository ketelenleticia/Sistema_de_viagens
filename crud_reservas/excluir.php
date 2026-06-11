<?php
require "../conexao.php";

$id = $_GET['id'] ?? null;

if ($id) {

    $stmt = $conexao->prepare("
        DELETE FROM tabela_reservas
        WHERE id = :id
    ");

    $stmt->execute([
        ':id' => $id
    ]);
}

header("Location: index.php");
exit;
?>