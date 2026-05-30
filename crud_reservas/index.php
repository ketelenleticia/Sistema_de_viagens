<?php
require "../conexao.php";

$stmt = $conexao->prepare("
    SELECT
        r.id,
        c.nome,
        c.email,
        p.destino,
        r.data_reserva,
        p.data_saida AS data_viagem,
        r.status
    FROM tabela_reservas r
    JOIN tabela_clientes c ON r.cliente = c.id_cliente
    JOIN tabela_pacotes p ON r.pacote = p.id_pacote
    ORDER BY r.id DESC
");

$stmt->execute();
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-amber-50 font-sans">

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

                    <a href="../crud_pacotes/index.php"
                        class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 rounded-r-full">
                        <i data-feather="briefcase" class="w-5 h-5 mr-3"></i>
                        Pacotes
                    </a>

                    <a href="index.php" class="flex items-center px-6 py-3 bg-amber-500 text-white rounded-r-full">
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
                    <h2 class="text-4xl font-bold text-blue-950">Reser<span class="text-amber-500">vas</span></h2>
                    <p class="text-blue-950">Gerencie as reservas cadastradas no sistema.</p>
                </div>

                <a href="adicionar.php"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl shadow-md flex items-center">
                    <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                    Nova Reserva
                </a>

            </div>

            <!-- Barra de busca -->
            <div class="bg-blue-950 p-4 rounded-2xl shadow-sm mb-6">
                <div class="relative w-96">
                    <input type="text" placeholder="Buscar por cliente ou destino..."
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
                            <th class="p-4 text-left">Cliente</th>
                            <th class="p-4 text-left">Email</th>
                            <th class="p-4 text-left">Destino</th>
                            <th class="p-4 text-left">Data Reserva</th>
                            <th class="p-4 text-left">Data Viagem</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach($reservas as $dado): ?>
                        <tr class="border-b hover:bg-gray-50">

                            <!-- ID -->
                            <td class="p-4">
                                <?= $dado['id'] ?>
                            </td>

                            <!-- Cliente -->
                            <td class="p-4 font-semibold text-gray-800">
                                <?= $dado['nome'] ?>
                            </td>

                            <!-- Email -->
                            <td class="p-4 text-gray-600">
                                <?= $dado['email'] ?>
                            </td>

                            <!-- Destino -->
                            <td class="p-4">
                                <?= $dado['destino'] ?>
                            </td>

                            <!-- Data Reserva -->
                            <td class="p-4">
                                <?= date('d/m/Y', strtotime($dado['data_reserva'])) ?>
                            </td>

                            <!-- Data Viagem -->
                            <td class="p-4">
                                <?= date('d/m/Y', strtotime($dado['data_viagem'])) ?>
                            </td>

                            <!-- Status -->
                            <td class="p-4">

                                <?php if($dado['status'] == 'Confirmada'): ?>

                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-medium">
                                    Confirmada
                                </span>

                                <?php elseif($dado['status'] == 'Pendente'): ?>

                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-medium">
                                    Pendente
                                </span>

                                <?php else: ?>

                                <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-medium">
                                    Cancelada
                                </span>

                                <?php endif; ?>

                            </td>

                            <!-- Ações -->
                            <td class="p-4">
                                <div class="flex gap-2">

                                    <a href="editar.php?id=<?= $dado['id'] ?>"
                                        class="border border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-white p-2 rounded-lg">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </a>

                                    <a href="excluir.php?id=<?= $dado['id'] ?>"
                                        onclick="return confirm('Deseja realmente excluir esta reserva?')"
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
                    Mostrando 1 a <?= count($reservas) ?> de <?= count($reservas) ?> reservas
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