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

        <div class="left5">
        </div>

        <div class="right5">
            <div class="container">

                <div class="heading">
                    <span class="text">DISCOVER, WATCH, ENJOY</span>
                </div>
                <div id="screen4">
                    <h2>Seleziona le date di uscita che ti interessano.<br>
                        Se non farai scelte, sceglieremo noi casualmente!</h2>
                    <br>
                    <div id="releasedate-form" style="max-height: 350px; overflow-y: scroll; margin: 2px;">
                        <form action="tvgeek-magic4.php" method="POST">
                            <?php
                            // Recupera i paesi di produzione selezionati dalla checkbox
                            if (isset($_POST['submit'])) {
                                $selectedGenres = $_POST['genres']; // so per certo non è null, contorllato in tvgeek-magic2.
                                // Crea la stringa di query per i generi selezionati
                                $genreConditions = "";
                                foreach ($selectedGenres as $genre) {
                                    $genreConditions .= "'$genre' , ";
                                    ?>
                                    <input type="hidden" name="genres[]" value="<?php echo $genre; ?>">
                                    <?php
                                }
                                $genreConditions = rtrim($genreConditions, " , "); // Rimuovo l'ultima occorrenza di « , ».

                                if(!isset($_POST['production_countries'])) {
                                    $sql = "SELECT DISTINCT production_countries FROM all_movies_details_cleaned WHERE genres IN ($genreConditions) AND production_countries IS NOT NULL ORDER BY RAND() LIMIT 15;";
                                    $result = $conn->query($sql);
                                    // Inizializza l'array per salvare i generi
                                    $selectedProdC = array();

                                    // Recupera i risultati e salvali nell'array
                                    while ($row = $result->fetch_assoc()) {
                                        $selectedProdC[] = $row['production_countries'];
                                    }
                                } else
                                    $selectedProdC = $_POST['production_countries'];
                            } else {
                                $selectedGenres = array(); // Nessun genere selezionato
                                $selectedProdC = array(); // Nessun paese di produzione selezionato
                            }

                            $prodCConditions = "";
                            foreach ($selectedProdC as $pc) {
                                $prodCConditions .= "'$pc' , ";
                                ?>
                                <input type="hidden" name="production_countries[]" value="<?php echo $pc; ?>">
                                <?php
                            }
                            $prodCConditions = rtrim($prodCConditions, " , "); // Rimuovo l'ultima occorrenza di «, ».

                            // Esegui la query per recuperare i valori distinti di release_date
                            $sql = "SELECT DISTINCT formatted_release_date
                                    FROM (
                                          SELECT DATE_FORMAT(STR_TO_DATE(release_date, '%d/%m/%Y'), '%d/%m/%Y') AS formatted_release_date
                                          FROM all_movies_details_cleaned
                                          WHERE genres IN ($genreConditions) AND production_countries IN ($prodCConditions) AND release_date IS NOT NULL
                                    ) AS subquery
                                    ORDER BY STR_TO_DATE(formatted_release_date, '%d/%m/%Y') ASC;";
                            $result = $conn->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                if (!empty($row['formatted_release_date'])) {
                                    ?>
                                    <label>
                                        <input type="checkbox" type="submit" name="release_date[]" value="<?php echo $row['formatted_release_date']; ?>" unchecked>
                                        <?php echo $row['formatted_release_date']; ?>
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