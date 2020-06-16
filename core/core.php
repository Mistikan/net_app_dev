<?php
require_once 'core/Parser.php';
require_once 'core/Designer.php';
require_once 'core/Db.php';

$url = substr(substr(parse_url($_SERVER['REQUEST_URI'])['path'], 0, -4), 1);
if (empty($url))
    $url = 'index';
$parser = new Parser();
$designer = new Designer($url);
$dbManager = new Db();

if ($url === 'index') {
    // получаем доступные станки
    $machineArr = $dbManager->getMachines();

    $header = $designer->getHeadContents();
// крафтим и рисуем селектор станков по переданному списку доступных станков

// предварительно убираем '.txt' из названий чтобы в списке на странице было красиво
// подставляется '.txt' в файле parsing если прилетает параметр со станком
    foreach ($machineArr as &$machine) {
        $machine = substr($machine, 0, -4);
    }

    $selectMachine = $designer->getChooseMachineHtml($machineArr);
// получаем календарь
    $calendar = $designer->getCalendar();
// получаем подвал
    $footer = $designer->getFooter();

// рисуем все части по очереди
    $designer->drawPage([$header, $selectMachine, $calendar, $footer]);
} else if ($url === 'about'){
    $designer->drawWholePage();
}
?>