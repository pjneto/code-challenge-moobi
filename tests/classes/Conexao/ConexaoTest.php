<?php
require 'vendor/autoload.php';
require 'config/config.php';

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class ConexaoTest extends TestCase
{
	use TestCaseTrait;

	private $conn = null;

	public function getConnection()
    {
    	if (!$this->conn) {
            $db = new \PDO("mysql:host=".HOST.";dbname=" . DATABASE, USUARIO, SENHA);
            $this->conn = $this->createDefaultDBConnection($db, DATABASE);
        }

        return $this->conn;

	}

    public function getDataSet()
	{
        return $this->createXMLDataSet("./tests/classes/DadosTest/loja_brinquedos_db.xml");
	}

	public function testeClientes()
    { 
        $conn = $this->getConnection()->getConnection();
   
        $query = $conn->query('SELECT * FROM clientes');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
         
        $this->assertCount(3, $results);
        $this->assertEquals("Antonio", $results[0]['nome']);
        $this->assertEquals("Ana", $results[1]['nome']);
        $this->assertEquals("Joana", $results[2]['nome']);
    }

    public function testeProdutos()
    { 
        $conn = $this->getConnection()->getConnection();
   
        $query = $conn->query('SELECT * FROM produtos');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
         
        $this->assertCount(5, $results);
        $this->assertEquals("Carrinho", $results[0]['nome']);
        $this->assertEquals("Boneca", $results[1]['nome']);
        $this->assertEquals("Boneco", $results[2]['nome']);
        $this->assertEquals("Robô", $results[3]['nome']);
    }

    public function testePedidos()
    { 
        $conn = $this->getConnection()->getConnection();
   
        $query = $conn->query('SELECT * FROM pedidos');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
         
        $this->assertCount(2, $results);
        $this->assertEquals(DEBITO, $results[0]['formaPagamento']);
        $this->assertEquals(CARTAO_CREDITO, $results[1]['formaPagamento']);
    }

    public function testePedidosProdutos()
    { 
        $conn = $this->getConnection()->getConnection();
   
        $query = $conn->query('SELECT * FROM pedidos_produtos WHERE idpedido = "1000"');
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
         
        $this->assertCount(2, $results);
        $this->assertEquals(61, $results[0]['idProduto']);
        $this->assertEquals(62, $results[1]['idProduto']);
    }

}
