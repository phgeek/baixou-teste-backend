<?php
$DEBUG = true;

// Habilitando erros do PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoloaders para classes e namespaces
include 'autoloader.php';

// Configuração geral do script
$conf = include 'config.php';

$zip = new App\Zip();
$zip->download($conf['url'], $conf['zip'])
    ->extract();

$xml = new App\Xml();
$products = $xml->getContent($conf['data'] . $conf['xml']);

$db = new App\Db();
$db = $db->connect();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/narrow-jumbotron.css" />
    <link rel="stylesheet" href="assets/styles.css" />

    <title>Baixou - Teste Backend</title>
  </head>
  <body>
    <div class="container">
      <div class="header clearfix">
        <h3 class="text-muted"><img style="background-color: #1569b3;padding: 8px;" src="https://4e4356b68404a5138d2d-33393516977f9ca8dc54af2141da2a28.ssl.cf1.rackcdn.com/modules/baixou/shell/3.0/lay/baixou-logo.png" /> - Teste Backend</h3>
      </div>

<?php
if ($DEBUG)
    echo 'DEBUG INFO:<br /><br />';

foreach( $products as $p )
{
    $objProduct = new App\Model\Produtos($db);
    $objProduct->setCodigo($p->Reduzido)
                ->setDescricao($p->Descricao)
                ->setFornecedor($p->Fornecedor)
                ->setPreco($p->PrecoPor)
                ->saveOrUpdate();

    if ($DEBUG)
        echo 'CODIGO: ' . $objProduct->getCodigo() . ' - ' . $objProduct->getDescricao() . '<br />'
            .'R$ ' . $objProduct->getPreco() . ' [' . $objProduct->getFornecedor() . '] <br /><br />';
}

?>


    </div>
    <footer class="footer">
        <p>Baixou &copy; <?= date('Y') ?></p>
    </footer>

  </body>
</html>
