<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacotes de Viagem</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-amber-50 font-sans">

    <?php
require "../conexao.php";

$stmt = $conexao->prepare("SELECT * FROM tabela_pacotes");
$stmt->execute();
$pacotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-blue-950 shadow-lg flex flex-col justify-between">

            <div>
                <!-- Logo -->
                <div class="p-6 ">
                    <h1 class="text-3xl font-bold text-white">Viagem<span class="text-amber-500">Tech</span></h1>
                    <p class="text-sm text-white">Sistema de Viagens</p>
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

        <!-- Conteúdo Principal -->
        <main class="flex-1 p-8">

            <!-- Cabeçalho -->
            <div class="flex justify-between items-center mb-8">

                <div>
                    <h2 class="text-4xl font-bold text-blue-950">Paco<span class="text-amber-500">tes</span></h2>
                    <p class="text-blue-950">Gerencie os pacotes de viagem cadastrados no sistema.</p>
                </div>

                <a href="adicionar.php"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl shadow-md flex items-center">
                    <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                    Novo Pacote
                </a>

            </div>

            <!-- Barra de busca -->
            <div class="bg-blue-950 p-4 rounded-2xl shadow-sm mb-6">
                <div class="relative w-96">
                    <input type="text" placeholder="Buscar por destino ou descrição..."
                        class="w-full border rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <i data-feather="search" class="absolute left-3 top-3.5 w-5 h-5 text-amber-500"></i>
                </div>
            </div>

            <!-- Tabela -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <table class="w-full border-collapse">

                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Imagem</th>
                            <th class="p-4 text-left">Destino</th>
                            <th class="p-4 text-left">Descrição</th>
                            <th class="p-4 text-left">Preço</th>
                            <th class="p-4 text-left">Duração</th>
                            <th class="p-4 text-left">Data de Saída</th>
                            <th class="p-4 text-left">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach($pacotes as $dado): ?>
                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-4"><?= $dado['id_pacote'] ?></td>
                            <!-- Imagem -->
                            <td class="p-4">
                                <?php if(!empty($dado['imagem'])): ?>
                                <img src="../assets/<?= $dado['imagem'] ?>" alt="Imagem do pacote"
                                    class="w-20 h-14 object-cover rounded-lg shadow">
                                <?php else: ?>
                                <span class="text-gray-400">
                                    Sem imagem
                                </span>
                                <?php endif; ?>
                            </td>
                            <!-- Destino -->
                            <td class="p-4 font-semibold text-gray-800"><?= $dado['destino'] ?>
                            </td>
                            <td class="p-4 text-gray-600 max-w-xs"><?= $dado['descricao'] ?>
                            </td>
                            <td class="p-4 font-bold text-blue-900">R$
                                <?= number_format($dado['preco'], 2, ',', '.') ?>
                            </td>
                            <td class="p-4"><?= $dado['duracao'] ?> dias
                            </td>
                            <td class="p-4"><?= date('d/m/Y', strtotime($dado['data_saida'])) ?>
                            </td>

                            <!-- Ações -->
                            <td class="p-4">
                                <div class="flex gap-2">

                                    <a href="editar.php?id_pacote=<?= $dado['id_pacote'] ?>"
                                        class="border border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-white p-2 rounded-lg">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </a>

                                    <a href="excluir.php?id_pacote=<?= $dado['id_pacote'] ?>"
                                        onclick="return confirm('Deseja realmente excluir este pacote?')"
                                        class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-white p-2 rounded-lg">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </a>

                                </div>
                            </td>

                        </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>

                <!-- Rodapé -->
                <div class="p-4 text-amber-500">
                    Mostrando 1 a <?= count($pacotes) ?> de <?= count($pacotes) ?> pacotes
                </div>

            </div>

            <!-- Voltar -->
            <div class="mt-6">
                <a href="../index.php" class="text-amber-500 hover:underline flex items-center">
                    <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                    Voltar ao Dashboard
                </a>
            </div>

        </main>

    </div>

    <script>
    feather.replace();
    </script>

</body>

</html>