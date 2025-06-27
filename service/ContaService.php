<?php
require_once (__DIR__."/../model/Conta.php");
require_once (__DIR__."/../dao/ContaDAO.php");
class ContaService
{
    private Conta $conta;
    private ContaDAO $dao;
    private bool $erro;
    private array $posts;
    public function __construct($posts)
    {
        if (session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        $this->conta=new Conta();
        $this->dao=new ContaDAO();
        $this->erro=false;
        $this->posts = $posts;
    }
    public function verificaDadosCadastro()
    {
        $this->verificaNull();
        $nome = $this->verificaNome();
        $valor = $this->verificaValor();
        $data = $this->verificaData();
        $imp = $this->verificaImportancia();
        $tipo = $this->verificaTipo();
        $this->cadastro($nome,$valor,$tipo,$imp,$data);
    }
    public function cadastro($nome,$valor,$tipo,$imp,$data)
    {
        $this->conta->setNome($nome);
        $this->conta->setValor($valor);
        $this->conta->setTipo($tipo);
        $this->conta->setImportancia($imp);
        $this->conta->setData_vencimento($data);
        $this->conta->setId_cliente($this->posts["id_cliente"]);
        unset(
            $_SESSION["guardaConta"],
            $_SESSION["guardaValor"],
            $_SESSION["guardaImportancia"],
            $_SESSION["guardaTipo"],
            $_SESSION["guardaData"]
        );
        $this->dao->cadastroConta($this->conta);
        header("Location: ../view/cadastroConta.php");
        exit;
    }
    public function deletar()
    {
        require_once (__DIR__."/../util/Token.php");

        $token = $this->posts["token"] ?? null;
        $tokenManager = new Token();
        $id = $tokenManager->verificarToken($token);
        if ($id == false)
        { 
            $msg = 8;
            $this->voltar($msg,"delete");
        }
        if($this->dao->selectContaCliente($_SESSION['id'],$id) == null)
        {
            $msg = 8;
            $this->voltar($msg,"delete");
        }
        $this->conta->setId($id);
        $this->dao->deleteConta($this->conta->getId());
        $tokenManager->limparTokens();
        header("Location: ../view/inicial.php");
        exit;
    }
    public function buscarTodos($id)
    {
        $idCliente = $id;
        return $this->dao->selectAllContaCliente($idCliente);
    }
    public function verificaNull()
    {
        foreach($this->posts as $p)
        {
            if($p == "" || $p == null)
            {
                $this->erro = true;
                $msg = 0;
                $this->voltar($msg,"cadastro");
            }
        }
        

    }
    public function verificaNome()
    {
        $nome = trim($this->posts["nomeConta"]);
        if(strlen($nome) < 3)
        {
            $this->erro = true;
            $msg = 1;
        }
        if(strlen($nome) > 50)
        {
            $this->erro = true;
            $msg = 2;
        }
        if($this->erro)
        {
            $this->voltar($msg,"cadastro");
        }
        return $nome;
        
    }
    public function verificaValor()
    {
        $valor = $this->posts["valorConta"];
        if(!is_numeric($valor))
        {
            $this->erro = true;
            $msg = 8;
        }  
        else if($valor <= 0)
        {
            $this->erro = true;
            $msg = 6;
        }
        else if($valor > 999999999999999.99)
        {
            $this->erro = true;
            $msg = 7;
        }
        if($this->erro)
        {
            $this->voltar($msg,"cadastro");
        }
        return $valor;
    }
    public function verificaData()
    {
        $data = $_POST["data_vencimentoConta"];
        $data1 = new DateTime($data);
        $data2 = new DateTime(date("Y-m-d"));
        if ($data1 < $data2)
        {
            $this->erro = true;
            $msg = 3;
            $this->voltar($msg,"cadastro");
        }
        return $data;
    }
    public function verificaImportancia()
    {
        $importacia = trim($_POST["importanciaConta"]);
        if(strlen($importacia) > 1 || strlen($importacia) < 1)
        {
            $this->erro = true;
            $msg = 4;
            $this->voltar($msg,"cadastro");
        }
        $l = ["A","M","B"];
        $v = false;
        foreach($l as $c)
        {
            if($c == $importacia)
            {
                $v = true;
            }
        }
        if(!$v)
        {
            $this->erro = true;
            $msg = 8;
            $this->voltar($msg,"cadastro");
        }
    
        return $importacia;
    }
    public function verificaTipo()
    {
        $tipo = trim($_POST["tipoConta"]);
        if(strlen($tipo) > 1 || strlen($tipo) < 1 )
        {
            $this->erro = false;
            $msg = 5;
            $this->voltar($msg,"cadastro");
        }
        $l = ["L","M","S","F"];
        $v = false;
        foreach($l as $c)
        {
            if($c == $tipo)
            {
                $v = true;
            }
        }
        if(!$v)
        {
            $this->erro = true;
            $msg = 8;
            $this->voltar($msg,"cadastro");
        }
        return $tipo;
    }
    public function voltar($msg,$pag)
    {
        if($pag == "cadastro")
        {
            $_SESSION["guardaConta"] = $this->posts["nomeConta"];
            $_SESSION["guardaValor"] = $this->posts["valorConta"];
            $_SESSION["guardaImportancia"] = $this->posts["importanciaConta"];
            $_SESSION["guardaTipo"] = $this->posts["tipoConta"];
            $_SESSION["guardaData"] = $this->posts["data_vencimentoConta"];
            header("Location: ../view/cadastroConta.php?msg={$msg}");
        }
        if($pag == "delete")
        {
            header("Location: ../view/inicial.php?msg={$msg}");
        }
        exit;
    }
}
?>
