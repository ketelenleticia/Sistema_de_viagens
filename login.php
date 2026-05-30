<?php
session_start();
require "conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);

    
    $stmt = $conexao->prepare("SELECT * FROM tabela_login WHERE email = :email AND senha = :senha");
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':senha', $senha);
    $stmt->execute();

    $user = $stmt->fetch();


    if($user){

     $_SESSION["email"] = $user["email"];

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

<body
    class="flex items-center justify-center min-h-screen bg-[url('https://thumbs.dreamstime.com/b/praia-t%C3%B3pica-4933786.jpg')] bg-cover bg-center bg-no-repeat p-4 relative">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-slate-200">


        <div class="px-14 py-12 flex flex-col justify-center">

            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold font-serif text-slate-800">ViagenTech</h2>
                <p class="text-gray-500 text-slate-600 mt-2">Sistema de viagens</p>
            </div>
            <!-- Título -->
            <div class="text-center mb-4">
                <h2 class="text-2xl font-bold font-serif text-slate-800">Login</h2>
            </div>

            <!-- Erro PHP -->
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
                    <a href="#" class="text-amber-500 hover:underline">
                        Desejar se cadastrar?
                    </a>
                </div>

                <!-- Botão -->
                <button type="submit"
                    class=" pt-3 w-full bg-amber-500 hover:bg-amber-600 margin-top text-white py-4 rounded-xl font-medium text-lg transition">
                    Enter
                </button>

            </form>

        </div>

</body>

</html>