<?php
require_once 'config.php';
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

        <div class="left6">
        </div>

        <div class="right6">
            <div class="container">

                <div class="heading">
                    <span class="text">DISCOVER, WATCH, ENJOY</span>
                </div>
                <div id="screen4">
                    <h1 class="my-5">Congratulazioni! La tua ricerca ha<br>prodotto i seguenti risultati</h1>
                    <br>
                    <div id="results" style="max-height: 300px; overflow-y: scroll; margin: 2px;">
                        <?php
                        // Recupera le date selezionate dalla checkbox
                        if (isset($_POST['submit'])) {
                            $selectedGenres = $_POST['genres']; // so per certo non è null, contorllato in tvgeek-magic2.
                            $genreConditions = "";
                            foreach ($selectedGenres as $genre)
                                $genreConditions .= "'$genre' , ";
                            $genreConditions = rtrim($genreConditions, " , "); // Rimuovo l'ultima occorrenza di « , ».

                            $selectedProdC = $_POST['production_countries'];
                            $prodCConditions = "";
                            foreach ($selectedProdC as $pc)
                                $prodCConditions .= "'$pc' , ";
                            $prodCConditions = rtrim($prodCConditions, " , "); // Rimuovo l'ultima occorrenza di «, ».

                            if(!isset($_POST['release_date'])) {
                                $sql = "SELECT DISTINCT release_date
                                               FROM all_movies_details_cleaned
                                               WHERE genres IN ($genreConditions)
                                                 AND production_countries IN ($prodCConditions)
                                                 AND release_date IS NOT NULL ORDER BY RAND() LIMIT 15;";
                                $result = $conn->query($sql);
                                // Inizializza l'array per salvare i generi
                                $selectedRelDate = array();

                                // Recupera i risultati e salvali nell'array
                                while ($row = $result->fetch_assoc()) {
                                    $selectedRelDate[] = $row['release_date'];
                                }
                            } else
                                $selectedRelDate = $_POST['release_date'];
                        } else {
                            $selectedGenres = array(); // Nessun genere selezionato
                            $selectedProdC = array(); // Nessun paese di produzione selezionato
                            $release_date = array(); // Nessuna data di rilascio di produzione selezionato
                        }

                        // Crea la stringa di query per i generi selezionati
                        $relDateConditions = "";
                        foreach ($selectedRelDate as $relDate)
                            $relDateConditions .= "'$relDate' , ";
                        $relDateConditions = rtrim($relDateConditions, " , "); // Rimuovo l'ultima occorrenza di «, ».

                        // Esegui la query per recuperare i contenuti consigliati
                        $sql = "SELECT DISTINCT id, original_title, overview, tagline
                                FROM all_movies_details_cleaned
                                WHERE genres IN ($genreConditions) AND production_countries IN ($prodCConditions) 
                                   AND release_date IN ($relDateConditions) AND original_title IS NOT NULL;";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            if (!empty($row['original_title'])) {
                                ?>
                                <div class="results">
                                    <span class="input2"><?php echo $row['original_title']; ?></span>
                                </div>
                                <?php
                                if(!empty($row['overview']))
                                    ?>
                                    <div class="results">
                                    <span class="input3"><?php echo $row['overview']; ?></span>
                                </div>
                                <br>
                                <?php
                                ?>
                                <?php
                                if(!empty($row['tagline']))
                                    ?>
                                    <div class="results">
                                    <span class="input4"><?php echo $row['tagline']; ?></span>
                                </div>
                                <?php
                                ?>
                                <br>
                                <a href="content-infos.php?id=<?php echo $row['id']; ?>" data-text="Infos">Premi qui per più informazioni</a></li>
                                <br>
                                <br>
                                <?php
                            } else continue;
                        } ?>
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
            </div>
        </div>
</main>

<script src="js/script.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bez.js"></script>
<script src="js/pace.js"></script>
<script src="js/index.js"></script>
</body>
</html>