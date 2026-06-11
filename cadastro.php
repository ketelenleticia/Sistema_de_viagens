<?php
session_start();
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);

    // Verifica se o email já existe
    $verifica = $conexao->prepare(
        "SELECT email FROM tabela_login WHERE email = :email"
    );
//  O PHP procura esse email no banco.
    $verifica->execute([       
        ':email' => $email
    ]);

    if ($verifica->fetch()) {

        $erro = "Este email já está cadastrado.";

    } else {

        // Gera o hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conexao->prepare("
            INSERT INTO tabela_login (email, senha)
            VALUES (:email, :senha)
        ");

        $stmt->execute([
            ':email' => $email,
            ':senha' => $senhaHash
        ]);

        $_SESSION['sucesso'] = "Cadastro realizado com sucesso! Faça login.";

        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro do Sistema</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>
    <div class="flex h-screen">

        <!-- Lado esquerdo -->
        <div class="hidden md:flex w-1/2 relative">
            <img src="assets/imagem/avi3.jpg" alt="Avião" class="w-full h-full object-cover">

            <div class="absolute inset-0 bg-black/20"></div>

            <div class="absolute bottom-20 left-12 text-white">
                <h1 class="text-4xl font-bold">
                    Bem-vindo ao ViagemTech
                </h1>
                <p class="text-xl mt-2">
                    Faça seu cadastro para acessar o sistema de viagens
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center bg-white">
            <div class="w-full max-w-sm">
                <div class="text-center mb-6">
                    <h2 class="text-4xl font-bold text-slate-700">Viagem<span class="text-amber-500">Tech</span></h2>
                    <p class="text-gray-500 text-amber-500 mt-2">Sistema de viagens</p>
                    <br>
                    <p class="text-lg font-semibold text-amber-500">Faça seu cadastro para continuar</p>
                </div>


                <!-- Mensagem de erro -->
                <?php if (!empty($erro)) : ?>
                <div class="bg-red-100 text-red-700 border border-red-300 rounded-lg p-3 mb-4">
                    <?php echo $erro; ?>
                </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="" method="POST" class="space-y-5">

                    <!-- Email -->
                    <div>
                        <label class="block text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" placeholder="Digite seu email" required
                            class="w-full border-2 border-slate-300 rounded-xl  px-4 py-4 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <!-- Senha -->
                    <div>
                        <label class="block text-slate-700 mb-2">Senha</label>
                        <input type="password" name="senha" placeholder="Digite sua senha" required
                            class="w-full border border-slate-300 rounded-xl px-4 py-4 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <!-- Link de login -->
                    <div class="text-center">
                        <a href="login.php" class="text-amber-500 hover:underline">
                            Já tem uma conta? Faça login
                        </a>
                    </div>
                    <!-- Botão -->
                    <button type="submit"
                        class=" pt-3 w-full bg-amber-500 hover:bg-amber-600 margin-top text-white py-4 rounded-xl font-medium text-lg transition">
                        Cadastrar
                    </button>

                </form>
            </div>

        </div>
    </div>
</body>

</html>