<?php
session_start();   //iniciar a sessão para armazenar informações do usuário//
require "conexao.php";

//variável global do PHP que informa qual método HTTP

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);

    $stmt = $conexao->prepare("
        SELECT * FROM tabela_login
        WHERE email = :email
    ");

    $stmt->execute([
        ':email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

    if ($user && password_verify($senha, $user['senha'])) {

        $_SESSION['email'] = $user['email'];

        header("Location: index.php");
        exit;

    } else {
        $erro = "Email ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Sistema</title>
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
                    Faça login para acessar o sistema de viagens
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center bg-white">
            <div class="w-full max-w-sm">
                <div class="text-center mb-6">
                    <h2 class="text-4xl font-bold text-slate-700">Viagem<span class="text-amber-500">Tech</span></h2>
                    <p class="text-gray-500 text-amber-500 mt-2">Sistema de viagens</p>
                    <br>
                    <p class="text-lg font-semibold text-amber-500">Faça login para continuar</p>
                </div>

                <?php if (isset($_SESSION['sucesso'])) : ?>
                <div class="bg-green-100 text-green-700 border border-green-300 rounded-lg p-3 mb-4">
                    <?php
                    echo $_SESSION['sucesso'];
                    unset($_SESSION['sucesso']);
                    ?>
                </div>
                <?php endif; ?>

                <!-- Erro PHP //!empty() é  para verificar se um campo foi preenchido . -->
                <?php if (!empty($erro)) : ?>
                <div class="bg-amber-100 text-amber-600 border border-amber-300 rounded-lg p-3 mb-4">
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

                    <!-- Link de cadastro -->
                    <div class="text-center">
                        <a href="cadastro.php" class="text-amber-500 hover:underline">
                            Não tem uma conta? Cadastre-se
                        </a>
                    </div>

                    <!-- Botão -->
                    <button type="submit"
                        class=" pt-3 w-full bg-amber-500 hover:bg-amber-600 margin-top text-white py-4 rounded-xl font-medium text-lg transition">
                        Enter
                    </button>

                </form>
            </div>

        </div>
    </div>
</body>

</html>