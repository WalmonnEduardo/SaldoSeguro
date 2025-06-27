<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once(__DIR__."/../controller/ContaController.php");
if($_SESSION['id'] == null)
{
    header("Location: http://127.0.0.1/ifpr/lpw/contas/view/login.php");
    die;
}
if($_SERVER["REQUEST_METHOD"] === "GET")
{
    $erros = json_decode(file_get_contents(__DIR__."/../config/mensagens.json"),true);
}
$control = new ContaController();
$contas = $control->buscarTodos($_SESSION["id"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saldo Seguro</title>
    <link rel="shortcut icon" href="./img/moeda.png">
    <link rel="stylesheet" href="css/output.css"/>
</head>
<body class="h-screen w-screen">
<header>
    <div class="bg-[#4E1F00] h-[8dvh] flex justify-center items-center w-full">
        <form action="../controller/ClienteController.php" method="post" class="flex items-center">
            <input type="text" class="hidden" name="acao" value="sair">
            <button class="absolute left-4 self-center p-2 w-[150px] bg-[#C40C0C] hover:bg-[#7D0A0A] text-white rounded-xl text-center">Sair</button>
        </form>
        <h1 class="text-white text-3xl font-bold">Olá <?=$_SESSION['usuario']?></h1>
        <a href="cadastroConta.php" class="absolute right-4 self-center p-2 w-[150px] bg-[#85512D] hover:bg-[#74512D] text-white rounded-xl text-center">Cadastrar Conta</a>
    </div>
    <div class="bg-[#74512D] h-[4dvh] flex justify-center items-center w-full">
        <marquee class="w-1/3" scrollamount="12"><p class="text-white font-xl">Vamos organizar suas contas</p></marquee>
    </div>
</header>
<main class="bg-[#FEBA17] h-[80dvh] overflow-y-auto p-4 ">
    <div class="flex justify-center">
        <table>
            <tr>
                <th class="bg-[#74512D] border border-[#4E1F00] text-[#F8F4E1] p-2">Nome</th>
                <th class="bg-[#74512D] border border-[#4E1F00] text-[#F8F4E1] p-2">Valor(R$)</th>
                <th class="bg-[#74512D] border border-[#4E1F00] text-[#F8F4E1] p-2">Data de Vencimento</th>
                <th class="bg-[#74512D] border border-[#4E1F00] text-[#F8F4E1] p-2">Dias para o vencimento</th>
                <th class="bg-[#74512D] border border-[#4E1F00] text-[#F8F4E1] p-2">Importancia</th>
                <th class="bg-[#74512D] border border-[#4E1F00] text-[#F8F4E1] p-2">Tipo</th>
                <th class="bg-[#74512D] border border-[#4E1F00] text-[#F8F4E1] p-2">Excluir</th>
            </tr>
            <?php 
            if($contas != null)
            {
                foreach($contas as $conta)
                {
                    print $conta;
                }
            }
            ?>
        </table>
    </div>
</main>
<footer class="bg-[#4E1F00] h-[8dvh] flex justify-evenly items-center w-full">
    <div>
        <p class="text-white">Valor total: R$
            <?php 
                $vt = 0;
                if($contas != null)
                {
                    foreach($contas as $conta)
                    {
                        $vt+=$conta->getValor();
                    }
                }
                print number_format($vt , 2, ',', '.')
            ?>
        </p>
        <?php if(isset($_GET["msg"])):?>
            <p class="text-red-500 font-bold text-2xl"><?=$_GET["msg"] == 8 ? $erros["errosConta"][$_GET["msg"]]:""?></p>
        <?php endif;?>
    </div>
</footer>
<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>