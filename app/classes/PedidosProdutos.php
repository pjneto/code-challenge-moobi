<?php
namespace CodeChallengeMoobi;

use CodeChallengeMoobi\Conexao;

class PedidosProdutos
{
    protected $tabela;
    protected $objConexao;

    public function __construct()
    {
        $this->objConexao = new Conexao\AcessoBanco();
        $this->tabela = 'pedidos_produtos';
        $this->chave = 'idPedidoProduto';
        $this->chaveProduto = 'idProduto';
        $this->chavePedido = 'idPedido';
    }

    public function retornarPedidosProdutos()
    {
        return $this->objConexao->select($this->tabela);
    }

    public function consultarPedidoProduto($idPedidoProduto)
    {
        return $this->objConexao->selectById($this->tabela, $idPedidoProduto, $this->chave);
    }

    public function consultarProdutosDeUmPedido($idPedido)
    {
        return $this->objConexao->selectById($this->tabela, $idPedido, $this->chavePedido);
    }

    public function cadastrarPedidosProdutos(array $produtos, $idPedido)
    {
        try {
           
           foreach ($produtos as $idProduto) {
                $dados = $this->montarDados($idProduto, $idPedido);
                $this->objConexao->insert($this->tabela, $dados);
           }

           return true;

        } catch(\Exception $erro) {
            echo $erro->getMessage();
            exit;
        }
    }

    public function montarDados($idProduto, $idPedido)
    {
        $dados['idProduto'] = $idProduto;
        $dados['idPedido'] = $idPedido;
        $dados['ativo'] = 'S';
        $dados['dataCad'] = date('Y-m-d H:i:s');

        return $dados;
    }

    public function atualizarPedidoProduto(array $novosDados, $idPedidoProduto)
    {
        return $this->objConexao->update($this->tabela, $novosDados, $idPedidoProduto, $this->chave);
    }

    public function inativarPedidoProduto($idPedidoProduto)
    {
        $dados['ativo'] = 'N';
        return $this->objConexao->update($this->tabela, $dados, $idPedidoProduto, $this->chave);
    }

    public function ativarPedidoProduto($idPedidoProduto)
    {
        $dados['ativo'] = 'S';
        return $this->objConexao->update($this->tabela, $dados, $idPedidoProduto, $this->chave);
    }

    public function apagarPedidoProduto($idPedidoProduto)
    {
    	return $this->objConexao->delete($this->tabela, $idPedidoProduto, $this->chave);
    }

}