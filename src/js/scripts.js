document.addEventListener("DOMContentLoaded", init);
//document.addEventListener("load", init);
function init()
{
	google.charts.load('current', {'packages':['corechart']});

	var sMachine = document.getElementById('sendMachinefff');
	sMachine.addEventListener("change", updateMachine);

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
	onChangeDateTime:function(dp, input){
			var machine = document.getElementById('sendMachinefff').value;
			if (machine === '') return;
			var date = input.val();
			console.log(machine + " -> " + date);
			getDataForDay(machine, date);
		}
	});
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

function getDataForDay(machine, date) 
{
	//1. Сбор данных, необходимых для выполнения запроса на сервере
	// TODO: в идеале надо блочить select для перевыбора
	$.when($.ajax({
		url: 'core/parsing.php',
		type: 'POST',
		data: {
			action: "getDataForDay",
			machine: encodeURIComponent(machine),
			date: encodeURIComponent(date)
		},
		contentType: 'application/x-www-form-urlencoded',
		success: result => {
			return result
		}
	})).done((result) => {
		var obj = jQuery.parseJSON(result);
		var dataArr = [];
		for (var i = 0; i < obj.length; i++) {
			dataArr.push([new Date(obj[i][4] * 1000), obj[i][0]]);
		}
		drawChart(dataArr);
	})
}

function updateMachine() {
    //alert('ok');
	updateCalendar();
}

// добавляем в календарь границы минимально и максимально возможной даты
function updateCalendar(){
	$.when(getMinAndMaxTime()).done((days) => {
		$("#datetime").datetimepicker({
			onGenerate: function (ct) {
				$(this).find('.xdsoft_date');
			},
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
