<?php


class Db
{
    /**
     * @var string
     */
    private $pathDb;

    public function __construct()
    {
        $this->pathDb .= $_SERVER['DOCUMENT_ROOT'] . "/db/";
    }

    // Возвращает все доступные станки для визуализации и обработки
    public function getMachines()
    {
        $arr = [];
        $skip = array('.', '..');
        $files = scandir($this->pathDb);
        foreach ($files as $file) {
            if (!in_array($file, $skip)) {
                // echo $file . '<br />';
                $arr[] = $file;
            }
        }
        return $arr;
    }
}