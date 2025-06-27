<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__."/../controller/ClienteController.php");
require_once(__DIR__."/../controller/ContaController.php");
if (session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
}
if($_SESSION['id'] == null)
{
    header("Location: http://127.0.0.1/ifpr/lpw/contas/view/login.php");
};
if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $erros = json_decode(file_get_contents(__DIR__."/../config/mensagens.json"),true);
}
$conta = $_SESSION["guardaConta"] ?? '';
$data = $_SESSION["guardaData"] ?? '';
$imp = $_SESSION["guardaImportancia"] ?? '';
$tipo = $_SESSION["guardaTipo"] ?? '';
$valor = $_SESSION['guardaValor'] ?? '';
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
        <h1 class="titulo-ini text-3xl font-bold text-white">Cadastro da conta</h1>
        <a href="inicial.php" class="absolute right-4 self-center p-2 w-[150px] bg-[#85512D] hover:bg-[#74512D] text-white rounded-xl text-center" ">Voltar</a>
    </div>
    <div class="inicial bg-[#FEBA17] h-[90dvh] overflow-hidden flex justify-center items-center">
        <form action="../controller/ContaController.php" class="bg-[#74512D] h-[70dvh] w-[50dvw] rounded-3xl flex flex-col justify-center gap-10 items-center" method="POST">
            <div class="w-[90%] flex flex-col justify-center items-center">
                <label class="text-white text-2xl" for="nomeConta">Nome:</label>
                <input type="text" class="w-[400px] h-[30px] p-4 rounded-2xl" name="nomeConta" value="<?=$conta?>" autocomplete="off">
                <?php if(isset($_GET["msg"])):?>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 1 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 2 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
                <?php endif;?>
            </div>
            <div class="w-[90%] flex flex-col justify-center items-center">
                <label class="text-white text-2xl" for="valorConta">Valor:</label>
                <input type="number" class="w-[400px] h-[30px] p-4 rounded-2xl" name="valorConta" step="0.01" value="<?=$valor?>" autocomplete="off">
                <?php if(isset($_GET["msg"])):?>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 6 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 7 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
                <?php endif;?>
            </div>
            <div class="w-[90%] flex flex-col justify-center items-center">
                <label class="text-white text-2xl" for="data_vencimentoConta">Data de Vencimento:</label>
                <input type="date" class="w-[400px] h-[30px] p-4 rounded-2xl" name="data_vencimentoConta" value="<?=$data?>">
                <?php if(isset($_GET["msg"])):?>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 3 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
                <?php endif;?>
            </div>
            <div class="w-[90%] flex flex-col justify-center items-center">
                <label class="text-white text-2xl" for="importanciaConta">Importancia:</label>
                <select name="importanciaConta" id="importanciaConta" class="w-[400px] h-[30px] px-4 rounded-2xl">
                    <option value="" <?=$imp == "" ? "selected" :""?>>Selecione</option>
                    <option value="A" <?=$imp == "A" ? "selected" :""?>>Alta</option>
                    <option value="M" <?=$imp == "M" ? "selected" :""?>>Média</option>
                    <option value="B" <?=$imp == "B" ? "selected" :""?>>Baixa</option>
                </select>
                <?php if(isset($_GET["msg"])):?>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 4 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
                <?php endif;?>
            </div>
            <div class="w-[90%] flex flex-col justify-center items-center">
                <label class="text-white text-2xl" for="tipoConta">Tipo:</label>
                <select name="tipoConta" id="tipoConta" class="w-[400px] h-[30px] px-4 rounded-2xl">
                    <option value="" <?=$tipo == "" ? "selected" :""?>>Selecione</option>
                    <option value="M" <?=$tipo == "M" ? "selected" :""?>>Mercado</option>
                    <option value="L" <?=$tipo == "L" ? "selected" :""?>>Lazer</option>
                    <option value="S" <?=$tipo == "S" ? "selected" :""?>>Saúde</option>
                    <option value="F" <?=$tipo == "F" ? "selected" :""?>>Fixa</option>
                </select>
                <?php if(isset($_GET["msg"])):?>
                    <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 5 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
                <?php endif;?>
            </div>
            <div class="w-[90%] flex flex-col justify-center items-center hidden">
                <input type="text" class="w-[400px] h-[25px]" name="id_cliente" value="<?=$_SESSION['id']?>">
            </div>
            <input type="hidden" class="hidden" name="acao" value="insert">
            <div>
                <button type="submit" class="text-white text-2xl bg-[#0B8457] hover:bg-[#096C47] p-2 rounded-2xl">Enviar</button>
            </div>
            <?php if(isset($_GET["msg"])):?>
                <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 0 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
                <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 8 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
            <?php endif;?>
        </form>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="./js/funcioPage.js"></script>
</body>
</html>