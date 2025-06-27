<?php
require_once (__DIR__."/../model/Cliente.php");
require_once (__DIR__."/../dao/ClienteDAO.php");
class ClienteService
{
    private Cliente $cliente;
    private ClienteDAO $dao;
    private bool $erro;
    private array $posts;
    private string $acao;
    public function __construct($posts)
    {
        session_start();
        $this->cliente=new Cliente();
        $this->dao=new ClienteDAO();
        $this->erro=false;
        $this->posts = $posts;
        $this->acao = $posts["acao"];
    }
    public function verificaDadosCadastro()
    {
        $this->verificaNull();
        $nome = $this->verificaNome();
        $email = $this->verificaEmail("cadastro");
        $senha = $this->verificaSenha();
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $this->cadastro($nome,$email,$hash);
    }
    public function verificaDadosLogin()
    {
        $this->verificaNull();
        $this->cliente = $this->verificaEmail();
        $senha = $this->verificaSenha();
        $this->login($senha);
    }
    public function cadastro($nome,$email,$senha)
    {
        $this->cliente->setNome($nome);
        $this->cliente->setEmail($email);
        $this->cliente->setSenha($senha);;
        unset($_SESSION['guardaEmail'], $_SESSION['guardaSenha']);
        $this->dao->cadastroCliente($this->cliente);
        $this->verificaDadosLogin();
    }
    public function login($senha)
    {
        if(password_verify($senha, $this->cliente->getSenha()))
        {
            $_SESSION['usuario'] = $this->cliente->getNome();
            $_SESSION['id'] = $this->cliente->getId();
            header("Location: ../view/inicial.php");
            exit;  
        }
        else
        {
            $msg = 8;
            $this->voltar($msg);
        }
    }
    public function verificaNull()
    {
        foreach($this->posts as $p)
        {
            if($p == "" || $p == null)
            {
                $this->erro = true;
                $msg = 0;
                $this->voltar($msg);
            }
        }
    }
    public function verificaNome()
    {
        $nome = trim($this->posts["nomeCliente"]);
        if(strlen($nome) < 3)
        {
            $this->erro = true;
            $msg = 3;
        }
        if(strlen($nome) > 50)
        {
            $this->erro = true;
            $msg = 4;
        }
        if($this->erro)
        {
            $this->voltar($msg);
        }
        return $nome;
    }
    public function verificaEmail($tipo=null)
    {
        $email = trim($this->posts["emailCliente"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $msg = 2;
            $this->erro = true;
            $this->voltar($msg);
        }
        $clienteTemp = new Cliente();
        $clienteTemp->setEmail($email);
        $clienteBanco = $this->dao->verificaEmail($clienteTemp);

        if($tipo == "cadastro")
        {
            if($clienteBanco != null)
            {
                $msg = 1;
                $this->voltar($msg);
            }
            return $email;
        }
        else
        {
            if($clienteBanco == null)
            {
                $msg = 8;
                $this->voltar($msg);
            }
            return $clienteBanco;
        }
    }
    public function verificaSenha()
    {
        $senha = trim($this->posts["senhaCliente"]);
        if(strlen($senha) < 8)
        {
            $this->erro = true;
            $msg = 5;
        }
        if(strlen($senha) > 50)
        {
            $this->erro = true;
            $msg = 6;
        }
        if($this->erro)
        {
            $this->voltar($msg);
        }
        return $senha;
    }
    public function voltar($msg)
    {
        $_SESSION['guardaEmail'] = trim($this->posts["emailCliente"]);
        $_SESSION['guardaSenha'] = trim($this->posts["senhaCliente"]);
        if($this->acao == "insert")
        {
            $_SESSION['guardaUsuario'] = trim($this->posts["nomeCliente"]);
            header("Location: ../view/cadastroCliente.php?msg={$msg}");
        }
        if($this->acao == "findLogin")
        {
            header("Location: ../view/login.php?msg={$msg}");
        }
        exit;
    }
    public function desconect()
    {
        session_unset();
        session_destroy();
        header("Location: ../view/login.php");
        exit;
    }
}
?>
