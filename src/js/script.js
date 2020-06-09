$(document).ready(function(){
	// //станок
	// $('#select1').text($("#st1").text());
	// $('h2').text($("#st1").text());
	//
	// $("#st1").click(function(){
	// 	   $('#select1').text($("#st1").text());
	//     $('h2').text($("#st1").text());
    // });
    // $("#st2").click(function(){
	//     $('#select1').text($("#st2").text());
	//     $('h2').text($("#st2").text());
    // });
    // $("#st3").click(function(){
    // 	   $('#select1').text($("#st3").text());
    // 	   $('h2').text($("#st3").text());
    // });

    //промежуток
    $('#select2').text($("#d1").text());
    
    $("#d1").click(function(){ 
        $('#select2').text($("#d1").text());               
    });   
    $("#d2").click(function(){  
        $('#select2').text($("#d2").text());              
    }); 
    $("#d3").click(function(){ 
        $('#select2').text($("#d3").text());              
    }); 
    $("#d4").click(function(){ 
        $('#select2').text($("#d4").text());              
    }); 
    $("#d5").click(function(){ 
        $('#select2').text($("#d5").text());              
    }); 

	//график	  
    $("#r1").click(function(){ 
    	$('#grafic').css('display','block'); 
    	$('#diagram').css('display','none');              
    });   

    //диаграмма
    $("#r2").click(function(){      
    	$('#grafic').css('display','none'); 
    	$('#diagram').css('display','block');         
    }); 

    // //input
    // $('#date_timepicker_start').datetimepicker({
    //       format:'d.m.Y H:i',
    //       lang:'ru'
    // });
    // $('#date_timepicker_end').datetimepicker({
    //       format:'d.m.Y H:i',
    //       lang:'ru'
    // });
    // $("#date_timepicker_start").change(function(){
    //     $("#date_timepicker_end").datetimepicker('show');
    // });

});
