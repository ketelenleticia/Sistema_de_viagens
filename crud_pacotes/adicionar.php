<?php

require "../conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $destino = $_POST['destino'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $duracao = $_POST['duracao'];
    $data_saida = $_POST['data_saida'];

    

    // Salva no banco

    $stmt = $conexao->prepare("
    INSERT INTO tabela_pacotes 
    (destino, descricao, preco, duracao, data_saida) 
    VALUES 
    (:destino, :descricao, :preco, :duracao, :data_saida)
    ");

    $stmt->execute([
    ':destino'   => $destino,
    ':descricao' => $descricao,
    ':preco'     => $preco,
    ':duracao'   => $duracao,
    ':data_saida'=> $data_saida
    ]);

    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Pacote</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-950 min-h-screen flex items-center justify-center font-sans pt-4">

    <div class="w-full max-w-3xl bg-white rounded-3xl shadow-xl p-10">

        <!-- Título -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-blue-950 mb-8 text-center">
                Novo Pacote
            </h1>
            <p class="text-amber-500 mt-2">Preencha os dados do pacote para adicioná-lo ao sistema.</p>
        </div>

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data" class="space-y-6 ">

            <!-- Destino -->
            <div>
                <label class="block font-semibold mb-2">Destino</label>

                <input type="text" name="destino" placeholder="Ex: Paris, França" required
                    class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <!-- Descrição -->
            <div>
                <label class="block font-semibold mb-2">Descrição</label>

                <textarea name="descricao" rows="4" placeholder="Descreva o pacote..." required
                    class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Preço -->
                <div>
                    <label class="block font-semibold mb-2">Preço (R$)</label>

                    <input type="number" step="0.01" name="preco" placeholder="3500.00" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <!-- Duração -->
                <div>
                    <label class="block font-semibold mb-2">Duração (dias)</label>

                    <input type="number" name="duracao" placeholder="7" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <!-- Data -->
                <div>
                    <label class="block font-semibold mb-2">Data de Saída</label>

                    <input type="date" name="data_saida" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

            </div>



            <!-- Botões -->
            <div class="flex gap-4 pt-4">

                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-xl shadow-md">
                    Salvar Pacote
                </button>

                <a href="index.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-8 py-3 rounded-xl">
                    Voltar
                </a>

            </div>

        </form>



    </div>

</body>

</html>