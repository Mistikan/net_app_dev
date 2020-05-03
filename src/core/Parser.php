<?php


class Parser
{
    public $pathDb;

    public function __construct() {
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

    public function getMinTime($machine)
    {
        $lines = file($this->pathDb . $machine);
        $val = explode('*', $lines[0]); // Парсим строку
        $time = (int)$val[4]; // Получаем время записи
        return $time;
    }

    public function getMaxTime($machine)
    {
        $lines = file($this->pathDb . $machine);
        $val = explode('*', $lines[count($lines) - 1]); // Парсим строку
        $time = (int)$val[4]; // Получаем время записи
        return $time;
    }

    public function getMinAndMaxTime($machine)
    {
        return [
            'minDays' => date("d.m.Y", self::getMinTime($machine)),
            'maxDays' => date("d.m.Y", self::getMaxTime($machine)),
        ];
    }

    // Возвращает двумерный массив значений указанного станка с необязательным указанием верхней и нижней границ времени
    // Формат массива:
    // $arr[n][0] - n-ая запись работы перемещения инструмента;
    // $arr[n][1] - n-ая запись отдыха перемещения инструмента;
    // $arr[n][2] - n-ая запись работы инструмента;
    // $arr[n][3] - n-ая запись отдыха инструмента;
    // $arr[n][4] - n-ая запись времени в unix time;
    // $arr[n][5] - n-ая запись работал ли станок в целом.  - пока убрал.
    // TODO: не совсем то, вроде, выводит в плане работы станка.
    function getDataByDate($machine, $beginDate = 0, $endDate = null)
    {
        $arr = array();
        $handle = @fopen($this->pathDb . $machine, "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $val = explode('*', $buffer); // Парсим строку
                // Конвертируем str2int
                foreach ($val as &$value) {
                    $value = (int)$value;
                }
                $time = $val[4]; // Получаем время записи
                if ($beginDate < $time && ($endDate === null || $time < $endDate)) { //  Проверка, что строчка удовлетворяет условию по времени
                    /*
                    echo $time." -> ".date("H:m:s d.m.y",$time);
                    echo "<br>";
                    */
                    /*
                    if ($val[0] == ""){
                        $val[5] = false;
                    }
                    else {
                        $val[5] = true;
                    }
                    */
                    $arr[] = $val;
                }
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
                return -1;
            }
            fclose($handle);
            return $arr;
        }
    }
}