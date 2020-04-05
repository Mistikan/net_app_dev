<?php 
session_start();
include('db.php');  
include('diagram.php');

$_SESSION["COUNT"] = $_POST["COUNT"];
if ($_POST["OT"] == NULL){
    $_SESSION["OT"] = '16.12.19';
    $_SESSION["COUNT"] = 10;
}  
else 
    $_SESSION["OT"] = $_POST["OT"];
if ($_POST["DO"] == NULL)
    $_SESSION["DO"] = '16.12.19';
else 
    $_SESSION["DO"] = $_POST["DO"];


$_SESSION["COUNT3"] = $_POST["COUNT3"];
if ($_POST["OT3"] == NULL)
    $_SESSION["OT3"] = '4.16.12.19';
else 
    $_SESSION["OT3"] = $_POST["OT3"];
if ($_POST["DO3"] == NULL){
    $_SESSION["DO3"] = '12.16.12.19';
}   
else 
    $_SESSION["DO3"] = $_POST["DO3"];


if ($_POST["OT2"] == NULL)
    $_SESSION["OT2"] = '19';
else 
    $_SESSION["OT2"] = $_POST["OT2"];
if ($_POST["DO2"] == NULL)
    $_SESSION["DO2"] = '19';
else 
    $_SESSION["DO2"] = $_POST["DO2"];


$arr1 = Data_selection($_SESSION["OT"], $_SESSION["DO"], $_SESSION["COUNT"]);
$arr2 = Data_selection($_SESSION["OT2"], $_SESSION["DO2"]);
$arr3 = Data_selection($_SESSION["OT3"], $_SESSION["DO3"], $_SESSION["COUNT3"]);

fg(formatting_tip_g($arr1));
fk(formatting_tip_k($arr2));
fd(formatting_tip_d($arr3));
?>

<style>
    input {
        width: 90px;
    }
    #count{
        width: 20px;
    }
    div{
        float: left;
        margin-left: 30px;
        margin-top: 60px;
    }
    p{
        margin-left: 10px;
    }
    a {
        float: left;
        margin-top: 300px;
        margin-left: 10%;
        position-x:fixed;
    }
</style>





<form action="index.php" method="post">
    <div>
        <img src="example3.png">
        <p>OT:<input type="text" name="OT" value="<?=$_SESSION["OT"]?>" /> 
        DO:<input type="text" name="DO" value="<?=$_SESSION["DO"]?>" /> 
        COUNT:<input type="text" id="count" name="COUNT" value="<?=$_SESSION["COUNT"]?>" />
        <button type="submit" />@</button></p>
    </div>

    <div>
        <img src="Naked.png">
        <p>OT:<input type="text" name="OT3" value="<?=$_SESSION["OT3"]?>" /> 
        DO:<input type="text" name="DO3" value="<?=$_SESSION["DO3"]?>" /> 
        COUNT:<input type="text" id="count" name="COUNT3" value="<?=$_SESSION["COUNT3"]?>" />
        <button type="submit" />@</button></p>
    </div>

    <div>
        <img src="example14.png">
        <p>OT:<input type="text" name="OT2" value="<?=$_SESSION["OT2"]?>" /> 
        DO:<input type="text" name="DO2" value="<?=$_SESSION["DO2"]?>" /> 
        <button type="submit" />@</button></p>
    </div>
</form>

<h1>
    <a href="1.php" target="_blank">Bar chart</a>
    <a href="2.php" target="_blank">Schedule</a>
    <a href="3.php" target="_blank">Pie chart</a>
</h1>
