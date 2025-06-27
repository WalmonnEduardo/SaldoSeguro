<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $erros = json_decode(file_get_contents(__DIR__."/../config/mensagens.json"),true);
}
session_start();
$email = $_SESSION['guardaEmail'] ?? '';
$senha = $_SESSION['guardaSenha'] ?? '';
$nome = $_SESSION['guardaUsuario'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/moeda.png">
    <title>Saldo Seguro</title>
</head>
<body class="h-screen w-screen">
    <div class="h-[10dvh] w-full flex items-center justify-center relative bg-[#4E1F00]">
        <h1 class="titulo-ini text-3xl font-bold text-white">Cadastro</h1>
        <a href="login.php" class="absolute right-4 self-center p-2 w-[150px] bg-[#85512D] hover:bg-[#74512D] text-white rounded-xl text-center" ">Login</a>
    </div>
    <div class="inicial bg-[#FEBA17] h-[90dvh] overflow-hidden flex justify-center items-center">
        <form action="../controller/ClienteController.php" class="bg-[#74512D] h-[60dvh] w-[50dvw] rounded-3xl flex flex-col justify-center gap-10 items-center" method="POST">
            <div class="w-[90%] flex flex-col justify-center items-center">
                <label class="text-white text-2xl" for="senhaCliente">Nome:</label>
                <input type="text" class="w-[400px] h-[30px] p-4 rounded-2xl" name="nomeCliente" value="<?=$nome?>" autocomplete="off">
                <?php if(isset($_GET["msg"])): ?>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 3 ? $erros["errosCliente"][$_GET["msg"]]:""?></p>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 4 ? $erros["errosCliente"][$_GET["msg"]]:""?></p>
                <?php endif; ?>
            </div>    
            <div class="w-[90%] flex flex-col justify-center items-center">
                <label class="text-white text-2xl" for="emailCliente">Email:</label>
                <input type="text" class="w-[400px] h-[30px] p-4 rounded-2xl" name="emailCliente" value="<?=$email?>" autocomplete="off">
                <?php if(isset($_GET["msg"])): ?>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 2 ? $erros["errosCliente"][$_GET["msg"]]:""?></p>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 1 ? $erros["errosCliente"][$_GET["msg"]]:""?></p>
                <?php endif; ?>
            </div>
            <div class="w-[90%] flex flex-col justify-center items-center">
                <label class="text-white text-2xl" for="senhaCliente">Senha:</label>
                <div class="flex">
                    <input type="password" class="w-[350px] h-[30px] p-4 rounded-tl-2xl rounded-bl-2xl" id="senha" name="senhaCliente" value="<?=$senha?>" autocomplete="off">
                    <button type="button" onclick="alterar()" class="w-[50px] h-[30px] py-4 bg-[#4E1F00] rounded-tr-2xl rounded-br-2xl text-white flex justify-center items-center"><img class="visi" src="img/visibility.png" alt="visibility"></button>
                </div>
                <?php if(isset($_GET["msg"])): ?>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 5 ? $erros["errosCliente"][$_GET["msg"]]:""?></p>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 6 ? $erros["errosCliente"][$_GET["msg"]]:""?></p>
                <?php endif; ?>
            </div>
            <div>
                <button type="submit" class="text-white text-2xl bg-[#0B8457] hover:bg-[#096C47] p-2 rounded-2xl">Enviar</button>
            </div>
            <?php if(isset($_GET["msg"])): ?>
                <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 0 ? $erros["errosCliente"][$_GET["msg"]]:""?></p>
                <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 8 ? $erros["errosCliente"][$_GET["msg"]]:""?></p>
            <?php endif; ?>
            <input type="text" class="hidden" name="acao" value="insert">
        </form>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="./js/funcioPage.js"></script>
</body>
</html>