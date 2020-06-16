<?PHP

/*
Подключаем JPGraph (внимание, директория,
содержащая файл jpgraph.php должна присутствовать
в INCLUDE_PATH, иначе нужно указывать путь до неё)
*/
require_once('../core/jpgraph/jpgraph.php');
/*
Подключаем расширение, ответственное за
создание линейных графиков:
*/
require_once('../core/jpgraph/jpgraph_line.php');

// Создадим немного данных для визуализации:
$ydata = array(19, 3, 8, 29, 15, 16, 19);

/*
Массив значений абсцисс опционален, 
его можно не задавать
*/
$xdata = array(0, 1, 2, 3, 4, 5, 6);

/*
Создаем экземпляр класса графика, задаем параметры
изображения: ширина, высота, название файла в кеше,
время хранения изображения в кеше, указываем, выводить
ли изображение при вызове функции Stroke (true)
или только создать и хранить в кеше (false):
*/
$graph = new Graph(400, 300, 'auto', 10, true);

// Указываем, какие оси использовать:
$graph->SetScale('textlin');

/*
Создаем экземпляр класса линейного графика, передадим
ему нужные значения:
*/
$lineplot = new LinePlot($ydata, $xdata);

// Задаём цвет кривой
$lineplot->SetColor('forestgreen');

// Присоединяем кривую к графику:
$graph->Add($lineplot);

// Даем графику имя:
$graph->title->Set('Простой график');

/*
Если планируете использовать кириллицу, то необходимо 
использовать TTF-шрифты, которые её поддерживают,
например arial.
*/
$graph->title->SetFont(FF_ARIAL, FS_NORMAL);
$graph->xaxis->title->SetFont(FF_VERDANA, FS_ITALIC);
$graph->yaxis->title->SetFont(FF_TIMES, FS_BOLD);

// Назовем оси:
$graph->xaxis->title->Set('Время');
$graph->yaxis->title->Set('Деньги');

// Выделим оси цветом:
$graph->xaxis->SetColor('#СС0000');
$graph->yaxis->SetColor('#СС0000');

// Зададим толщину кривой:
$lineplot->SetWeight(3);

// Обозначим точки звездочками, задав тип маркера:
$lineplot->mark->SetType(MARK_FILLEDCIRCLE);

// Выведем значения над каждой из точек:
$lineplot->value->Show();

// Фон графика зальем градиентом:
$graph->SetBackgroundGradient('ivory', 'orange');

// Придадим графику тень:
$graph->SetShadow(4);

/*
Выведем получившееся изображение в браузер (в случае если
при создании объекта graph последний параметр был false, 
изображение будет сохранено в кеше, но не выдано в браузер)
*/

$graph->Stroke();


?>