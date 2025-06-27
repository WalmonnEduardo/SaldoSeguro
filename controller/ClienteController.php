<?php
require_once (__DIR__."/../service/ClienteService.php");
class ClienteController
{
    private ClienteService $service;
    private string $acao;
    public function __construct()
    {
        if (!isset($_POST["acao"]))
        {
            return; 
        }
        $this->service=new ClienteService($_POST);
        $this->acao=$_POST["acao"];
        $this->verificaAcao();
    }
    public function verificaAcao()
    {
        switch($this->acao)
        {
            case "insert":$this->inserir(); break;
            case "findLogin":$this->login();break;
            case "sair":$this->desconect();break;
        }    
    }
    public function inserir()
    {
        $this->service->verificaDadosCadastro();
    }
    public function login()
    {
        $this->service->verificaDadosLogin();
    }
    public function desconect()
    {
        $this->service->desconect();
    }
}
new ClienteController();