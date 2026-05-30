<?php 
require "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destino = $_POST['destino'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $duracao = $_POST['duracao'];
    $data_saida = $_POST['data_saida'];

    $stmt=$conexao->prepare("INSERT INTO tabela_reservas (destino,descricao,preco,duracao,data_saida) VALUES (:destino,:descricao,:preco,:duracao,:data_saida)");
    $stmt->bindValue(':destino', $destino);
    $stmt->bindValue(':descricao', $descricao);
    $stmt->bindValue(':preco', $preco);
    $stmt->bindValue(':duracao', $duracao);
    $stmt->bindValue(':data_saida', $data_saida);

     if($stmt->execute()){ 
        header("Location:index.php");
    } else {
        echo "Erro ao salvar";
    }

   
}





?>