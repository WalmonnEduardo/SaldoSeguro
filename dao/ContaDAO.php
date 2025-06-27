<?php
require_once(__DIR__."/../util/Conexao.php");
require_once(__DIR__."/../model/Conta.php");
    
class ContaDAO
{
    private PDO $con;
    public function __construct()
    {
        $this->con = (new Conexao())->conectar();
    }
    public function cadastroConta(Conta $conta)
    {
        $sql = "INSERT INTO Conta(nome,data_vencimento,valor,tipo,importancia,id_cliente) VALUES(?,?,?,?,?,?);";
        $stm = $this->con->prepare($sql);
        $stm->execute([$conta->getNome(),$conta->getData_vencimento(),$conta->getValor(),$conta->getTipo(),$conta->getImportancia(),$conta->getId_cliente()]);
    }
    public function selectConta($nome)
    {
        $sql = "SELECT * FROM Conta WHERE nome LIKE ?;";
        $stm = $this->con->prepare($sql);
        $stm->execute([$nome]);
        $dados = $stm->fetchAll();
        if(count($dados) > 0)
        {
            $c = Conta::contaObj($dados[0]);
        }
        else
        {
            $c = null;
        }
        
        return $c;
    }
    public function selectAllContaCliente($idCliente)
    {
        $sql = "SELECT * FROM Conta WHERE id_cliente=?;";
        $stm = $this->con->prepare($sql);
        $stm->execute([$idCliente]);
        $dados = $stm->fetchAll();
        if(count($dados) > 0)
        {
            foreach($dados as $d)
            {
                $c[] = Conta::contaObj($d);
            }
        }
        else
        {
            $c = null;
        }
        return $c;
    }
    public function selectContaCliente($idCliente,$idConta)
    {
        $sql = "SELECT * FROM Conta WHERE id_cliente=? AND id=?;";
        $stm = $this->con->prepare($sql);
        $stm->execute([$idCliente,$idConta]);
        $dados = $stm->fetchAll();
        if(count($dados) > 0)
        {
            foreach($dados as $d)
            {
                $c[] = Conta::contaObj($d);
            }
        }
        else
        {
            $c = null;
        }
        return $c;
    }
    public function deleteConta($id)
    {
        $sql = "DELETE FROM Conta WHERE id = ?";;
        $stm = $this->con->prepare($sql);
        $stm->execute([$id]);
    }
}