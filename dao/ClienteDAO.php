<?php
require_once(__DIR__."/../util/Conexao.php");
require_once(__DIR__."/../model/Cliente.php");
    
class ClienteDAO
{
    private PDO $con;
    public function __construct()
    {
        $this->con = (new Conexao())->conectar();
    }
    public function cadastroCliente(Cliente $cliente)
    {
        $sql = "INSERT INTO Cliente(nome,senha,email) VALUES(?,?,?);";
        $stm = $this->con->prepare($sql);
        $stm->execute([$cliente->getNome(),$cliente->getSenha(),$cliente->getEmail()]);
    }
    public function verificaEmail(Cliente $cliente)
    {
        $sql = "SELECT * FROM Cliente WHERE email = ?";
        $stm = $this->con->prepare($sql);
        $stm->execute([$cliente->getEmail()]);
        $dados = $stm->fetchAll();
        if(count($dados) > 0)
        {
            $c = Cliente::clienteObj($dados[0]);
        }
        else
        {
            $c = null;
        }
        
        return $c;
    }
}
