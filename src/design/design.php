<?PHP

$header = <<<HEADER
<!DOCTYPE html>
<html lang="ru">
<head>
<meta http-equiv=Content-Type content="text/html;charset=UTF-8">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.full.js"></script>
<!-- Сюда наш скрипт !-->
<script type="text/javascript" src="js/scripts.js"></script>
<link rel="stylesheet" href="css/jquery.datetimepicker.min.css">

</head>
<body>
<h1 align="center">Проект по визуализации данных работы станков</h1>
HEADER;

$content1 = <<<CONTENT
<h1 align="center">Выбор станка:</h1>

<form><p><select multiple id="sendMachinefff" name="machine" onchange="updateMachine();">
CONTENT;
	   


$content3 = <<<CONTENT
</select></p>
<p><input type="button" id="sendMachine" value="Выбрать"></p>
</form>

<h1 align="center">Время:</h1>
<div id="calendar">
Здесь появится календарь в идеале.
</div>

<input id="datetime">

<h1 align="center">График:</h1>
<div id="graph">Здесь появится график в идеале.
	<div id="graph_end" style="width: 900px; height: 500px"></div>
</div>
CONTENT;

$footer = <<<FOOTER
</body>
<footer>
<p align="center">Copyright Группа 18ИСТв-1</p>
</footer>
</html>
FOOTER;
?>