<?php

$core = "/core/core.php";
$pathDb = ".";
while (!is_file($pathDb.$core)) {
	$pathDb .= "/..";
}
$pathDb .= "/db/";


// Возвращает все доступные станки для визуализации и обработки
function getMachines()
{
	$arr = array();
	global $pathDb;
	$skip = array('.', '..');
	$files = scandir($pathDb);
	foreach($files as $file) {
		if(!in_array($file, $skip)){
			// echo $file . '<br />';
			$arr[] = $file;
		}
	}
	return $arr;
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
function getVals($machine, $beginDate = 0, $endDate = null)
{
	global $pathDb;
	$arr = array();
	$handle = @fopen($pathDb.$machine, "r");
	if ($handle) {
		while (($buffer = fgets($handle, 4096)) !== false) {
			$val = explode( '*', $buffer ); // Парсим строку
			// Конвертируем str2int
			foreach ( $val as &$value ) {
				$value = (int)$value;
			}
			$time = $val[4]; // Получаем время записи
			if ($beginDate < $time && ($endDate === null || $time < $endDate)){ //  Проверка, что строчка удовлетворяет условию по времени
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

function getMinTime($machine)
{
	global $pathDb;
	$lines = file($pathDb.$machine);
	$val = explode( '*', $lines[0] ); // Парсим строку
	$time = (int)$val[4]; // Получаем время записи
	return	$time;
}

function getMinDay($machine)
{
	$time = getMinTime($machine);
	return date("Y-m-d", $time);
}

function getMaxTime($machine)
{
	global $pathDb;
	$lines = file($pathDb.$machine);
	$val = explode( '*', $lines[count($lines)-1] ); // Парсим строку
	$time = (int)$val[4]; // Получаем время записи
	return	$time;
}

function getMaxDay($machine)
{
	$time = getMaxTime($machine);
	return date("Y-m-d", $time);
}

$action  = $_POST["action"];
$machine = $_POST["machine"];
$date    = $_POST["date"];
switch($action) {
	// TODO: убрать getCalendar, т.к. хтмл нужно вынести в JS.
	case 'getCalendar':
		$gnD = getMinDay($machine);
		$gxD = getMaxDay($machine);
		$calendar = <<<CAL
		<form>
		Example: 25.12.2019<br>
		<p>Выберите день для просмотра: 
		<input type="date" name="day" id="dateFromCalendar"
		min="$gnD" max="$gxD" >
		<input type="button" id="sendMachineAndDate" onclick="sendDate()" value="Выбрать"></p>
		</form>
CAL;
		echo $calendar;
		break;
	case "getMinDay":
		$time = getMinTime($machine);
		echo date("d.m.Y", $time);
		break;
	case "getMaxDay":
		$time = getMaxTime($machine);
		echo date("d.m.Y", $time);
		break;
	case "getMinTime":
		echo getMinTime($machine);
		break;
	case "getMaxTime":
		echo getMaxTime($machine);
		break;
	case "getMinAndMaxTime":
		$gnT = getMinTime($machine);
		$gnX = getMaxTime($machine);
		$arr = array($gnT, $gnX);
		echo json_encode($arr);
		break;
	/*
	час, 
	день, +
	месяц, 
	квартал, 
	год, 
	все время, +
	от даты до даты.
	*/
	case 'getDataForDay':
		$date = strtotime($date); // Date2Unixtime
		$arr = getVals($machine, $date, $date + 86400);
		echo json_encode($arr);
		break;
	case 'getDataForAll':
		$arr = getVals($machine);
		echo json_encode($arr);
		break;
	default:
		   echo "";
}

/*

echo getMinTime("db2.txt");

echo "<br>";
echo getMaxTime("db2.txt");
*/
/*
echo "Hello.<br>";

echo "Function getMachines:<br>";
$gM = getMachines();
print_r($gM);

echo "<br>Function getVals:<br>";

$vals = getVals($gM[0]); // Без указания границ
echo count($vals)."<br>";

$vals = getVals($gM[0], 1576501265); // С указанием нижней границы
echo count($vals)."<br>";

$vals = getVals($gM[0], 0 ,1576502168); // С указанием верхней границы
echo count($vals)."<br>";

$vals = getVals($gM[0], 1576501265, 1576502168); // С указанием обоих границ
echo count($vals)."<br>";

echo "Bye-bye.<br>";
*/
?>
