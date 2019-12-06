<?php
require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ProdutosTest extends TestCase
{

	public function getObjetoProduto()
	{
		return new CodeChallengeMoobi\Produtos();
	}

	public function testeRetornarProdutos() 
	{
		$objProduto = $this->getObjetoProduto();
		$qtdeProdutos = count($objProduto->retornarProdutos());
		$this->assertEquals(5, $qtdeProdutos);
	}

	public function testeConsultarProduto()
	{
		$objProduto = $this->getObjetoProduto();
		$produto = $objProduto->consultarProduto(63);
		$this->assertEquals('Robô', $produto[0]->nome);
	}

	public function testeCadastrarProdutoSucesso()
	{
		$novoProduto = [
			'dataCad' 		=> date('Y-m-d H:i:s'),
			'ativo' 		=> 'S',
			'nome' 			=> 'Banco Imobiliário',
			'modelo' 		=> 'Tradicional',
			'marca' 		=> 'Estrela',
			'preco' 		=> '500.99',
			'quantidade' 	=> '1'
		];

		$objProduto = $this->getObjetoProduto();
		$resultadoCadastro = $objProduto->cadastrarProduto($novoProduto);
		$this->assertEquals(true, $resultadoCadastro);

		$produtos = $objProduto->retornarProdutos();
		$resultado = $produtos[count($produtos) - 1]->nome;
		$this->assertEquals('Banco Imobiliário', $resultado);

	}

	public function testeCadastrarProdutoErro()
	{
		$novoProduto = [
			'dataCad' 		=> date('Y-m-d H:i:s'),
			'ativo' 		=> 'S',
			'nome' 			=> 'Ursinho',
			'preco'			=> '59.99'
		];

		$objProduto = $this->getObjetoProduto();
		$resultadoCadastro = $objProduto->cadastrarProduto($novoProduto);
		$this->assertEquals(QTDE_PRODUTO_NAO_INFORMADO, $resultadoCadastro);
	}

	public function testeAtualizarProduto()
	{
		$objProduto = $this->getObjetoProduto();
		$novosDados = ['preco' => '99.99'];
		$resultUpdate = $objProduto->atualizarProduto($novosDados, 60);
		$this->assertEquals(true, $resultUpdate);

		$produtos = $objProduto->consultarProduto(60);
		$resultado = $produtos[0]->preco;
		$this->assertEquals('99.99', $resultado);
	}

	public function testeInativarProduto()
	{
		$objProduto = $this->getObjetoProduto();
		$resultUpdate = $objProduto->inativarProduto(64);
		$this->assertEquals(true, $resultUpdate);
	}

	public function testeAtivarProduto()
	{
		$objProduto = $this->getObjetoProduto();
		$resultUpdate = $objProduto->ativarProduto(64);
		$this->assertEquals(true, $resultUpdate);
	}

	public function testeDecrementarEstoqueDosProdutos()
	{
		$objProduto = $this->getObjetoProduto();
		$produto = $objProduto->consultarProduto(65);
		$qtdeAntigaProduto = $produto[0]->quantidade;

		$resultadoDecremento = $objProduto->decrementarEstoqueDosProdutos([65]);
		$this->assertEquals(true, $resultadoDecremento);

		$produtoAtualizado = $objProduto->consultarProduto(65);
		$qtdeNovaProduto = $produtoAtualizado[0]->quantidade;

		$this->assertEquals($qtdeAntigaProduto - 1, $qtdeNovaProduto);
		$this->assertNotEquals($qtdeAntigaProduto, $qtdeNovaProduto);
	}
}