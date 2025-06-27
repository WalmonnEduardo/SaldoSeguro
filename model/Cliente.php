<?php
class Cliente
{
	private int $id;
	private String $nome;
	private String $senha;
	private String $email;

	public static function clienteObj(array $cliente)
	{
		$clienteObj = new Cliente();
		$clienteObj->setId($cliente["id"]);
		$clienteObj->setNome($cliente["nome"]);
		$clienteObj->setSenha($cliente["senha"]);
		$clienteObj->setEmail($cliente["email"]);
		return $clienteObj;
	}
	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function setNome(String $nome): self
	{
		$this->nome = $nome;
		return $this;
	}
	public function getNome(): String
	{
		return $this->nome;
	}
	public function setSenha(String $senha): self
	{
		$this->senha = $senha;
		return $this;
	}
	public function getSenha(): String
	{
		return $this->senha;
	}
	public function setEmail(String $email): self
	{
		$this->email = $email;
		return $this;
	}
	public function getEmail(): String
	{
		return $this->email;
	}

}
?>