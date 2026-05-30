<?php
session_start();
require "conexao.php";

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}


// Contadores simples
$totalClientes = $conexao->query("SELECT COUNT(*) FROM tabela_clientes")->fetchColumn();
$totalPacotes = $conexao->query("SELECT COUNT(*) FROM tabela_pacotes")->fetchColumn();
$totalReservas = $conexao->query("SELECT COUNT(*) FROM tabela_reservas")->fetchColumn();

$ultimasReservas = $conexao->query("
    SELECT 
        tabela_reservas.*,
        tabela_clientes.nome AS cliente,
        tabela_pacotes.destino AS pacote
    FROM tabela_reservas
    INNER JOIN tabela_clientes 
        ON tabela_reservas.cliente = tabela_clientes.id_cliente
    INNER JOIN tabela_pacotes 
        ON tabela_reservas.pacote= tabela_pacotes.id_pacote
    ORDER BY tabela_reservas.id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Viagens</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-amber-50 font-sans">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-blue-950 shadow-lg flex flex-col justify-between">

            <div>
                <!-- Logo -->
                <div class="p-6  text-amber-500">
                    <h1 class="text-3xl font-bold text-white">Viagem<span class="text-amber-500">Tech</span></h1>
                    <p class="text-sm text-white">Sistema de Viagens</p>
                </div>

                <!-- Menu -->
                <nav class="mt-6 text-slate-950">

                    <a href="index.php" class="flex items-center px-6 py-3 bg-amber-500 text-white rounded-r-full">
                        <i data-feather="home" class="w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>

                    <a href="crud_cliente/index.php"
                        class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 text-white rounded-r-full">
                        <i data-feather="users" class="w-5 h-5 mr-3"></i>
                        Clientes
                    </a>

                    <a href="crud_pacotes/index.php"
                        class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 text-white rounded-r-full">
                        <i data-feather="briefcase" class="w-5 h-5 mr-3"></i>
                        Pacotes
                    </a>

                    <a href="crud_reservas/index.php"
                        class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 text-white rounded-r-full">
                        <i data-feather="calendar" class="w-5 h-5 mr-3"></i>
                        Reservas
                    </a>
                </nav>

                <!-- Rodapé Sidebar -->
                <div class="p-6 items-center">
                    <a href="../logout.php"
                        class="flex items-center px-10 py-3 text-white bg-amber-600 hover:bg-amber-700 rounded-xl mt-60 max-w-40">
                        <i data-feather="log-out" class="w-5 h-5 mr-3"></i>
                        Sair
                    </a>
                </div>

            </div>


        </aside>

        <!-- Conteúdo -->
        <main class="flex-1 p-8 ">

            <!-- Topo -->

            <div class="flex justify-between items-center  mb-10">

                <div>
                    <h2 class="text-4xl font-bold text-blue-950">Dash<span class="text-amber-500">board</span></h2>
                    <p class="text-blue-950 ">Bem-vindo ao sistema de gerenciamento de viagens.</p>
                </div>

                <!-- Busca -->
                <div class="relative w-80">
                    <input type="text" placeholder="Buscar..."
                        class="w-full border rounded-xl py-3 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <i data-feather="search" class="absolute left-3 top-3.5 w-5 h-5 text-amber-500"></i>
                </div>

            </div>

            <!-- HERO VIDEO -->
            <div class="relative w-full h-[380px] rounded-3xl overflow-hidden shadow-xl mt-6">

                <!-- VIDEO -->
                <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
                    <source src="videos/praia.mp4" type="video/mp4">
                </video>

                <!-- OVERLAY ESCURO -->
                <div class="absolute inset-0 bg-black/45"></div>

                <!-- CONTEÚDO -->
                <div class="relative z-10 flex flex-col justify-center h-full px-14 text-white">

                    <span class="bg-orange-500 text-white px-4 py-2 rounded-full w-fit text-sm font-semibold mb-4">
                        Explore o mundo
                    </span>

                    <h1 class="text-5xl font-extrabold leading-tight max-w-2xl">
                        Descubra destinos incríveis
                        com a <span class="text-orange-400">ViagemTech</span>
                    </h1>

                    <p class="mt-5 text-lg text-gray-200 max-w-xl">
                        Os melhores pacotes de viagens nacionais e internacionais.
                        Viva experiências inesquecíveis.
                    </p>
                    <!-- BOTÕES -->
                    <div class="flex gap-4 mt-8">

                        <a href="crud_pacotes/index.php"
                            class="bg-orange-500 hover:bg-orange-600 transition px-7 py-3 rounded-xl font-semibold shadow-lg">
                            Ver Pacotes
                        </a>

                    </div>

                </div>

            </div>
            <br>
            <br>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 ">

                <!-- Clientes -->
                <div class="bg-white rounded-2xl shadow-sm p-6 flex justify-between items-center border-2 border-white rounded-2xl p-6 hover:border-amber-500
                transition-all duration-200">

                    <div>

                        <p class="text-gray-500">Clientes Cadastrados</p>
                        <h3 class="text-4xl font-bold mt-2"><?= $totalClientes ?></h3>
                    </div>

                    <div class="bg-amber-100 p-4 rounded-xl">
                        <i data-feather="users" class="text-amber-500"></i>
                    </div>
                </div>

                <!-- Pacotes -->
                <div class="bg-white rounded-2xl shadow-sm p-6 flex justify-between items-center border-2 border-white rounded-2xl p-6 hover:border-amber-500
                transition-all duration-200">
                    <div>
                        <p class="text-gray-500">Pacotes Ativos</p>
                        <h3 class="text-4xl font-bold mt-2"><?= $totalPacotes ?></h3>
                    </div>
                    <div class="bg-amber-100 p-4 rounded-xl">
                        <i data-feather="briefcase" class="text-amber-500"></i>
                    </div>
                </div>

                <!-- Reservas -->
                <div class="bg-white rounded-2xl shadow-sm p-6 flex justify-between items-center border-2 border-white rounded-2xl p-6 hover:border-amber-500
                transition-all duration-200">
                    <div>
                        <p class="text-gray-500">Reservas do Mês</p>
                        <h3 class="text-4xl font-bold mt-2"><?= $totalReservas ?></h3>
                    </div>
                    <div class="bg-amber-100 p-4 rounded-xl">
                        <i data-feather="calendar" class="text-amber-500"></i>
                    </div>
                </div>

            </div>




            <!-- Últimas Reservas -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="p-6 border-b bg-blue-950 flex justify-between items-center">
                    <h3 class="text-2xl text-white font-bold">Últimas Reservas</h3>

                    <a href="crud_reservas/index.php"
                        class=" bg-amber-500 text-white hover:bg-amber-600 px-5 py-3 rounded-xl flex items-center">
                        <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                        Nova Reserva
                    </a>
                </div>

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="p-4 text-left">Cliente</th>
                                <th class="p-4 text-left">Pacote</th>
                                <th class="p-4 text-left">Data reserva</th>
                                <th class="p-4 text-left">Data viagem</th>
                                <th class="p-4 text-left">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($reserva = $ultimasReservas->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4"><?= $reserva['cliente'] ?></td>
                                <td class="p-4"><?= $reserva['pacote'] ?></td>
                                <td class="p-4"><?=date("d/m/Y", strtotime($reserva['data_reserva'])) ?>
                                </td>
                                <td class="p-4"><?=date("d/m/Y", strtotime($reserva['data_viagem'])) ?>
                                </td>

                                <!-- Status -->
                                <td class="p-4">

                                    <?php if($reserva['status'] == 'Confirmada'): ?>

                                    <span
                                        class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-medium">
                                        Confirmada
                                    </span>

                                    <?php elseif($reserva['status'] == 'Pendente'): ?>

                                    <span
                                        class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-medium">
                                        Pendente
                                    </span>

                                    <?php else: ?>

                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-medium">
                                        Cancelada
                                    </span>

                                    <?php endif; ?>

                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </main>

    </div>

    <script>
    feather.replace();
    </script>

</body>

</html>