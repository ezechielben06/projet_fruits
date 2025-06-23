<?php
    define('HOST','localhost');
    define('USER','root');
    define('PASS','');
    define('DATABASE','greenshop');
    $conn=mysqli_connect(HOST,USER,PASS,DATABASE)or die("connexion échoué");
?>