<?php
include 'core/parsing.php';
include 'design/design.php';


$machine = $_GET["machine"];
//echo $header.$content.$footer;


echo $header;

/*
$content= <<<CONTENT
<br>
<p align="center"><img src='core/visualization.php'></p>
<br>

https://developers.google.com/chart/interactive/docs/gallery/linechart
CONTENT;
*/
echo "https://ruphp.com/34888.html<br>";

echo "https://learn.javascript.ru/introduction-browser-events";
echo $content1;
// TODO: в идеале переделать эту херню в один контент
$arr = getMachines();
foreach ($arr as $value) {
	if ($value == $machine) {
		echo "	<option selected value=\"".$value."\">".$value."</option>\n" ;
	}
	else 
	{
		echo "	<option value=\"".$value."\">".$value."</option>\n";
	}
}

echo $content3;
if ($machine != ""){
	echo 'Выбран станок: '.htmlspecialchars($machine).'!<br>';
	echo 'Минимальное время: '.getMinTime($machine).'!<br>';
	echo 'Максимальное время: '.getMaxTime($machine).'!<br>';
	echo 'Минимальный день: '.getMinDay($machine).'!<br>';
	echo 'Максимальный день: '.getMaxDay($machine).'!<br>';
	
	$gnD = getMinDay($machine);
	$gxD = getMaxDay($machine);
	
$calendar = <<<CAL
	<form>
	<p>Выберите день для просмотра: 
	<input type="date" name="day" action="index.php" method="get"
	min="$gnD" max="$gxD" >
	<input type="submit" value="Отправить"></p>
	</form>
CAL;
	echo $calendar;
}

echo $footer;

?>