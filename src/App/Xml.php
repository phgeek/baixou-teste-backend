<?php
namespace App;

class Xml
{
    private $_xmlFile;
    private $_xml;

    public function getContent($xmlFile)
    {
        $this->_xmlFile = $xmlFile;
        $xml = $this->load()->filter();
        return new \SimpleXMLElement($this->_xml);
    }

    public function load()
    {
        $this->_xml = file_get_contents($this->_xmlFile);
        return $this;
    }

    // Filtra caracteres inválidos no XML
    // Não é a melhor solução mas, no momento, funciona
    public function filter()
    {
        $this->_xml = preg_replace(
                [
                    "/&(?!#?[a-z0-9]+;)/",
                    '/\<([\/]?[A-Za-z]+)\>(.+)\<([\/]?[A-Za-z]+)\>(.+)\<([\/]?[A-Za-z]+)\>/',
                ],
                [
                    "&amp;",
                    '<$1>$2&lt;$3&gt;$4<$5>',
                ],
                $this->_xml
            );

        return $this;
    }
}
