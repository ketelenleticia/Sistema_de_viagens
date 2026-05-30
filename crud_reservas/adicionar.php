<?php
require "../conexao.php";


$stmtClientes = $conexao->prepare("
    SELECT id_cliente, nome, email
    FROM tabela_clientes
    ORDER BY nome ASC
");
$stmtClientes->execute();
$clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);


$stmtPacotes = $conexao->prepare("
    SELECT id_pacote, destino, data_saida
    FROM tabela_pacotes
    ORDER BY destino ASC
");
$stmtPacotes->execute();
$pacotes = $stmtPacotes->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cliente = $_POST['cliente'];
    $pacote = $_POST['pacote'];
    $data_reserva = $_POST['data_reserva'];
    $data_viagem = $_POST['data_viagem'];
    $status = $_POST['status'];

    $stmt = $conexao->prepare("
        INSERT INTO tabela_reservas
        (cliente, pacote, data_reserva, data_viagem, status)
        VALUES
        (:cliente, :pacote, :data_reserva, :data_viagem, :status)
    ");

    $stmt->execute([
        ':cliente' => $cliente,
        ':pacote' => $pacote,
        ':data_reserva' => $data_reserva,
        ':data_viagem' => $data_viagem,
        ':status' => $status
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
    <title>Adicionar Reserva</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-950 min-h-screen flex items-center justify-center font-sans pt-4">

    <div class="bg-white shadow-xl rounded-3xl p-10 w-full max-w-4xl">

        <!-- Título -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-blue-950 mb-8 text-center">
                Nova Reserva
            </h1>
            <p class="text-amber-500 mt-2">Preencha os dados da reserva para adicioná-la ao sistema.</p>
        </div>

        <!-- Formulário -->
        <form method="POST" class="space-y-6">

            <!-- Cliente -->
            <div>
                <label class="block font-semibold mb-2">
                    Cliente
                </label>

                <select name="cliente" required class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-amber-500">

                    <option value="">
                        Selecione um cliente
                    </option>

                    <?php foreach($clientes as $cliente): ?>
                    <option value="<?= $cliente['id_cliente'] ?>">
                        <?= $cliente['nome'] ?> - <?= $cliente['email'] ?>
                    </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- Pacote -->
            <div>
                <label class="block font-semibold mb-2">
                    Pacote
                </label>

                <select name="pacote" id="pacote" required
                    class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">

                    <option value="">
                        Selecione um pacote
                    </option>

                    <?php foreach($pacotes as $pacote): ?>
                    <option value="<?= $pacote['id_pacote'] ?>" data-saida="<?= $pacote['data_saida'] ?>">

                        <?= $pacote['destino'] ?> | Saída: <?= date('d/m/Y', strtotime($pacote['data_saida'])) ?>

                    </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- Datas + Status -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Data Reserva -->
                <div>
                    <label class="block font-semibold mb-2">
                        Data da Reserva
                    </label>

                    <input type="date" name="data_reserva" value="<?= date('Y-m-d') ?>" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <!-- Data Viagem -->
                <div>
                    <label class="block font-semibold mb-2">
                        Data da Viagem
                    </label>

                    <input type="date" name="data_viagem" id="data_viagem" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <!-- Status -->
                <div>
                    <label class="block font-semibold mb-2">
                        Status
                    </label>

                    <select name="status" class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-amber-500">

                        <option value="Pendente">
                            Pendente
                        </option>

                        <option value="Confirmada">
                            Confirmada
                        </option>

                        <option value="Cancelada">
                            Cancelada
                        </option>

                    </select>
                </div>

            </div>

            <!-- Aviso -->
            <div class="bg-amber-100 border border-amber-200 rounded-2xl p-4">
                <p class="text-sm text-amber-700">
                    Ao selecionar um pacote, a data da viagem será preenchida automaticamente com a data de saída.
                </p>
            </div>

            <!-- Botões -->
            <div class="flex gap-4 pt-4">

                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-xl shadow-md">
                    Salvar Reserva
                </button>

                <a href="index.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-xl">
                    Voltar
                </a>

            </div>

        </form>

    </div>


    <script>
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