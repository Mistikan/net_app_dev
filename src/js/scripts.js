document.addEventListener("DOMContentLoaded", init);
//document.addEventListener("load", init);
function init()
{
	google.charts.load('current', {'packages':['corechart']});

	var sMachine = document.getElementById('sendMachinefff');
	sMachine.addEventListener("click", sendMachine);
	
	$("#datetime").datetimepicker({
		timepicker:false,
		//lang: 'ru',
		format: 'd.m.Y',
		theme: 'dark',
		inline: true,
		formatDate: 'd.m.Y',
		/*
		value: '16.12.2019',
		minDate: '16.12.2019',
		maxDate: '18.12.2019',
		*/
	});

	$("#datetime").datetimepicker({
	onChangeDateTime:function(dp, $input){ 
			// TODO: в генерируемом списке баз должен быть один элемент обязательно выбран, ибо в ином случае machine пустой получается
			var machine = document.getElementById('sendMachinefff').value;
			var date = $input.val();
			console.log(machine + " -> " + date);
			getDataForDay(machine, date);
		}
	});
}

function sendMachine()
{
	//1. Сбор данных, необходимых для выполнения запроса на сервере
	var machine = document.getElementById('sendMachinefff').value;
	//Подготовка данных для отправки на сервер
	//т.е. кодирование с помощью метода encodeURIComponent
	name = 'action=getCalendar&machine=' + encodeURIComponent(machine);
	//name = 'action=getMinAndMaxTime&machine=' + encodeURIComponent(machine);
	// 2. Создание переменной request
	var request = new XMLHttpRequest();
	// 3. Настройка запроса
	request.open('POST','core/parsing.php',true);
	// 4. Подписка на событие onreadystatechange и обработка его с помощью анонимной функции
	request.addEventListener('readystatechange', function() {
		//если запрос пришёл и статус запроса 200 (OK)
		if ((request.readyState == 4) && (request.status == 200)) {
			// например, выведем объект XHR в консоль браузера
			// console.log(request);
			// и ответ (текст), пришедший с сервера в окне alert
			// console.log(request.responseText);
			/*
			var obj = jQuery.parseJSON(request.responseText);
			var minTime = obj[0];
			var maxTime = obj[1];
			console.log(minTime);
			console.log(maxTime);
			*/
			// получить элемент c id = calendar
			var calendar = document.getElementById('calendar');
			// заменить содержимое элемента ответом, пришедшим с сервера
			calendar.innerHTML = request.responseText;
		}
	});
	// Устанавливаем заголовок Content-Type(обязательно для метода POST). Он предназначен для указания кодировки, с помощью которой зашифрован запрос. Это необходимо для того, чтобы сервер знал как его раскодировать.
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	// 5. Отправка запроса на сервер. В качестве параметра указываем данные, которые необходимо передать (необходимо для POST)
	request.send(name);
}

function drawChart(arr)
{
	/*
	arr - массив с данными.
	Первый элемент массива - время в Unix Time
	Второй элемент массива - значение
	Example arr:
	var arr = new Array(		
		[new Date(1576500172 * 1000),  2000],
		[new Date(1576500182 * 1000),  660 ],
		[new Date(1576500192 * 1000),  1030],	
		[new Date(1576500202 * 1000),  10  ],
		[new Date(1576500212 * 1000),  500 ],
	);
	*/
		
	var data = new google.visualization.DataTable();
	data.addColumn('date', 'Date');
	data.addColumn('number', 'Machine_Work');
	data.addRows(arr);
		
    var options = {
    	title: 'Работа станка',
        curveType: 'none',
		// curveType: 'function',
        legend: { position: 'bottom' }
	};
		
    var chart = new google.visualization.LineChart(document.getElementById('graph_end'));
    chart.draw(data, options);
}

function sendDate() {
	//1. Сбор данных, необходимых для выполнения запроса на сервере
	// TODO: в идеале надо блочить select для перевыбора
	var machine = document.getElementById('sendMachinefff').value;
	var date = document.getElementById('dateFromCalendar').value;
	//Подготовка данных для отправки на сервер
	//т.е. кодирование с помощью метода encodeURIComponent
	getDataForDay(machine, date);
}

function getDataForDay(machine, date) 
{
	//1. Сбор данных, необходимых для выполнения запроса на сервере
	// TODO: в идеале надо блочить select для перевыбора
	//var machine = document.getElementById('sendMachinefff').value;
	//var date = document.getElementById('dateFromCalendar').value;
	//Подготовка данных для отправки на сервер
	//т.е. кодирование с помощью метода encodeURIComponent
	name = 'action=getDataForDay&machine=' + encodeURIComponent(machine)+'&date='+encodeURIComponent(date);
	// 2. Создание переменной request
	var request = new XMLHttpRequest();
	// 3. Настройка запроса
	request.open('POST','core/parsing.php',true);
	// 4. Подписка на событие onreadystatechange и обработка его с помощью анонимной функции
	request.addEventListener('readystatechange', function() {
		//если запрос пришёл и статус запроса 200 (OK)
		if ((request.readyState==4) && (request.status==200)) {
		// например, выведем объект XHR в консоль браузера
			//console.log(request);
			// и ответ (текст), пришедший с сервера в окне alert
			//console.log(request.responseText);
			// получить элемент c id = graph
			var graph = document.getElementById('graph');
			// заменить содержимое элемента ответом, пришедшим с сервера
			// graph.innerHTML = request.responseText; <- ВАЖНАЯ СТРОКА
			var obj = jQuery.parseJSON(request.responseText);
			
			var dataArr = new Array();
			for (var i = 0; i < obj.length; i++) {
				dataArr.push([new Date(obj[i][4]* 1000), obj[i][0]]);
			}
			//  console.log(dataArr);
			drawChart(dataArr);
			
			
		}
	});
	// Устанавливаем заголовок Content-Type(обязательно для метода POST). Он предназначен для указания кодировки, с помощью которой зашифрован запрос. Это необходимо для того, чтобы сервер знал как его раскодировать.
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	// 5. Отправка запроса на сервер. В качестве параметра указываем данные, которые необходимо передать (необходимо для POST)
	request.send(name);
}

function updateMachine() {
    //alert('ok');
	updateCalendar();
}

function updateCalendar(){
	// TODO: короче, эти две функции надо переписать так, чтобы по возврату ОБОИХ значений обновлялись данные в календаре.
	// Здесь можно поправить как и стороны php, дергая только один запрос, или поместить в одну функцию два запроса и ждать готовности обоих, а потом обновлять
	gnD();
	gxD();
}

function gnD(){
	var machine = document.getElementById('sendMachinefff').value;
	console.log(machine);
	name = 'action=getMinDay&machine=' + encodeURIComponent(machine);
	var request = new XMLHttpRequest();
	request.open('POST','core/parsing.php',true);
	request.addEventListener('readystatechange', function() {
		if ((request.readyState==4) && (request.status==200)) {
			console.log("Min Day:" + request.responseText);
			$("#datetime").datetimepicker({
				onGenerate:function( ct ){
				$(this).find('.xdsoft_date');
			},
				value: request.responseText,
				minDate:request.responseText,

			});
	}});
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(name);
};

function gxD(){
	var machine = document.getElementById('sendMachinefff').value;
	name = 'action=getMaxDay&machine=' + encodeURIComponent(machine);
	var request = new XMLHttpRequest();
	request.open('POST','core/parsing.php',true);
	request.addEventListener('readystatechange', function() {
		if ((request.readyState==4) && (request.status==200)) {
			console.log("Max Day:" + request.responseText);
			$("#datetime").datetimepicker({
				onGenerate:function( ct ){
				$(this).find('.xdsoft_date');
			},
				maxDate: request.responseText,
			});
		}});
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send(name);
};
