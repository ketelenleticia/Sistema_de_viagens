<?php
require "../conexao.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID inválido.");
}

$stmt = $conexao->prepare("SELECT * FROM tabela_reservas WHERE id = ?");
$stmt->execute([$id]);
$reserva = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reserva) {
    die("Reserva não encontrada.");
}

$stmtClientes = $conexao->prepare("
    SELECT id_cliente, nome, email
    FROM tabela_clientes
    ORDER BY nome
");
$stmtClientes->execute();
$clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);


$stmtPacotes = $conexao->prepare("
    SELECT id_pacote, destino, data_saida
    FROM tabela_pacotes
    ORDER BY destino
");
$stmtPacotes->execute();
$pacotes = $stmtPacotes->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmtUpdate = $conexao->prepare("
        UPDATE tabela_reservas
        SET cliente = :cliente,
            pacote = :pacote,
            data_reserva = :data_reserva,
            data_viagem = :data_viagem,
            status = :status
        WHERE id = :id
    ");

    $stmtUpdate->execute([
        ':cliente' => $_POST['cliente'],
        ':pacote' => $_POST['pacote'],
        ':data_reserva' => $_POST['data_reserva'],
        ':data_viagem' => $_POST['data_viagem'],
        ':status' => $_POST['status'],
        ':id' => $id
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
    <title>Editar Reserva</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-amber-50 font-sans min-h-screen flex">



    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-blue-950 shadow-lg flex flex-col justify-between">

            <div>
                <!-- Logo -->
                <div class="p-6">
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

            <div class="p-6 bg-amber-500">
                <a href="../logout.php" class="flex items-center text-white hover:text-amber-600">
                    <i data-feather="log-out" class="w-5 h-5 mr-2"></i>
                    Sair
                </a>
            </div>

        </aside>

        <!-- Conteúdo -->
        <main class="flex-1 p-10">

            <!-- Título -->
            <div class="mb-8">
                <h2 class="text-4xl font-bold text-blue-950">Edi<span class="text-amber-500">tar</span></h2>
                <p class="text-blue-950">Atualize as informações da reserva.</p>

            </div>

            <!-- Card -->

            <div class="bg-white rounded-2xl shadow-sm p-8 w-[1150px]">


                <form method="POST" class="space-y-6">

                    <!-- Cliente -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Cliente
                        </label>

                        <select name="cliente" required
                            class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">

                            <?php foreach($clientes as $cliente): ?>
                            <option value="<?= $cliente['id_cliente'] ?>"
                                <?= ($cliente['id_cliente'] == $reserva['cliente']) ? 'selected' : '' ?>>

                                <?= $cliente['nome'] ?> - <?= $cliente['email'] ?>

                            </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- Pacote -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Pacote
                        </label>

                        <select name="pacote" id="pacote" required
                            class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">

                            <?php foreach($pacotes as $pacote): ?>
                            <option value="<?= $pacote['id_pacote'] ?>" data-saida="<?= $pacote['data_saida'] ?>"
                                <?= ($pacote['id_pacote'] == $reserva['pacote']) ? 'selected' : '' ?>>

                                <?= $pacote['destino'] ?> | Saída:
                                <?= date('d/m/Y', strtotime($pacote['data_saida'])) ?>

                            </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- Datas -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <!-- Data Reserva -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Data da Reserva
                            </label>

                            <input type="date" name="data_reserva" value="<?= $reserva['data_reserva'] ?>" required
                                class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <!-- Data Viagem -->
                        <div>
                            <label class=" block text-gray-700 font-semibold mb-2">
                                Data da Viagem
                            </label>

                            <input type="date" name="data_viagem" id="data_viagem"
                                value="<?= $reserva['data_viagem'] ?>" required
                                class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Status
                            </label>

                            <select name="status"
                                class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">

                                <option value="Pendente" <?= ($reserva['status'] == 'Pendente') ? 'selected' : '' ?>>
                                    Pendente
                                </option>

                                <option value="Confirmada"
                                    <?= ($reserva['status'] == 'Confirmada') ? 'selected' : '' ?>>
                                    Confirmada
                                </option>

                                <option value="Cancelada" <?= ($reserva['status'] == 'Cancelada') ? 'selected' : '' ?>>
                                    Cancelada
                                </option>

                                <option value="Concluída" <?= ($reserva['status'] == 'Concluída') ? 'selected' : '' ?>>
                                    Concluída
                                </option>

                            </select>
                        </div>

                    </div>

                    <!-- Botões -->
                    <div class="flex gap-6 pt-6">

                        <!-- Atualizar -->
                        <button type="submit"
                            class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-xl shadow-md flex items-center">
                            <i data-feather="save" class="w-6 h-6 mr-3"></i>
                            Atualizar
                        </button>

                        <!-- Voltar -->
                        <a href="index.php"
                            class="border border-gray-300 hover:bg-gray-100 text-gray-700 px-8 py-3 rounded-xl flex items-center">
                            <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i>
                            Voltar
                        </a>

                    </div>

                </form>

            </div>
    </div>


    </main>

    </div>

    <!-- Script -->
    <script>
    feather.replace();

    const pacoteSelect = document.getElementById("pacote");
    const dataViagem = document.getElementById("data_viagem");

    pacoteSelect.addEventListener("change", function() {

        const selectedOption = this.options[this.selectedIndex];
        const dataSaida = selectedOption.getAttribute("data-saida");

        if (dataSaida) {
            dataViagem.value = dataSaida;
        }

    });
    </script>

</body>

</html>