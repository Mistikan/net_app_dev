<?php
require_once 'Parser.php';
$parser = new Parser();

$action  = isset($_POST["action"]) ? $_POST["action"] : null;
$machine = isset($_POST["machine"]) ? $_POST["machine"] : null;
$dateFrom    = isset($_POST["dateFrom"]) ? urldecode($_POST["dateFrom"]) : null;
$dateTo = isset($_POST["dateTo"]) ? urldecode($_POST["dateTo"]) : null;
//var_dump($dateFrom);
switch($action) {
	case 'getData':
		header('Content-Type: application/json');
		echo json_encode($parser->getDataByDate($machine, strtotime($dateFrom. ":59:59"), strtotime($dateTo. ":59:59")));
		break;
	case 'getMinAndMaxTime': // получаем мин и макс дни для календаря по станку
		header('Content-Type: application/json');
		echo json_encode($parser->getMinAndMaxTime($machine));
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
//	case 'getDataForDay':
//		echo json_encode($parser->getDataByDate($machine, strtotime($dateFrom. ":59:59"), strtotime($dateTo. ":59:59")));
//		break;
	case 'getDataForAll':
		echo json_encode($parser->getDataByDate($machine));
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
