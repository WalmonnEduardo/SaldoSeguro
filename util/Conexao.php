<?php
class Conexao
{
    private $server = "127.0.0.1";
    private $banco = "dbContas";
    private $usuario = "seu_usuario";
    private $senha = "sua_senha";

    function conectar()
    {
        try
        {
            $conn = new PDO(
                "mysql:host=" . $this->server . ";dbname=" . $this->banco,
                $this->usuario,
                $this->senha
            );
            return $conn;
        }
        catch (Exception $e)
        {
            echo "Erro ao conectar com o Banco de dados: " . $e->getMessage();
        }
    }
}
