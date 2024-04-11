<?php
session_start();
if ($_GET['id'] > 1 && is_numeric($_GET['id'])) {

try{

  //On se connecte à MySQL
  $bdd = new PDO('mysql:host=localhost;dbname=Getflix;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch (Exception $e) {

  //En cas d'erreur on affiche un message et on arrete tout
  die('Erreur : ' . $e->getMessage());
}

$req = $bdd->prepare('SELECT id FROM video WHERE id = :id');
$req->execute(array('id' => $_GET['id']));
$resultat = $req->fetch();
//deja dans la table
if($resultat){
}
// id pas repertorié dans la table ? => ajout
  else{
  $add = $bdd->prepare('INSERT INTO video(id) VALUES(:id)') or die(print_r($bdd->errorInfo()));
  $add->execute(array('id'=> $_GET['id']));
}
// si on a cliqué pour supp un comm, supp de la bd
if(isset($_POST['delete'])){
  $req = $bdd->prepare('DELETE FROM comments WHERE id = :id') or die(print_r($bdd->errorInfo()));

  $req->execute(array('id'=>$_POST['id_comm']));
}
?>
<link rel="stylesheet" href="./css/style3.css">
<!--On inclut la NavBar-->
<?php include('NavBar.php'); ?>
<!--Video à ajouter-->


<script>
//recuperation de du GET[id] en javascript
var get = window.location.search ;
var id="";
for(var i = 4;i<get.length;i++){
    id+=get[i];
}

//recuper le trailer
var url = "https://api.themoviedb.org/3/tv/"+id+"/videos?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US";
function getTrailer(){
                    fetch(url)
                    .then(reponse =>reponse.json())
                    .then (data => {
                    var key=data.results[0].key;
                    var trailer = document.getElementById('trailer');
                    trailer.innerHTML+="<iframe title='trailer' width='916' height='515' src='https://www.youtube.com/embed/"+key+"' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>"

                    })

                    }

function getTitre(){
  var url = "https://api.themoviedb.org/3/tv/"+id+"?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US";
  fetch(url)
                    .then(reponse =>reponse.json())
                    .then (data => {
                    var title=document.getElementById('titleMovie');
                    title.innerHTML="<h2>"+data.original_name+"</h2><i>Last episode : "+data.last_episode_to_air.name+"</i>";
})
}
function getInfo(){
  var url = "https://api.themoviedb.org/3/tv/"+id+"?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US";
  fetch(url)
                    .then(reponse =>reponse.json())
                    .then (data => {
                    var info=document.getElementById('infoContent');
                    info.innerHTML="<label><br><ins><strong> Number of Seasons : </strong></ins>"+data.number_of_seasons+"<br><ins><strong>Number of Episode : </strong></ins>"+data.number_of_episodes+"<br><ins><strong>Rating : </strong></ins>"+data.vote_average+"/10 <br>  <br> <ins><strong> Overview :</strong></ins>"+data.overview+"<br><a rel='noreferrer' id='website'href='"+data.homepage+"' target='_blank'><br>Official Website </a></label>";
})
}

function getSimilar(){
  var url = "https://api.themoviedb.org/3/tv/"+id+"/similar?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US";
  fetch(url)
                    .then(reponse =>reponse.json())
                    .then (data => {
                    var sim=document.getElementById('similarMovie');
                    var sim1=document.getElementById('similarMovie1');
                    var sim2=document.getElementById('similarMovie2');
                    var sim3=document.getElementById('similarMovie3');
                    var idVid = data.results[0].id;
                    sim.innerHTML+="<label><br> <a href='pageSerie.php?id="+idVid+"'><img class='simPoch' src=http://image.tmdb.org/t/p/w185//"+data.results[0].poster_path+"></img></a><br>"+data.results[0].original_name+"</label>";
                    var idVid = data.results[1].id;
                    sim1.innerHTML+="<label><br> <a  href='pageSerie.php?id="+idVid+"'><img class='simPoch' src=http://image.tmdb.org/t/p/w185//"+data.results[1].poster_path+"></img></a><br>"+data.results[1].original_name+"</label>";
                    var idVid = data.results[2].id;
                    sim2.innerHTML+="<label><br> <a  href='pageSerie.php?id="+idVid+"'><img class='simPoch' src=http://image.tmdb.org/t/p/w185//"+data.results[2].poster_path+"></img></a><br>"+data.results[2].original_name+"</label>";
                    var idVid = data.results[3].id;
                    sim3.innerHTML+="<label><br> <a  href='pageSerie.php?id="+idVid+"'><img class='simPoch' src=http://image.tmdb.org/t/p/w185//"+data.results[3].poster_path+"></img></a><br>"+data.results[3].original_name+"</label>";
})

}
                    getTrailer();
                    getTitre();
                    getInfo();
                    getSimilar();

</script>
<!--les 3 sections -->
<h2 id="titleMovie"></h2>
<div class="container-fluid ">
<div id="trailer" class="row justify-content-center">

</div>
<div class='row justify-content-md-center'>
<div class="col col-lg-2">
<h3 onclick='Info()' id='information2' class="disabled">Informations</h3>
</div>
<div class="col col-lg-2">



<h3 onclick='com()' id='commentaire2' class="active">Comments</h3>
</div>


<div class="col col-lg-2 ">
<h3 onclick="vid()" id='video2' class="disabled">Similar Series</h3>
</div>
</div>

<!--Information -->

<div id="information" style='display:none' >
<div class="row">
<div  id="infoContent" class="col-md-6">

 </div>
 <div class="col-md-3">

        </div>
  <div class="col-md-3">
   </div>
</div>
</div>

<!--Commentaires-->

<div id="commentaire" style='display:block'>
<?php //Ajout du php pour les commentaires
//on verifie que le com existe
$bdd = new PDO('mysql:host=localhost;dbname=Getflix', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$id5=$_GET['id'];
        if(isset($_POST['com']) AND !empty($_POST['com'])){
//si le com existe et qu'il n'est pas vide:
        $userid=$_SESSION['id_user'];
        $commentaire= htmlspecialchars($_POST['com']);
            $ins = $bdd->prepare('INSERT INTO comments(id_vid, id_user, comment, date_comment)
            VALUES (?,?,?,NOW())');
            $ins->execute(array($id5 , $userid ,$commentaire));

            $c_msg = "<span style='color:green'>Your comment has been successfully posted</span>";
        } else {
            $c_msg = "<span style='color:red'>Error: Something went wrong</span>";
        }

        ?>
<div class="row">
<div class="col-md-4">

        </div>
        <div id='bodySpace' class="col-md-4 listeCom">

        <?php if($_SESSION['status'] != 3){ ?>
          <form method="POST">
          <label>Add comment</label>
              <input type="text" id="story" name='com'  rows="3" cols="40">
         <br>
              <button type="submit" class="btn btn-outline-danger valider">Send comment</button>
          </form>
        <?php } ?>
        <h4 class='listeCom'> Other comments :</h4>
        <?php
    $requete=$bdd->prepare('SELECT comment , date_comment, username, c.id FROM comments c INNER JOIN users u
    ON c.id_user= u.id WHERE id_vid =? ORDER BY date_comment DESC');

    $requete->execute(array($id5));
    //Vision non admin
    if($_SESSION['status'] != 2){
      while($ligne = $requete->fetch()){
          echo "<article class='listeCom'> <section id='eachCom'> ".$ligne['username']." - ".$ligne['date_comment'].
          "</section><section class='eachCom'>". $ligne['comment']." <br> </section> </article> <br>";
      }
    //Vision admin
    }else {
      while($ligne = $requete->fetch()){
          echo "<article class='listeCom'> <section id='eachCom'>
          <form action='' method='post'>
          <input style='visibility:hidden;display:none;' name='id_comm' value='" . $ligne['id'] . "' />
          <input style='padding:0;margin-left:60%;' type='submit' name='delete' value='delete' />
          </form> ".$ligne['username']." - ".$ligne['date_comment'].
          "</section><section class='eachCom'>". $ligne['comment']."  <br> </section> </article> <br>";
      }
    }
    ?>
            </div>
            <div class="col-md-4">
  </div>
</div>


</div>

<!--Vidéo simmilaire-->

<div id="video" style="display:none">
<div class="row">
<div id="similarMovie2" class="col-md-3">

 </div>
 <div id="similarMovie3" class="col-md-3">

 </div>
  <div id="similarMovie" class="col-md-3">
   </div>
   <div id="similarMovie1" class="col-md-3">
</div>
</div>

  </div>
</div>


<!--On inclut le footer-->
<?php include('footer.php'); ?>



<?php
}
else {
  header("Location: ./404.html");
  exit;
}
 ?>
