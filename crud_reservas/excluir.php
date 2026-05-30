<?php
require "../conexao.php";

$id_pacote = $_GET['id_pacote'] ?? null;

if ($id_pacote) {
    $stmt = $conexao->prepare("DELETE FROM tabela_reservas WHERE id_pacote = :id_pacote");
    $stmt->execute([
        ':id_pacote' => $id_pacote
    ]);
}

header("Location: index.php");
exit;
?>