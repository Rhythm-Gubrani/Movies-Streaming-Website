<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/cssIndex.css">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="css/media/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="css/media/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="css/media/favicon/favicon-16x16.png">
    <link rel="manifest" href="css/media/favicon/site.webmanifest">
    <title>MoviesFlix</title>
</head>
<body>
<script>
            function afficherFilm(nombre,url,id){
                var content=document.getElementById(id);
                page=1;
                id="";
                nombre=6;
                genre="";
                url1=url+page;
                function movie(page){
                    fetch(url)
                    .then(reponse =>reponse.json())
                    .then (data => {
                    for(var i=0;i<nombre;i++){
                    var test  =data.results[i].poster_path;
                    var id = data.results[i].id;
                    content.innerHTML+="<div class='col-md-2 pochette'><a alt='"+data.results[i].title+"' href='pageVideo.php?id="+id+"'><img width= 80% alt='Movie poster' src=http://image.tmdb.org/t/p/w185//".concat(test,"></img> </a><br><a id='titr' href='pageVideo.php?id="+id+"'>"+data.results[i].title+"</a><br>"+data.results[i].vote_average+"/10</div>" );
                    }
                    })
                    }
            movie();
            }
</script>
<?php include('NavBar.php'); ?>
<!-- Vidéo Principale -->
        <section class='corps'>
        <iframe title="Trailer Gemini" src="https://www.youtube.com/embed/AbyJignbSj0" frameborder="0"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="enter" style="width: 100%; ">
        </iframe>
        </section>
<!-- Fin Vidéo Principale -->
<!-- Top Film -->
        <section class="container-fluid corps">
            <h2 class="sousTitre"><a class="souTitre" href=''>Top-rated</a></h2>
            <div id="topRated" class="row">
            <script>
                afficherFilm(6,"https://api.themoviedb.org/3/movie/top_rated?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=","topRated",);
            </script>
            </div>

<!--  Récents -->
            <h2 class="sousTitre"><a class="souTitre" href='recently.php'>Recently Added</a></h2>
            <div id="recently" class="row">
            <script>
                afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US&page=","recently");
            </script>
            </div>


            <h2 class="sousTitre"><a class="souTitre" href='action.php'>Action Movies</a></h2>
            <div id="action" class="row">
            <script>
                afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=28","action");
            </script>
            </div>

            <h2 class="sousTitre"><a class="souTitre" href='adventure.php'>Adventure Movies</a></h2>
            <div id="adventure" class="row">
            <script>
                afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=12&page=2","adventure");
            </script>
            </div>

            <h2 class="sousTitre"><a class="souTitre" href='comedy.php'>Comedy Movies</a></h2>
            <div id="comedy" class="row">
            <script>
                afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=35","comedy");
            </script>
            </div>

            <h2 class="sousTitre"><a class="souTitre" href='horror.php'>Horror Movies</a></h2>
            <div id="horror" class="row">
            <script>
                afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=27","horror");
            </script>
            </div>

            <h2 class="sousTitre"><a class="souTitre" href='romantic.php'>Romantic Movies</a></h2>
            <div id="romance" class="row bas">
            <script>
                afficherFilm(6,"https://api.themoviedb.org/3/discover/movie?api_key=b53ba6ff46235039543d199b7fdebd90&with_genres=10749","romance");
            </script>
            </div>

        </section>
        <?php include('footer.php'); ?>



