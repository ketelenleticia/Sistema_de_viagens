<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Ícones -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-amber-50 font-sans">

    <?php
require "../conexao.php";

$stmt = $conexao->prepare("SELECT * FROM tabela_clientes");
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-blue-950 shadow-lg flex flex-col justify-between">
            <div>
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-white">Viagem<span class="text-amber-500">Tech</span></h1>
                    <p class="text-sm text-white">Sistema de Viagens</p>
                </div>

                <nav class="mt-6">
                    <a href="../index.php"
                        class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 rounded-r-full">
                        <i data-feather="home" class="w-5 h-5 mr-3"></i> Dashboard
                    </a>

                    <a href="index.php" class="flex items-center px-6 py-3 bg-amber-500 text-white rounded-r-full">
                        <i data-feather="users" class="w-5 h-5 mr-3"></i> Clientes
                    </a>

                    <a href="../crud_pacotes/index.php"
                        class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 rounded-r-full">
                        <i data-feather="briefcase" class="w-5 h-5 mr-3"></i> Pacotes
                    </a>

                    <a href="../crud_reservas/index.php"
                        class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 rounded-r-full">
                        <i data-feather="calendar" class="w-5 h-5 mr-3"></i> Reservas
                    </a>
                </nav>
            </div>

            <div class="p-6 bg-amber-500">
                <a href="../logout.php" class="flex items-center text-white hover:text-amber-600">
                    <i data-feather="log-out" class="w-5 h-5 mr-2"></i> Sair
                </a>
            </div>
        </aside>


        <main class="flex-1 p-8">

            <!-- Topo -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-4xl font-bold text-blue-950">Clien<span class="text-amber-500">tes</span></h2>
                    <p class="text-blue-950">Gerencie seus clientes cadastrados no sistema.</p>
                </div>

                <a href="adicionar.php"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl shadow-md flex items-center">
                    <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                    Novo Cliente
                </a>
            </div>

            <!-- Barra de pesquisa -->
            <div class="bg-blue-950 p-4 rounded-2xl shadow-sm mb-6 flex justify-between items-center">
                <div class="relative w-96">
                    <input type="text" placeholder="Buscar por nome, CPF ou email..."
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
                            <th class="p-4 text-left">Nome</th>
                            <th class="p-4 text-left">CPF</th>
                            <th class="p-4 text-left">Telefone</th>
                            <th class="p-4 text-left">Email</th>
                            <th class="p-4 text-left">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!--imagem de perfil circular com as iniciais do nome do cliente, usando a primeira letra -->
                        <?php foreach($clientes as $dado): ?>
                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-4"><?= $dado['id_cliente'] ?></td>


                            <td class="p-4 flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-amber-100 text-amber-500 flex items-center justify-center font-bold">
                                    <?= strtoupper(substr($dado['nome'],0,1)) ?>
                                </div>
                                <?= $dado['nome'] ?>
                            </td>

                            <td class="p-4"><?= $dado['cpf'] ?></td>

                            <td class="p-4"><?= $dado['telefone'] ?></td>

                            <td class="p-4"><?= $dado['email'] ?></td>

                            <td class="p-4">
                                <div class="flex gap-2">

                                    <a href="editar.php?id_cliente=<?= $dado['id_cliente'] ?>"
                                        class="border border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-white p-2 rounded-lg">
                                        <i data-feather="edit" class="w-4 h-4"></i>
                                    </a>

                                    <a href="excluir.php?id_cliente=<?= $dado['id_cliente'] ?>"
                                        onclick="return confirm('Deseja realmente excluir este cliente?')"
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
                    Mostrando 1 a <?= count($clientes) ?> de <?= count($clientes) ?> clientes
                </div>
            </div>

        </main>

    </div>

    <script>
    feather.replace();
    </script>

</body>

</html>