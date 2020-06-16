<?php 
session_start();
include('db.php');  
include('diagram.php');

if ($_POST["OT"] == NULL)
    $_SESSION["OT"] = '3.16.12.19';
else 
    $_SESSION["OT"] = $_POST["OT"];
if ($_POST["DO"] == NULL)
    $_SESSION["DO"] = '12.16.12.19';
else 
    $_SESSION["DO"] = $_POST["DO"];
    $_SESSION["COUNT"] = $_POST["COUNT"];


$arr1 = Data_selection($_SESSION["OT"], $_SESSION["DO"], $_SESSION["COUNT"]);

fg(formatting_tip_g($arr1));
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





<form action="1.php" method="post">
    <div>
        <img src="example3.png">
        <p>OT:<input type="text" name="OT" value="<?=$_SESSION["OT"]?>" /> 
        DO:<input type="text" name="DO" value="<?=$_SESSION["DO"]?>" /> 
        COUNT:<input type="text" id="count" name="COUNT" value="<?=$_SESSION["COUNT"]?>" />
        <button type="submit" />@</button></p>
    </div>
</form>