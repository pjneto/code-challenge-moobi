<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class PedidosTest extends TestCase
{

	public function getObjetoPedido()
	{
		return new CodeChallengeMoobi\Pedidos();
	}

	public function getObjetoProduto()
	{
		return new CodeChallengeMoobi\Produtos();
	}

	public function testeRetornarPedidos() 
	{
		$objPedido = $this->getObjetoPedido();
		$qtdePedidos = count($objPedido->retornarPedidos());
		$this->assertEquals(2, $qtdePedidos);
	}

	public function testeConsultarProduto()
	{
		$objPedido = $this->getObjetoPedido();
		$pedido = $objPedido->consultarPedido(1000);
		$this->assertEquals(DEBITO, $pedido[0]->formaPagamento);

		$objPedido = $this->getObjetoPedido();
		$pedido = $objPedido->consultarPedido(1001);
		$this->assertEquals(CARTAO_CREDITO, $pedido[0]->formaPagamento);
	}

	public function testeCadastrarPedidoSucesso()
	{
		$novoPedido = [
			'dataCad' 			=> date('Y-m-d H:i:s'),
			'ativo' 			=> 'S',
			'dataPedido' 		=> date('Y-m-d H:i:s'),
			'formaPagamento' 	=> CARTAO_CREDITO,
			'numParcelas' 		=> '5',
			'idCliente' 		=> '100',
			'produtos'			=> [60, 61, 62]
		];

		$objPedido = $this->getObjetoPedido();
		$resultadoCadastro = $objPedido->cadastrarPedido($novoPedido);
		$this->assertEquals(true, $resultadoCadastro);

		$qtdePedidos = count($objPedido->retornarPedidos());
		$this->assertEquals(3, $qtdePedidos);
	}

	public function testeCadastrarPedidoErro()
	{

		$novoPedido1 = [
			'dataCad' 			=> date('Y-m-d H:i:s'),
			'ativo' 			=> 'S',
			'dataPedido' 		=> date('Y-m-d H:i:s'),
			'formaPagamento' 	=> DEBITO,
			'numParcelas' 		=> '5',
			'idCliente' 		=> '100',
			'produtos'			=> [60, 61]
		];

		$objPedido = $this->getObjetoPedido();
		$resultado1 = $objPedido->cadastrarPedido($novoPedido1);
		$this->assertEquals(PARCELAS_SOMENTE_CARTAO_CREDITO, $resultado1);


		$novoPedido2 = [
			'dataCad' 			=> date('Y-m-d H:i:s'),
			'ativo' 			=> 'S',
			'dataPedido' 		=> date('Y-m-d H:i:s'),
			'formaPagamento' 	=> CARTAO_CREDITO,
			'numParcelas' 		=> '10',
			'idCliente' 		=> '101',
			'produtos'			=> [64]
		];

		$objPedido = $this->getObjetoPedido();
		$resultado2 = $objPedido->cadastrarPedido($novoPedido2);
		$this->assertEquals(SEM_PEDIDO_ESTOQUE, $resultado2);
	}

	public function testeRetornarValoresDesconto()
	{
		$objPedido = $this->getObjetoPedido();

		$resultado1 = $objPedido->retornarValorDesconto(CARTAO_CREDITO);
		$this->assertEquals(0, $resultado1);

		$resultado2 = $objPedido->retornarValorDesconto(DEBITO);
		$this->assertEquals(0.10, $resultado2);

		$resultado3 = $objPedido->retornarValorDesconto(BOLETO);
		$this->assertEquals(0.05, $resultado3);
	}

	public function testeCalcularValorVendaPorProdutos()
	{
		$objProduto = $this->getObjetoProduto();
		$produto1 = $objProduto->consultarProduto(60);
		$produto2 = $objProduto->consultarProduto(61);

		$produtosComprados = [$produto1[0]->idProduto, $produto2[0]->idProduto];
		$valorItensComprados = $produto1[0]->preco + $produto2[0]->preco;

		$objPedido = $this->getObjetoPedido();
		$resultadoCalculoValorVenda = $objPedido->calcularValorVendaPorProdutos($produtosComprados, 0);

		$this->assertEquals($valorItensComprados, $resultadoCalculoValorVenda);
	}

	public function testeAtualizarProduto()
	{
		$objPedido = $this->getObjetoPedido();
		$novosDados = ['dataPedido' => '2015-01-01'];
		$resultUpdate = $objPedido->atualizarPedido($novosDados, 1002);
		$this->assertEquals(true, $resultUpdate);

		$pedidos = $objPedido->consultarPedido(1002);
		$resultado = $pedidos[0]->dataPedido;
		$this->assertEquals('2015-01-01', $resultado);
	}

	public function testeInativarPedido()
	{
		$objPedido = $this->getObjetoPedido();
		$resultUpdate = $objPedido->inativarPedido(1002);
		$this->assertEquals(true, $resultUpdate);
	}

	public function testeAtivarPedido()
	{
		$objPedido = $this->getObjetoPedido();
		$resultUpdate = $objPedido->ativarPedido(1002);
		$this->assertEquals(true, $resultUpdate);
	}
}