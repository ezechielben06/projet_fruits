<?php
require_once('connexion.php');
 if($_SERVER['REQUEST_METHOD']=="POST"){
    $password=md5($_POST['password']);
    $req=sprintf("INSERT INTO utilisateurs values(NULL,'%s','%s','%s')", $_POST['nom'], $_POST['email'], $password);
    $result=mysqli_query($conn,$req);
header("location:index.php?pg=connecte");
}
