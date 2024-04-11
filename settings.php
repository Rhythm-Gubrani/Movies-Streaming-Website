<?php

session_start();

  try{

    //Connection to MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=Getflix;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }catch (Exception $e) {

    //If an issue occurs, show a message and stop
    die('Erreur : ' . $e->getMessage());
  }
  // //If btn ban is set, ban user
  // if(isset($_POST['ban'])  && $_SESSION['status'] == 2 ){

  //   $req = $bdd->prepare('DELETE FROM users WHERE id = :id')or die(print_r($bdd->errorInfo()));

  //   $req->execute(array(
  //     'id'=>$_POST['id_user']
  //   ));

  //   $req->closeCursor();

  // }

  // //If condition ok, update user rigths
  // if(isset($_POST['rigth']) && $_POST['rigth'] != "Change status" && $_SESSION['status'] == 2){

  //   $req = $bdd->prepare('UPDATE users SET status = :status WHERE id = :id')or die(print_r($bdd->errorInfo()));

  //   $req->execute(array(
  //     'id'=>$_POST['id_user'],
  //     'status'=>$_POST['rigth']
  //   ));

  //   $req->closeCursor();

  // }
  // //Get all users from db if Admin
  // if ($_SESSION['status'] == 2) {

  //   $card = "<div class='row'>";
  //   $cardEnd = "</div>";

  //   $req = $bdd->query('SELECT id,username,email,status FROM users');

  //   //Show all users in cards with possiblity to ban and change rigths
  //   while ($donnees = $req->fetch()) {
  //     $card .="
  //           <div class='col-auto ml-2 mt-2 mb-2'>
  //             <div class='card' style='width: 18rem;'>
  //               <div class='card-body'>
  //                 <h5 class='card-title'>" . $donnees['username'] ."</h5>
  //                 <p class='card-text'>User email : " . $donnees['email'] ."<br>User status is : " . rigths($donnees['status']) . "</p>
  //                 <form action='' method='post'>
  //                   <input style='visibility:hidden;display:none;' name='id_user' value='" . $donnees['id'] . "' />
  //                   <div class='form-row align-items-center'>
  //                     <div class='col-8 my-1'>
  //                       <label class='mr-sm-2 sr-only' for='inlineFormCustomSelect'>Preference</label>
  //                       <select name='rigth' class='custom-select mr-sm-2' id='inlineFormCustomSelect'>
  //                         <option selected>Change status</option>
  //                         <option value='1'>User</option>
  //                         <option value='2'>Admin</option>
  //                         <option value='3'>Ban from commenting</option>
  //                       </select>
  //                     </div>
  //                     <div class='col-1 my-1'>
  //                       <input style='background-color:#dc3545;color:#fff;border-color:#dc3545' type='submit' class='btn btn-danger' id='enter' value='Change'/>
  //                     </div>
  //                   </div>
  //                 </form>
  //                 <form class='aligne-item-center' action='' method='post'>
  //                   <input style='visibility:hidden;display:none;' name='id_user' value='" . $donnees['id'] . "' />
  //                   <input type='submit' name='ban' value='ban' class='btn btn-danger' />
  //                 </form>
  //               </div>
  //             </div>
  //           </div>";
  //   }
  // }

  //Check if we need to change the username, and if it's ok to do so
  if(isset($_POST['name']) && trim($_POST['name']) != "" ) {
    $req = $bdd->prepare('SELECT username FROM users WHERE username = :username') or die(print_r($bdd->errorInfo()));
    $req->bindValue('username',$_POST['name']);
    $req->execute();
    $resultat = $req->fetch();
    //If the username isn't in the db update username
    if($resultat[0] == false ){
      $req = $bdd->prepare('UPDATE users SET username = :name WHERE username = :username') or die(print_r($bdd->errorInfo()));

      $req->execute(array(
        'name'=>htmlspecialchars(trim($_POST['name'])),
        'username'=>htmlspecialchars($_SESSION['username'])
      ));

      $req->closeCursor();

      $_SESSION['username'] = htmlspecialchars(trim($_POST['name']));
    }
  }

  //Check if we need to change the password, and if it's ok to do so
  if (isset($_POST['password']) && isset($_POST['password1']) && !empty($_POST['password']) && !empty($_POST['password1']) && $_POST['password'] == $_POST['password1'] ) {

    $req = $bdd->prepare('UPDATE users SET password = :password WHERE username = :username') or die(print_r($bdd->errorInfo()));

    $req->execute(array(
      'password'=>password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_DEFAULT),
      'username'=>htmlspecialchars($_SESSION['username'])
    ));

    $req->closeCursor();
  }

  //Check if we need to change the email, and if it's ok to do so
  if (isset($_POST['email']) && valid_email($_POST['email']) ) {

    $req = $bdd->prepare('SELECT email FROM users WHERE email = :email') or die(print_r($bdd->errorInfo()));
    $req->bindValue('email',$_POST['email']);
    $req->execute();
    $resultat = $req->fetch();
    //if the email isn't in the db update email
    if($resultat[0] == false) {
      $req = $bdd->prepare('UPDATE users SET email = :email WHERE username = :username') or die(print_r($bdd->errorInfo()));

      $req->execute(array(
        'email'=>htmlspecialchars($_POST['email']),
        'username'=>htmlspecialchars($_SESSION['username'])
      ));

      $req->closeCursor();
    }

  }

  //Check if we need to change the profile picture
  if (isset($_POST['img']) && $_POST['img'] != "Choose..." ){

    $req = $bdd->prepare('UPDATE users SET img = :img WHERE username = :username') or die(print_r($bdd->errorInfo()));

    $req->execute(array(
      'img'=>$_POST['img'],
      'username'=>htmlspecialchars($_SESSION['username'])
    ));

    $req->closeCursor();
  }

  //Verify if user can get acces to the data
  $ok = false;
  $req = $bdd->query('SELECT username FROM users') or die(print_r($bdd->errorInfo()));
  while ($donnees = $req->fetch()) {
    if($donnees['username'] == $_SESSION['username']){
      $ok = true;
    }
  }

  if(isset($_SESSION['username']) && $ok == true){

  //Show user's datas
  $name = "pas reçu"; $password = "pas reçu"; $email = "pas reçu"; $img = "profile1.png";
  $req = $bdd->prepare('SELECT username,email,img FROM users WHERE username = :username') or die(print_r($bdd->errorInfo()));

  $req->bindValue('username',htmlspecialchars($_SESSION['username']),PDO::PARAM_STR);
  $req->execute();

  while ($donnees = $req->fetch()) {
    $name = $donnees['username'];
    $email = $donnees['email'];
    if ($donnees['img']!=null) {
      $img = $donnees['img'];
    }
  }
  $req->closeCursor();

?>
<link rel="stylesheet" href="./css/categorie.css">
 <section class="genre">

   <?php include 'NavBar.php'; ?>

   <div class="container mt-5 mb-5 sett">
     <div class="row">
       <div class="col-md-4">
         <img src=<?php echo "\"css/media/" .$img . "\"" ?> width="100%" alt="profile picture"><br>

         <form action="settings.php" method="post">
          <div class="form-row align-items-center">
            <div class="col-auto my-1">
              <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
              <select name="img" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                <option selected>Choose...</option>
                <option value="profile1.png">green</option>
                <option value="profile2.png">orange</option>
                <option value="profile3.png">cyan</option>
                <option value="profile4.png">beige</option>
                <option value="profile5.png">blue</option>
              </select>
            </div>
            <div class="col-auto my-1">
              <button type="submit" class="btn btn" id="enter">Submit</button>
            </div>
          </div>
        </form>

       </div>
       <div class="col-md-1 col-ms">

       </div>
       <div class="accordion text-center col-md-7 col-ms" id="accordionExample">
        <div class="card ">
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button class="btn btn-link" id="button1" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                Your name : <?php echo $name; ?>
              </button>
            </h2>
          </div>

          <div id="collapseOne" class="collapse" id="button1" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
              <form class="" action="settings.php" method="post">
                <label>New name :</label><br>
                <input type="text" name="name" value="" id="name" onkeyup="checkSubmit('name','name1')"><br><br>
                <input type="submit" name="submit" value=" Submit " id="name1" disabled="disabled">
              </form>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="headingTwo" >
            <h2 class="mb-0">
              <button class="btn btn-link collapsed" id="button1" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Change your password
              </button>
            </h2>
          </div>

          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
              <form class="" action="settings.php" method="post">
                <label>Your new password :</label><br>
                <input type="password" name="password" value="" id="password" onkeyup="check()"><br>
                <label>Type your new password a second time :</label><br>
                <input type="password" name="password1" value="" id="confirm_password" onkeyup="check()"><br>
                <span id='message'></span><br>
                <input type="submit" name="submit" value=" Submit " id="submit" disabled="disabled">
              </form>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="headingThree">
            <h2 class="mb-0">
              <button class="btn btn-link collapsed" id="button1" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Your email : <?php echo $email; ?>
              </button>
            </h2>
          </div>
          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
              <form class="" action="settings.php" method="post">
                <label>Your new email :</label><br>
                <input type="email" name="email" value="" onkeyup="checkSubmit('email','email1')" id="email"><br><br>
                <input type="submit" name="submit" value=" Submit " id="email1" disabled="disabled">
              </form>
            </div>
          </div>
        </div>
          <?php
          if ($_SESSION['status'] == 2) {
           ?>
           <div class="card">
             <div class="card-header" id="headingFour">
               <h2 class="mb-0">
                 <button class="btn btn-link collapsed" id="button1" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                   Admin powers !
                 </button>
               </h2>
             </div>
             <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
               <?php echo $card;echo $cardEnd; ?>
             </div>
           </div>
           <?php
          }
            ?>

      </div>

    </div>
  </div>

  <?php include 'footer.php'; ?>

  <script type="text/javascript">
    //Check if passwords are matching before submiting
    var check = function() {
      if (document.getElementById('password').value ==  document.getElementById('confirm_password').value && document.getElementById('password').value.length != 0 ) {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'matching';
        document.getElementById('submit').disabled = '';
      }
      else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'not matching';
        document.getElementById('submit').disabled = 'disabled';
      }
    }
    //Disable submit btn if input empty
    function checkSubmit(n, m){
      if (document.getElementById(n).value.length != 0) {
        document.getElementById(m).disabled = '';
      }
      else{
        document.getElementById(m).disabled = 'disabled';
      }
    }

  
<?php
}
else{
  header('Location: ./connexion.php');

  exit;
}

//Check if the string look like an email address
function valid_email($str) {
  return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
//return a string with user status
function rigths($num){
  if($num == 2){
    return "Admin";
  }
  elseif ($num == 3) {
    return "banned from commenting";
  }
  else {
    return "User";
  }
}
 ?>
