<?php 
session_start();
include('db.php');  
include('diagram.php');


if ($_POST["OT2"] == NULL)
    $_SESSION["OT2"] = '19';
else 
    $_SESSION["OT2"] = $_POST["OT2"];
if ($_POST["DO2"] == NULL)
    $_SESSION["DO2"] = '19';
else 
    $_SESSION["DO2"] = $_POST["DO2"];


$arr2 = Data_selection($_SESSION["OT2"], $_SESSION["DO2"]);

fk(formatting_tip_k($arr2));
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





<form action="3.php" method="post">
    <div>
        <img src="example14.png">
        <p>OT:<input type="text" name="OT2" value="<?=$_SESSION["OT2"]?>" /> 
        DO:<input type="text" name="DO2" value="<?=$_SESSION["DO2"]?>" /> 
        <button type="submit" />@</button></p>
    </div>
</form>
