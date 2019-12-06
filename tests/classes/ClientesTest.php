<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ClientesTest extends TestCase
{

	public function getObjetoCliente()
	{
		return new CodeChallengeMoobi\Clientes();
	}

	public function testeRetornarClientes() 
	{
		$objCliente = $this->getObjetoCliente();
		$qtdeClientes = count($objCliente->retornarClientes());
		$this->assertEquals(3, $qtdeClientes);
	}

	public function testeConsultarCliente()
	{
		$objCliente = $this->getObjetoCliente();
		$cliente = $objCliente->consultarCliente(100);
		$this->assertEquals('Antonio', $cliente[0]->nome);
	}

	public function testeCadastrarClienteSucesso()
	{
		$novoCliente = [
			'dataCad' 	=> date('Y-m-d H:i:s'),
			'ativo' 	=> 'S',
			'nome' 		=> 'Maria das Graças',
			'sexo' 		=> 'F',
			'tipoDoc' 	=> 'CPF',
			'documento' => '01234567899',
			'telefone' 	=> '7999987456',
			'celular' 	=> '7945454778',
			'email' 	=> 'maria@email.com'
		];

		$objCliente = $this->getObjetoCliente();
		$resultadoCadastro = $objCliente->cadastrarCliente($novoCliente);
		$this->assertEquals(true, $resultadoCadastro);

		$clientes = $objCliente->retornarClientes();
		$resultado = $clientes[count($clientes) - 1]->nome;
		$this->assertEquals('Maria das Graças', $resultado);
	}

	public function testeCadastrarClienteErro()
	{
		$novoCliente = [
			'dataCad' 	=> date('Y-m-d H:i:s'),
			'ativo' 	=> 'S',
			'nome' 		=> 'João',
			'tipoDoc' 	=> 'CPF',
			'documento' => '01234567890',
			'telefone' 	=> '79999874563',
			'email'		=> 'email@email.com'
		];

		$objCliente = $this->getObjetoCliente();
		$resultadoCadastro = $objCliente->cadastrarCliente($novoCliente);
		$this->assertEquals(CELULAR_NAO_INFORMADO, $resultadoCadastro);
	}

	public function testeAtualizarCliente()
	{
		$objCliente = $this->getObjetoCliente();
		$novosDados = ['email' => 'lojaonline@loja.com'];
		$resultUpdate = $objCliente->atualizarCliente($novosDados, 102);
		$this->assertEquals(true, $resultUpdate);
	}

	public function testeInativarCliente()
	{
		$objCliente = $this->getObjetoCliente();
		$resultUpdate = $objCliente->inativarCliente(102);
		$this->assertEquals(true, $resultUpdate);
	}

	public function testeAtivarCliente()
	{
		$objCliente = $this->getObjetoCliente();
		$resultUpdate = $objCliente->ativarCliente(102);
		$this->assertEquals(true, $resultUpdate);
	}

}