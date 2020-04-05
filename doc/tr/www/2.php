<?php 
session_start();
include('db.php');  
include('diagram.php');

$_SESSION["COUNT3"] = $_POST["COUNT3"];
if ($_POST["OT3"] == NULL)
    $_SESSION["OT3"] = '16.12.19';
else 
    $_SESSION["OT3"] = $_POST["OT3"];
if ($_POST["DO3"] == NULL){
    $_SESSION["DO3"] = '16.12.19';
    $_SESSION["COUNT3"] = 10;
}   
else 
    $_SESSION["DO3"] = $_POST["DO3"];


$arr3 = Data_selection($_SESSION["OT3"], $_SESSION["DO3"], $_SESSION["COUNT3"]);
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





<form action="2.php" method="post">
    <div>
        <img src="Naked.png">
        <p>OT:<input type="text" name="OT3" value="<?=$_SESSION["OT3"]?>" /> 
        DO:<input type="text" name="DO3" value="<?=$_SESSION["DO3"]?>" /> 
        COUNT:<input type="text" id="count" name="COUNT3" value="<?=$_SESSION["COUNT3"]?>" />
        <button type="submit" />@</button></p>
    </div>
</form>