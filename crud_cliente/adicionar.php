<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-950 min-h-screen flex items-center justify-center font-sans">

    <!--Principal -->
    <div class="w-full max-w-3xl bg-white rounded-3xl shadow-xl p-10">

        <!-- Título -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-blue-950">Cadastro de Clientes</h1>
            <p class="text-amber-500 mt-2">Preencha as informações do cliente para cadastro no sistema.</p>
        </div>

        <!-- Formulário -->
        <form action="processo.php" method="post" class="space-y-6">

            <!-- Nome -->
            <div>
                <label class="block text-slate-700 font-semibold mb-2">Nome Completo</label>
                <input type="text" name="nome" placeholder="Digite o nome completo..." required
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <!-- CPF -->
            <div>
                <label class="block text-slate-700 font-semibold mb-2">CPF</label>
                <input type="text" name="cpf" placeholder="000.000.000-00" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <!-- Telefone -->
            <div>
                <label class="block text-slate-700 font-semibold mb-2">Telefone</label>
                <input type="text" name="telefone" placeholder="(00) 00000-0000" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-slate-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" placeholder="cliente@email.com" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-between items-center pt-6">
                <a href="index.php"
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-2xl hover:bg-gray-300 transition">Voltar</a>

                <button type="submit"
                    class="px-8 py-3 bg-amber-500 text-white rounded-2xl hover:bg-amber-600 transition shadow-md">Salvar
                    Cliente</button>
            </div>

        </form>

    </div>

</body>

</html>