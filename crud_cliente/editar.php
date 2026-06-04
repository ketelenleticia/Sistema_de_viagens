<?php
require "../conexao.php";

$id_cliente = $_GET['id_cliente'] ?? null;

if (!$id_cliente) {
    die("ID inválido");
}

// buscar
$stmt = $conexao->prepare("SELECT * FROM tabela_clientes WHERE id_cliente = :id_cliente");
$stmt->execute([':id_cliente' => $id_cliente]);
$dado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dado) {
    die("Registro não encontrado");
}

// atualizar
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $stmt = $conexao->prepare("UPDATE tabela_clientes  SET nome = :nome, cpf = :cpf, email = :email, telefone = :telefone 
        WHERE id_cliente = :id_cliente
    ");

    $stmt->execute([
        ':nome' => $_POST['nome'],
        ':cpf' => $_POST['cpf'],
        ':email' => $_POST['email'],
        ':telefone' => $_POST['telefone'],
        ':id_cliente' => $id_cliente
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
    <title>Editar Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!--Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-amber-50 font-sans min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-950 shadow-lg flex flex-col justify-between">

        <div>
            <!-- Logo -->
            <div class="p-6">
                <h1 class="text-3xl font-bold text-white">Viagens<span class="text-amber-500">Tech</span></h1>
                <p class="text-sm text-gray-500">Sistema de Viagens</p>
            </div>

            <!-- Menu -->
            <nav class="mt-6">

                <a href="../index.php"
                    class="flex items-center px-6 py-3 bg-blue-950 text-white hover:bg-blue-900 rounded-r-full">
                    <i data-feather="home" class="w-5 h-5 mr-3"></i>
                    Dashboard
                </a>

                <a href="index.php" class="flex items-center px-6 py-3 bg-amber-500 text-white rounded-r-full">
                    <i data-feather="users" class="w-5 h-5 mr-3"></i>
                    Clientes
                </a>

                <a href="../crud_pacotes/index.php"
                    class="flex items-center px-6 py-3 text-white bg-blue-950 hover:bg-blue-900 rounded-r-full">
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
    <main class="flex-1 p-10 ">

        <!-- Título -->
        <div class="mb-8">
            <h2 class="text-4xl font-bold text-blue-950">Edi<span class="text-amber-500">tar</span></h2>
            <p class="text-blue-950">Atualize as informações do cliente selecionado.</p>
        </div>

        <!-- Card Formulário -->
        <div class="bg-white rounded-2xl shadow-sm p-8 max-w-6xl">

            <form method="POST" class="space-y-6">

                <!-- Nome -->
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">
                        Nome Completo
                    </label>

                    <input type="text" name="nome" value="<?= $dado['nome'] ?>" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <!-- CPF -->
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">
                        CPF
                    </label>

                    <input type="text" name="cpf" value="<?= $dado['cpf'] ?>" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <!-- Telefone -->
                <div>
                    <label class="block text-slate-700 font-semibold mb-2">
                        Telefone
                    </label>

                    <input type="text" name="telefone" value="<?= $dado['telefone'] ?>" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Email
                    </label>

                    <input type="email" name="email" value="<?= $dado['email'] ?>" required
                        class="w-full border rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <!-- Botões -->
                <div class="flex gap-4 pt-4">

                    <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white px-8 py-3 rounded-xl shadow-md flex items-center">
                        <i data-feather="save" class="w-5 h-5 mr-2"></i>
                        Atualizar
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