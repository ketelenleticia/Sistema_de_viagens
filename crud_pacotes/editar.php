<?php
require "../conexao.php";

$id_pacote = $_GET['id_pacote'] ?? null;

if (!$id_pacote) {
    die("ID inválido");
}

// buscar
$stmt = $conexao->prepare("SELECT * FROM tabela_pacotes WHERE id_pacote= :id_pacote");
$stmt->execute([':id_pacote' => $id_pacote]);
$dado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dado) {
    die("Registro não encontrado");
}

// atualizar
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $conexao->prepare("UPDATE tabela_pacotes SET destino = :destino, imagem = :imagem, descricao = :descricao, preco = :preco, duracao = :duracao, data_saida = :data_saida WHERE id_pacote = :id_pacote");

    $stmt->execute([
        ':destino' => $_POST['destino'],
        ':imagem' => $_POST['imagem'],
        ':descricao' => $_POST['descricao'],
        ':preco' => $_POST['preco'],
        ':duracao' => $_POST['duracao'],
        ':data_saida' => $_POST['data_saida'],
         ':id_pacote' => $id_pacote
         
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pacote</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-amber-50 font-sans min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-950 shadow-lg flex flex-col justify-between">

        <div>
            <!-- Logo -->
            <div class="p-6">
                <h1 class="text-3xl font-bold text-white">Viagens<span class="text-amber-500">Tech</span></h1>
                <p class="text-sm text-blue-950">Sistema de Viagens</p>
            </div>

            <!-- Menu -->
            <nav class="mt-6">

                <a href="../index.php"
                    class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 rounded-r-full">
                    <i data-feather="home" class="w-5 h-5 mr-3"></i>
                    Dashboard
                </a>

                <a href="../crud_cliente/index.php"
                    class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 rounded-r-full">
                    <i data-feather="users" class="w-5 h-5 mr-3"></i>
                    Clientes
                </a>

                <a href="index.php" class="flex items-center px-6 py-3 bg-amber-500 text-white rounded-r-full">
                    <i data-feather="briefcase" class="w-5 h-5 mr-3"></i>
                    Pacotes
                </a>

                <a href="../crud_reservas/index.php"
                    class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 rounded-r-full">
                    <i data-feather="calendar" class="w-5 h-5 mr-3"></i>
                    Reservas
                </a>

            </nav>
        </div>

        <!-- Logout -->
        <div class="p-6 bg-amber-500">
            <a href="../logout.php" class="flex items-center text-white hover:text-amber-600">
                <i data-feather="log-out" class="w-5 h-5 mr-2"></i>
                Sair
            </a>
        </div>

    </aside>

    <!-- Conteúdo -->
    <main class="flex-1 p-10">

        <!-- Cabeçalho -->
        <div class="mb-8">
            <h2 class="text-4xl font-bold text-blue-950">Edi<span class="text-amber-500">tar</span></h2>
            <p class="text-blue-950">Atualize as informações do pacote de viagem.</p>
        </div>


        <!-- Formulário -->
        <div class="bg-white rounded-2xl shadow-sm p-8 max-w-6xl">

            <form method="POST" class="space-y-6">

                <!-- Destino -->
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">
                        Destino
                    </label>

                    <input type="text" name="destino" value="<?= $dado['destino'] ?>" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <!-- Descrição -->
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">
                        Descrição
                    </label>

                    <textarea name="descricao" rows="4" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500"><?= $dado['descricao'] ?></textarea>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Preço -->
                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">
                            Preço (R$)
                        </label>

                        <input type="number" step="0.01" name="preco" value="<?= $dado['preco'] ?>" required
                            class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <!-- Duração -->
                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">
                            Duração (dias)
                        </label>

                        <input type="number" name="duracao" value="<?= $dado['duracao'] ?>" required
                            class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <!-- Data -->
                    <div>
                        <label class="block text-slate-700 font-semibold mb-2">
                            Data de Saída
                        </label>

                        <input type="date" name="data_saida" value="<?= $dado['data_saida'] ?>" required
                            class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                </div>

                <!-- Imagem Atual -->
                <?php if(!empty($dado['imagem'])): ?>
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">
                        Imagem Atual
                    </label>

                    <img src="../assets/<?= $dado['imagem'] ?>" class="w-48 h-32 object-cover rounded-xl">
                </div>
                <?php endif; ?>

                <!-- Nova Imagem -->
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">
                        Alterar Imagem (opcional)
                    </label>

                    <input type="file" name="imagem" class="w-full border rounded-xl px-4 py-3 bg-white">
                </div>

                <!-- Botões -->
                <div class="flex gap-4 pt-4">

                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-xl shadow-md flex items-center">
                        <i data-feather="save" class="w-5 h-5 mr-2"></i>
                        Atualizar Pacote
                    </button>

                    <a href="index.php"
                        class="border border-gray-300 hover:bg-gray-100 text-gray-700 px-8 py-3 rounded-xl flex items-center">
                        <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i>
                        Voltar
                    </a>

                </div>

            </form>

        </div>

    </main>

    <script>
    feather.replace();
    </script>

</body>

</html>