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

        <div class="left4">
        </div>

        <div class="right4">
            <div class="container">

                <div class="heading">
                    <span class="text">DISCOVER, WATCH, ENJOY</span>
                </div>
                <div id="screen2">
                    <h2>Seleziona i paesi di produzione che ti interessano.<br>
                        Se non farai scelte, sceglieremo noi casualmente!</h2>
                    <br>
                    <div id="production-form" style="max-height: 340px; overflow-y: scroll;">
                        <form action="tvgeek-magic3.php" method="POST">
                            <?php
                            // Recupera i generi selezionati dalla checkbox
                            if (isset($_POST['submit'])) {
                                if(!isset($_POST['genres'])) {
                                    $sql = "SELECT DISTINCT genres FROM all_movies_details_cleaned WHERE genres IS NOT NULL ORDER BY RAND() LIMIT 20;";
                                    $result = $conn->query($sql);
                                    // Inizializza l'array per salvare i generi
                                    $selectedGenres = array();

                                    // Recupera i risultati e salvali nell'array
                                    while ($row = $result->fetch_assoc()) {
                                        $selectedGenres[] = $row['genres'];
                                    }
                                } else
                                    $selectedGenres = $_POST['genres'];
                            } else {
                                $selectedGenres = array();
                            }

                            // Crea la stringa di query per i generi selezionati
                            $genreConditions = "";
                            foreach ($selectedGenres as $genre) {
                                $genreConditions .= "'$genre' , ";
                                ?>
                                <input type="hidden" name="genres[]" value="<?php echo $genre; ?>">
                                <?php
                            }
                            $genreConditions = rtrim($genreConditions, " , "); // Rimuovo l'ultima occorrenza di «OR».

                            // Esegui la query per recuperare i valori distinti di production_countries
                            $sql2 = "SELECT DISTINCT production_countries FROM all_movies_details_cleaned WHERE genres IN ($genreConditions) AND production_countries IS NOT NULL;";
                            $result2 = $conn->query($sql2);

                            while ($row2 = $result2->fetch_assoc()) {
                                if (!empty($row2['production_countries']) && $row2['production_countries'] != "none") {
                                    ?>
                                    <label>
                                        <input type="checkbox" type="submit" name="production_countries[]" value="<?php echo $row2['production_countries']; ?>" unchecked>
                                        <?php echo $row2['production_countries']; ?>
                                    </label>
                                    <br>
                                    <?php
                                } else continue;
                            } ?>
                            <input type="submit" name="submit" value="Prosegui" class="acc-btn-cuteblue"/>
                        </form>
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