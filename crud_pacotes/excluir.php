<?php
require "../conexao.php";

$id_pacote = $_GET['id_pacote'] ?? null;

if ($id_pacote) {
    
    // Exclui as reservas do cliente
    $stmt = $conexao->prepare("DELETE FROM tabela_reservas WHERE pacote = :id_pacote");
    $stmt->execute([
        ':id_pacote' => $id_pacote
    ]);
    
    // Exclui o cliente
    $stmt = $conexao->prepare("DELETE FROM tabela_pacotes WHERE id_pacote = :id_pacote");
    $stmt->execute([
        ':id_pacote' => $id_pacote
    ]);
}

header("Location: index.php");
exit;
?>