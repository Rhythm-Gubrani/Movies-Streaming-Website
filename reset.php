
<?php

session_start();
  try {
  $bdd = new PDO('mysql:host=localhost; dbname=Getflix', 'root', '');
  }
  catch (Exception $e){
  die('Erreur : ' . $e->getMessage());
  }
  
if(isset($_POST['recup_submit']) && isset($_POST['recup_mail']) && $_POST['recup_mail']!="") { //check if fields are empty
      $etape1=false;
  $recup_mail = htmlspecialchars($_POST['recup_mail']); //check if mail have the good characteres
      if(filter_var($recup_mail,FILTER_VALIDATE_EMAIL)) {   //mail validation
        echo $recup_mail;
         $mailexist = $bdd->prepare('SELECT email FROM users WHERE email = ?'); //verfy mail exits in our bdd
         $mailexist->execute(array($recup_mail));
         if($mailexist) {
          echo "mail existant en bdd";
            $_SESSION['recup_mail'] = $recup_mail;
            $recup_code = "";
          //creation code aleatoire
            for($i=0; $i < 8; $i++) { 
              $recup_code .= mt_rand(0,9);
            }
            echo $recup_code;
          }
          mail($recup_mail,"Password lost from GETFLIX",$recup_code);
          $insert = $bdd->prepare('INSERT INTO recuperation(email, code) VALUES (?,?)');
          $insert->execute(array($recup_mail,$recup_code));
        }   
      }
      
      if(isset($_POST['verif_code']) && isset($_POST['verif_mail']) && trim($_POST['verif_mail']) != "" ){
         $req=$bdd->prepare('SELECT email, code FROM recuperation WHERE email = ? AND code = ?');

         if($req->execute(array($_POST['verif_mail'],$_POST['verif_code']))){

            $req=$bdd->query('SELECT username, password, id, status FROM users WHERE email = '.$_POST['verif_mail']);
            
            $_SESSION['username']=$req['username'];
            $_SESSION['password']=$req['password'];
            $_SESSION['id_user']=$req['id'];
            $_SESSION['status']=$req['status'];
            
            header("Location: ./settings.php");
         }else{
            echo "Wrong code";
         }
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
    <title>Forgot password</title>
</head>
<body>
<nav class="navbar navbar-light bg-transparent">
  <a class="navbar-brand" href="connexion.php">
    <div class="logo"><img src="css/media/logo.gif" width="100%" alt="logo"></div>
  </a>
</nav>
<div class="container">
  <div class="row">
    <div class="col-md">
    </div>
    <div class="col-md col-sm-12 col-xs-12">
<div id="main">
  <h3>Forgot password</h3>
   <?php if(isset($_POST['recup_mail']) && trim($_POST['recup_mail']) != "") { ?>  
       
      <form method='POST'>
      <input type= 'email' placeholder="yourmail@gmail.com" name="verif_mail"/><br>
       <input type='number' placeholder='Code de vérification' name='verif_code'/><br/>
       <input type='submit' value='Valider' name='verif_submit'/>
     </form>";        
      <?php } ?>


                
   <?php if(!isset($_POST['recup_mail'])){ ?>
    <form method="POST">
    <input class="input" type="email" placeholder="  E-mail" name="recup_mail"><br>
      <span id='message'></span><br>
    <input id="connect" type="submit" name="recup_submit" value="Send an Email">
  </form>
   <?php } ?>  
      <p>Already an account ? <a href="connexion.php">Sign in</a> </p>
  </div>
    </div>
    <div class="col-md">
    </div>
  </div>
</div>
       
<script type="text/javascript">
    var check = function() {
      if (document.getElementById('password').value ==
        document.getElementById('confirm_password').value) {
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