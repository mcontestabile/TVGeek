<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TVGeek - La casa dei cinefili e tv series addicted</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.6/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">

    <!--favicon-img-->
    <link rel="icon" type="image/png" href="images/favicon.jpg">
    <!--favicon-img-->

    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<!-- MAIN CONTENT -->
<main id="index-one">

    <!-- CUSTOM CURSOR -->
    <div class="cursor scale"></div>
    <div class="cursor-two scale"></div>
    <!-- CUSTOM CURSOR -->

    <!-- HEADER -->
    <div id="header">
        <!-- NAVIGATION -->
        <div class="navigation">
            <div class="logo hover ">
                <a href="index.html" class="text-index">TVGeek</a>
            </div>
            <div class="menu-bar hover ">
                <div class="menu-bar-name text">Menu</div>
                <div class="menu-bar-lines text">
                    <div class="menu-bar-line"></div>
                    <div class="menu-bar-line"></div>
                </div>
            </div>
        </div>
        <!-- NAVIGATION -->



        <div class="scrolling-part"></div>

        <div class="left7">
        </div>

        <div class="right7">
            <div class="container">

                <div class="heading">
                    <span class="text">DISCOVER, WATCH, ENJOY</span>
                </div>
                <div id="screen2">
                    <h2>Maggiori informazioni sul contenuto selezionato</h2>
                    <br>
                    <div id="production-form">
                        <div id="results" style="max-height: 340px; overflow-y: scroll; margin: 2px;">
                            <?php
                            // Recupera i generi selezionati dalla checkbox
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                            } else {
                                $id = array(); // Nessun contenuto selezionato
                            }

                            $sql = "SELECT t1.*, t2.actor1_name, t2.actor2_name, t2.actor3_name,
                                           t2.actor4_name, t2.actor5_name, t2.actor_number, t2.director_name,
                                           t2.producer_name, t2.screenplay_name, t2.editor_name,
                                          (
                                          SELECT country
                                          FROM language_to_country
                                          WHERE language_to_country.language = t1.original_language
                                          ) AS country
                                     FROM all_movies_details_cleaned AS t1
                                         LEFT JOIN all_movies_casting_raw AS t2 ON t1.id = t2.id
                                     WHERE t1.id = $id;";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                            // Accedo ai dati delle due tabelle
                            $title = $row['title'];
                            $runtime = $row['runtime'];
                            $spoken_languages = $row['spoken_languages'];
                            $vote_average = $row['vote_average'];
                            $vote_count = $row['vote_count'];
                            $production_companies = $row['production_companies'];
                            $actor_number = intval($row['actor_number']);
                            $director_name = $row['director_name'];
                            $producer_name = $row['producer_name'];
                            $screenplay_name = $row['screenplay_name'];
                            $editor_name = $row['editor_name'];
                            $original_language= $row['original_language'];
                            $country = $row['country'];
                            $actor1 = $row['actor1_name'];
                            $actor2 = $row['actor2_name'];
                            $actor3 = $row['actor3_name'];
                            $actor4 = $row['actor4_name'];
                            $actor5 = $row['actor5_name'];
                            $popularity = $row['popularity'];
                            $imdb_id = $row['imdb_id'];

                            ?>
                            <div class="results">
                                <?php
                                if(!empty($title) && $title != "none") {
                                    ?>
                                    <span class="input3">Title </span>
                                    <span class="input4"><?php echo $title; ?></span><br>
                                <?php }
                                if(!empty($imdb_id) && $imdb_id != "none") {
                                    ?>
                                    <span class="input3">Codice contenuto imdB </span>
                                    <span class="input4"><?php echo $imdb_id; ?></span><br>
                                <?php }
                                if(!empty($runtime) && $runtime != "none") {
                                    ?>
                                    <span class="input3">Durata </span>
                                    <span class="input4"><?php echo $runtime; ?>'</span><br>
                                <?php }
                                if(!empty($vote_average) && $vote_average != "none") {
                                    ?>
                                    <span class="input3">Valutazione media </span>
                                    <span class="input4"><?php echo $vote_average; ?></span>
                                    <?php if(!empty($vote_count) && $vote_count != "none") {
                                        ?>
                                        <span class="input3"> su </span>
                                        <span class="input4"><?php echo $vote_count; ?></span><span class="input3"> valutazioni </span><br>
                                    <?php }
                                }
                                if(!empty($popularity) && $popularity != "none") {
                                    ?>
                                    <span class="input3">Popolarità </span>
                                    <span class="input4"><?php echo $popularity; ?></span><br>
                                <?php }
                                if(!empty($original_language) && $original_language != "none"){
                                ?>
                                <span class="input3">Lingua originale </span>
                                <span class="input4"><?php echo $original_language; ?></span><br>
                                <span class="input3">Codice paese </span>
                                <span class="input4"><?php echo $country; ?></span><br>
                                <?php }
                                if(!empty($spoken_languages) && $spoken_languages != "none") {
                                        ?>
                                        <span class="input3">Lingue parlate </span>
                                        <span class="input4"><?php echo $spoken_languages; ?></span><br>
                                        <?php
                                    }
                                if(!empty($production_companies) && $production_companies != "none") {
                                        ?>
                                        <span class="input3">Compagnia di produzione </span>
                                        <span class="input4"><?php echo $production_companies; ?></span><br>
                                <?php }
                                if($actor1 != "none" || $actor2 != "none" || $actor3 != "none" || $actor4 != "none" || $actor5 != "none") {
                                        ?> <span class="input3">Cast </span> <?php
                                        $i = 0;
                                        if(!empty($actor1) && $actor1 != "none") {
                                            $i = $i + 1;
                                            ?>
                                            <label class="input4"><?php echo $actor1; ?></label>
                                        <?php }
                                        if(!empty($actor2) && $actor2 != "none") {
                                            $i = $i + 1;
                                            ?>
                                            <label class="input4"><?php echo $actor2; ?></label>
                                        <?php }
                                        if(!empty($actor3) && $actor3 != "none") {
                                            $i = $i + 1;
                                            ?>
                                            <label class="input4"><?php echo $actor3; ?></label>
                                        <?php }
                                        if(!empty($actor4) && $actor4 != "none") {
                                            $i = $i + 1;
                                            ?>
                                            <label class="input4"><?php echo $actor4; ?></label>
                                        <?php }
                                        if(!empty($actor5) && $actor5 != "none") {
                                            $i = $i + 1;
                                            ?>
                                            <label class="input4"><?php echo $actor5; ?></label>
                                        <?php }
                                        if(!empty($actor_number) && $actor_number != "none") {
                                            $actors_left = $actor_number - $i;
                                            if($actors_left > 0) {
                                                ?>
                                                <label class="input4"> e altri <?php echo $actors_left; ?></label><br>
                                                <?php
                                            } else {
                                                ?>
                                                <label class="input4"></label><br>
                                                <?php
                                            }
                                        }
                                    }
                                if(!empty($director_name) && $director_name != "none") {
                                        ?>
                                        <form action="director-awards.php" method="POST">
                                            <span class="input3">Regista </span>
                                            <span class="input4"><?php echo $director_name; ?></span>
                                            <input type="hidden" name="director" value="<?php echo $director_name; ?>">
                                            <input type="submit" name="submit" value="Scheda direttore" class="acc-btn-cuteblue"/>
                                            <!-- <a href="director-awards.php?id=<?php echo $director_name; ?>" data-text="Infos">Scheda direttore</a></li> --><br>
                                        </form>
                                        <?php
                                    }
                                    if(!empty($producer_name) && $producer_name != "none") {
                                        ?>
                                        <span class="input3">Produttore </span>
                                        <span class="input4"><?php echo $producer_name; ?></span><br>
                                        <?php
                                    }
                                    if(!empty($screeplay_name) && $screeplay_name != "none") {
                                        ?>
                                        <span class="input3">Screenplay </span>
                                        <span class="input4"><?php echo $screenplay_name; ?></span><br>
                                        <?php
                                    }
                                    if(!empty($editor_name) && $editor_name != "none") {
                                        ?>
                                        <span class="input3">Editor </span>
                                        <span class="input4"><?php echo $editor_name; ?></span><br>
                                        <?php
                                    }

                                    }
                                    } else {
                                        echo "Nessun risultato trovato.";
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="container">
                        <!-- STREAMING IMG -->
                        <div class="streaming img text">
                            <img src="images/streaming.png" class = "text" alt="streaming">
                        </div>
                        <!-- STREAMING IMG -->
                    </div>

                    <!-- NAVIGATION CONTENT -->
                    <div class="navigation-content">
                        <div class="navigation-logo hover opacity">
                            <a href="#" class="text">TVGeek</a>
                        </div>
                        <ul class="navigation-ul">
                            <li><a href="index.html" data-text="Home" data-img="images/home.jpg">Home</a></li>
                            <li><a href="about.html"  data-text="About"  data-img="images/about-img.jpg">About</a></li>
                            <li><a href="account.html" data-text="Account" data-img="images/account.jpg">Account</a></li>
                            <li><a href="contact.php" data-text="Contact" data-img="images/contact-us.jpg">Contatti</a></li>
                        </ul>
                        <div class="navigation-close hover about-close opacity">
                            <div class="navigation-close-line"></div>
                            <div class="navigation-close-line"></div>
                        </div>

                        <div class="project-preview"></div>


                        <!-- STREAMING IMG -->
                        <div class="streaming-navigation opacity">
                            <img src="images/streaming.png" title="streaming zone" class="text" alt="streaming">
                        </div>
                        <!-- STREAMING IMG -->
                    </div>
                    <!-- NAVIGATION CONTENT -->

</main>

<script src="js/script.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bez.js"></script>
<script src="js/pace.js"></script>
<script src="js/index.js"></script>
</body>
</html>