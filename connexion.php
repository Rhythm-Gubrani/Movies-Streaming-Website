<?php
$error = "";
session_start();
// verifie si ya un cookie , si oui il redirige directement vers index.php
if(isset($_SESSION['username'])&& isset($_SESSION['password'])){
  header("Location: ./index.php");
}
if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] !="" && $_POST['password'] !="" ) {
  try{

    //On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=Getflix;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }catch (Exception $e) {

    //En cas d'erreur on affiche un message et on arrete tout
    die('Erreur : ' . $e->getMessage());
  }

  $req = $bdd->prepare('SELECT id , username , password , status FROM users WHERE username = :username');
  $req->execute(array(
      'username' => $_POST['username']
      ));
  $resultat = $req->fetch();
  if($resultat[1]==""){
    $error="<span id='error' style='color:red;font-size:24px;position:relative;top:10px;'> Username not registered. !</span>";
  }
  else{


  //verifie si $resultat est pas vide et que le mot de passe equivaut + creation session
if ($resultat !="" &&  password_verify($_POST['password'],$resultat['password'])){
  $_SESSION['username']=$_POST['username'];
  $_SESSION['password']=$_POST['password'];
  $_SESSION['id_user']=$resultat['id'];
  $_SESSION['status']=$resultat['status'];

      //se souvenir de moi
    if(isset($_POST['remember'])){
        setcookie("username",$_POST['username'],time()+10000,null,null,false,true);
        setcookie("password",$_POST['password'],time()+10000,null,null,false,true);
        setcookie("status",$_POST['status'],time()+10000,null,null,false,true);

      }
      header("Location: ./index.php");
}
//affichage message d'erreur
else{
  $error="<span id='error' style='color:red;font-size:24px;position:relative;top:10px;'> Wrong password !</span>";
}
}
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="css/style.css">
      <link rel="apple-touch-icon" sizes="180x180" href="css/media/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="css/media/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="css/media/favicon/favicon-16x16.png">
    <link rel="manifest" href="css/media/favicon/site.webmanifest">
      <title>Sign in</title>
  </head>
  <body>

  <nav class="navbar navbar-light bg-transparent">
      <img src="css/media/logo.png" width="220" height="70" alt="logo" >
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md">

      </div>
      <div class="col-md col-sm-12">
        <div id="main">
          <?php if(isset($_SESSION['inscription']) && $_SESSION['inscription'] ) { ?>
            <span style="color:green;font-weigth:bolder;font-size:200%;position:relative;">Successful registration !</span>
          <?php
            $_SESSION['inscription'] = false;
          } ?>
          <h3>Sign in</h3>
          <form method="POST" action="connexion.php" >
          <input class="input" type ="text" name="username" placeholder="Username" autocomplete="off"><br>
          <input class="input" type ="password" name="password" placeholder="Password"><br>
          <input type="checkbox" name="remember"> <label>Remember me</label> <br>
          <a href="reset.php">Forgot password ? </a><br>
          <input id="connect" type="submit" name="submit" value="Sign in">
          </form>
          <?php echo $error; ?>
          <p> New to MoviesFlix ? <a href="inscription.php">Sign up now</a> </p>

        </div>
      </div>
      <div class="col-md">

      </div>
    </div>
  </div>
  <!-- <footer>
    <div class="TMdb">
      <img src="css/media/logo.svg" width="20%" alt="logo"><br>
      "This product uses the TMDb API but <br> is not endorsed or certified by TMDb." -->
    </div>
  </footer>





  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </body>
</html>
