document.addEventListener("DOMContentLoaded", init);
//document.addEventListener("load", init);

let datePickerFrom = false;
let datePickerTo = false;

function init()
{
	google.charts.load('current', {'packages':['corechart']});

	var sMachine = document.getElementById('sendMachinefff');
	sMachine.addEventListener("change", updateMachine);

	//  создаем выбиралку дат ОТ
	datePickerFrom = $("#datetimefrom").datetimepicker({
		timepicker:true,
		//lang: 'ru',
		format: 'd.m.Y H',
		theme: 'dark',
		inline: true,
		formatDate: 'd.m.Y',
		formatTime:'H',
		onChangeDateTime:function(dp, input){
			var machine = document.getElementById('sendMachinefff').value;
			if (machine === '') return;
			var date = input.val();
			console.log(machine + " -> " + date);
			// делаем минимальный выбор ДО равным выбранному значению ОТ, чтобы не вышло что ОТ - позднее ДО
			datePickerTo = $("#datetimeto").datetimepicker({
				value: date,
				minDateTime: date,
			});
			getData(machine, date, datePickerTo.val());
		}
	});

	//  создаем выбиралку дат ДО
	datePickerTo = $("#datetimeto").datetimepicker({
		timepicker:true,
		//lang: 'ru',
		format: 'd.m.Y H',
		theme: 'dark',
		inline: true,
		formatDate: 'd.m.Y',
		formatTime:'H',
		onChangeDateTime:function(dp, input){
			var machine = document.getElementById('sendMachinefff').value;
			if (machine === '') return;
			var date = input.val();
			console.log(machine + " -> " + date);
			getData(machine, datePickerFrom.val(), date);
		}
	});

	$("#allTime").click('click', () => {
		var machine = document.getElementById('sendMachinefff').value;
		if (machine === '') return;
		getData(machine);
	})
}

// получаем данные по рэйнджу
function getData(machine, dateFrom = null, dateTo = null)
{
	$.when($.ajax({
		url: 'core/parsing.php',
		type: 'POST',
		data: {
			action: "getData",
			machine: machine,
			dateFrom: encodeURIComponent(dateFrom),
			dateTo: encodeURIComponent(dateTo)
		},
		contentType: 'application/x-www-form-urlencoded',
		success: result => {
			return result
		}
	})).done((result) => {
		var dataArr = [];
		for (var i = 0; i < result.length; i++) {
			dataArr.push([new Date(result[i][4] * 1000), result[i][0]]);
		}
		drawChart(dataArr);
	})
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

	var table = new google.visualization.DataTable();
	table.addColumn('date', 'Date');
	table.addColumn('number', 'Machine_Work');
	table.addRows(arr);
		
    var options = {
    	title: 'Работа станка',
        curveType: 'none',
		// curveType: 'function',
        legend: { position: 'bottom' }
	};
		
    var chart = new google.visualization.LineChart(document.getElementById('graph_end'));
    chart.draw(table, options);
}

// function getDataForDay(machine, date)
// {
// 	//1. Сбор данных, необходимых для выполнения запроса на сервере
// 	// TODO: в идеале надо блочить select для перевыбора
// 	$.when($.ajax({
// 		url: 'core/parsing.php',
// 		type: 'POST',
// 		data: {
// 			action: "getDataForDay",
// 			machine: encodeURIComponent(machine),
// 			datefrom: encodeURIComponent(date)
// 		},
// 		contentType: 'application/x-www-form-urlencoded',
// 		success: result => {
// 			return result
// 		}
// 	})).done((result) => {
// 		var obj = jQuery.parseJSON(result);
// 		var dataArr = [];
// 		for (var i = 0; i < obj.length; i++) {
// 			dataArr.push([new Date(obj[i][4] * 1000), obj[i][0]]);
// 		}
// 		drawChart(dataArr);
// 	})
// }

function updateMachine() {
    //alert('ok');
	updateCalendar();
}

// добавляем в календарь границы минимально и максимально возможной даты
function updateCalendar(){
	$.when(getMinAndMaxTime()).done((days) => {
		datePickerFrom.datetimepicker({
			value: days.minDays,
			maxDate: days.maxDays,
			minDate: days.minDays
		});
		datePickerTo.datetimepicker({
			value: days.minDays,
			maxDate: days.maxDays,
			minDate: days.minDays
		});
	})
}

async function getMinAndMaxTime() {
	var machine = document.getElementById('sendMachinefff').value;
	return $.ajax({
		url: 'core/parsing.php',
		type: 'POST',
		data: {
			action: "getMinAndMaxTime",
			machine: encodeURIComponent(machine)
		},
		contentType: 'application/x-www-form-urlencoded',
		success: result => {
			return result
		}
	})
}
