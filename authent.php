<?php

session_start();
require('connexion.php');
//s'il y avait une session on la detruit
if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
    $_SESSION = array();
    session_unset();
    session_destroy();
    unset($_SESSION);
}
if($_SERVER['REQUEST_METHOD']=="POST"){
// Vérifier si les champs sont remplis
   if (!empty($_POST['email']) && !empty($_POST['password'])) {
    // Sécuriser les entrées utilisateur
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password =md5(mysqli_real_escape_string($conn, $_POST['password']));
    // Requête pour vérifier l'existence de l'utilisateur
    $req = "SELECT * FROM utilisateurs WHERE email ='$email' AND passwd='$password'";
    $result = mysqli_query($conn, $req);
    // Vérifier si un seul utilisateur est trouvé
       if ($result && mysqli_num_rows($result) == 1) {
        $info_user = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $info_user['email'];
        header('Location: index.php?pg=confirm');
        exit();
       } else {
        // Redirection en cas d'erreur d'authentification
        header('Location: index.php?pg=connecte&error=1');
        exit();
      }
   }
}

?>
 