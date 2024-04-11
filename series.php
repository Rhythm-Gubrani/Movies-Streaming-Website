<?php
session_start();

?>

<link rel="stylesheet" href="./css/categorie.css">
<section class='genre'>

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
                    content.innerHTML+="<div class='col-md-2' id='movie'><a alt ='"+data.results[i].name+"' class='pochette' href='pageSerie.php?id="+idFilm+"'><img alt='TV poster' src=http://image.tmdb.org/t/p/w185//".concat(test,"></img> </a><p id='title'>"+data.results[i].name+"</p></div>" );
                    }

                    })
                    }
            movie();
            }

</script>
<?php include('NavBar.php'); ?>
<h2 class="titre">Series</h2>
<!-- <p class="genreDesc">Anim</p> -->
<h4 id="genreTitle">Check our Series catalogue</h4>
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
        <script> afficherFilm(6," https://api.themoviedb.org/3/tv/popular?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=1",'firstRow'); </script>

    </div>
    </div>
    <!--/.First slide-->

    <!--Second slide-->
    <div class="carousel-item">
    <div class="row" id="secondRow">
        <script> afficherFilm(6,"https://api.themoviedb.org/3/tv/popular?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=2",'secondRow'); </script>

    </div>
    </div>

    <!--/.Second slide-->

    <!--Third slide-->
    <div class="carousel-item">
    <div class="row" id="thirdRow">
        <script> afficherFilm(6,"https://api.themoviedb.org/3/tv/popular?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=3",'thirdRow'); </script>

    </div>
    </div>

    <div class="carousel-item">
    <div class="row" id="fourRow">
        <script> afficherFilm(6,"https://api.themoviedb.org/3/tv/popular?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=4",'fourRow'); </script>

    </div>
    </div>
    
    <div class="carousel-item">
      <div class="row" id="fiveRow">
        <script> afficherFilm(6,"https://api.themoviedb.org/3/tv/popular?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=5",'fiveRow'); </script>
        
      </div>
    </div>
    
  </div>
  <!--/.Slides-->
  
</div>
<!--/.Carousel Wrapper-->


</section>
<!--On inclut le footer-->

<?php include('footer.php'); ?>



