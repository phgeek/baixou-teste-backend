<?php
namespace App;

use App\Tools;

class Zip {
    private $_url;
    private $_zip;

    public function download($url, $zip)
    {
        $this->_url = $url;
        $this->_zip = $zip;

        $file = fopen($this->_url, 'rb');
        if ($file) {
            $newf = fopen($this->_zip, 'wb');
            if ($newf) {
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newf) {
            fclose($newf);
        }

        return $this;
    }

    public function extract()
    {
        $conf = Tools::loadConfig();

        $zip = new \ZipArchive;
        $res = $zip->open($this->_zip);
        if ($res === TRUE) {
            $zip->extractTo($conf['data'], [$conf['xml']]);
            $zip->close();
        }
    }
}