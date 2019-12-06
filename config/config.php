<?php

// Informações do Banco de dados
define("DRIVE", "mysql");
define("HOST", "localhost");
define("DATABASE", "loja_brinquedos");
define("USUARIO", "root");
define("SENHA", "");

// Informações do tipo de pagamento
define("CARTAO_CREDITO", "CD");
define("DEBITO", "DE");
define("BOLETO", "BO");

// Erros do Cliente
define('DOCUMENTO_NAO_INFORMADO', 'Erro: Documento não informado!');
define('TELEFONE_NAO_INFORMADO', 'Erro: Telefone não informado!');
define('CELULAR_NAO_INFORMADO', 'Erro: Celular não informado!');
define('EMAIL_NAO_INFORMADO', 'Erro: E-mail não informado!');

// Erros do Produto
define('NOME_PRODUTO_NAO_INFORMADO', 'Erro: Nome do produto não informado!');
define('PRECO_NAO_INFORMADO', 'Erro: Preço do produto não informado!');
define('QTDE_PRODUTO_NAO_INFORMADO', 'Erro: Quantidade do produto em estoque não informado!');

// Erros do Pedido
define('DATA_PEDIDO_NAO_INFORMADO', 'Erro: Data do pedido não informado!');
define('FORMA_PAGAMENTO_NAO_INFORMADO', 'Erro: Forma de pagamento do pedido não informado!');
define('PRODUTO_NAO_INFORMADO', 'Erro: Não é possível registrar o pedido sem informar ao menos um produto!');
define('CLIENTE_NAO_INFORMADO', 'Erro: Cliente para o pedido não informado!');
define('SEM_PEDIDO_ESTOQUE', 'Erro: Não é possível registrar o pedido, pois não possui o produto no estoque');
define('PARCELAS_SOMENTE_CARTAO_CREDITO', 'Erro: Só é possível parcelar compras no cartão de crédito!');
define('QTDE_PARCELAS_NAO_INFORMADO', 'Erro: Informe a quantidade de parcelas para compras no cartão de crédito!');

