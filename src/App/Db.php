<?php
namespace App;

use App\Tools;

class Db
{
    private $_conn;
    private $_conf;

    public function __construct()
    {
        // Carrega as configurações do BD
        $this->_conf = Tools::loadConfig('db');
    }

    public function connect()
    {
        try {
            $db = 'mysql:host=' . $this->_conf['host'] . ';dbname=' . $this->_conf['db'];
            $this->_conn = new \PDO($db, $this->_conf['user'], $this->_conf['pass']);
            // set the PDO error mode to exception
            //$this->_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $this->_setupDb();
        } catch(PDOException $e) {
            echo "Conexão falhou: " . $e->getMessage();
        }

        return $this->_conn;
    }

    public function close()
    {
        $this->conn = null;
    }

    private function _setupDb() {
        // Checa se existe e cria o BD
        $table = 'produtos';
        if (!$this->_conn->exec("SELECT 1 FROM " . $table . " LIMIT 1")) {
            $this->_conn->exec("CREATE TABLE `" . $table . "` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(30) NOT NULL,
  `descricao` varchar(300) NOT NULL,
  `fornecedor` varchar(300) NOT NULL,
  `preco` decimal(7,2) NOT NULL,
  `datahoraatualizacao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");
        }
    }
}
