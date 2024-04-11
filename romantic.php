<?php 
session_start();

?>
<link rel="stylesheet" href="./css/categorie.css">
<section class='genre'>
<!--On inclut la NavBar-->
<script>
            function afficherFilm(nombre,url,id,page){
                var content=document.getElementById(id);
                page=1;
                id="";
                nombre=6;
                genre="";
                url1=url+"&page="+page;
                function movie(page){
                    fetch(url)
                    .then(reponse =>reponse.json())
                    .then (data => {
                    for(var i=0;i<nombre;i++){
                    var test  =data.results[i].poster_path;
                    var idFilm = data.results[i].id;
                    // content.innerHTML+="<div class='col-md-2'><a class='pochette' href='pageVideo.php?id="+idFilm+"'><img src=http://image.tmdb.org/t/p/w185//".concat(test,"></img> </a></div>" );
                    // content.innerHTML+="<div class='carousel-caption'><h4 class='h4-responsive'>blabla<h4></div>";
                    content.innerHTML+="<div class='col-md-2' id='movie'><a alt ='"+data.results[i].title+"' class='pochette' href='pageVideo.php?id="+idFilm+"'><img alt='Movie poster' src=http://image.tmdb.org/t/p/w185//".concat(test,"></img> </a><p id='title'>"+data.results[i].title+"</p></div>" );
                    }
                    
                    })
                    }
            movie();
            }
  
</script>
<?php include('NavBar.php'); ?>
<h2 class="titre">Romance Movies</h2>
<!-- <p class="genreDesc"> most often a romance is understood to be "love stories", emotion-driven stories that are primarily focused on the relationship between the main characters of the story. Beyond the focus on the relationship, the biggest defining characteristic of the romance genre is that a happy ending is always guaranteed...</p> -->
<h4 id="genreTitle">Check our Romance movies catalogue</h4>
<!--Carousel Wrapper-->
<div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

  <!--Controls-->
  <div class="controls-top">
    <a id='btnLeft' class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fas fa-chevron-left"></i></a>
    <a id ='btnRight' class="btn-floating" href="#multi-item-example" data-slide="next"><i
        class="fas fa-chevron-right"></i></a>
  </div>
  <!--/.Controls-->

  <!--Indicators-->
  <ol class="carousel-indicators">
    <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
    <li data-target="#multi-item-example" data-slide-to="1"></li>
    <li data-target="#multi-item-example" data-slide-to="2"></li>
    <li data-target="#multi-item-example" data-slide-to="3"></li>
    <li data-target="#multi-item-example" data-slide-to="4"></li>
  </ol>
  <!--/.Indicators-->

  <!--Slides-->
  <div class="carousel-inner" role="listbox">

    <!--First slide-->
    <div class="carousel-item active">
    <div class="row" id="firstRow">
        <script> afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=10749",'firstRow'); </script>

    </div>
    </div>
    <!--/.First slide-->

    <!--Second slide-->
    <div class="carousel-item">
    <div class="row" id="secondRow">
        <script> afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=10749&page=2",'secondRow'); </script>

    </div>
    </div>

    <!--/.Second slide-->

    <!--Third slide-->
    <div class="carousel-item">
    <div class="row" id="thirdRow">
        <script> afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=10749&page=3",'thirdRow'); </script>

    </div>
    </div>

    <div class="carousel-item">
    <div class="row" id="fourRow">
        <script> afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=10749&page=4",'fourRow'); </script>

    </div>
    </div>

    <div class="carousel-item">
    <div class="row" id="fiveRow">
        <script> afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=10749&page=5",'fiveRow'); </script>

    </div>
    </div>

  </div>
  <!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->
</section>
<!--On inclut le footer-->
<?php include('footer.php'); ?>

