<?php
require_once(__DIR__."/../service/ContaService.php");
class ContaController
{
    private ContaService $service;
    private string $acao;
    public function __construct()
    {
        $this->service = new ContaService($_POST ?? []);
        if (isset($_POST["acao"]))
        {
            $this->acao = $_POST["acao"];
            $this->verificaAcao();
        }
    }
    public function verificaAcao()
    {
        switch($this->acao)
        {
            case "insert":$this->inserir(); break;
            case "delete":$this->excluir(); break;
        }    
    }
    public function inserir()
    {
        $this->service->verificaDadosCadastro();
    }
    public function excluir()
    {
        $this->service->deletar();
    }
    public function buscarTodos($id)
    {
        return $this->service->buscarTodos($id);
    }
   
}
new ContaController();