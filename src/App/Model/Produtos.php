<?php
namespace App\Model;

class Produtos
{
    protected $_db;

    private $_name = 'produtos';

    private $id;
    private $codigo;
    private $descricao;
    private $fornecedor;
    private $preco;
    private $datahoraatualizacao;

    public function __construct(\PDO $db)
    {
        $this->_db = $db;
    }

    public function saveOrUpdate()
    {
        $this->setDatahoraatualizacao(date("Y-m-d H:i:s"));

        // Prepara Prepared Statement
        $sql = "INSERT INTO " . $this->_name . " (codigo, descricao, fornecedor, preco, datahoraatualizacao) 
VALUES (:1, :2, :3, :4, :5)
ON DUPLICATE KEY UPDATE
codigo=:1, descricao=:2, fornecedor=:3, preco=:4, datahoraatualizacao=:5";
        $stmt = $this->_db->prepare($sql);

        // Apenas vars podem ser vinculadas
        $v1 = $this->getCodigo();
        $v2 = $this->getDescricao();
        $v3 = $this->getFornecedor();
        $v4 = $this->getPreco();
        $v5 = $this->getDatahoraatualizacao();

        // Vincula os parametros
        $stmt->bindParam(':1', $v1);
        $stmt->bindParam(':2', $v2);
        $stmt->bindParam(':3', $v3);
        $stmt->bindParam(':4', $v4);
        $stmt->bindParam(':5', $v5);

        // Executa a query preparada
        $stmt->execute();
    }

    public function getAll()
    {
        $sql = "SELECT id, codigo, descricao, fornecedor, preco, datahoraatualizacao FROM " . $this->_name;
        $stmt = $this->_db->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        return new \RecursiveArrayIterator($stmt->fetchAll());

    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->Id;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setFornecedor($fornecedor)
    {
        $this->fornecedor = $fornecedor;
        return $this;
    }

    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    public function setPreco($preco)
    {
        $this->preco = $preco;
        return $this;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function setDatahoraatualizacao($datahoraatualizacao)
    {
        $this->datahoraatualizacao = $datahoraatualizacao;
        return $this;
    }

    public function getDatahoraatualizacao()
    {
        return $this->datahoraatualizacao;
    }
}
