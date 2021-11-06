<?php
ob_start();
if(!isset($_SESSION['user'])){
    session_start();
}
if(!isset($_SESSION['user'])){
    header("location:../404.php?level=member atau admin");
}else{
    $level=$_SESSION['level'];
    if(!($level=="member" or $level=="admin")){
        header("location:../404.php?level=member atau admin");
    }
}
ob_flush();
?>