<?php
require "../conexao.php";

$id_cliente = $_GET['id_cliente'] ?? null;



if ($id_cliente) {  

    // Exclui as reservas do cliente
    $stmt = $conexao->prepare("DELETE FROM tabela_reservas WHERE cliente = :id_cliente");
    $stmt->execute([
        ':id_cliente' => $id_cliente
    ]);

    // Exclui o cliente
    $stmt = $conexao->prepare("DELETE FROM tabela_clientes WHERE id_cliente = :id_cliente");
    $stmt->execute([
        ':id_cliente' => $id_cliente
    ]);
}

header("Location: index.php");
exit;
?>