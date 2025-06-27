<?php
class Conta
{
	private int $id;
	private String $nome;
	private string $data_vencimento;
	private float $valor;
	private String $tipo;
	private String $importancia;
	private int $id_cliente;

	public function __toString()
	{
		require_once(__DIR__ . '/../util/Token.php');
		$tokenManager = new Token();
		$token = $tokenManager->gerarToken($this->getId());

		$data = date("d/m/Y", strtotime($this->getData_vencimento()));
		$v = new DateTime($this->getData_vencimento());
		$hj = new DateTime(date("Y-m-d"));
		$intervalo = $v->diff($hj);
		$dias = $intervalo->days;

		switch ($this->getImportancia()) {
			case "A": $imp = "Alta"; break;
			case "M": $imp = "Média"; break;
			case "B": $imp = "Baixa"; break;
		}

		switch ($this->getTipo()) {
			case "L": $tip = "Lazer"; break;
			case "S": $tip = "Saúde"; break;
			case "M": $tip = "Mercado"; break;
			case "F": $tip = "Fixo"; break;
		}

		$v = number_format($this->getValor(), 2, ',', '.');

		return "
		<tr>
			<td class=\"bg-[#F8F4E1] border border-black p-2\">{$this->getNome()}</td>
			<td class=\"bg-[#F8F4E1] border border-black p-2 text-right\">{$v}</td>
			<td class=\"bg-[#F8F4E1] border border-black p-2 text-center\">{$data}</td>
			<td class=\"bg-[#F8F4E1] border border-black p-2 text-center\">{$dias}</td>
			<td class=\"bg-[#F8F4E1] border border-black p-2 text-center\">{$imp}</td>
			<td class=\"bg-[#F8F4E1] border border-black p-2 text-center\">{$tip}</td>
			<td class=\"bg-[#F8F4E1] border border-black\">
				<form action=\"../controller/ContaController.php\" method=\"post\">
					<input type=\"hidden\" name=\"acao\" value=\"delete\">
					<input type=\"hidden\" name=\"token\" value=\"{$token}\">
					<button onclick='return confirm(\"Confirma a exclusão do item {$this->getNome()}?\");' type='submit' class=\"p-2 bg-[#C40C0C] hover:bg-[#7D0A0A] text-white rounded-3xl\">Excluir</button>
				</form>
			</td>
		</tr>
		";
	}

	public static function contaObj(array $conta)
	{
		$contaObj = new Conta();
		$contaObj->setId($conta["id"]);
		$contaObj->setNome($conta["nome"]);
		$contaObj->setData_vencimento($conta["data_vencimento"]);
		$contaObj->setValor($conta["valor"]);
		$contaObj->setTipo($conta["tipo"]);
		$contaObj->setImportancia($conta["importancia"]);
		$contaObj->setId_cliente($conta["id_cliente"]);
		return $contaObj;
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
	public function setData_vencimento(string $data_vencimento): self
	{
		$this->data_vencimento = $data_vencimento;
		return $this;
	}
	public function getData_vencimento(): string
	{
		return $this->data_vencimento;
	}
	public function setValor(float $valor): self
	{
		$this->valor = $valor;
		return $this;
	}
	public function getValor(): float
	{
		return $this->valor;
	}
	public function setTipo(String $tipo): self
	{
		$this->tipo = $tipo;
		return $this;
	}
	public function getTipo(): String
	{
		return $this->tipo;
	}
	public function setImportancia(String $importancia): self
	{
		$this->importancia = $importancia;
		return $this;
	}
	public function getImportancia(): String
	{
		return $this->importancia;
	}
	public function setId_cliente(int $id_cliente): self
	{
		$this->id_cliente = $id_cliente;
		return $this;
	}
	public function getId_cliente(): int
	{
		return $this->id_cliente;
	}

}
?>