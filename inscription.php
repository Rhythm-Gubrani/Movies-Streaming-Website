<?php
$msg = "";
session_start();
//On vérifie que ce qu'on doit ajouter est set et pas vide avant d'accéder à la
if (isset($_POST['username']) && isset($_POST['password1']) && isset($_POST['email']) && $_POST['username']!="" && $_POST['password1']!="" && $_POST['email']!="" ) {
  try{

    //On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=Getflix;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }catch (Exception $e) {

    //En cas d'erreur on affiche un message et on arrete tout
    die('Erreur : ' . $e->getMessage());
  }

  $req = $bdd->query('SELECT username,email FROM users') or die(print_r($bdd->errorInfo()));

  $ok = true;
  while ($donnees = $req->fetch()) {
    if($donnees['username'] == trim($_POST['username'])){
      $ok = false;
      $msg .= " Username taken ";
    }
    if ($donnees['email'] == $_POST['email']) {
      $ok = false;
      $msg .= " Email already in use ";
    }
  }

  if($_POST['password1']==$_POST['password2'] && valid_email($_POST['email']) && $ok) {
    $req = $bdd->prepare('INSERT INTO users(username,password,email,status) VALUES(:username,:password,:email,1)') or die(print_r($bdd->errorInfo()));

    $req->execute(array(
      'username'=>htmlspecialchars(trim($_POST['username'])),
      'password'=>password_hash(htmlspecialchars($_POST['password1']), PASSWORD_DEFAULT),
      'email'=>htmlspecialchars($_POST['email'])
    ));
    $_SESSION['inscription'] = true;
    header("Location: ./connexion.php");

  }
}
elseif((isset($_POST['username']) && isset($_POST['password1']) && isset($_POST['email']) && isset($_POST['password2']))
&&
($_POST['username'] == "" || $_POST['password1'] == ""  || $_POST['password2'] =="" || $_POST['email'] =="") ) {
    $msg = "One or more fields are empty !!!";
}
function valid_email($str) {
return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <link rel="apple-touch-icon" sizes="180x180" href="css/media/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="css/media/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="css/media/favicon/favicon-16x16.png">
    <link rel="manifest" href="css/media/favicon/site.webmanifest">
      <title>Sign up</title>
  </head>
  <body>
  <nav class="navbar navbar-light bg-transparent">
    <a class="navbar-brand" href="connexion.php">
      <img src="css/media/logo.gif" width="190" height="70" alt="">
    </a>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-md">
      </div>
      <div class="col-md col-sm-12 col-xs-12">
  <div id="main">
      <h3>Sign up</h3>
      <p style="color:red;padding:0;margin:0;"><?php echo $msg ?></p>
      <form action="inscription.php" method="POST">
              <input class="input" type="email" placeholder="E-mail" name="email" autocomplete="off"><br>
              <input class="input" type="text" placeholder="Username" name="username" autocomplete="off"><br>
              <input class="input" type="password" placeholder="Password" name="password1" id="password" onkeyup="check()" autocomplete="off"><br>
              <input class="input" type="password" placeholder="Confirm password" name="password2" id="confirm_password" onkeyup="check()" autocomplete="off">
              <br>
              <span id='message'></span><br>

              <input id="connect" type="submit" name="submit" value="Sign Up">
          </form>
      <p>Already Moviesflix's account ? <a href="connexion.php">Sign in</a> </p>
  </div>
      </div>
      <div class="col-md">
      </div>
    </div>

  </div>




    <script>
      var check = function() {
        if (document.getElementById('password').value ==
          document.getElementById('confirm_password').value && document.getElementById('password').value != "") {
          document.getElementById('message').style.color = 'green';
          document.getElementById('message').innerHTML = '<span>matching</span>';
        } else {
          document.getElementById('message').style.color = 'red';
          document.getElementById('message').innerHTML = '<span>not matching</span>';
        }
      }
      </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>




  </body>
</html>
