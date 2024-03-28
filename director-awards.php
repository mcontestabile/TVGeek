<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
use Google\Service\Customsearch;
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

        <div class="left8">
        </div>

        <div class="right8">
            <div class="container">

                <div class="heading">
                    <span class="text">DISCOVER, WATCH, ENJOY</span>
                </div>
                <div id="screen2">
                    <h2>Trivia: informazioni sul regista che ha<br>
                        prodotto il contenuto che ti consigliamo</h2>
                    <br>
                    <div id="production-form">
                        <div id="results" style="max-height: 350px; overflow-y: scroll; margin: 2px;">
                            <?php
                            // Recupera i generi selezionati dalla checkbox
                            if (isset($_POST['director'])) {
                                $director_name = $_POST['director']; //"Steven Spielberg"
                            } else {
                                $director_name = array(); // Nessun contenuto selezionato
                            }
                            ?>
                            <span class="input3">Regista </span>
                            <span class="input4"><?php echo $director_name; ?></span><br><br>
                            <?php

                            $sum = "SELECT t1.summary, t2.original_language, t3.tmdbID, t3.imdbID, t3.total_awards
                                    FROM favorite_directors_summary AS t1
                                        LEFT JOIN most_common_language_by_director AS t2 ON t1.director = t2.director_name
                                        LEFT JOIN acclaimed_directors_awards AS t3 ON t1.director = t3.name
                                    WHERE director =  '$director_name';";
                            $summ = $conn->query($sum);
                            if ($summ->num_rows > 0) {
                                while ($row = $summ->fetch_assoc()) {
                                    // Accedo ai dati della tabella
                                    $summary = $row['summary'];
                                    $original_language = $row['original_language'];
                                    $tmdbID = $row['tmdbID'];
                                    $imdbID = $row['imdbID'];
                                    $total_awards = $row['total_awards'];

                                    if(!empty($summary) && $summary != "none") {
                                        ?>
                                        <span class="input3">Sommario </span>
                                        <span class="input4"><?php echo $summary;?></span><br><br>
                                        <?php
                                    }
                                    if(!empty($original_language) && $original_language != "none") {
                                        ?>
                                        <span class="input3">Lingua più usata da <?php echo $director_name; ?> </span>
                                        <span class="input4"><?php echo $original_language;?></span><br><br>
                                        <?php
                                    }
                                    if(!empty($tmdbID) && $tmdbID != "none") {
                                        ?>
                                        <span class="input3">Identificativo TMDB </span>
                                        <span class="input4"><?php echo $tmdbID;?></span><br><br>
                                        <?php
                                    }
                                    if(!empty($tmdbID) && $tmdbID != "none") {
                                        ?>
                                        <span class="input3">Identificativo imDB </span>
                                        <span class="input4"><?php echo $imdbID;?></span><br><br>
                                        <?php
                                    }
                                    if(!empty($total_awards) && $total_awards != "none") {
                                        ?>
                                        <span class="input3">Numero totale premi vinti </span>
                                        <span class="input4"><?php echo $total_awards;?></span><br><br>
                                        <?php
                                    }
                                }
                            }

                            if($director_name == "Steven Spielberg") {
                                $sa = "SELECT award_ceremony, award_year, award_category, outcome
                                       FROM (
                                            SELECT DISTINCT adb.ceremony AS award_ceremony, adb.award_year AS award_year,
                                                            adb.category AS award_category, adb.outcome AS outcome
                                            FROM all_movies_casting_raw AS amcr LEFT JOIN awards_by_directors AS adb ON amcr.director_name = adb.director_name
                                            WHERE amcr.director_name = 'Steven Spielberg'
    
                                            UNION
    
                                            SELECT DISTINCT sa.ceremony AS award_ceremony, sa.award_year AS award_year,
                                                            sa.category AS award_category, sa.outcome AS outcome
                                            FROM all_movies_casting_raw AS amcr LEFT JOIN spielberg_awards AS sa ON amcr.director_name = sa.name
                                            WHERE amcr.director_name = 'Steven Spielberg'
                                       ) AS combined_results;";

                                $prizes = $conn->query($sa);

                                if ($prizes->num_rows > 0) {
                                    ?>
                                    <table>
                                    <tr><th class="input3">Cerimonia</th><th class="input3">Anno</th><th class="input3">Categoria</th><th class="input3">Risultato</th></tr>
                                    <?php
                                    while ($row = $prizes->fetch_assoc()) {
                                        $sa_ceremony = $row['award_ceremony'];
                                        $sa_year = $row['award_year'];
                                        $sa_category = $row['award_category'];
                                        $sa_outcome = $row['outcome'];

                                        if(!empty($sa_ceremony) && $sa_ceremony != "none") {
                                            ?>
                                            <tr>
                                            <td> <?php echo $sa_ceremony; ?></td>
                                            <?php
                                        }
                                        if(!empty($sa_year) && $sa_year != "none") {
                                            ?>
                                            <td> <?php echo $sa_year; ?></td>
                                            <?php
                                        }
                                        if(!empty($sa_category) && $sa_category != "none") {
                                            ?>
                                            <td> <?php echo $sa_category; ?></td>
                                            <?php
                                        }
                                        if(!empty($sa_outcome) && $sa_outcome != "none") {
                                            ?>
                                            <td> <?php echo $sa_outcome; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?></table><?php
                                }

                            }
                            else {
                                $sql = "SELECT DISTINCT adb.ceremony AS award_ceremony, adb.award_year AS award_year,
                                         adb.category AS award_category, adb.outcome AS adb_outcome, adb.original_language AS ol
                                        FROM all_movies_casting_raw AS amcr
                                            LEFT JOIN awards_by_directors AS adb ON amcr.director_name = adb.director_name
                                        WHERE amcr.director_name = '$director_name';";

                                $prizes = $conn->query($sql);

                                if ($prizes->num_rows > 0) {
                                    ?>
                                    <table>
                                    <tr><th class="input3">Cerimonia</th><th class="input3">Anno</th><th class="input3">Categoria</th><th class="input3">Risultato</th><th class="input3">Lingua originale</th></tr>
                                    <?php
                                    while ($row = $prizes->fetch_assoc()) {
                                        // Accedo ai dati delle due tabelle
                                        $award_ceremony = $row['award_ceremony'];
                                        $award_year = $row['award_year'];
                                        $award_category = $row['award_category'];
                                        $adb_outcome = $row['adb_outcome'];
                                        $ol = $row['ol'];

                                        if(!empty($award_ceremony) && $award_ceremony != "none") {
                                            ?>
                                            <tr>
                                            <td> <?php echo $award_ceremony; ?></td>
                                            <?php
                                        }
                                        if(!empty($award_year) && $award_year != "none") {
                                            ?>
                                            <td> <?php echo $award_year; ?></td>
                                            <?php
                                        }
                                        if(!empty($award_category) && $award_category != "none") {
                                            ?>
                                            <td> <?php echo $award_category; ?></td>
                                            <?php
                                        }
                                        if(!empty($adb_outcome) && $adb_outcome != "none") {
                                            ?>
                                            <td> <?php echo $adb_outcome; ?></td>
                                            <?php
                                        }
                                        if(!empty($ol) && $ol != "none") {
                                            ?>
                                            <td> <?php echo $ol;?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?></table><?php
                                }
                            }
                            ?>
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