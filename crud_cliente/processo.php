<?php 

require "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    $stmt=$conexao->prepare("INSERT INTO tabela_clientes (nome,cpf,telefone,email) VALUES (:nome,:cpf,:telefone,:email)");
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':cpf', $cpf);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':email', $email);

     if($stmt->execute()){ 
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao salvar";
    }

   
}





?>