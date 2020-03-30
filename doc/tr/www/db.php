<?php 
session_start();
$arr = array();

if ($_SESSION["arr"] != NULL){
    $arr = $_SESSION["arr"];
}
else {
    $read = file('bz.txt');
    foreach($read as $line) {
        $arr[] = $line;
    }
    $_SESSION["arr"] = $arr;
}    



//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
function Sorting($from, $before, $t){
    $t = explode(".", $t);
    for($i = 3, $j = count($from) - 1; $i >= 4 - count($from); $i--, $j--){
        if ($t[$i] < $from[$j] || $before[$j] < $t[$i]){
            return false;
        }
    }
    return true;
}


function Data_compression($arr, $n){
    $filter_arr = array();  
    for($i = 0; $i < $n; $i++){
        $sum = 0;
        $sumF = 0;
        $sumB = 0;
        for($j = 0; $j < count($arr)/$n; $j++){
            if ($arr[$i*(count($arr)/$n-1) + ($i + $j)] != NULL){
                $line = $arr[$i*(count($arr)/$n-1) + ($i + $j)];
                $line = explode("*", $line);
                if ($line[0] == NULL)
                    $line0[0] = 0;
                if ($line[1] == NULL)
                    $line0[1] = 0;
                $sumF += $line[0];
                $sumB += $line[1];
                $sum++;
            }
        }
        if ($sum != 0){
            $sumF /= $sum;
            $sumB /= $sum;
            $filter_arr[] = $sumF.'*'.$sumB;
        }
    }
    return $filter_arr;
}


function Data_selection($from = 19, $before = 19, $n = 0){
    global $arr;
    $filter_arr = array();
    $from = explode(".", $from);
    $before = explode(".", $before);
    foreach($arr as $line){
        $t = $line;
        $line = explode("*", $line);
        if ($n == 0){ 
            $n = $before[0] - $from[0];
            if ($n == 0)
                $n = 1;
        }
        if (Sorting($from, $before, date('h.d.m.y', $line[4])))
            $filter_arr[] = $t;      
    }
    $filter_arr = Data_compression($filter_arr, $n);
    return $filter_arr;
}


function formatting_tip_k($arr){
    $arrF = 0;
    $arrB = 0;
    for($i = 0; $i < count($arr); $i++){
        $t = explode("*", $arr[$i]);
        $arrF += $t[0];
        $arrB += $t[1];
    }
    return array($arrF, $arrB);
}

function formatting_tip_g($arr){
    $arrF = array();
    $arrB = array();
    for($i = 0; $i < count($arr); $i++){
        $t = explode("*", $arr[$i]);
        $arrF[] = $t[0];
        $arrB[] = $t[1];
    }
    return array($arrF, $arrB);
}

function formatting_tip_d($arr){
    $arr2 = array();
    for($i = 0; $i < count($arr); $i++){
        $t = explode("*", $arr[$i]);
        $arr2[] = $t[0] - $t[1];
    }
    return $arr2;
}
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
?>