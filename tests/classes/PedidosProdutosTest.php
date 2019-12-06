<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class PedidosProdutosTest extends TestCase
{

	public function getObjetoPedidosProdutos()
	{
		return new CodeChallengeMoobi\PedidosProdutos();
	}

	public function testeRetornarPedidosProdutos() 
	{
		$objPedidoProduto = $this->getObjetoPedidosProdutos();
		$qtdePedidosProdutos = count($objPedidoProduto->retornarPedidosProdutos());
		$this->assertEquals(2, $qtdePedidosProdutos);
	}

	public function testeConsultarProdutosDeUmPedido()
	{
		$objPedidoProduto = $this->getObjetoPedidosProdutos();
		$produtosDeUmPedido = $objPedidoProduto->consultarProdutosDeUmPedido(1000);
		$this->assertEquals(2, count($produtosDeUmPedido));
	}

	public function testeCadastrarPedidosProdutos()
	{
		$produtos = [60, 61, 62, 63];
		$pedido = 1001;

		$objPedidoProduto = $this->getObjetoPedidosProdutos();
		$resultadoCadastro = $objPedidoProduto->cadastrarPedidosProdutos($produtos, $pedido);
		$this->assertEquals(true, $resultadoCadastro);

		$objPedidoProduto = $this->getObjetoPedidosProdutos();
		$produtosDeUmPedido = $objPedidoProduto->consultarProdutosDeUmPedido(1001);
		$this->assertEquals(4, count($produtosDeUmPedido));
	}

	public function testeAtualizarPedidoProduto()
	{
		$objPedidoProduto = $this->getObjetoPedidosProdutos();
		$novosDados = ['dataCad' => '2019-01-01 01:01:01'];
		$resultUpdate = $objPedidoProduto->atualizarPedidoProduto($novosDados, 202);
		$this->assertEquals(true, $resultUpdate);

		$pedidoProduto = $objPedidoProduto->consultarPedidoProduto(202);
		$resultado = $pedidoProduto[0]->dataCad;
		$this->assertEquals('2019-01-01 01:01:01', $resultado);
	}

	public function testeInativarPedidoProduto()
	{
		$objPedidoProduto = $this->getObjetoPedidosProdutos();
		$resultUpdate = $objPedidoProduto->inativarPedidoProduto(202);
		$this->assertEquals(true, $resultUpdate);
	}

	public function testeAtivarPedidoProduto()
	{
		$objPedidoProduto = $this->getObjetoPedidosProdutos();
		$resultUpdate = $objPedidoProduto->ativarPedidoProduto(202);
		$this->assertEquals(true, $resultUpdate);
	}
}