<?php   
include("pChart/pData.class");   
include("pChart/pChart.class"); 



function fg($arr){
 // Dataset definition   
    $DataSet = new pData;  
    $DataSet->AddPoint($arr[0],"Serie1");  
    $DataSet->AddPoint($arr[1],"Serie2");  
    $DataSet->AddAllSeries();  
    $DataSet->SetAbsciseLabelSerie();  
    $DataSet->SetSerieName("Work","Serie1");  
    $DataSet->SetSerieName("Plain","Serie2");  
    
    // Initialise the graph  
    $Test = new pChart(700,230);  
    $Test->setFontProperties("Fonts/tahoma.ttf",8);  
    $Test->setGraphArea(50,30,680,200);  
    $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);  
    $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);  
    $Test->drawGraphArea(255,255,255,TRUE);  
    $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
    $Test->drawGrid(4,TRUE,230,230,230,50);  
    
    // Draw the 0 line  
    $Test->setFontProperties("Fonts/tahoma.ttf",6);  
    $Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
    
    // Draw the bar graph  
    $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
    
    // Finish the graph  
    $Test->setFontProperties("Fonts/tahoma.ttf",8);  
    $Test->drawLegend(596,150,$DataSet->GetDataDescription(),255,255,255);  
    $Test->setFontProperties("Fonts/tahoma.ttf",10);  
    $Test->drawTitle(50,22,"Example 12",50,50,50,585);  
    $Test->Render("example3.png");  
}



function fk($arr){
    // Dataset definition   
    $DataSet = new pData;  
    $DataSet->AddPoint($arr,"Serie1");  
    $DataSet->AddPoint(array("Work","Plain"),"Serie2");  
    $DataSet->AddAllSeries();  
    $DataSet->SetAbsciseLabelSerie("Serie2");  
    
    // Initialise the graph  
    $Test = new pChart(300,200);  
    $Test->loadColorPalette("Sample/softtones.txt");  
    $Test->drawFilledRoundedRectangle(7,7,293,193,5,240,240,240);  
    $Test->drawRoundedRectangle(5,5,295,195,5,230,230,230);  
    
    // This will draw a shadow under the pie chart  
    $Test->drawFilledCircle(122,102,70,200,200,200);  
    
    // Draw the pie chart  
    $Test->setFontProperties("Fonts/tahoma.ttf",8);  
    $Test->drawBasicPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),120,100,70,PIE_PERCENTAGE,255,255,218);  
    $Test->drawPieLegend(230,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
    
    $Test->Render("example14.png");  
}



function fd($arr){
    // Dataset definition   
    $DataSet = new pData;  
    $DataSet->AddPoint($arr);  
    $DataSet->AddSerie();  
    $DataSet->SetSerieName("Work/Plain","Serie1");  
    
    // Initialise the graph  
    $Test = new pChart(700,230);  
    $Test->setFontProperties("Fonts/tahoma.ttf",10);  
    $Test->setGraphArea(40,30,680,200);  
    $Test->drawGraphArea(252,252,252);  
    $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);  
    $Test->drawGrid(4,TRUE,230,230,230,255);  
    
    // Draw the line graph  
    $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());  
    $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);  
    
    // Finish the graph  
    $Test->setFontProperties("Fonts/tahoma.ttf",8);  
    $Test->drawLegend(45,35,$DataSet->GetDataDescription(),255,255,255);  
    $Test->setFontProperties("Fonts/tahoma.ttf",10);  
    $Test->drawTitle(60,22,"My pretty graph",50,50,50,585);  
    $Test->Render("Naked.png");  
}

?>